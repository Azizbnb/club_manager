<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Filament\Resources\PaymentResource\RelationManagers;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('amount')
                ->required()
                ->numeric()
                ->label('Montant')
                ->prefix('€'),

            Forms\Components\Select::make('status')
                ->options([
                    'paid' => 'Payé',
                    'pending' => 'En attente',
                    'failed' => 'Échoué',
                ])
                ->required()
                ->label('Statut'),

            Forms\Components\Select::make('payment_method')
                ->options([
                    'check' => 'Cheque',
                    'cash' => 'Espèce',
                    'cb' => 'CB',
                ])
                ->required()
                ->label('Type de Paiement'),
  
            Forms\Components\Select::make('user_id')
                ->relationship('user', 'first_name')
                ->required()
                ->label('Utilisateur'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                ->sortable()
                ->label('ID'),
                Tables\Columns\TextColumn::make('amount')
                ->label('Montant')
                ->money('eur'),

                Tables\Columns\TextColumn::make('payment_method')
                ->label('Type de paiement')
                ->searchable(),

                Tables\Columns\TextColumn::make('user.first_name')
                ->label('Utilisateur'),

                Tables\Columns\TextColumn::make('created_at')
                ->dateTime('d/m/Y')
                ->label('Créé le'),

                Tables\Columns\IconColumn::make('status')
                ->options([
                    'heroicon-o-check-circle' => 'paid',
                    'heroicon-o-clock' => 'pending',
                    'heroicon-o-x-mark' => 'failed',
                ])
                ->colors([
                    'success' => 'paid',
                    'info' => 'pending',
                    'warning' => 'failed',
                ])
                ->searchable()
                ->label('Etat du paiement'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn ($record) => auth()->user()->can('edit payments')),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record) => auth()->user()->can('delete payments')),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                ->visible(fn () => auth()->user()->can('delete payments')),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->hasPermissionTo('view payments');
    }
}

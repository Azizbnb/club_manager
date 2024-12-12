<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\TextInput::make('first_name')
                ->required()
                ->label('Prénom'),

                Forms\Components\TextInput::make('last_name')
                ->required()
                ->label('Nom'),

                Forms\Components\TextInput::make('email')
                ->required()
                ->email()
                ->unique()
                ->label('Email'),

                Forms\Components\TextInput::make('password')
                ->password()
                ->required()
                ->label('Mot de passe')
                ->dehydrateStateUsing(fn ($state) => bcrypt($state)) // Hasher le mot de passe
                ->hiddenOn('edit'), // Masquer lors de l'édition

                Forms\Components\Select::make('gender')
                ->options([
                    'male' => 'Homme',
                    'female' => 'Femme',
                ])
                ->required()
                ->label('Genre'),

                Forms\Components\TextInput::make('address')
                ->required()
                ->label('Adresse Postale'),

                Forms\Components\Select::make('experience')
                ->options([
                    'debutant',
                    'intermediaire',
                    'avancé'
                ])
                ->required()
                ->label('Experience'),

                Forms\Components\DatePicker::make('birth_date')
                ->required()
                ->maxDate(now())
                ->label('Date de naissance'),

                Forms\Components\TextInput::make('phone')
                ->tel()
                ->label('Téléphone'),

                Forms\Components\Select::make('category_id')
                ->relationship('category', 'category_name') // Relation avec la table categories
                ->required()
                ->label('Catégorie'),

                Forms\Components\Toggle::make('is_admin')
                ->label('Administrateur')
                ->default(false),

                Forms\Components\Toggle::make('profile_status')
                ->label('Etat de l\'inscription')
                ->default(false),
        ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable()->label('ID'),
                Tables\Columns\TextColumn::make('first_name')->label('Prénom'),
                Tables\Columns\TextColumn::make('last_name')->label('Nom'),
                Tables\Columns\TextColumn::make('gender')->label('Genre'),
                Tables\Columns\TextColumn::make('email')->label('Email'),
                Tables\Columns\TextColumn::make('category.category_name')->label('Catégorie'),
                Tables\Columns\ToggleColumn::make('is_admin')->label('Admin'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->label('Créé le'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
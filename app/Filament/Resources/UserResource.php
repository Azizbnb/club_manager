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
use Spatie\Permission\Models\Role;


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
                    ->unique(ignoreRecord: true) // Ignore l'utilisateur actuel lors de l'édition
                    ->label('Email'),

                    Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->label('Mot de passe')
                    ->dehydrateStateUsing(fn ($state) => bcrypt($state)) // Hasher le mot de passe
                    ->hiddenOn('edit'), // Masquer lors de l'édition

                    Forms\Components\Select::make('gender')
                    ->options([
                        'Homme' => 'Homme',
                        'Femme' => 'Femme',
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

                    Forms\Components\Select::make('profile_status')
                    ->options([
                        'certficat manquant' => 'Certficat manquant',
                        'photo manquante' => 'Photo manquante',
                        'payement incomplet' => 'Payement incomplet',
                        'payement partiellement complet' => 'payement partiellement complet',
                    ])
                    ->required()
                    ->label('Etat du dossier'),

                    Forms\Components\Select::make('role')
                    ->label('Rôle')
                    ->options(\Spatie\Permission\Models\Role::all()->pluck('name', 'name')->toArray())
                    ->multiple(false)
                    ->preload()
                    ->relationship('roles', 'name')
                    ->label('Attribuer un rôle'),

            

                    // Par défaut, pas de rôle visible
                    
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')->label('Prénom')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')->label('Nom')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender')->label('Genre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('experience')->label('Expérience')
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name')->label('Role')
                    ->searchable(),
                Tables\Columns\TextColumn::make('profile_status')->label('Etat du dossier')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.category_name')->label('Catégorie')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('created_at')->dateTime('d/m/Y')->label('Créé le'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn () => auth()->user()->can('edit users')),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record) => auth()->user()->hasPermissionTo('delete users')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => auth()->user()->can('delete users')),
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

    protected function afterCreate(): void
    {
        $role = $this->form->getState('role');
        $this->record->syncRoles($role);
    }

    protected function afterSave(): void
    {
        $this->record->syncRoles($this->form->getState('role'));
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->hasPermissionTo('view users');
    }



}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages;
use App\Filament\Resources\DocumentResource\RelationManagers;
use App\Models\Document;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // Si l'utilisateur connecté a le rôle "Membre", on filtre ses propres documents
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (auth()->user()->hasRole('Membre')) {
            $query->where('user_id', auth()->id());
        }
        return $query;
    }

    // ---- Affichage du formulaire ----
    public static function form(Form $form): Form
    {
        return $form->schema([
                Forms\Components\Select::make('type')
                ->options([
                    "certificat_medical" => "Certificat médical",
                    "photo_identite" => "Photo d'identité",
                    "autre" => "Autre"
                ])
                ->required()
                ->label('Type de documents'),
    
                Forms\Components\FileUpload::make('file_path')
                ->required()
                ->label('Fichier')
                ->directory('documents')
                ->acceptedFileTypes(['application/pdf', 'image/*'])
                ->default(fn ($record) => $record ? $record->file_path : null),
    
                Forms\Components\Select::make('user_id')
                ->relationship('user', 'first_name') 
                ->required()
                ->label('Utilisateur associé'),

                Forms\Components\Select::make('status')
                ->options([
                    "Reçu" => "Reçu",
                    "Envoyé" => "Envoyé",
                    "En attente" => "en Attente"
                ])
                ->required()
                ->label('Etat de la Récéption'),
        ]);
    }
    
    // ---- Affichage du tableau ----
    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('type')->label('Type de document')
                ->searchable(),
            Tables\Columns\TextColumn::make('user.first_name')->label('Appartient à')
                ->searchable(),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->label('Ajouté le')
                ->searchable(),
            Tables\Columns\TextColumn::make('file_path')
                ->label('Fichier')
                ->url(fn ($record) => asset('storage/' . $record->file_path))
                ->openUrlInNewTab(),
            
            Tables\Columns\IconColumn::make('status')
                ->options([
                    'heroicon-o-check-circle' => 'Reçu',
                    'heroicon-o-paper-airplane' => 'Envoyé',
                    'heroicon-o-clock' => 'En attente',
                ])
                ->colors([
                    'success' => 'Reçu',
                    'primary' => 'Envoyé',
                    'warning' => 'En attente',
                ])
                ->label('Récéption'),
        ])

        ->filters([])

        ->actions([
            Tables\Actions\EditAction::make()
                ->visible(fn ($record) => auth()->user()->can('edit documents')),
            Tables\Actions\DeleteAction::make()
                ->visible(fn ($record) => auth()->user()->can('delete documents')),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make()
                ->visible(fn () => auth()->user()->can('delete documents')),
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
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }
}

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

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('type')
                ->required()
                ->label('Type de document'), // Type de document (ex : Certificat médical)
    
                Forms\Components\FileUpload::make('attachment')
                ->required()
                ->multiple()
                ->label('Fichier')
                ->directory('documents') // Stocke les fichiers dans "storage/app/public/documents"
                ->acceptedFileTypes(['application/pdf', 'image/*']) // Accepte PDF et images
                ->maxSize(2048), // Limite de taille en Ko (2 Mo)
    
                Forms\Components\Select::make('user_id')
                ->relationship('user', 'first_name') // Relation avec le modèle User
                ->required()
                ->label('Utilisateur associé'),
        ]);
    }
    

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->sortable()->label('ID'),
            Tables\Columns\TextColumn::make('type')->label('Type de document'),
            Tables\Columns\TextColumn::make('user.first_name')->label('Utilisateur'), // Affiche le prénom de l'utilisateur
            Tables\Columns\TextColumn::make('created_at')->dateTime()->label('Ajouté le'),
            Tables\Columns\TextColumn::make('file_path')
                ->label('Fichier')
                ->url(fn ($record) => asset('storage/' . $record->file_path)), // Lien pour télécharger le fichier
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

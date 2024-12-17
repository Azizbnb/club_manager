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
        ]);
    }
    
    // ---- Affichage du tableau ----
    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->sortable()->label('ID'),
            Tables\Columns\TextColumn::make('type')->label('Type de document'),
            Tables\Columns\TextColumn::make('user.first_name')->label('Utilisateur'),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->label('Ajouté le'),
            Tables\Columns\TextColumn::make('file_path')
                ->label('Fichier')
                ->url(fn ($record) => asset('storage/' . $record->file_path))
                ->openUrlInNewTab(),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
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

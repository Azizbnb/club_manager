<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Resources\DocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDocuments extends ListRecords
{
    protected static string $resource = DocumentResource::class;

    protected function getHeaderActions(): array
    {
        if(auth()->user()->hasPermissionTo('create documents')){
            return [
                Actions\CreateAction::make(),
            ];
        } else {
            return [];
        }
    }
}

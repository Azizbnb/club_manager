<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Resources\DocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDocument extends EditRecord
{
    protected static string $resource = DocumentResource::class;

    protected function getHeaderActions(): array
    {
        if(auth()->user()->hasPermissionTo('delete documents')){
            return [
                Actions\DeleteAction::make(),
            ];
        } else {
            return [];
        }
    }

    protected function canEdit(): bool
    {
        if(auth()->user()->hasPermissionTo('edit documents')) {
            return true;
        }else {
            return false;
        }
    }
}

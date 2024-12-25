<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        if(auth()->user()->hasPermissionTo('delete categories')){
            return [
                Actions\DeleteAction::make(),
            ];
        } else {
            return [];
        }
    }

    protected function canEdit(): bool
    {
        if(auth()->user()->hasPermissionTo('edit categories')) {
            return true;
        }else {
            return false;
        }
    }
}

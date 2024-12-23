<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    protected function canCreate(Category $record): bool
    {
        if(auth()->user()->hasPermissionTo('create categories')) {
            return true;
        }else {
            return false;
        }
    }
}

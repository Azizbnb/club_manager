<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Resources\DocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDocument extends CreateRecord
{
    protected static string $resource = DocumentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
{
    if (is_array($data['file_path'])) {
        $data['file_path'] = json_encode($data['file_path']); // Encode en JSON
    }

    return $data;
}
}

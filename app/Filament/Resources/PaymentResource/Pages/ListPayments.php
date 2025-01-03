<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use App\Filament\Resources\PaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPayments extends ListRecords
{
    protected static string $resource = PaymentResource::class;

    protected function getHeaderActions(): array
    {
        if(auth()->user()->hasPermissionTo('create payments')){
            return [
                Actions\CreateAction::make(),
            ];
        } else {
            return [];
        }
    }
}

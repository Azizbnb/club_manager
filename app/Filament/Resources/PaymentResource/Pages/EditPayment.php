<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use App\Filament\Resources\PaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPayment extends EditRecord
{
    protected static string $resource = PaymentResource::class;

    protected function getHeaderActions(): array
    {
        if(auth()->user()->hasPermissionTo('delete payments')){
            return [
                Actions\DeleteAction::make(),
            ];
        } else {
            return [];
        }
    }

    protected function canEdit(): bool
    {
        if(auth()->user()->hasPermissionTo('edit payments')) {
            return true;
        }else {
            return false;
        }
    }
}

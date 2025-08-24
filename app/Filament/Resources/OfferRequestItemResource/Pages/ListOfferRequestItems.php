<?php

namespace App\Filament\Resources\OfferRequestItemResource\Pages;

use App\Filament\Resources\OfferRequestItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOfferRequestItems extends ListRecords
{
    protected static string $resource = OfferRequestItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No actions needed for read-only report
        ];
    }
}

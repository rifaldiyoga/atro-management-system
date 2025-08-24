<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\OfferRequestResource;
use App\Models\OfferRequest;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOfferRequests extends BaseWidget
{
    protected static ?int $sort = 3; // Urutan widget di dasbor
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(OfferRequest::query()->latest()->limit(5))
            ->columns([
                Tables\Columns\TextColumn::make('ph_no')->label('No Transaksi'),
                Tables\Columns\TextColumn::make('customer.name')->label('Pelanggan'),
                Tables\Columns\TextColumn::make('salesman.name')->label('Salesman'),
                BadgeColumn::make('status')
                    ->colors([
                        'primary' => 'draft',
                        'warning' => 'sent',
                        'success' => fn($state) => in_array($state, ['approved', 'completed']),
                        'danger' => 'rejected',
                    ]),
                Tables\Columns\TextColumn::make('trxdate')->label('Tanggal')->date(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Lihat')
                    ->url(fn(OfferRequest $record): string => OfferRequestResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}

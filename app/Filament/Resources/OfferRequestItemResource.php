<?php

namespace App\Filament\Resources;

use App\Models\OfferRequestItem;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\OfferRequestItemResource\Pages;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;

class OfferRequestItemResource extends Resource
{
    protected static ?string $model = OfferRequestItem::class;

    protected static ?string $navigationGroup = 'Laporan';
    protected static ?string $navigationLabel = 'Riwayat Penawaran Per Item';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $pluralModelLabel = 'Riwayat Penawaran Per Item';

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('offerRequest.ph_no')
                    ->label('No. Penawaran')
                    ->url(fn($record) => $record->offerRequest ? route('filament.admin.resources.offer-requests.edit', $record->offerRequest) : null)
                    ->openUrlInNewTab()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('item.code')
                    ->label('Kode Item')
                    ->url(fn($record) => $record->item ? route('filament.admin.resources.items.edit', $record->item) : null)
                    ->openUrlInNewTab()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('item.name')->label('Nama Item'),
                Tables\Columns\TextColumn::make('quantity')->label('Qty'),
                Tables\Columns\TextColumn::make('selling_price')->money('IDR', true)->label('Selling'),
                Tables\Columns\TextColumn::make('purchase_price')->money('IDR', true)->label('Purchase'),
                Tables\Columns\TextColumn::make('discount')->label('Discount'),

                Tables\Columns\TextColumn::make('supplier.name')->label('Supplier'),

                // Offer Request Details
                Tables\Columns\TextColumn::make('offerRequest.rfq_number')->label('No. RFQ'),
                Tables\Columns\TextColumn::make('offerRequest.customer.name')->label('Customer'),
                Tables\Columns\TextColumn::make('offerRequest.trxdate')->date()->label('Tanggal Penawaran'),
                Tables\Columns\TextColumn::make('offerRequest.status')->label('Status'),
            ])
            ->filters([
                // 🔍 Filter by Product
                Filter::make('item_name')
                    ->form([
                        TextInput::make('value')->label('Product Name'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query->when(
                            $data['value'],
                            function ($q, $value) {
                                $driver = $q->getModel()->getConnection()->getDriverName();
                                if ($driver === 'pgsql') {
                                    return $q->whereHas('item', fn($q2) => $q2->where('name', 'ILIKE', "%{$value}%"));
                                } else {
                                    return $q->whereHas('item', fn($q2) => $q2->where('name', 'LIKE', "%{$value}%"));
                                }
                            }
                        );
                    }),

                // 📄 Filter by No. Penawaran
                Filter::make('ph_no')
                    ->form([
                        TextInput::make('value')->label('No. Penawaran'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query->when(
                            $data['value'],
                            function ($q, $value) {
                                $driver = $q->getModel()->getConnection()->getDriverName();
                                if ($driver === 'pgsql') {
                                    return $q->whereHas('offerRequest', fn($q2) => $q2->where('ph_no', 'ILIKE', "%{$value}%"));
                                } else {
                                    return $q->whereHas('offerRequest', fn($q2) => $q2->where('ph_no', 'LIKE', "%{$value}%"));
                                }
                            }
                        );
                    }),

                // 📦 Filter by Supplier
                SelectFilter::make('supplier_id')
                    ->label('Supplier')
                    ->multiple()
                    ->relationship('supplier', 'name')
                    ->searchable(),

                // 👤 Filter by Customer (via offer request relation)
                SelectFilter::make('offerRequest.customer_id')
                    ->label('Customer')
                    ->multiple()
                    ->relationship('offerRequest.customer', 'name')
                    ->searchable(),

                // 📅 Filter by Offer Request Date Range
                Filter::make('offer_request_date')
                    ->form([
                        DatePicker::make('from')->label('From Date'),
                        DatePicker::make('until')->label('To Date'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn($q, $date) => $q->whereHas('offerRequest', fn($q2) => $q2->whereDate('trxdate', '>=', $date)))
                            ->when($data['until'], fn($q, $date) => $q->whereHas('offerRequest', fn($q2) => $q2->whereDate('trxdate', '<=', $date)));
                    }),

                // 🏷️ Filter by Status
                SelectFilter::make('offerRequest.status')
                    ->label('Status')
                    ->multiple()
                    ->options([
                        'draft' => 'Draft',
                        'submitted' => 'Submitted',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
            ])
            ->actions([]) // Removes View/Edit/Delete buttons
            ->bulkActions([]); // Removes checkboxes & bulk actions
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOfferRequestItems::route('/'),
        ];
    }
}

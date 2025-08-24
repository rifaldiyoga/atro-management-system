<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Item;
use App\Models\Order;
use App\Models\SalesmanGroup;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Carbon\Carbon;
use Dom\Text;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\View;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationGroup = 'Transaksi';
    protected static ?string $navigationLabel = 'Purchase Order';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $pluralModelLabel = 'Purchase Order';
    protected static ?string $modelLabel = 'Purchase Order';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Grid::make(4)->schema([
                            Select::make('customer_id')
                                ->label('Customer')
                                ->placeholder('Pilih Customer')
                                // Menambahkan query untuk memfilter berdasarkan partner_type
                                ->relationship(
                                    name: 'customer',
                                    titleAttribute: 'name',
                                    // Menghapus type hint Builder untuk memperbaiki error
                                    modifyQueryUsing: fn($query) => $query->where('partner_type', 'customer')
                                )
                                ->searchable()
                                ->required(),
                            DatePicker::make('trxdate')->label('Tanggal')->required()->default(Carbon::now()),
                            TextInput::make('po_no')->label('No. Purchase Order')->required(),


                            TextInput::make('ph_no')->label('No. Penawaran Harga'),


                            TextInput::make('rfq_number')->label('No. RFQ')->nullable(),
                            TextInput::make('rfq_duration')->label('Delivery Time')->nullable(),

                            Select::make('salesman_id')
                                ->label('Salesmen')
                                ->placeholder('Pilih Salesmen')
                                ->relationship(
                                    name: 'salesman',
                                    titleAttribute: 'name',
                                )
                                ->getOptionLabelFromRecordUsing(function (SalesmanGroup $record) {
                                    $salesmenNames = $record->salesmen->pluck('name')->implode(', ');
                                    return "{$record->name} ({$salesmenNames})";
                                })
                                ->searchable(),

                        ]),

                        Forms\Components\Group::make([
                            TableRepeater::make('items')
                                ->label('')
                                ->relationship()
                                ->columnSpan('full')
                                ->headers([
                                    Header::make('Item')->width('200px')->markAsRequired(),
                                    Header::make('Qty')->width('100px')->markAsRequired(),
                                    Header::make('Harga Beli')->width('200px')->markAsRequired(),
                                    Header::make('Harga Jual')->width('200px')->markAsRequired(),
                                    Header::make('Diskon')->width('100px'),
                                    Header::make('Supplier')->width('150px')->markAsRequired(),
                                ])
                                ->addActionLabel('Tambah Item')
                                ->addable(function (Forms\Get $get) {
                                    $items = $get('items');
                                    if (empty($items)) {
                                        return true;
                                    }
                                    $lastItem = end($items);
                                    return !blank($lastItem['item_id']);
                                })
                                ->schema([
                                    Select::make('item_id')
                                        ->label('Product')
                                        ->searchable()
                                        ->required()
                                        ->relationship('item', 'name')
                                        ->placeholder('Pilih Item')
                                        ->live() // Membuat field ini reaktif
                                        ->afterStateUpdated(function (Forms\Set $set, $state) {
                                            $item = Item::find($state);
                                            if ($item) {
                                                $purchasePrice = $item->price;
                                                $sellingPrice = $purchasePrice * 1.70;
                                                // Format with thousands separator
                                                $set('purchase_price', number_format($purchasePrice, 0, '', ','));
                                                $set('selling_price', number_format($sellingPrice, 0, '', ','));
                                            } else {
                                                // Kosongkan harga jika item tidak dipilih
                                                $set('purchase_price', null);
                                                $set('selling_price', null);
                                            }
                                        }),
                                    TextInput::make('quantity')
                                        ->label('Qty')
                                        ->numeric()
                                        ->required()
                                        ->default(1)
                                        ->disabled(fn(Forms\Get $get): bool => blank($get('item_id'))),
                                    TextInput::make('purchase_price')
                                        ->label('Purchase Price')
                                        ->numeric()
                                        ->required()
                                        ->mask(RawJs::make('$money($input)'))
                                        ->stripCharacters(',')
                                        ->live() // Mengubah dari onBlur menjadi onChange
                                        ->afterStateUpdated(function (Forms\Set $set, $state) {
                                            // Remove separator (comma) before calculation
                                            $cleanState = str_replace(',', '', $state);
                                            $sellingPrice = (float)$cleanState * 1.70;
                                            // Format selling price with thousands separator
                                            $set('selling_price', number_format($sellingPrice, 0, '', ','));
                                        })
                                        ->disabled(fn(Forms\Get $get): bool => blank($get('item_id'))),
                                    TextInput::make('selling_price')
                                        ->label('Selling Price')
                                        ->numeric()
                                        ->mask(RawJs::make('$money($input)'))
                                        ->stripCharacters(',')
                                        ->required()
                                        ->disabled(fn(Forms\Get $get): bool => blank($get('item_id'))),
                                    TextInput::make('discount')
                                        ->label('Discount')
                                        ->numeric()
                                        ->nullable()
                                        ->disabled(fn(Forms\Get $get): bool => blank($get('item_id'))),
                                    Select::make('supplier_id')
                                        ->label('Supplier')
                                        ->placeholder('Pilih Supplier')
                                        ->relationship(
                                            name: 'supplier',
                                            titleAttribute: 'name',
                                            modifyQueryUsing: fn($query) => $query->where('partner_type', 'supplier')
                                        )
                                        ->searchable()
                                        ->required()
                                        ->disabled(fn(Forms\Get $get): bool => blank($get('item_id'))),
                                ])
                                ->columnSpan('full'),
                            // Add subtotal placeholder below the TableRepeater
                            Forms\Components\Placeholder::make('subtotal')
                                ->label('Subtotal')
                                ->content(function (\Filament\Forms\Get $get) {
                                    $items = $get('items') ?? [];
                                    $subtotal = 0;
                                    foreach ($items as $item) {
                                        $qty = isset($item['quantity']) ? (float)$item['quantity'] : 0;
                                        $price = isset($item['selling_price']) ? (float)str_replace(',', '', $item['selling_price']) : 0;
                                        $discount = isset($item['discount']) ? (float)$item['discount'] : 0;
                                        $subtotal += ($qty * $price) - $discount;
                                    }
                                    return number_format($subtotal, 0, ',', '.');
                                })
                                ->columnSpan('full'),
                        ]),

                        Grid::make(4)->schema([
                            Textarea::make('notes')
                                ->label('Keterangan')
                                ->columnSpan(1)
                                ->rows(4),
                            // Placeholder::make('')->content(''),
                            // Placeholder::make('')->content(''),
                            FileUpload::make('attachments')
                                ->label('Lampiran')
                                ->disk('public')
                                ->directory('housing-units')
                                ->openable()
                                ->columnSpan(2)
                                ->panelLayout('grid')
                                ->multiple()
                                ->moveFiles(),
                        ])
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('po_no')
                    ->label('No. PO')
                    ->searchable(),


                Tables\Columns\TextColumn::make('customer.name') // Better to show customer name instead of ID
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('trxdate')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('rfq_number')
                    ->label('No. RFQ')
                    ->searchable(),

                Tables\Columns\TextColumn::make('rfq_duration')
                    ->label('Waktu Pengiriman')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('trxdate')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('from')->label('Dari Tanggal'),
                        \Filament\Forms\Components\DatePicker::make('until')->label('Sampai Tanggal'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn($q, $date) => $q->whereDate('trxdate', '>=', $date))
                            ->when($data['until'], fn($q, $date) => $q->whereDate('trxdate', '<=', $date));
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}

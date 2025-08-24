<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfferRequestResource\Pages;
use App\Filament\Resources\OrderResource;
use App\Models\Item;
use App\Models\OfferRequest;
use App\Models\Salesman;
use App\Models\SalesmanGroup;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Component;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;

class OfferRequestResource extends Resource
{
    protected static ?string $model = OfferRequest::class;

    protected static ?string $navigationGroup = 'Transaksi';
    protected static ?string $navigationLabel = 'Permintaan Penawaran';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $pluralModelLabel = 'Permintaan Penawaran';
    protected static ?string $modelLabel = 'Permintaan Penawaran';

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
                                ->relationship(
                                    name: 'customer',
                                    titleAttribute: 'name',
                                    modifyQueryUsing: fn($query) => $query->where('partner_type', 'customer')
                                )
                                ->searchable()
                                ->required(),
                            DatePicker::make('trxdate')->label('Tanggal')->required()->default(Carbon::now()),
                            TextInput::make('ph_no')->label('No. Penawaran Harga')->required()->default(fn() => OfferRequest::generateTrxNo()),
                            TextInput::make('rfq_number')->label('No. RFQ')->nullable(),
                            TextInput::make('validity')->label('Validity (Hari)')->default('14')->numeric()->nullable(),
                            TextInput::make('payment_deadline')->label('Pembayaran')->nullable()->default('1 Bulan'),
                            TextInput::make('rfq_duration')->label('Delivery Time')->nullable()->required(),

                            Select::make('salesman_group_id')
                                ->label('Salesman Group')
                                ->placeholder('Pilih Salesman Group')
                                ->relationship(
                                    name: 'salesmanGroup',
                                    titleAttribute: 'name',
                                )
                                ->getOptionLabelFromRecordUsing(function (SalesmanGroup $record) {
                                    $salesmenNames = $record->salesmen->pluck('name')->implode(', ');
                                    return "{$record->name} ({$salesmenNames})";
                                })
                                ->searchable(['name'])
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
                                        ->live()
                                        ->afterStateUpdated(function (Forms\Set $set, $state, Forms\Get $get, Component $component) {
                                            $item = Item::find($state);
                                            if ($item) {
                                                $purchasePrice = $item->price;
                                                $sellingPrice = $purchasePrice * 1.70;
                                                $set('purchase_price', number_format($purchasePrice, 0, '', ','));
                                                $set('selling_price', number_format($sellingPrice, 0, '', ','));
                                            } else {
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
                                        ->mask(RawJs::make('$money($input)'))
                                        ->stripCharacters(',')
                                        ->required()
                                        ->extraAttributes([
                                            'x-model' => 'purchasePrice',
                                            'x-on:input' => 'updateSellingPrice()',
                                        ])
                                        ->disabled(fn(Forms\Get $get): bool => blank($get('item_id'))),

                                    TextInput::make('selling_price')
                                        ->label('Selling Price')
                                        ->numeric()
                                        ->extraAttributes([
                                            'x-model' => 'sellingPrice',
                                        ])
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
                                ->columnSpan('full')
                                ->extraAttributes([
                                    'x-data' => '{
                                        addRowOnSelect() {
                                            // Find all item_id selects in the repeater
                                            const selects = $el.querySelectorAll("select[name*=item_id]");
                                            if (selects.length) {
                                                const lastSelect = selects[selects.length - 1];
                                                lastSelect.addEventListener("change", () => {
                                                    // Wait for Livewire to update, then add a new row
                                                    setTimeout(() => {
                                                        $el.querySelector("[wire\\:click*=addItem]")?.click();
                                                    }, 300);
                                                });
                                            }
                                        }
                                    }',
                                    'x-init' => 'addRowOnSelect()',
                                ]),
                        ]),
                        Grid::make(4)->schema([
                            Textarea::make('notes')
                                ->label('Keterangan')
                                ->columnSpan(1)
                                ->rows(4),
                            FileUpload::make('attachment')
                                ->label('Lampiran')
                                ->disk('public')
                                ->multiple()
                                ->openable()
                                ->panelLayout('grid')
                                ->columnSpan(2)
                                ->directory('attachments'),
                        ])
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ph_no')
                    ->label('No Transaksi')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Nama Pelanggan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('trxdate')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
                BadgeColumn::make('status')
                    ->colors([
                        'primary' => 'draft',
                        'warning' => 'sent',
                        'success' => fn($state) => in_array($state, ['approved', 'completed']),
                        'danger' => 'rejected',
                    ]),
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
            ->defaultSort('ph_no', 'desc')
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

                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'sent' => 'Sent',
                        'approved' => 'Approved',
                        'completed' => 'Completed',
                        'rejected' => 'Rejected',
                    ]),
            ])
            ->actions([

                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('create_po')
                    ->label('Buat PO')
                    ->icon('heroicon-o-shopping-cart')
                    ->color('success')
                    ->url(function (OfferRequest $record): string {
                        return OrderResource::getUrl('create', ['offer_request_id' => $record->id]);
                    }),

            ])
            ->bulkActions([]);
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
            'index' => Pages\ListOfferRequests::route('/'),
            'create' => Pages\CreateOfferRequest::route('/create'),
            'edit' => Pages\EditOfferRequest::route('/{record}/edit'),
        ];
    }
}

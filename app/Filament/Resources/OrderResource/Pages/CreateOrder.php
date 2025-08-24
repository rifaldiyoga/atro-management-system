<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\OfferRequest; // Import model OfferRequest
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;


    /**
     * Metode ini dijalankan saat halaman dimuat.
     * Kita akan menggunakannya untuk mengisi form secara otomatis.
     */
    public function mount(): void
    {
        // Jalankan metode mount() dari parent terlebih dahulu untuk menginisialisasi form.
        parent::mount();

        // Memeriksa apakah ada 'offer_request_id' di URL
        if (request()->has('offer_request_id')) {
            // Mengambil data OfferRequest berdasarkan ID, dengan eager loading untuk efisiensi
            $offerRequest = OfferRequest::with('items')->find(request()->query('offer_request_id'));

            // Jika data ditemukan
            if ($offerRequest) {
                // Menyiapkan data untuk diisikan ke form
                $data = [
                    'customer_id' => $offerRequest->customer_id,
                    'trxdate' => $offerRequest->trxdate,
                    'notes' => $offerRequest->notes,
                    'ph_no' => $offerRequest->ph_no,
                    'rfq_number' => $offerRequest->rfq_number,
                    'rfq_duration' => $offerRequest->rfq_duration, // Menambahkan lampiran jika ada
                    'salesman_id' => $offerRequest->salesman_id,
                ];

                // Menyiapkan data untuk repeater 'items'
                $itemsData = [];
                foreach ($offerRequest->items as $item) {
                    $itemsData[] = [
                        'item_id' => $item->item_id,
                        'quantity' => $item->quantity,
                        'purchase_price' => $item->purchase_price,
                        'selling_price' => $item->selling_price,
                        'discount' => $item->discount,
                        'supplier_id' => $item->supplier_id,
                    ];
                }

                $data['repeater'] = [
                    'items' => $itemsData
                ];

                $this->form->fill($data);
            }
        }
    }
}

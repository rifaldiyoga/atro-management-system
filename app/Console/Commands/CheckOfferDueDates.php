<?php

namespace App\Console\Commands;

use App\Filament\Resources\OfferRequestResource;
use App\Models\OfferRequest;
use App\Models\User;
use Carbon\Carbon;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Console\Command;

class CheckOfferDueDates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-offer-due-dates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Periksa penawaran yang akan jatuh tempo dan kirim notifikasi';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memeriksa penawaran yang akan jatuh tempo...');

        // Tentukan interval hari pengingat dalam sebuah array
        $reminderIntervals = [7, 3];

        // Ambil semua penawaran yang masih aktif (misalnya, belum menjadi PO)
        $offers = OfferRequest::where('status', '!=', 'completed')->get();

        // Ambil semua pengguna yang akan menerima notifikasi (misalnya, semua admin)
        $recipients = User::all();

        foreach ($offers as $offer) {
            // Pastikan 'validity' adalah angka dan 'trxdate' adalah tanggal yang valid
            if (!is_numeric($offer->validity) || !$offer->trxdate) {
                continue;
            }

            // Hitung tanggal jatuh tempo
            $dueDate = Carbon::parse($offer->trxdate)->addDays((int)$offer->validity);

            // Loop melalui setiap interval pengingat
            foreach ($reminderIntervals as $days) {
                // Clone objek dueDate agar tidak termodifikasi di setiap iterasi
                $reminderDate = $dueDate->clone()->subDays($days);

                // Periksa apakah hari ini adalah hari pengingat untuk interval saat ini
                if (Carbon::today()->isSameDay($reminderDate)) {

                    // Kirim notifikasi ke setiap penerima
                    foreach ($recipients as $recipient) {
                        Notification::make()
                            ->title('Pengingat Jatuh Tempo Penawaran')
                            ->body("Penawaran dengan nomor {$offer->ph_no} untuk {$offer->customer->name} akan jatuh tempo dalam {$days} hari.")
                            ->actions([
                                Action::make('view')
                                    ->label('Lihat Penawaran')
                                    ->url(OfferRequestResource::getUrl('edit', ['record' => $offer])),
                            ])
                            ->sendToDatabase($recipient);
                    }

                    $this->info("Notifikasi {$days} hari dikirim untuk penawaran #{$offer->ph_no}");

                    // Hentikan loop interval untuk penawaran ini karena notifikasi hari ini sudah dikirim
                    break;
                }
            }
        }

        $this->info('Pemeriksaan selesai.');

        return self::SUCCESS;
    }
}

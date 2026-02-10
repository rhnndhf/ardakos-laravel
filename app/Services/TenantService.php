<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Room;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TenantService
{
    /**
     * Register a new tenant and assign them to a room.
     *
     * @param array{
     *     name: string,
     *     gender: string,
     *     phone: string,
     *     ktp_url: string,
     *     check_in_date: string,
     *     room_id: int
     * } $data
     * @throws ValidationException
     */
    public function registerTenant(array $data): Tenant
    {
        return DB::transaction(function () use ($data) {
            $room = Room::findOrFail($data['room_id']);

            // Validasi ketersediaan kamar
            if ($room->occupancy_status === 'Terisi') {
                throw ValidationException::withMessages([
                    'room_id' => 'Kamar ini sudah penuh.',
                ]);
            }

            // Validasi gender (aturan syariah/kost)
            $genderMap = [
                'Laki-laki' => 'Putra',
                'Perempuan' => 'Putri',
            ];

            if (
                $room->room_type !== 'Campur' &&
                $room->room_type !== ($genderMap[$data['gender']] ?? $data['gender'])
            ) {
                throw ValidationException::withMessages([
                    'gender' => "Kamar ini khusus untuk {$room->room_type}.",
                ]);
            }

            $tenant = Tenant::create([
                'name' => $data['name'],
                'gender' => $data['gender'],
                'phone' => $data['phone'],
                'ktp_url' => $data['ktp_url'],
                'check_in_date' => $data['check_in_date'],
                'room_id' => $room->id,
                'status' => 'AKTIF',
            ]);

            // Update status kamar
            $room->increment('active_occupants');
            $room->refresh();

            if ($room->active_occupants >= 1) { // Asumsi 1 kamar max 1 orang untuk sekarang
                $room->update(['occupancy_status' => 'Terisi']);
            }

            return $tenant;
        });
    }

    /**
     * Process tenant checkout.
     */
    public function checkoutTenant(Tenant $tenant, string $checkOutDate): void
    {
        DB::transaction(function () use ($tenant, $checkOutDate) {
            $tenant->update([
                'status' => 'NONAKTIF',
                'check_out_date' => $checkOutDate,
            ]);

            if ($tenant->room_id) {
                $room = $tenant->room;
                $room->decrement('active_occupants');

                if ($room->active_occupants === 0) {
                    $room->update(['occupancy_status' => 'Tersedia']);
                }
            }
        });
    }
}

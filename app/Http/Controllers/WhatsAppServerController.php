<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WhatsAppServer;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;

class WhatsAppServerController extends Controller
{
    public function createwaserver(array $data): void
    {
        // 1. Validasi data input
        $validatedData = Validator::make($data, [
            'nama' => 'required',
            'no_wa' => 'required|string|max:15', // No WhatsApp wajib diisi
        ])->validate();

        // 2. Kirim data ke API SentWA (Create Instance)
        try {
            $response = Http::post('http://localhost:3000/api/getQR', [
                'no_wa' => $validatedData['no_wa'], // Kirim nomor WA ke API
                'access_token' => env('WABLAST_API_KEY'), // Menggunakan token dari .env
            ]);
            
            // 3. Cek apakah respons API berhasil
            if ($response->successful()) {
                // Pastikan respons mengandung instance_id
                $responseData = $response->json();
                
                // if (isset($responseData['instance_id']) && !empty($responseData['instance_id'])) {
                //     $instanceId = $responseData['instance_id'];

                    // 4. Simpan data ke database
                    WhatsAppServer::create([
                        'no_wa' => $validatedData['no_wa'], // Nomor WhatsApp
                        // 'instance_id' => $instanceId, // Instance ID dari SentWA
                    ]);

                    // 5. Notifikasi sukses
                    Notification::make()
                        ->title('WA Server Created Successfully!')
                        ->success()
                        ->send();
                } 
                // else {
                //     // 6. Jika tidak ada instance_id dalam respons
                //     Notification::make()
                //         ->title('Failed to Create WA Server: No instance_id')
                //         ->danger()
                //         ->send();
                // }
            else {
                // 7. Jika respons API gagal (status code bukan 2xx)
                Notification::make()
                    ->title('Failed to Create WA Server: API Error')
                    ->danger()
                    ->send();
            }
        } catch (\Exception $e) {
            // 8. Jika terjadi error pada request (misalnya masalah jaringan)
            Notification::make()
                ->title('Failed to Create WA Server: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }
}

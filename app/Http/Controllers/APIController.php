<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Kelas;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class APIController extends Controller
{
    public function terimaDataJadwal(Request $request)
    {
        $dataJadwal = $request->all();

        DB::beginTransaction();
        try {
            foreach ($dataJadwal as $item) {
                // Pastikan struktur slot_waktu valid dan tidak kosong
                if (!isset($item['slot_waktu']) || !is_array($item['slot_waktu']) || count($item['slot_waktu']) === 0) {
                    continue;
                }

                // Ambil index pertama (mulai) dan terakhir (selesai)
                $firstSlotStr = $item['slot_waktu'][0];
                $lastSlotStr = end($item['slot_waktu']);

                // Ekstrak hari dan angka slot (e.g. "Jumat_3" -> "Jumat" dan "3")
                $firstSlotParts = explode('_', $firstSlotStr);
                $lastSlotParts = explode('_', $lastSlotStr);

                $hari = strtolower($firstSlotParts[0]); // menjadi lowercase sesuai ENUM database
                $startSlotNum = (int) $firstSlotParts[1];
                $endSlotNum = (int) $lastSlotParts[1];

                // Slot ke-1 dimulai jam 08:00, setiap slot bernilai 50 menit
                $jamMulai = Carbon::createFromTime(8, 0)->addMinutes(($startSlotNum - 1) * 50)->format('H:i:s');
                $jamSelesai = Carbon::createFromTime(8, 0)->addMinutes($endSlotNum * 50)->format('H:i:s');

                // Ambil data kelas beserta angkatannya untuk field id_sekolah, semester, tingkat
                $kelas = Kelas::with('angkatan')->find($item['id_kelas']);

                if (!$kelas || !$kelas->angkatan) {
                    continue; // Skip apabila data kelas atau angkatan terkait tidak ditemukan
                }

                Jadwal::create([
                    'id_sekolah'  => $kelas->id_sekolah,
                    'id_kelas'    => $item['id_kelas'],
                    'id_mapel'    => $item['id_mapel'],
                    'id_ruangan'  => $item['id_ruangan'], // Sesuaikan dengan field pada input
                    'hari'        => $hari,
                    'jam_mulai'   => $jamMulai,
                    'jam_selesai' => $jamSelesai,
                    'semester'    => $kelas->angkatan->semester,
                    'tingkat'     => $kelas->angkatan->id_tingkat,
                ]);
            }
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data jadwal berhasil diproses dan disimpan.',
                'data_count' => count($dataJadwal)
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data jadwal',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

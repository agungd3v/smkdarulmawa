<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jadwal;

class DashboardController extends Controller
{
    public function jadwal() {
        $arrDay = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', "Jum'at", 'Sabtu'];
        $hari = $arrDay[getdate()['wday']];
        $jadwal = Jadwal::with(['pelajaran'])->where('nama_hari', 'Selasa')->first();

        return response()->json([
            'status' => $jadwal ? true : false,
            'message' => $jadwal ? $jadwal : '-'
        ]);
    }
}

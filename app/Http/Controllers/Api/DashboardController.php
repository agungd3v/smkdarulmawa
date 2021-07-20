<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jadwal;
use App\User;

class DashboardController extends Controller
{
    public function jadwal() {
        $arrDay = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', "Jum'at", 'Sabtu'];
        $hari = $arrDay[getdate()['wday']];
        $jadwal = Jadwal::with(['pelajaran'])->where('nama_hari', $hari)->first();

        return response()->json([
            'status' => $jadwal ? true : false,
            'message' => $jadwal ? $jadwal : '-'
        ]);
    }

    public function siswa() {
        $user = User::where('role', 'siswa')->get();

        return response()->json([
            'status' => $user ? true : false,
            'message' => $user ? $user : 'Tidak ditukan adanya siswa'
        ]);
    }
}

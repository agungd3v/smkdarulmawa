<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jadwal;

class GuruController extends Controller
{
    public function index() {
        return view('dashboard.guru.index');
    }

    public function jadwal() {
        $jadwals = Jadwal::with(['pelajaran'])->get();
        return view('dashboard.guru.jadwal', compact('jadwals'));
    }
}

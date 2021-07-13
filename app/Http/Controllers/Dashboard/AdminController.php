<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
        return view('dashboard.admin.index');
    }

    public function guru() {
        return view('dashboard.admin.guru');
    }

    public function siswa() {
        return view('dashboard.admin.siswa');
    }

    public function pelajaran() {
        return view('dashboard.admin.pelajaran');
    }

    public function absen() {
        return view('dashboard.admin.absen');
    }

    public function nilai() {
        return view('dashboard.admin.nilai');
    }
}

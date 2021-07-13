<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    public function index() {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        if ($user->role === 'guru') {
            return redirect()->route('guru.dashboard');
        }
        if ($user->role === 'siswa') {
            return redirect()->route('siswa.dashboard');
        }
    }
}

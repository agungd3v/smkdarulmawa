<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;

class ProfileController extends Controller
{
    public function index() {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function update(Request $request) {
        $request->validate([
            'name' => 'required'
        ]);

        $user = User::find(Auth::user()->id);
        $user->name = $request->name;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        if ($request->nidn) {
            $user->nidn = $request->nidn;
        }

        $user->save();

        return redirect()->route('user.profile')->with('berhasil', 'Profile berhasil di ubah');
    }
}

<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;

class AdminController extends Controller
{
    public function index() {
        return view('dashboard.admin.index');
    }

    // Guru
    public function guru() {
        $gurus = User::where('role', 'guru')->orderBy('id', 'desc')->paginate(5);
        return view('dashboard.admin.guru', compact('gurus'));
    }

    public function guruPost(Request $request) {
        $request->validate([
            'name' => 'required',
            'nidn' => 'required|numeric|unique:users,nidn',
            'email' => 'required|email|unique:users,email',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->nidn = intval($request->nidn);
        $user->email = $request->email;
        $user->password = Hash::make('smkdarulmawa');
        $user->role = 'guru';
        $user->save();

        return redirect()->route('admin.guru')->with('berhasil', 'Data guru '. $request->name .' berhasil ditambahkan');
    }

    public function guruUpdate(Request $request) {
        $request->validate([
            'name' => 'required',
            'nidn' => 'required|numeric',
            'email' => 'required|email',
        ]);

        $user = User::where('id', $request->id)->first();
        $user->name = $request->name;
        $user->nidn = $request->nidn;
        $user->email = $request->email;

        $checkNidn = User::where('nidn', $request->nidn)->first();
        if ($checkNidn) {
            if ($checkNidn->id != $user->id) {
                return redirect()->route('admin.guru')->with('errorMessage', 'NIGN telah terdaftar');
            }
        }

        $checkEmail = User::where('email', $request->email)->first();
        if ($checkEmail) {
            if ($checkEmail->id != $user->id) {
                return redirect()->route('admin.guru')->with('errorMessage', 'Email telah terdaftar');
            }
        }

        if ($request->oldpassword && $request->newpassword) {
            if (!Hash::check($request->oldpassword, $user->password)) {
                return redirect()->route('admin.guru')->with('errorMessage', 'Password lama tidak benar!');
            }
            $user->password = Hash::make($request->newpassword);
        }

        $user->save();

        return redirect()->route('admin.guru')->with('berhasil', 'Data guru '. $request->name .' berhasil diperbarui');
    }

    public function gutuDelete(Request $request) {
        $user = User::where('id', $request->id)->first();
        if (!$user) {
            return redirect()->route('admin.guru')->with('errorMessage', 'Kamu siapa ?');
        }

        $user->delete();

        return redirect()->route('admin.guru')->with('berhasil', 'Guru '. $user->name .' berhasil dihapus');
    }

    public function guruResetPassword(Request $request) {
        $user = User::where('id', $request->id)->first();
        if (!$user) {
            return redirect()->route('admin.guru')->with('errorMessage', 'Kamu siapa ?');
        }

        $user->password = Hash::make('smkdarulmawa');
        $user->save();

        return redirect()->route('admin.guru')->with('berhasil', 'Password '. $user->name .' berhasil direset menjadi smkdarulmawa');
    }
    // End Guru

    // Siswa
    public function siswa() {
        $siswas = User::where('role', 'siswa')->orderBy('id', 'desc')->paginate(5);
        return view('dashboard.admin.siswa', compact('siswas'));
    }

    public function siswaPost(Request $request) {
        $request->validate([
            'name' => 'required',
            'nidn' => 'required|numeric|unique:users,nidn',
            'email' => 'required|email|unique:users,email',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->nidn = intval($request->nidn);
        $user->email = $request->email;
        $user->password = Hash::make('smkdarulmawa');
        $user->role = 'siswa';
        $user->save();

        return redirect()->route('admin.siswa')->with('berhasil', 'Data siswa '. $request->name .' berhasil ditambahkan');
    }

    public function siswaUpdate(Request $request) {
        $request->validate([
            'name' => 'required',
            'nidn' => 'required|numeric',
            'email' => 'required|email',
        ]);

        $user = User::where('id', $request->id)->first();
        $user->name = $request->name;
        $user->nidn = $request->nidn;
        $user->email = $request->email;

        $checkNidn = User::where('nidn', $request->nidn)->first();
        if ($checkNidn) {
            if ($checkNidn->id != $user->id) {
                return redirect()->route('admin.siswa')->with('errorMessage', 'NISN telah terdaftar');
            }
        }

        $checkEmail = User::where('email', $request->email)->first();
        if ($checkEmail) {
            if ($checkEmail->id != $user->id) {
                return redirect()->route('admin.siswa')->with('errorMessage', 'Email telah terdaftar');
            }
        }

        if ($request->oldpassword && $request->newpassword) {
            if (!Hash::check($request->oldpassword, $user->password)) {
                return redirect()->route('admin.siswa')->with('errorMessage', 'Password lama tidak benar!');
            }
            $user->password = Hash::make($request->newpassword);
        }

        $user->save();

        return redirect()->route('admin.siswa')->with('berhasil', 'Data siswa '. $request->name .' berhasil diperbarui');
    }

    public function siswaDelete(Request $request) {
        $user = User::where('id', $request->id)->first();
        if (!$user) {
            return redirect()->route('admin.siswa')->with('errorMessage', 'Kamu siapa ?');
        }

        $user->delete();

        return redirect()->route('admin.siswa')->with('berhasil', 'Siswa '. $user->name .' berhasil dihapus');
    }

    public function siswaResetPassword(Request $request) {
        $user = User::where('id', $request->id)->first();
        if (!$user) {
            return redirect()->route('admin.siswa')->with('errorMessage', 'Kamu siapa ?');
        }

        $user->password = Hash::make('smkdarulmawa');
        $user->save();

        return redirect()->route('admin.siswa')->with('berhasil', 'Password '. $user->name .' berhasil direset menjadi smkdarulmawa');
    }
    // End Siswa

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

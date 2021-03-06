<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\Pelajaran;
use App\Jadwal;
use App\Absen;
use App\Jawaban;
use App\Materi;
use App\Tugas;
use PDF;

class AdminController extends Controller
{
    public function index() {
        $siswa = User::where('role', 'siswa')->count();
        $guru = User::where('role', 'guru')->count();
        $pelajaran = Pelajaran::count();
        $materi = Materi::count();
        return view('dashboard.admin.index', compact('siswa', 'guru', 'pelajaran', 'materi'));
    }

    // Guru
    public function guru() {
        $gurus = User::where('role', 'guru')->orderBy('id', 'desc')->paginate(10);
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

        if ($request->newpassword) {
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
        $siswas = User::where('role', 'siswa')->orderBy('id', 'desc')->paginate(10);
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

        if ($request->newpassword) {
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

    // Pelajaran
    public function pelajaran() {
        $pelajarans = Pelajaran::orderBy('id', 'desc')->paginate(10);
        $gurus = User::where('role', 'guru')->orderBy('name', 'asc')->get();
        return view('dashboard.admin.pelajaran', compact('gurus', 'pelajarans'));
    }

    public function pelajaranPost(Request $request) {
        $request->validate([
            'kode' => 'required|unique:pelajarans,kode_pelajaran',
            'name' => 'required',
            'pengajar' => 'required',
            'waktu' => 'required'
        ]);

        $pelajaran = new Pelajaran();
        $pelajaran->kode_pelajaran = $request->kode;
        $pelajaran->nama_pelajaran = $request->name;
        $pelajaran->guru_id = intval($request->pengajar);
        $pelajaran->jam = intval($request->waktu);
        $pelajaran->save();

        return redirect()->route('admin.pelajaran')->with('berhasil', 'Pelajaran '. $request->name .' berhasil ditambahkan');
    }

    public function pelajaranUpdate(Request $request) {
        $request->validate([
            'kode' => 'required',
            'name' => 'required',
            'pengajar' => 'required',
            'waktu' => 'required'
        ]);

        $pelajaran = Pelajaran::where('id', $request->id)->first();
        $pelajaran->kode_pelajaran = $request->kode;
        $pelajaran->nama_pelajaran = $request->name;
        $pelajaran->guru_id = intval($request->pengajar);
        $pelajaran->jam = intval($request->waktu);

        $checkKode = Pelajaran::where('kode_pelajaran', $request->kode)->first();
        if ($checkKode) {
            if ($checkKode->id != $pelajaran->id) {
                return redirect()->route('admin.pelajaran')->with('errorMessage', 'Kode pelajaran telah terdaftar');
            }
        }

        $pelajaran->save();

        return redirect()->route('admin.pelajaran')->with('berhasil', 'Pelajaran '. $request->name .' berhasil diperbarui');
    }

    public function pelajaranDelete(Request $request) {
        $pelajaran = Pelajaran::where('id', $request->id)->first();
        if (!$pelajaran) {
            return redirect()->route('admin.pelajaran')->with('errorMessage', 'Kamu siapa ?');
        }

        $pelajaran->delete();

        return redirect()->route('admin.pelajaran')->with('berhasil', 'Pelajaran '. $pelajaran->nama_pelajaran .' berhasil dihapus');
    }
    // End Pelajaran

    // Jadwal
    public function jadwal() {
        $jadwals = Jadwal::with(['pelajaran'])->get();
        $pelajarans = Pelajaran::orderBy('nama_pelajaran', 'asc')->get();
        return view('dashboard.admin.jadwal', compact('jadwals', 'pelajarans'));
    }

    public function jadwalPost(Request $request) {
        if ($request->identity) {
            if ($request->identity == 'jadwal_hari') {
                $request->validate([
                    'name' => 'required|unique:jadwals,nama_hari',
                    'masuk' => 'required',
                    'pulang' => 'required'
                ]);
        
                $jadwal = new Jadwal();
                $jadwal->nama_hari = $request->name;
                $jadwal->jam_masuk = $request->masuk;
                $jadwal->jam_pulang = $request->pulang;
                $jadwal->save();

                return redirect()->route('admin.jadwal')->with('berhasil', 'Jadwal hari '. $request->name .' berhasil diset');
            }
            if ($request->identity == 'jadwal_pelajaran') {
                $request->validate([
                    'jadwal_hari' => 'required',
                    'pelajaran' => 'required',
                    'jam_masuk' => 'required',
                    'jam_pulang' => 'required'
                ]);

                $pelajaran = Pelajaran::where('id', $request->pelajaran)->first();

                $jadwal = json_decode($request->jadwal_hari);
                $jadwal = Jadwal::where('id', $jadwal->id)->first();
                $jadwal->pelajaran()->attach($pelajaran->id, ['jam_masuk' => $request->jam_masuk, 'jam_pulang' => $request->jam_pulang]);
                
                return redirect()->route('admin.jadwal')
                                 ->with('berhasil', 'Pelajaran '. $pelajaran->nama_pelajaran .' berhasil ditambahkan ke hari '. $jadwal->nama_hari);
            }
        } else {
            return redirect()->route('admin.jadwal')->with('errorMessage', 'Sistem tidak mengetahui apa yang ingin kamu lakukan!');
        }
    }

    public function jadwalUpdate(Request $request) {
        if ($request->identity) {
            $jadwal = Jadwal::where('id', $request->id)->first();

            if ($request->identity == 'jadwal_hari') {
                $jadwal->jam_masuk = $request->masuk;
                $jadwal->jam_pulang = $request->pulang;
                $jadwal->save();

                return redirect()->route('admin.jadwal')->with('berhasil', 'Jadwal hari '. $jadwal->nama_hari .' berhasil diperbarui');
            }

            if ($request->identity == 'jadwal_pelajaran') {
                $jadwal->pelajaran()->updateExistingPivot($request->pelajaran_id, [
                    'jam_masuk' => $request->jam_masuk,
                    'jam_pulang' => $request->jam_pulang
                ]);
                
                $dataPelajaran = null;
                foreach ($jadwal->pelajaran as $key => $pelajaran) {
                    if ($pelajaran->id == $request->pelajaran_id) $dataPelajaran = $pelajaran;
                }

                return redirect()->route('admin.jadwal')->with('berhasil', 'Waktu pelajaran '. $dataPelajaran->nama_pelajaran .' berhasil diperbarui');
            }
        } else {
            return redirect()->route('admin.jadwal')->with('errorMessage', 'Sistem tidak mengetahui apa yang ingin kamu lakukan!');
        }

    }

    public function jadwalDelete(Request $request) {
        if ($request->identity) {
            $jadwal = Jadwal::where('id', $request->id)->first();

            if ($request->identity == 'hari') {
                if (!$jadwal) {
                    return redirect()->route('admin.jadwal')->with('errorMessage', 'Kamu siapa ?');
                }
                
                $jadwal->delete();
                
                return redirect()->route('admin.jadwal')->with('berhasil', 'Hari berhasil dihapus');
            }
            
            if ($request->identity == 'pelajaran') {
                if (!$jadwal) {
                    return redirect()->route('admin.jadwal')->with('errorMessage', 'Kamu siapa ?');
                }

                $jadwal->pelajaran()->detach($request->pelajaran_id);
                
                return redirect()->route('admin.jadwal')->with('berhasil', 'Pelajaran berhasil dihapus');
            }
        } else {
            return redirect()->route('admin.jadwal')->with('errorMessage', 'Sistem tidak mengetahui apa yang ingin kamu lakukan!');
        }
    }
    // End Jadwal

    public function absen() {
        $pelajarans = Pelajaran::orderBy('nama_pelajaran', 'asc')->get();
        $absens = Absen::with('user', 'pelajaran')->orderBy('id', 'desc')->paginate(10);
        return view('dashboard.admin.absen', compact('absens', 'pelajarans'));
    }

    public function nilai() {
        $pelajarans = Pelajaran::orderBy('nama_pelajaran', 'asc')->get();
        $jawabans = Jawaban::with('user', 'tugas')->orderBy('created_at', 'desc')->paginate(15);
        return view('dashboard.admin.nilai', compact('jawabans', 'pelajarans'));
    }

    public function reportAbsen(Request $request) {
        $pelajaran = Pelajaran::with('guru')->where('id', $request->pelajaran)->first();
        $from = null;
        $to = null;
        if ($pelajaran) {
            if ($request->from == null && $request->to == null) {
                $absens = Absen::with('user')->where('pelajaran_id', $pelajaran->id)->orderBy('created_at', 'desc')->get();
            } else {
                if ($request->from != null && $request->to == null) {
                    $from = date('d/m/Y', strtotime($request->from));
                    $absens = Absen::with('user')
                                    ->where('created_at', '>', $request->from)
                                    ->where('pelajaran_id', $pelajaran->id)
                                    ->orderBy('created_at', 'desc')
                                    ->get();
                } elseif ($request->to != null && $request->from == null) {
                    $to = date('d/m/Y', strtotime($request->to));
                    $absens = Absen::with('user')
                                    ->where('created_at', '<', $request->to)
                                    ->where('pelajaran_id', $pelajaran->id)
                                    ->orderBy('created_at', 'desc')
                                    ->get();
                } else {
                    $from = date('d/m/Y', strtotime($request->from));
                    $to = date('d/m/Y', strtotime($request->to));
                    $absens = Absen::with('user')
                                    ->whereBetween('created_at', [$request->from, $request->to])
                                    ->where('pelajaran_id', $pelajaran->id)
                                    ->orderBy('created_at', 'desc')
                                    ->get();
                }
            }

            $pdf = PDF::loadview('report.absen', compact('pelajaran', 'absens', 'from', 'to'))->setPaper('A4', 'potrait');
            return $pdf->stream(
                "Report Absen" . ($from || $to ? " - " : "") . ($from && $to ? "($from - " : $from) . ($from && $to ? "$to)" : $to)
            );
        } else {
            return redirect()->route('admin.absen')->with('errorMessage', 'Mohon pilih pelajaran terlebih dahulu!');
        }

    }

    public function reportNilai(Request $request) {
        $tugas = Tugas::with('jawaban')->where('id', $request->tugas)->first();
        $from = null;
        $to = null;
        if ($tugas) {
            if ($request->from == null && $request->to == null) {
                $jawabans = Jawaban::where('tugas_id', $tugas->id)->orderBy('nilai', 'desc')->get();
            } else {
                if ($request->from != null && $request->to == null) {
                    $from = date('d/m/Y', strtotime($request->from));
                    $jawabans = Jawaban::where('tugas_id', $tugas->id)
                                    ->where('created_at', '>', $request->from)
                                    ->orderBy('nilai', 'desc')
                                    ->get();
                } elseif ($request->to != null && $request->from == null) {
                    $to = date('d/m/Y', strtotime($request->to));
                    $jawabans = Jawaban::where('tugas_id', $tugas->id)
                                    ->where('created_at', '<', $request->to)
                                    ->orderBy('nilai', 'desc')
                                    ->get();
                } else {
                    $from = date('d/m/Y', strtotime($request->from));
                    $to = date('d/m/Y', strtotime($request->to));
                    $jawabans = Jawaban::where('tugas_id', $tugas->id)
                                    ->whereBetween('created_at', [$request->from, $request->to])
                                    ->orderBy('nilai', 'desc')
                                    ->get();
                }
            }

            $pdf = PDF::loadview('report.nilai', compact('tugas', 'jawabans', 'from', 'to'))->setPaper('A4', 'potrait');
            return $pdf->stream(
                "Report Nilai" . ($from || $to ? " - " : "") . ($from && $to ? "($from - " : $from) . ($from && $to ? "$to)" : $to)
            );
        } else {
            return redirect()->route('guru.tugas')->with('errorMessage', 'Mohon pilih pelajaran terlebih dahulu!');
        }
    }
}

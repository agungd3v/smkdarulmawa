<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Jadwal;
use App\Absen;
use App\Materi;
use App\Pelajaran;
use App\User;
use App\Tugas;
use App\Jawaban;

class GuruController extends Controller
{
    public function index() {
        return view('dashboard.guru.index');
    }

    public function jadwal() {
        $jadwals = Jadwal::with(['pelajaran'])->get();
        return view('dashboard.guru.jadwal', compact('jadwals'));
    }

    public function absen() {
        $absens = Absen::with(['user', 'pelajaran'])->get();
        return view('dashboard.guru.absen', compact('absens'));
    }

    public function materi() {
        $guru = User::with(['pelajaran'])->where('id', Auth::user()->id)->first();
        $pelajarans = Auth::user()->pelajaran;
        return view('dashboard.guru.materi', compact('pelajarans', 'guru'));
    }

    public function materiPost(Request $request) {
        $request->validate([
            'pelajaran_id' => 'required',
            'judul' => 'required',
            'materi' => 'required'
        ]);

        $user = Auth::user();
        $pelajaran = Pelajaran::where('id', $request->pelajaran_id)->first();
        $materi = new Materi();
        
        if ($pelajaran) {
            $materi->guru_id = $user->id;
            $materi->pelajaran_id = $pelajaran->id;
            $materi->judul = $request->judul;
            $materi->materi = $request->materi;
            $materi->save();

            return redirect()->route('guru.materi')->with('berhasil', 'Berhasil menambahkan materi pelajaran '. $pelajaran->nama_pelajaran);
        } else {
            return redirect()->route('guru.materi')->with('errorMessage', 'Pelajaran tidak dikenali!');
        }
    }

    public function tugas() {
        $guru = User::with(['pelajaran'])->where('id', Auth::user()->id)->first();
        // dd($guru);
        return view('dashboard.guru.tugas', compact('guru'));
    }

    public function tugasPost(Request $request) {
        $request->validate([
            'pelajaran_id' => 'required',
            'soal' => 'required',
            'deadline' => 'required'
        ]);
        
        $pelajaran = Pelajaran::find($request->pelajaran_id);
        if (!$pelajaran) {
            return redirect()->route('guru.tugas')->with('errorMessage', 'Aksi yang kamu lakukan tidak dikenali oleh sistem kami');
        }

        $tugas = new Tugas();
        $tugas->pelajaran_id = $pelajaran->id;
        $tugas->soal = $request->soal;
        $tugas->deadline = $request->deadline;
        $tugas->save();

        return redirect()->route('guru.tugas')->with('berhasil', 'Berhasil menambahkan tugas pada pelajaran '. $pelajaran->nama_pelajaran);
    }

    public function tugasPenilaian(Request $request) {
        $request->validate([
            'menilai' => 'required|numeric'
        ]);

        $jawaban = Jawaban::with('user', 'tugas')->where('siswa_id', $request->siswa_id)->where('tugas_id', $request->tugas_id)->first();
        if (!$jawaban) {
            return redirect()->route('guru.tugas')->with('errorMessage', 'Sistem tidak mengenali aksi yang ingin kamu lakukan!');
        }

        $jawaban->nilai = $request->menilai;
        $jawaban->save();

        return redirect()->route('guru.tugas')->with('berhasil', 'Berhasil memberikan nilai '. $jawaban->nilai .' untuk siswa '. $jawaban->user->name);
    }
}

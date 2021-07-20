<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Jadwal;
use App\Pelajaran;
use App\Absen;
use App\Jawaban;
use App\Materi;
use App\Komentar;
use App\Tugas;

class SiswaController extends Controller
{
    public function index() {
        return view('dashboard.siswa.index');
    }

    public function jadwal() {
        $jadwals = Jadwal::with(['pelajaran'])->get();
        return view('dashboard.siswa.jadwal', compact('jadwals'));
    }

    public function absen() {
        $absens = Absen::with('user', 'pelajaran')->get();
        return view('dashboard.siswa.absen', compact('absens'));
    }

    public function absenPost(Request $request) {
        if ($request->identity) {
            $pelajaran = Pelajaran::where('id', $request->pelajaran_id)->first();
            $user = Auth::user();

            if ($pelajaran && $user) {
                $absen = new Absen();
                $absen->siswa_id = $user->id;
                $absen->pelajaran_id = $pelajaran->id;    

                if ($request->identity == 'absen') {
                    $absen->status = 'Hadir';
                } else {
                    $absen->status = 'Invalid';
                }

                $absen->save();

                return redirect()->route('siswa.absen')->with('berhasil', 'Kamu telah behasil absen pelajaran '. $pelajaran->nama_pelajaran);
            } else {
                return redirect()->route('siswa.absen')->with('errorMessage', 'Pelajaran atau siswa tidak terdaftar');
            }
        } else {
            return redirect()->route('siswa.absen')->with('errorMessage', 'Kamu siapa ?');
        }
    }

    public function materi() {
        $pelajarans = Pelajaran::with(['materi'])->get();
        return view('dashboard.siswa.materi', compact('pelajarans'));
    }

    public function materiView($id) {
        $materi = Materi::with('pelajaran', 'user')->where('id', $id)->first();
        return view('dashboard.siswa.view-materi', compact('materi'));
    }

    public function komentarPost(Request $request) {
        $request->validate([
            'materi' => 'required',
            'comment' => 'required'
        ]);

        $user = Auth::user();
        $materi = Materi::where('id', $request->materi)->first();
        if (!$materi) {
            return redirect()->route('siswa.materi.view', $materi->id)->with('errorMessage', 'Something when wrong');
        }

        $komentar = new Komentar();
        $komentar->siswa_id = $user->id;
        $komentar->materi_id = $materi->id;
        $komentar->comment = $request->comment;
        $komentar->save();

        return redirect()->route('siswa.materi.view', $materi->id);
    }

    public function tugas() {
        $jawabanku = Jawaban::where('siswa_id', Auth::user()->id)->first();
        $pelajarans = Pelajaran::with(['tugas'])->get();
        return view('dashboard.siswa.tugas', compact('pelajarans', 'jawabanku'));
    }

    public function jawaban(Request $request) {
        $request->validate([
            'tugas_id' => 'required',
            'jawab' => 'required'
        ]);

        $tugas = Tugas::where('id', $request->tugas_id)->first();
        if (!$tugas) {
            return redirect()->route('siswa.tugas')->with('errorMessage', 'Sistem tidak mengetahui aksi yang kamu lakukan');
        }

        $user = Auth::user();
        $jawaban = new Jawaban();
        $jawaban->siswa_id = $user->id;
        $jawaban->tugas_id = $tugas->id;
        $jawaban->jawaban = $request->jawab;
        $jawaban->save();

        return redirect()->route('siswa.tugas')->with('berhasil', 'Kamu telah berhasil menjawab');
    }
}

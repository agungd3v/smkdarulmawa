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
use PDF;

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
        $pelajarans = Pelajaran::where('guru_id', Auth::user()->id)->get();
        $absens = Absen::with(['user', 'pelajaran'])->get();
        return view('dashboard.guru.absen', compact('absens', 'pelajarans'));
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
            return redirect()->route('guru.absen')->with('errorMessage', 'Mohon pilih pelajaran terlebih dahulu!');
        }

    }
}

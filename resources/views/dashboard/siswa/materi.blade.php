@extends('layouts.dashboard')
@section('title', 'Materi Pelajaran')
@section('materi', 'active')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        @foreach ($pelajarans as $pelajaran)
          <div class="row">
            <div class="col-12">
              <h1>{{ $pelajaran->nama_pelajaran }}</h1>
            </div>
          </div>
          <div class="row">
            @forelse ($pelajaran->materi as $materi)
              <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="w-100">
                  <div class="card card-stats mb-3" style="cursor: pointer" onclick="moveMateri('{{ route('siswa.materi.view', $materi->id) }}')">
                    <div class="card-body">
                      <div class="row">
                        <div class="col">
                          <h5 class="card-title text-uppercase text-muted mb-2">{{ date('m/d/Y', strtotime($materi->created_at)) }}</h5>
                          <span class="h2 font-weight-bold mb-0" style="line-height: 20px">{{ $materi->judul }}</span>
                        </div>
                        <div class="col-auto">
                          <div class="icon icon-shape bg-orange text-white rounded-circle shadow">
                            <i class="ni ni-chart-pie-35"></i>
                          </div>
                        </div>
                      </div>
                      <p class="mt-3 mb-0 text-sm d-flex align-items-center justify-content-end">
                        <i class="ni ni-align-left-2 text-orange"></i>
                        <span class="text-nowrap ml-2">{{ count($materi->komentar) }} Komentar</span>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            @empty
              <div class="col-12">
                <div class="card mb-3">
                  <div class="card-body">
                    <h2 class="mb-0 text-center text-orange">Materi pelajar ini belum ada</h2>
                  </div>
                </div>
              </div>
            @endforelse
          </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
<script>
  function moveMateri(materi) {
    window.location.href = materi
  }
</script>
@endpush

@extends('layouts.dashboard')
@section('title')
{{ $materi->pelajaran->nama_pelajaran }}
@endsection
@section('materi', 'active')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h1 class="mb-0">{{ $materi->judul }}</h1>
      </div>
      <div class="card-body">
        {!! $materi->materi !!}
        @if ($materi->document)
          <div class="mt-5">
            <h2>Document Available</h2>
            <span style="font-size: 36px; cursor: pointer;" onclick="showDocument('{{ $materi->document }}')">
              <i class="ni ni-archive-2 text-warning"></i>
            </span>
          </div>
        @endif
      </div>
      <div class="card-footer">
        <h3 class="mb-4">{{ count($materi->komentar) }} Komentar</h3>
        <div class="container-fluid">
          @foreach ($materi->komentar as $komentar)
            <div class="row mt-2 @if($komentar->user->id == Auth::user()->id) justify-content-end @endif">
              <div class="col-md-6 col-sm-12">
                <div class="card mb-0" style="border: 1px solid #5e72e4">
                  <div class="card-body">
                    <div class="d-flex align-items-start">
                      <div class="left mr-3">
                        <div style="width: 40px; height: 40px">
                          <img src="{{ asset('assets/img/brand/favicon.png') }}" alt="icon" class="w-100">
                        </div>
                      </div>
                      <div class="right">
                        <h3 class="mb-2">{{ $komentar->user->name }}</h3>
                        <div style="margin-bottom: 1rem">
                          <p class="mb-0" style="line-height: 1.1">{{ $komentar->comment }}</p>
                        </div>
                      </div>
                    </div>
                    <div style="position: absolute; bottom: 0; right: 0">
                      <span class="badge badge-lg badge-primary">
                        {{ date('d/m/Y - H:i', strtotime($komentar->created_at)) }}
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
      <div class="card-footer">
        <form action="{{ route('siswa.komentar.post') }}" method="POST">
          <div class="row">
            @csrf
            <input type="hidden" name="materi" value="{{ $materi->id }}">
            <div class="col-lg-10 col-md-10 col-sm-12 mb-2">
              <textarea name="comment" id="comment" rows="3" class="form-control"></textarea>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-12">
              <button type="submit" class="btn btn-primary w-100">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
<script>
  function showDocument(docUrl) {
    window.open(`/${docUrl}`)
  }
</script>
@endpush

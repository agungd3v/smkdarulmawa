@extends('layouts.dashboard')
@section('title', 'Tugas')
@section('tugas', 'active')

@push('css')
<style>
  .ck-content {
    height: 140px;
  }
</style>
@endpush

@section('content')
@if (session()->has('berhasil'))
<div class="row">
  <div class="col-12">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <span class="alert-icon"><i class="ni ni-like-2"></i></span>
      <span class="alert-text"><strong>Success!</strong> {{ session()->get('berhasil') }}</span>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  </div>
</div>
@endif
@if ($errors->any())
<div class="row">
  @foreach ($errors->all() as $error)
    <div class="col-12">
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <span class="alert-icon"><i class="ni ni-sound-wave"></i></span>
        <span class="alert-text"><strong>Error!</strong> {{ $error }}</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    </div>
  @endforeach
</div>
@endif
@if (session()->has('errorMessage'))
<div class="row">
  <div class="col-12">
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <span class="alert-icon"><i class="ni ni-sound-wave"></i></span>
      <span class="alert-text"><strong>Error!</strong> {{ session()->get('errorMessage') }}</span>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  </div>
</div>  
@endif
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
            @forelse ($pelajaran->tugas as $tugas)
              <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="w-100">
                  <div class="card card-stats mb-3" style="cursor: pointer" onclick="openTugas({{ $tugas }}, {{ $tugas->pelajaran }}, {{ $tugas->jawaban }})">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-6">
                          <h5 class="card-title text-uppercase text-muted mb-0">{{ date('m/d/Y', strtotime($tugas->created_at)) }}</h5>
                          @foreach ($tugas->jawaban as $jawaban)
                            @if (Auth::check())
                              @if ($jawaban->siswa_id == Auth::user()->id && $jawaban->nilai)
                                {{-- {{ dd($jawaban) }} --}}
                                <p class="mb-0 text-sm d-flex align-items-center mt-2">
                                  <i class="ni ni-trophy text-success"></i>
                                  <span class="text-nowrap ml-2">{{ $jawaban->nilai }}</span>
                                </p>
                              @endif
                            @endif
                          @endforeach
                        </div>
                        <div class="col-6">
                          <p class="mb-0 text-sm d-flex align-items-center justify-content-end">
                            <i class="ni ni-align-left-2 text-orange"></i>
                            <span class="text-nowrap ml-2">{{ count($tugas->jawaban) }} Jawaban</span>
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @empty
              <div class="col-12">
                <div class="card mb-3">
                  <div class="card-body">
                    <h2 class="mb-0 text-center text-orange">Tugas kosong</h2>
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
<div class="modal fade" id="openTugas" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Form Jawab Soal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('siswa.jawab') }}" method="POST">
        <div class="modal-body py-0">
          @csrf
          <input type="hidden" name="tugas_id" id="tugas" value="xxx">
          <div class="form-group mb-0">
            <div class="d-flex justify-content-between flex-wrap">
              <div>
                <h3 class="mb-1">Pelajaran</h3>
                <span class="badge badge-lg badge-success" id="display_pelajaran">#####</span>
              </div>
              <div>
                <h3 class="mb-1 text-right">Deadline</h3>
                <span class="badge badge-lg badge-warning" id="display_deadline">#####</span>
              </div>
            </div>
          </div>
          <hr class="my-3">
          <div class="d-flex flex-column">
            <h2>Soal</h2>
            <div id="soal">#####</div>
            <h2>Jawab</h2>
            <div class="form-group mb-0" id="lembarjawaban">
              <textarea id="jawab" name="jawab"></textarea>
            </div>
            <div id="jawabanku" class=""></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan Data</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('js')
<script src="{{ asset('assets/vendor/ckeditor5/ckeditor.js') }}"></script>
<script>
  window.addEventListener('DOMContentLoaded', () => {
    const elJawab = document.getElementById('jawab')
    if (elJawab) {
      ClassicEditor.create(elJawab, {
        toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|', 'insertTable' ]
      }).then(editor => {
        editor.model.document.on('change:data', () => {})
      }).catch(err => {
        console.error(err)
      })
    }
  })

  function openTugas(tugas, pelajaran, jawaban) {
    const elDisplayPelajaran = document.getElementById('display_pelajaran')
    const eldisplayDeadline = document.getElementById('display_deadline')
    const elSoal = document.getElementById('soal')
    const elTugas = document.getElementById('tugas')
    const elJawab = document.getElementById('jawabanku')
    const elLembarJawab = document.getElementById('lembarjawaban')

    const formatDate = tugas.deadline.split('-')

    let jawabanExist = []
    
    jawaban.map(data => {
      if (data.siswa_id == '{{ Auth::user()->id }}' && data.tugas_id == tugas.id) {
        jawabanExist.push(data)
      }
    })
    
    if (jawabanExist.length > 0) {
      document.querySelector('button[type=submit]').setAttribute('disabled', true)
      elLembarJawab.classList.add('d-none')
      elJawab.classList.remove('d-none')
      elJawab.innerHTML = jawabanExist[0].jawaban
    } else {
      document.querySelector('button[type=submit]').removeAttribute('disabled')
      elLembarJawab.classList.remove('d-none')
      elJawab.classList.add('d-none')
      elJawab.innerHTML = ''
    }

    elTugas.value = tugas.id
    elDisplayPelajaran.textContent = pelajaran.nama_pelajaran
    eldisplayDeadline.textContent = formatDate[2] + '/' + formatDate[1] + '/' + formatDate[0]
    elSoal.innerHTML = tugas.soal

    $('#openTugas').modal('show')
    jawabanExist = []
  }
</script>
@endpush

@extends('layouts.dashboard')
@section('title', 'Tugas')
@section('tugas', 'active')

@push('css')
<style>
  .ck-content {
    height: 320px;
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
      <div class="card-header border-0">
        <div class="d-flex justify-content-between align-items-center">
          <h3 class="mb-0">Table Tugas</h3>
          <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#openTugas">Tambah Tugas</button>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table align-items-center">
          <thead class="thead-light">
            <tr>
              <th scope="col" class="sort" data-sort="name">Nama Guru</th>
              <th scope="col"></th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody class="list">
            <tr>
              <th scope="row">{{ $guru->name }}</th>
              <td colspan="2" class="p-0">
                <table class="table align-items-center">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col" class="sort border-top-0 border-left" data-sort="pelajaran">Pelajaran</th>
                      <th scope="col" class="sort border-top-0" data-sort="tugas">Tugas</th>
                    </tr>
                  </thead>
                  <tbody class="list">
                    @foreach ($guru->pelajaran as $pelajaran)
                      <tr>
                        <th scope="row">{{ $pelajaran->nama_pelajaran }}</th>
                        <td>
                          <div class="d-flex flex-wrap">
                            @forelse ($pelajaran->tugas as $tugas)
                              <button type="button" class="btn btn-sm btn-default mb-2" onclick="openPenilaian({{ $tugas->jawaban }}, {{ $tugas }})">
                                <span>{{ date('d/m/Y', strtotime($tugas->created_at)) }}</span>
                                <span class="badge badge-primary">Jawaban - {{ count($tugas->jawaban) }}</span>
                              </button>
                            @empty
                              <span class="badge badge-lg badge-warning">Belum ada tugas untuk pelajaran ini</span>
                            @endforelse
                          </div>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header border-0">
        <div class="d-flex justify-content-between align-items-center">
          <h3 class="mb-0">Table Nilai</h3>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table align-items-center">
          <thead class="thead-light">
            <tr>
              <th scope="col">#</th>
              <th scope="col" class="sort" data-sort="hari">Nama Siswa</th>
              <th scope="col" class="sort" data-sort="pelajaran">Nama Pelajaran</th>
              <th scope="col" class="sort" data-sort="jam">Tugas Tanggal</th>
              <th scope="col" class="sort" data-sort="status">Nilai</th>
            </tr>
          </thead>
          <tbody class="list">  
            @forelse ($jawabans as $jawaban)
              @if ($jawaban->tugas->pelajaran->guru->id == Auth::user()->id)
                <tr class="{{ $jawaban->nilai ? 'bg-success text-white' : '' }}">
                  <th scope="row">{{ $loop->iteration }}</th>
                  <td style="width: 100%">{{ $jawaban->user->name }}</td>
                  <td>{{ $jawaban->tugas->pelajaran->nama_pelajaran }} ({{ $jawaban->tugas->pelajaran->guru->name }})</td>
                  <td>{{ date('d/m/Y', strtotime($jawaban->created_at)) }}</td>
                  <td>{{ $jawaban->nilai ? $jawaban->nilai : 0 }}</td>
                </tr>
              @endif
            @empty
              <tr>
                <td colspan="5">Data Not Found</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      {{ $jawabans->links() }}
    </div>
  </div>
</div>
<div class="modal fade" id="openTugas" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Form Tambah Materi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('guru.tugas.post') }}" method="POST">
        <div class="modal-body py-0">
          @csrf
          <div class="form-group mb-2">
            <label for="pelajaran">Pelajaran</label>
            <select name="pelajaran_id" id="pelajaran" class="custom-select">
              <option value="" selected hidden>Pilih Pelajaran</option>
              @foreach ($guru->pelajaran as $pelajaran)
                <option value="{{ $pelajaran->id }}">{{ $pelajaran->nama_pelajaran }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group mb-4">
            <label for="deadline">Deadline</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
              </div>
              <input type="date" min="{{ date('Y-m-d', strtotime(now())) }}" class="form-control" name="deadline" id="deadline">
            </div>
          </div>
          <div class="form-group mb-2">
            <textarea id="soal" name="soal"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan Data</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="openPenilaian" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Form Penilaian Tugas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('guru.tugas.penilaian') }}" method="POST">
        <div class="modal-body py-0">
          @csrf
          <input type="hidden" name="tugas_id" id="tugas" value="xxx">
          <div class="d-flex flex-column">
            <h2>Soal</h2>
            <div id="soalselected">#####</div>
            <h2>Jawaban</h2>
            <div class="form-group mb-3">
              <select name="siswa_id" id="siswa" class="custom-select" onchange="isSelected(this)">
                <option value="" selected hidden>Pilih Siswa</option>
              </select>
            </div>
            <div class="form-group mb-2" id="jawaban_siswa">
              <div id="jawabanku"></div>
            </div>
            <div class="form-group mb-0" id="nilai_siswa">
              <label for="menilai">Nilai</label>
              <input type="number" name="menilai" class="form-control" id="menilai">
            </div>
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
    ClassicEditor.create(document.getElementById('soal'), {
      toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|', 'insertTable' ]
    }).then(editor => {
      editor.model.document.on('change:data', () => {})
    }).catch(err => {
      console.error(err)
    })
  })
  let globTugas
  function openPenilaian(jawaban, tugas) {
    const elSiswa = document.getElementById('siswa')
    const elSoal = document.getElementById('soalselected')
    const elMenjawab = document.getElementById('jawaban_siswa')
    const elMenilai = document.getElementById('nilai_siswa')
    const elTugas = document.getElementById('tugas')
    elSoal.innerHTML = tugas.soal
    elTugas.value = tugas.id
    elMenilai.classList.add('d-none')
    elMenjawab.classList.add('d-none')
    elSiswa.innerHTML = '<option value="" selected hidden>Pilih Siswa</option>'
    fetch('/api/dashboard/siswa').then(res => res.json()).then(data => {
      if (data.status) {
        const siswa = data.message
        const siswaJawab = siswa.filter(({ id: id1 }) => jawaban.some(({ siswa_id: id2 }) => id2 === id1))
        siswaJawab.map(item => {
          elSiswa.innerHTML += `<option value="${item.id}">${item.name}</option>`
        })
        $('#openPenilaian').modal('show')
      }
    }).catch(err => {
      return console.error(err)
    })
    globTugas = tugas
  }
  function isSelected(selected) {
    const elMenjawab = document.getElementById('jawaban_siswa')
    const elMenilai = document.getElementById('nilai_siswa')
    const elJawaban = document.getElementById('jawabanku')
    const elInputNilai = document.getElementById('menilai')
    elMenilai.classList.remove('d-none')
    elMenjawab.classList.remove('d-none')
    if (globTugas.jawaban.length > 0) {
      globTugas.jawaban.map(item => {
        if (item.siswa_id == selected.value) {
          elJawaban.innerHTML = item.jawaban
          elInputNilai.value = item.nilai
        }
      })
    }
  }
</script>
@endpush

@extends('layouts.dashboard')
@section('title', 'Materi Pelajaran')
@section('materi', 'active')

@push('css')
<style>
  .ck-content {
    height: 320px;
  }
  .btn .badge:not(:last-child) {
    margin-right: 0;
  }
  .btn .badge:not(:first-child) {
    margin-left: 0
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
          <h3 class="mb-0">Table Materi</h3>
          <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#openMateri">Tambah Materi</button>
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
                      <th scope="col" class="sort border-top-0" data-sort="materi">Materi</th>
                    </tr>
                  </thead>
                  <tbody class="list">
                    @foreach ($guru->pelajaran as $pelajaran)
                      <tr>
                        <th scope="row">{{ $pelajaran->nama_pelajaran }}</th>
                        <td class="p-0">
                          <table class="table align-items-center">
                            <tbody class="list">
                              @forelse ($pelajaran->materi as $materi)
                                <tr>
                                  <td class="py-0 w-100">
                                    <span class="mr-1">{{ $materi->judul }}</span>
                                  </td>
                                  <td>
                                    <span class="badge badge-primary" style="cursor: pointer" onclick="viewMateri('{{ route('guru.materi.view', $materi->id) }}')">View Materi</span>
                                    <span class="badge badge-success" style="cursor: pointer" onclick="editMateri({{ $materi }}, {{ $pelajaran->id }})">Edit Materi</span>
                                    <span class="badge badge-danger" style="cursor: pointer" onclick="deleteMateri({{ $materi->id }})">Delete Materi</span>  
                                  </td>
                                </tr>
                              @empty
                                <tr>
                                  <td colspan="2">
                                    <span class="badge badge-danger">Belum ada materi</span>
                                  </td>
                                </tr>
                              @endforelse
                            </tbody>
                          </table>
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
<div class="modal fade" id="openMateri" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Form Tambah Materi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('guru.materi.post') }}" method="POST">
        <div class="modal-body py-0">
          @csrf
          <div class="form-group mb-2">
            <label for="pelajaran">Pelajaran</label>
            <select name="pelajaran_id" id="pelajaran" class="custom-select">
              <option value="" selected hidden>Pilih Pelajaran</option>
              @foreach ($pelajarans as $pelajaran)
                <option value="{{ $pelajaran->id }}">{{ $pelajaran->nama_pelajaran }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group mb-4">
            <label for="judul">Judul Materi</label>
            <input type="text" class="form-control" name="judul">
          </div>
          <div class="form-group mb-2">
            <textarea id="materi" name="materi"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan Data</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="editMateri" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Form Update Materi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('guru.materi.update') }}" method="POST">
        <div class="modal-body py-0">
          @csrf
          <input type="hidden" id="editId" name="materi_id" value="xxx">
          <div class="form-group mb-2">
            <label for="pelajaranEdit">Pelajaran</label>
            <select name="pelajaran_id" id="pelajaranEdit" class="custom-select">
              <option value="" selected hidden>Pilih Pelajaran</option>
              @foreach ($pelajarans as $pelajaran)
                <option value="{{ $pelajaran->id }}">{{ $pelajaran->nama_pelajaran }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group mb-4">
            <label for="judulEdit">Judul Materi</label>
            <input type="text" id="judulEdit" class="form-control" name="judul">
          </div>
          <div class="form-group mb-2 editmateri">
            <textarea id="materiEdit" name="materi"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update Data</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="deleteMateri" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
  <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
    <div class="modal-content bg-gradient-danger">
      <div class="modal-header">
        <h6 class="modal-title">Konfirmasi</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="py-3 text-center">
          <i class="ni ni-bell-55 ni-3x"></i>
          <h4 class="heading mt-4">Peringatan!</h4>
          <p>Jika kamu menekan ya maka materi ini akan terhapus beserta isi komentar di dalamnya.</p>
        </div>
      </div>
      <div class="modal-footer">
        <form action="{{ route('guru.materi.delete') }}" method="POST" class="mb-0">
          @csrf
          <input type="hidden" name="materi_id" id="deleteId" value="xxx">
          <button type="submit" class="btn btn-white">Ya, Hapus Data</button>
        </form>
        <button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Tidak</button>
      </div>  
    </div>
  </div>
</div>
@endsection

@push('js')
<script src="{{ asset('assets/vendor/ckeditor5/ckeditor.js') }}"></script>
<script>
  window.addEventListener('DOMContentLoaded', () => {
    ClassicEditor.create(document.getElementById('materi'), {
      toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|', 'insertTable' ]
    }).then(editor => {
      editor.model.document.on('change:data', () => {})
    }).catch(err => {
      console.error(err)
    })
  })
  function editMateri(materi, pelajaranId) {
    const elMateriId = document.getElementById('editId')
    const elPelajaran = document.getElementById('pelajaranEdit')
    const elJudul = document.getElementById('judulEdit')
    const elMateri = document.getElementById('materiEdit')
    const elckMateri = document.querySelector('.editmateri').querySelectorAll('.ck.ck-reset.ck-editor.ck-rounded-corners')

    elMateriId.value = materi.id
    elPelajaran.value = pelajaranId
    elJudul.value = materi.judul

    if (elckMateri.length > 0) {
      elckMateri[0].remove()
    }

    ClassicEditor.create(document.getElementById('materiEdit'), {
      toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|', 'insertTable' ]
    }).then(editor => {
      editor.setData(materi.materi)
    }).catch(err => {
      console.error(err)
    })
    
    $('#editMateri').modal('show')
  }
  function viewMateri(materi) {
    window.location.href = materi
  }
  function deleteMateri(materiId) {
    const elDeleteId = document.getElementById('deleteId')
    elDeleteId.value = materiId

    $('#deleteMateri').modal('show')
  }
</script>
@endpush

@extends('layouts.dashboard')
@section('title', 'Materi Pelajaran')
@section('materi', 'active')

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
                        <td>
                          <table class="table align-items-center">
                            <tbody class="list">
                              @foreach ($pelajaran->materi as $materi)
                                <tr>
                                  <td class="border-top-0 py-0">
                                    <button type="button" class="btn btn-sm btn-default">
                                      <span>{{ $materi->judul }}</span>
                                      <span class="badge badge-primary">{{ date('d / m / Y', strtotime($materi->created_at)) }}</span>
                                    </button>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="pt-1 pb-0 border-top-0"></td>
                                </tr>
                              @endforeach
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
</script>
@endpush

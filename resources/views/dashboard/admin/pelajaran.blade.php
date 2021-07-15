@extends('layouts.dashboard')
@section('title', 'Data Pelajaran')
@section('pelajaran', 'active')

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
          <h3 class="mb-0">Table Siswa</h3>
          <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#openPelajaran">Tambah Pelajaran</button>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table align-items-center">
          <thead class="thead-light">
            <tr>
              <th scope="col">#</th>
              <th scope="col" class="sort" data-sort="kode">Kode Pelajaran</th>
              <th scope="col" class="sort" data-sort="pelajaran">Nama Pelajaran</th>
              <th scope="col" class="sort" data-sort="guru">Nama Pengajar</th>
              <th scope="col" class="sort" data-sort="waktu">Waktu Pelajaran</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody class="list">  
            @forelse ($pelajarans as $pelajaran)
              <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $pelajaran->kode_pelajaran }}</td>
                <td>{{ $pelajaran->nama_pelajaran }}</td>
                <td>{{ $pelajaran->guru->name }}</td>
                <td>{{ $pelajaran->jam }} Jam</td>
                <td class="text-right">
                  <div class="dropdown">
                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                      <button class="dropdown-item" style="outline: none" data-toggle="modal" data-target="#editPelajaran" onclick="editPelajaran({{ $pelajaran }})">Edit Data</button>
                      <a class="dropdown-item" href="javascript:void(0)" onclick="document.getElementById('deletedata-{{ $pelajaran->kode_pelajaran }}').submit();">Delete Data</a>
                      <form id="deletedata-{{ $pelajaran->kode_pelajaran }}" action="{{ route('admin.pelajaran.delete') }}" method="POST" class="d-none">
                        @csrf
                        <input type="hidden" name="id" value="{{ $pelajaran->id }}">
                      </form>
                    </div>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6">
                  <p class="text-center">Data Not Found</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="openPelajaran" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Form Tambah Pelajaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.pelajaran.post') }}" method="POST">
        <div class="modal-body py-0">
          @csrf
          <div class="form-group mb-2">
            <label for="kode">Kode</label>
            <div class="input-group input-group-merge">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="ni ni-key-25 text-primary"></i>
                </span>
              </div>
              <input type="text" class="form-control" name="kode" id="kode">
            </div>
          </div>
          <div class="form-group mb-2">
            <label for="name">Nama Pelajaran</label>
            <div class="input-group input-group-merge">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="ni ni-books text-primary"></i>
                </span>
              </div>
              <input type="text" class="form-control" name="name" id="name">
            </div>
          </div>
          <div class="form-group mb-2">
            <label for="pengajar">Pengajar</label>
            <select name="pengajar" id="pengajar" class="custom-select">
              <option value="" selected hidden>Pilih Pengajar</option>
              @foreach ($gurus as $guru)
                <option value="{{ $guru->id }}">{{ $guru->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group mb-2">
            <label for="waktu">Waktu Pelajaran</label>
            <select name="waktu" id="waktu" class="custom-select">
              <option value="" selected hidden>Pilih lama waktu pelajaran</option>
              @for ($i = 1; $i <= 5; $i++)
                <option value="{{ $i }}">{{ $i }} Jam</option>
              @endfor
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan Data</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="editPelajaran" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Form Update Pelajaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.pelajaran.update') }}" method="POST">
        <div class="modal-body py-0">
          @csrf
          <input type="hidden" name="id" id="idx" value="xx">
          <div class="form-group mb-2">
            <label for="editkode">Kode</label>
            <div class="input-group input-group-merge">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="ni ni-key-25 text-primary"></i>
                </span>
              </div>
              <input type="text" class="form-control" name="kode" id="editkode" value="">
            </div>
          </div>
          <div class="form-group mb-2">
            <label for="editname">Nama Pelajaran</label>
            <div class="input-group input-group-merge">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="ni ni-books text-primary"></i>
                </span>
              </div>
              <input type="text" class="form-control" name="name" id="editname" value="">
            </div>
          </div>
          <div class="form-group mb-2">
            <label for="editpengajar">Ubah Pengajar</label>
            <select name="pengajar" id="editpengajar" class="custom-select">
              <option value="" selected hidden>Pilih Pengajar</option>
              @foreach ($gurus as $guru)
                <option value="{{ $guru->id }}">{{ $guru->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group mb-2">
            <label for="editwaktu">Waktu Pelajaran</label>
            <select name="waktu" id="editwaktu" class="custom-select">
              <option value="" selected hidden>Pilih lama waktu pelajaran</option>
              @for ($i = 1; $i <= 5; $i++)
                <option value="{{ $i }}">{{ $i }} Jam</option>
              @endfor
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update Data</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('js')
<script>
  function editPelajaran(pelajaran) {
    const elId = document.getElementById('idx')
    const elKode = document.getElementById('editkode')
    const elName = document.getElementById('editname')
    const elPengajar = document.getElementById('editpengajar')
    const elWaktu = document.getElementById('editwaktu')
    elId.value = pelajaran.id
    elKode.value = pelajaran.kode_pelajaran
    elName.value = pelajaran.nama_pelajaran
    elPengajar.value = pelajaran.guru.id
    elWaktu.value = pelajaran.jam
  }
</script>
@endpush

@extends('layouts.dashboard')
@section('title', 'Data Siswa')
@section('siswa', 'active')

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
          <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#openSiswa">Tambah Siswa</button>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table align-items-center">
          <thead class="thead-light">
            <tr>
              <th scope="col">#</th>
              <th scope="col" class="sort" data-sort="name">Nama Siswa</th>
              <th scope="col" class="sort" data-sort="nisn">NISN</th>
              <th scope="col" class="sort" data-sort="email">Alamat Email</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody class="list">
            @forelse ($siswas as $siswa)
              <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $siswa->name }}</td>
                <td>{{ $siswa->nidn }}</td>
                <td>{{ $siswa->email }}</td>
                <td class="text-right">
                  <div class="dropdown">
                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                      <button class="dropdown-item" style="outline: none" data-toggle="modal" data-target="#editSiswa" onclick="editSiswa({{ $siswa }})">Edit Data</button>
                      <a class="dropdown-item" href="javascript:void(0)" onclick="document.getElementById('resetpassword-{{ $siswa->nidn }}').submit();">Reset Password</a>
                      <form id="resetpassword-{{ $siswa->nidn }}" action="{{ route('admin.siswa.resetpassword') }}" method="POST" class="d-none">
                        @csrf
                        <input type="hidden" name="id" value="{{ $siswa->id }}">
                      </form>
                      <a class="dropdown-item" href="javascript:void(0)" onclick="document.getElementById('deletedata-{{ $siswa->nidn }}').submit();">Delete Data</a>
                      <form id="deletedata-{{ $siswa->nidn }}" action="{{ route('admin.siswa.delete') }}" method="POST" class="d-none">
                        @csrf
                        <input type="hidden" name="id" value="{{ $siswa->id }}">
                      </form>
                    </div>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5">
                  <p class="text-center">Data Not Found</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      {{ $siswas->links() }}
    </div>
  </div>
</div>
<div class="modal fade" id="openSiswa" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Form Tambah Siswa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.siswa.post') }}" method="POST">
        <div class="modal-body py-0">
          @csrf
          <div class="form-group mb-2">
            <label for="name">Nama Siswa</label>
            <div class="input-group input-group-merge">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="ni ni-single-02 text-primary"></i>
                </span>
              </div>
              <input type="text" class="form-control" name="name" id="name">
            </div>
          </div>
          <div class="form-group mb-2">
            <label for="nidn">NISN</label>
            <div class="input-group input-group-merge">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="ni ni-paper-diploma text-primary"></i>
                </span>
              </div>
              <input type="number" class="form-control" name="nidn" id="nidn">
            </div>
          </div>
          <div class="form-group mb-2">
            <label for="email">Alamat Email</label>
            <div class="input-group input-group-merge">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="ni ni-email-83 text-primary"></i>
                </span>
              </div>
              <input type="email" class="form-control" name="email" id="email">
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
<div class="modal fade" id="editSiswa" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Form Update Siswa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.siswa.update') }}" method="POST">
        <div class="modal-body py-0">
          @csrf
          <input type="hidden" name="id" id="idx" value="xxx">
          <div class="form-group mb-2">
            <label for="editname">Nama Siswa</label>
            <div class="input-group input-group-merge">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="ni ni-single-02 text-primary"></i>
                </span>
              </div>
              <input type="text" class="form-control" name="name" id="editname" value="">
            </div>
          </div>
          <div class="form-group mb-2">
            <label for="editnidn">NISN</label>
            <div class="input-group input-group-merge">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="ni ni-paper-diploma text-primary"></i>
                </span>
              </div>
              <input type="number" class="form-control" name="nidn" id="editnidn" value="">
            </div>
          </div>
          <div class="form-group mb-2">
            <label for="editemail">Alamat Email</label>
            <div class="input-group input-group-merge">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="ni ni-email-83 text-primary"></i>
                </span>
              </div>
              <input type="email" class="form-control" name="email" id="editemail" value="">
            </div>
          </div>
          <div class="form-group mb-2">
            <label for="oldpassword">Password Sekarang</label>
            <div class="input-group input-group-merge">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="ni ni-key-25 text-primary"></i>
                </span>
              </div>
              <input type="password" class="form-control" name="oldpassword" id="oldpassword">
            </div>
          </div>
          <div class="form-group mb-2">
            <label for="newpassword">Password Baru</label>
            <div class="input-group input-group-merge">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="ni ni-key-25 text-primary"></i>
                </span>
              </div>
              <input type="password" class="form-control" name="newpassword" id="newpassword">
            </div>
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
  function editSiswa(siswa) {
    const ElId = document.getElementById('idx')
    const ElName = document.getElementById('editname')
    const ElNidn = document.getElementById('editnidn')
    const ElEmail = document.getElementById('editemail')
    ElId.value = siswa.id
    ElName.value = siswa.name
    ElNidn.value = siswa.nidn
    ElEmail.value = siswa.email
  }
</script>
@endpush

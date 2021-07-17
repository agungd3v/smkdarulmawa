@extends('layouts.dashboard')
@section('title', 'Data Jadwal')
@section('jadwal', 'active')

@push('css')
<link href="{{ asset('assets/vendor/datetimepicker/jquery.datetimepicker.min.css') }}" rel="stylesheet" />
<style>
  input[type="time"]::-webkit-calendar-picker-indicator {
    display: none
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
{{-- Table Jadwal Hari --}}
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header border-0">
        <div class="d-flex justify-content-between align-items-center">
          <h3 class="mb-0">Table Jadwal Hari</h3>
          <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#openHari">Tambah Jadwal Hari</button>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table align-items-center">
          <thead class="thead-light">
            <tr>
              <th scope="col">#</th>
              <th scope="col" class="sort" data-sort="hari">Nama Hari</th>
              <th scope="col" class="sort" data-sort="masuk">Jam Masuk</th>
              <th scope="col" class="sort" data-sort="pulang">Jam Pulang</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody class="list">  
            @forelse ($jadwals as $jadwal)
              <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $jadwal->nama_hari }}</td>
                <td>{{ $jadwal->jam_masuk }}</td>
                <td>{{ $jadwal->jam_pulang }}</td>
                <td class="text-right">
                  <div class="dropdown">
                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                      <button class="dropdown-item" style="outline: none" data-toggle="modal" data-target="#updateHari" onclick="updateHari({{ $jadwal }})">Edit Data</button>
                      <a class="dropdown-item" href="javascript:void(0)" onclick="document.getElementById('deletedata-{{ $jadwal->id }}').submit();">Delete Data</a>
                      <form id="deletedata-{{ $jadwal->id }}" action="{{ route('admin.jadwal.delete') }}" method="POST" class="d-none">
                        @csrf
                        <input type="hidden" name="id" value="{{ $jadwal->id }}">
                        <input type="hidden" name="identity" value="hari">
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
    </div>
  </div>
</div>
{{-- End Table Jadwal Hari --}}

{{-- Table Jadwal Pelajaran --}}
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header border-0">
        <div class="d-flex justify-content-between align-items-center">
          <h3 class="mb-0">Table Jadwal Pelajaran</h3>
          <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#openPelajaran">Tambah Jadwal Pelajaran</button>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table align-items-center">
          <thead class="thead-light">
            <tr>
              <th scope="col">#</th>
              <th data-sort="hari">Nama Hari</th>
              <th></th>
              <th></th>
              <th></th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody class="list" id="list_data_jadwal_pelajaran">
            @forelse ($jadwals as $jadwal)
              @if (count($jadwal->pelajaran) > 0)
                <tr>
                  <th scope="row">{{ $loop->iteration }}</th>
                  <td>{{ $jadwal->nama_hari }}</td>
                  <td colspan="4" class="pt-0 pb-3 px-0">
                    <table class="table">
                      <thead>
                        <tr>
                          <th style="background: #f6f9fc" scope="col" class="sort border-top-0 border-left" data-sort="pelajaran">Nama Pelajaran</th>
                          <th style="background: #f6f9fc" scope="col" class="sort border-top-0" data-sort="masuk">Jam Masuk</th>
                          <th style="background: #f6f9fc" scope="col" class="sort border-top-0" data-sort="pulang">Jam Pulang</th>
                          <th style="background: #f6f9fc" scope="col" class="sort border-top-0"></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td colspan="4" class="py-1"></td>
                        </tr>
                        @foreach ($jadwal->pelajaran as $pelajaran)
                          <tr>
                            <td class="border-top-0 py-0">{{ $pelajaran->nama_pelajaran }} ({{ $pelajaran->guru->name }})</td>
                            <td class="border-top-0 py-0">{{ $pelajaran->pivot->jam_masuk }}</td>
                            <td class="border-top-0 py-0">{{ $pelajaran->pivot->jam_pulang }}</td>
                            <td class="border-top-0 py-0 text-right">
                              <div class="dropdown">
                                <a class="btn btn-sm btn-icon-only text-light pt-2" href="javascript:void(0)" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="fas fa-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                  <button class="dropdown-item" style="outline: none" data-toggle="modal" data-target="#updatePelajaran" onclick="updatePelajaran({{ $pelajaran->jadwal }}, {{ $pelajaran }}, {{ $jadwal->id }})">Edit Data</button>
                                  <a class="dropdown-item" href="javascript:void(0)" onclick="document.getElementById('deletedata-{{ $pelajaran->id }}').submit();">Delete Data</a>
                                  <form id="deletedata-{{ $pelajaran->id }}" action="{{ route('admin.jadwal.delete') }}" method="POST" class="d-none">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $jadwal->id }}">
                                    <input type="hidden" name="identity" value="pelajaran">
                                    <input type="hidden" name="pelajaran_id" value="{{ $pelajaran->id }}">
                                  </form>
                                </div>
                              </div>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </td>
                </tr>
              @endif
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
    </div>
  </div>
</div>
{{-- End Table Jadwal Pelajaran --}}

{{-- Modal Jadwal Hari --}}
<div class="modal fade" id="openHari" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Form Tambah Jadwal Hari</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.jadwal.post') }}" method="POST">
        <div class="modal-body py-0">
          @csrf
          <input type="hidden" name="identity" value="jadwal_hari">
          <div class="form-group mb-2">
            <label for="name">Nama Hari</label>
            <select name="name" id="name" class="custom-select">
              <option value="" selected hidden>Pilih Hari</option>
              <option value="Senin">Senin</option>
              <option value="Selasa">Selasa</option>
              <option value="Rabu">Rabu</option>
              <option value="Kamis">Kamis</option>
              <option value="Jum'at">Jum'at</option>
              <option value="Sabtu">Sabtu</option>
            </select>
          </div>
          <div class="form-group mb-2">
            <label for="masuk">Jam Masuk</label>
            <div class="input-group input-group-merge">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="ni ni-time-alarm text-primary"></i>
                </span>
              </div>
              <input class="form-control timepicker" type="time" name="masuk" id="masuk">
            </div>
          </div>
          <div class="form-group mb-2">
            <label for="pulang">Jam Pulang</label>
            <div class="input-group input-group-merge">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="ni ni-time-alarm text-primary"></i>
                </span>
              </div>
              <input class="form-control timepicker" type="time" name="pulang" id="pulang">
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
<div class="modal fade" id="updateHari" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Form Update Jadwal Hari</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.jadwal.update') }}" method="POST">
        <div class="modal-body py-0">
          @csrf
          <input type="hidden" name="identity" value="jadwal_hari">
          <input type="hidden" name="id" id="idx_hari" value="xxx">
          <div class="form-group mb-4">
            <h1>Jadwal Hari <span id="name_jadwal_hari"></span></h1>
          </div>
          <div class="form-group mb-2">
            <label for="masuk">Jam Masuk</label>
            <div class="input-group input-group-merge">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="ni ni-time-alarm text-primary"></i>
                </span>
              </div>
              <input class="form-control timepicker" type="time" name="masuk" id="update_hari_masuk">
            </div>
          </div>
          <div class="form-group mb-2">
            <label for="pulang">Jam Pulang</label>
            <div class="input-group input-group-merge">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="ni ni-time-alarm text-primary"></i>
                </span>
              </div>
              <input class="form-control timepicker" type="time" name="pulang" id="update_hari_pulang">
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
{{-- End Modal Jadwal Hari --}}

{{-- Modal Jadwal Pelajaran --}}
<div class="modal fade" id="openPelajaran" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Form Tambah Jadwal Pelajaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.jadwal.post') }}" method="POST">
        <div class="modal-body py-0">
          @csrf
          <input type="hidden" name="identity" value="jadwal_pelajaran">
          <div class="form-group mb-2">
            <label for="jadwal_hari">Nama Hari</label>
            <select name="jadwal_hari" id="jadwal_hari" class="custom-select">
              <option value="" selected hidden>Pilih Hari</option>
              @foreach ($jadwals as $jadwal)
                <option value="{{ $jadwal }}">{{ $jadwal->nama_hari }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group mb-2 d-none" id="select_pelajaran">
            <label for="pelajaran">Pelajaran</label>
            <select name="pelajaran[]" id="pelajaran" class="custom-select">
              <option value="" selected hidden>Pilih Pelajaran</option>
              @foreach ($pelajarans as $pelajaran)
                <option value="{{ $pelajaran->id }}">{{ $pelajaran->nama_pelajaran }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group mb-2">
            <label for="jam_masuk">Jam Masuk</label>
            <div class="input-group input-group-merge">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="ni ni-time-alarm text-primary"></i>
                </span>
              </div>
              <input class="form-control timepicker" type="time" name="jam_masuk" id="jam_masuk">
            </div>
          </div>
          <div class="form-group mb-2">
            <label for="jam_pulang">Jam Pulang</label>
            <div class="input-group input-group-merge">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="ni ni-time-alarm text-primary"></i>
                </span>
              </div>
              <input class="form-control timepicker" type="time" name="jam_pulang" id="jam_pulang" ng-model="endTime">
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
<div class="modal fade" id="updatePelajaran" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Form Update Jadwal Pelajaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.jadwal.update') }}" method="POST">
        <div class="modal-body py-0">
          @csrf
          <input type="hidden" name="identity" value="jadwal_pelajaran">
          <input type="hidden" name="id" id="jadwal_id" value="xxx">
          <input type="hidden" name="pelajaran_id" id="pelajaran_id" value="xxx">
          <div class="form-group mb-0">
            <h1>Jadwal Hari <span id="name_jadwal_hari_pelajaran"></span></h1>
          </div>
          <div class="form-group mb-4" id="select_pelajaran">
            <h4 class="text-primary">Pelajaran <span id="name_jadwal_pelajaran"></span></h4>
          </div>
          <div class="form-group mb-2">
            <label for="jam_masuk">Jam Masuk</label>
            <div class="input-group input-group-merge">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="ni ni-time-alarm text-primary"></i>
                </span>
              </div>
              <input class="form-control timepicker" type="time" name="jam_masuk" id="pivot_jam_masuk">
            </div>
          </div>
          <div class="form-group mb-2">
            <label for="jam_pulang">Jam Pulang</label>
            <div class="input-group input-group-merge">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="ni ni-time-alarm text-primary"></i>
                </span>
              </div>
              <input class="form-control timepicker" type="time" name="jam_pulang" id="pivot_jam_pulang">
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
{{-- End Modal Jadwal Pelajaran --}}
@endsection

@push('js')
<script src="{{ asset('assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js') }}"></script>
<script>
  $(document).ready(function() {
    $('.timepicker').each(function() {
      $(this).datetimepicker({
        datepicker:false,
        format:'H:i',
        allowTimes:[
          '00:00','01:00','02:00','03:00','04:00','05:00','06:00','06:15','06:30','06:45','07:00','07:15','07:30','07:45','08:00','08:15','08:30','08:45','09:00','09:15','09:30','09:45','10:00','10:15','10:30','10:45','11:00','11:15','11:30','11:45','12:00','12:15','12:30','12:45','13:00','13:15','13:30','13:45','14:00','14:15','14:30','14:45','15:00','15:15','15:30','15:45','16:00','16:15','16:30','16:45','17:00','17:15','17:30','17:45','18:00','19:00','20:00','21:00','22:00','23:00'
        ]
      })
      $(this).click(function() {
        $(this).datetimepicker({
          minTime: $(this).attr('min'),
          maxTime: $(this).attr('max')
        })
      })
    })
    $('.xdsoft_datetimepicker').each((i, el) => {
      $(el).attr('style', 'width: 320px')
      $(el).children('.xdsoft_timepicker').attr('style', 'width: 300px')
    })
  })
  document.addEventListener('DOMContentLoaded', () => {
    const elJadwalPelajaran = document.getElementById('list_data_jadwal_pelajaran')
    if (elJadwalPelajaran.children.length < 1) {
      elJadwalPelajaran.innerHTML = `
        <tr>
          <td colspan="6">
            <p class="text-center">Data Not Found</p>
          </td>
        </tr>
      `
    }
    const elSelectedDay = document.getElementById('jadwal_hari')
    elSelectedDay.addEventListener('change', function() {
      const elPelajaran = document.getElementById('select_pelajaran')
      const elTimeIn = document.getElementById('jam_masuk')
      const elTimeOut = document.getElementById('jam_pulang')
      const dataDay = JSON.parse(this.value)
      elPelajaran.classList.remove('d-none')
      elTimeIn.value = dataDay.jam_masuk
      elTimeIn.min = dataDay.jam_masuk
      elTimeIn.max = dataDay.jam_pulang
      elTimeOut.value = dataDay.jam_pulang
      elTimeOut.min = dataDay.jam_masuk
      elTimeOut.max = dataDay.jam_pulang
    })
  })
  function updateHari(jadwal) {
    const elId = document.getElementById('idx_hari')
    const elNameJadwal = document.getElementById('name_jadwal_hari')
    const elJamMasuk = document.getElementById('update_hari_masuk')
    const elJamPulang = document.getElementById('update_hari_pulang')
    elId.value = jadwal.id
    elNameJadwal.textContent = jadwal.nama_hari
    elJamMasuk.value = jadwal.jam_masuk
    elJamPulang.value = jadwal.jam_pulang
  }
  function updatePelajaran(jadwal_pelajaran, pelajaran, jadwalId) {
    const elJadwalId = document.getElementById('jadwal_id')
    const elPelajaranId = document.getElementById('pelajaran_id')
    const elNameHari = document.getElementById('name_jadwal_hari_pelajaran')
    const elNamePelajaran = document.getElementById('name_jadwal_pelajaran') 
    const elPivotMasuk = document.getElementById('pivot_jam_masuk')
    const elPivotPulang = document.getElementById('pivot_jam_pulang')
    let itsJadwal
    jadwal_pelajaran.forEach(item => {
      if (item.id == jadwalId) itsJadwal = item
    })
    elJadwalId.value = jadwalId
    elPelajaranId.value = pelajaran.id
    elNameHari.textContent = itsJadwal.nama_hari
    elNamePelajaran.textContent = pelajaran.nama_pelajaran
    elPivotMasuk.value = pelajaran.pivot.jam_masuk
    elPivotPulang.value = pelajaran.pivot.jam_pulang
  }
</script>
@endpush

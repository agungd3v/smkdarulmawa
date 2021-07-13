@extends('layouts.dashboard')
@section('title', 'Data Absen')
@section('absen', 'active')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header border-0">
        <div class="d-flex justify-content-between align-items-center">
          <h3 class="mb-0">Table Absensi</h3>
          <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#openAbsen">Tambah Absen</button>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table align-items-center">
          <thead class="thead-light">
            <tr>
              <th scope="col">#</th>
              <th scope="col" class="sort" data-sort="hari">Jam Datang</th>
              <th scope="col" class="sort" data-sort="datang">Jam Datang</th>
              <th scope="col" class="sort" data-sort="pulang">Jam Pulang</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody class="list">  
            <tr>
              <th scope="row">1</th>
              <td>Senin</td>
              <td>07:00 AM</td>
              <td>02:00 PM</td>
              <td class="text-right">
                <div class="dropdown">
                  <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                    <a class="dropdown-item" href="#">Edit Data</a>
                    <a class="dropdown-item" href="#">Hapus Data</a>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <th scope="row">2</th>
              <td>Selasa</td>
              <td>07:00 AM</td>
              <td>02:30 PM</td>
              <td class="text-right">
                <div class="dropdown">
                  <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                    <a class="dropdown-item" href="#">Edit Data</a>
                    <a class="dropdown-item" href="#">Hapus Data</a>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <th scope="row">3</th>
              <td>Rabu</td>
              <td>07:00 AM</td>
              <td>03:30 PM</td>
              <td class="text-right">
                <div class="dropdown">
                  <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                    <a class="dropdown-item" href="#">Edit Data</a>
                    <a class="dropdown-item" href="#">Hapus Data</a>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <th scope="row">4</th>
              <td>Kamis</td>
              <td>07:30 AM</td>
              <td>02:30 PM</td>
              <td class="text-right">
                <div class="dropdown">
                  <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                    <a class="dropdown-item" href="#">Edit Data</a>
                    <a class="dropdown-item" href="#">Hapus Data</a>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <th scope="row">5</th>
              <td>Jum'at</td>
              <td>08:00 AM</td>
              <td>03:00 PM</td>
              <td class="text-right">
                <div class="dropdown">
                  <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                    <a class="dropdown-item" href="#">Edit Data</a>
                    <a class="dropdown-item" href="#">Hapus Data</a>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

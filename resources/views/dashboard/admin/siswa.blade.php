@extends('layouts.dashboard')
@section('title', 'Data Siswa')
@section('siswa', 'active')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header border-0">
        <div class="d-flex justify-content-between align-items-center">
          <h3 class="mb-0">Table Siswa</h3>
          <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#openSiswa">Tambah Siswa</button>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table align-items-center">
          <thead class="thead-light">
            <tr>
              <th scope="col">#</th>
              <th scope="col" class="sort" data-sort="name">Nama Siswa</th>
              <th scope="col" class="sort" data-sort="email">Alamat Email</th>
              <th scope="col" class="sort" data-sort="kelas">Kelas</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody class="list">  
            <tr>
              <th scope="row">1</th>
              <td>Agung Ardiyanto</td>
              <td>agungd3v@gmail.com</td>
              <td>X (10)</td>
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
              <td>Wahid Mustaqim</td>
              <td>wm.aqim@gmail.com</td>
              <td>X (10)</td>
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
              <td>Kiki Andriawan</td>
              <td>kikuk@gmail.com</td>
              <td>X (10)</td>
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
              <td>Agung Dewantara</td>
              <td>dobleh@gmail.com</td>
              <td>X (10)</td>
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
              <td>Nurul Arifin</td>
              <td>ipin@gmail.com</td>
              <td>X (10)</td>
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

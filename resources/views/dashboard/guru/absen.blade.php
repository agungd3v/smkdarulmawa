@extends('layouts.dashboard')
@section('title', 'Absen Siswa')
@section('absen', 'active')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header border-0">
        <div class="d-flex justify-content-between align-items-center">
          <h3 class="mb-0">Table Absensi</h3>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table align-items-center">
          <thead class="thead-light">
            <tr>
              <th scope="col">#</th>
              <th scope="col" class="sort" data-sort="hari">Nama Siswa</th>
              <th scope="col" class="sort" data-sort="pelajaran">Nama Pelajaran</th>
              <th scope="col" class="sort" data-sort="jam">Jam Absen</th>
              <th scope="col" class="sort" data-sort="status">Status</th>
            </tr>
          </thead>
          <tbody class="list">  
            @forelse ($absens as $absen)
              @if ($absen->pelajaran->guru->id == Auth::user()->id)
                <tr>
                  <th scope="row">{{ $loop->iteration }}</th>
                  <td>{{ $absen->user->name }}</td>
                  <td>{{ $absen->pelajaran->nama_pelajaran }}</td>
                  <td>{{ date('H:i:s', strtotime($absen->created_at)) }}</td>
                  <td>
                    @if ($absen->status == 'Hadir')  
                      <span class="badge badge-success">{{ $absen->status }}</span>
                    @endif
                  </td>
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
    </div>
  </div>
</div>
@endsection

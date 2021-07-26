@extends('layouts.dashboard')
@section('title', 'Jadwal Mengajar')
@section('jadwal', 'active')

@section('content')
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
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td colspan="4" class="py-1"></td>
                        </tr>
                        @foreach ($jadwal->pelajaran as $pelajaran)
                          @if (Auth::check())
                            @if ($pelajaran->guru->id == Auth::user()->id)
                              <tr>
                                <td class="border-top-0 py-0" style="width: 100%">{{ $pelajaran->nama_pelajaran }} ({{ $pelajaran->guru->name }})</td>
                                <td class="border-top-0 py-0">{{ $pelajaran->pivot->jam_masuk }}</td>
                                <td class="border-top-0 py-0">{{ $pelajaran->pivot->jam_pulang }}</td>
                              </tr>
                            @endif
                          @endif
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
@endsection

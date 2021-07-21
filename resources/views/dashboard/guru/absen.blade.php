@extends('layouts.dashboard')
@section('title', 'Absen Siswa')
@section('absen', 'active')

@section('content')
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
        <div class="d-flex justify-content-between align-items-center flex-wrap">
          <h3 class="mb-0">Table Absensi</h3>
          <form action="{{ route('guru.report.absen') }}" method="POST" class="mb-0">
            @csrf
            <div class="d-flex align-items-end flex-wrap">
              <div class="form-group mb-0 mr-2 mt-2">
                <label for="pelajaran" class="text-sm">Pelajaran</label>
                <select name="pelajaran" id="pelajaran" class="form-control form-control-sm">
                  <option value="" selected hidden>Pilih Pelajaran&nbsp;&nbsp;&nbsp;</option>
                  @foreach ($pelajarans as $pelajaran)
                    <option value="{{ $pelajaran->id }}">{{ $pelajaran->nama_pelajaran }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group mb-0 mr-2 mt-2">
                <label for="from" class="text-sm">Dari</label>
                <input type="date" class="form-control form-control-sm" name="from">
              </div>
              <div class="form-group mb-0 mr-2 mt-2">
                <label for="to" class="text-sm">Sampai</label>
                <input type="date" class="form-control form-control-sm" name="to">
              </div>
              <div class="form-group" style="margin-bottom: 3px">
                <button type="submit" class="btn btn-sm btn-primary">Report</button>
              </div>
            </div>
          </form>
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
      {{ $absens->links() }}
    </div>
  </div>
</div>
@endsection

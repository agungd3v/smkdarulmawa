@extends('layouts.dashboard')
@section('title', 'Data Nilai')
@section('nilai', 'active')

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header border-0">
          {{-- <div class="d-flex justify-content-between align-items-center flex-wrap">
            <h3 class="mb-0">Table Absensi</h3>
            <form action="{{ route('admin.report.absen') }}" method="POST" class="mb-0">
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
          </div> --}}
        </div>
        <div class="table-responsive">
          <table class="table align-items-center">
            <thead class="thead-light">
              <tr>
                <th scope="col">#</th>
                <th scope="col" class="sort" data-sort="hari">Nama Siswa</th>
                <th scope="col" class="sort" data-sort="pelajaran">Nama Pelajaran</th>
                <th scope="col" class="sort" data-sort="jam">Tugas Tanggal</th>
                <th scope="col" class="sort" data-sort="status">Nilai</th>
              </tr>
            </thead>
            <tbody class="list">  
              @forelse ($jawabans as $jawaban)
                <tr class="{{ $jawaban->nilai ? 'bg-success text-white' : '' }}">
                  <th scope="row">{{ $loop->iteration }}</th>
                  <td style="width: 100%">{{ $jawaban->user->name }}</td>
                  <td>{{ $jawaban->tugas->pelajaran->nama_pelajaran }} ({{ $jawaban->tugas->pelajaran->guru->name }})</td>
                  <td>{{ date('d/m/Y', strtotime($jawaban->created_at)) }}</td>
                  <td>{{ $jawaban->nilai ? $jawaban->nilai : 0 }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="5">Data Not Found</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        {{ $jawabans->links() }}
      </div>
    </div>
  </div>
@endsection

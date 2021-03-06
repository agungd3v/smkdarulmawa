@extends('layouts.dashboard')
@section('title', 'Data Nilai')
@section('nilai', 'active')

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header border-0">
          <div class="d-flex justify-content-between align-items-center flex-wrap">
            <h3 class="mb-0">Table Nilai</h3>
            <form action="{{ route('admin.report.nilai') }}" method="POST" class="mb-0">
              @csrf
              <div class="d-flex align-items-end flex-wrap">
                <div class="form-group mb-0 mr-2 mt-2">
                  <label for="pelajaran" class="text-sm">Pelajaran</label>
                  <select name="pelajaran" id="pelajaran" class="form-control form-control-sm" onchange="showTugas(this)">
                    <option value="" selected hidden>Pilih Pelajaran&nbsp;&nbsp;&nbsp;</option>
                    @foreach ($pelajarans as $pelajaran)
                      <option value="{{ $pelajaran->id }}">{{ $pelajaran->nama_pelajaran }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group mb-0 mr-2 mt-2">
                  <label for="tugas" class="text-sm">Tugas</label>
                  <select name="tugas" id="tugas" class="form-control form-control-sm">
                    <option value="" selected hidden>Pilih Tugas&nbsp;&nbsp;&nbsp;</option>
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
                  <td>{{ date('d/m/Y', strtotime($jawaban->tugas->created_at)) }}</td>
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

@push('js')
<script>
  function showTugas(el) {
    const elTugas = document.getElementById('tugas')

    fetch('/api/dashboard/tugas', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json'},
      body: JSON.stringify({ pelajaran: el.value })
    }).then(res => res.json()).then(data => {
      if (data.status) {
        elTugas.innerHTML = '<option value="" selected hidden>Pilih Tugas&nbsp;&nbsp;&nbsp;</option>'
        data.message.tugas.forEach(vl => {
          elTugas.innerHTML += `<option value="${vl.id}">${formatDate(vl.created_at)}</option>`
        })
      }
    }).catch(err => {
      console.error(err)
    })
  }
  function formatDate(mydate) {
    const date = new Date(mydate)
    return `${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()}`
  }
</script>
@endpush

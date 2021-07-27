@extends('layouts.dashboard')
@section('title', 'Absen Pelajaran')
@section('absen', 'active')

@push('css')
<style>
  .tik {
    animation: tikAnimate 1s infinite
  }
  @keyframes tikAnimate {
    0% { opacity: 1 }
    25% { opacity: 0.75 }
    50% { opacity: 0.5 }
    75% { opacity: 0.25 }
    100% { opacity: 0 }
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
      <div class="card-header">
        <h2 class="text-center mb-0 text-primary">ABSEN PELAJARAN</h2>
        <h4 class="text-center mb-0" id="pelajaran">Tidak ada pelajaran</h4>
        <h1 class="text-center mb-0 mt-3 d-none" id="jam_masuk_pulang">
          <span id="d_jam_masuk"></span>
          <span>-</span>
          <span id="d_jam_pulang"></span>
        </h1>
      </div>
      <div class="card-body">
        <h4 class="text-center" id="date">Senin, 01 January 2021</h4>
        <h1 class="text-center">
          <span id="hour">00</span>
          <span class="tik">:</span>
          <span id="minute">00</span>
        </h1>
        <div class="d-flex justify-content-center align-items-center mt-3">
          <form action="{{ route('siswa.absen.post') }}" method="POST">
            @csrf
            <input type="hidden" name="identity" value="absen">
            <input type="hidden" name="pelajaran_id" id="pelajaran_id" value="xxx">
            <button class="btn btn-primary" id="btn_absen">Absen Pelajaran</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
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
              <th scope="col" class="sort" data-sort="keterangan">Keterangan</th>
            </tr>
          </thead>
          <tbody class="list">  
            @forelse ($absens as $absen)
              @if ($absen->user->id == Auth::user()->id)
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
                  <td>{{ $absen->keterangan ? $absen->keterangan : '-' }}</td>
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

@push('js')
<script>
  window.addEventListener('DOMContentLoaded', () => {
    const elDate = document.getElementById('date')
    const elHour = document.getElementById('hour')
    const elMinute = document.getElementById('minute')
    const elPelajaran = document.getElementById('pelajaran')
    const elMasukPulang = document.getElementById('jam_masuk_pulang')
    const elMasuk = document.getElementById('d_jam_masuk')
    const elPulang = document.getElementById('d_jam_pulang')
    const elPelajaranId = document.getElementById('pelajaran_id')
    const elBtnAbsen = document.getElementById('btn_absen')

    let dateNow = '00:00:00'
    let endDate = '00:00:00'

    setInterval(() => {
      const newDate = new Date()
      let year = newDate.getFullYear()
      let month = newDate.getMonth()
      let date = newDate.getDate()
      let day = newDate.getDay()
      let hour = newDate.getHours()
      let minute = newDate.getMinutes()
      let second = newDate.getSeconds()
      
      date.toString().length == 1 ? date = '0' + date : date = date
      hour.toString().length == 1 ? hour = '0' + hour : hour = hour
      minute.toString().length == 1 ? minute = '0' + minute : minute = minute
      second.toString().length == 1 ? second = '0' + second : second = second

      dateNow = `${hour}:${minute}:${second}`
  
      const arrDay = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', "Jum'at", 'Sabtu']
      const arrMonth = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
  
      elDate.textContent = `${arrDay[day]}, ${date} ${arrMonth[month]} ${year}`
      elHour.textContent = hour
      elMinute.textContent = minute
    }, 1000)

    fetch('/api/dashboard/jadwal').then(res => res.json()).then(data => {
      let jadwalSekarang

      if (data.status) {
        const jadwal = data.message

        const masuk = jadwal.jam_masuk
        const pulang = jadwal.jam_pulang

        if (dateNow < masuk || dateNow > pulang) {
          elBtnAbsen.setAttribute('disabled', true)
        } else {
          elBtnAbsen.removeAttribute('disabled')
        }

        data.message.pelajaran.map(data => {
          if (dateNow < data.pivot.jam_pulang) {
            jadwalSekarang = data
          }
        })
        
        if (jadwalSekarang) {
          if (dateNow < masuk || dateNow > pulang) {
            elBtnAbsen.setAttribute('disabled', true)
          } else {
            elMasukPulang.classList.remove('d-none')
            const splitJamMasuk = jadwalSekarang.pivot.jam_masuk.split(':')
            const splitJamPulang = jadwalSekarang.pivot.jam_pulang.split(':')
            elMasuk.textContent = splitJamMasuk[0] + ':' + splitJamMasuk[1]
            elPulang.textContent = splitJamPulang[0] + ':' + splitJamPulang[1]
            elPelajaranId.value = jadwalSekarang.id;
            elPelajaran.textContent = jadwalSekarang.nama_pelajaran
            
            elBtnAbsen.removeAttribute('disabled')
          }
        }
      } else {
        elPelajaran.textContent = data.message
      }
    }).catch(err => {
      console.error(err)
    })
  })
</script>
@endpush

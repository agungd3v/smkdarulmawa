<!DOCTYPE html>
<html lang="en">
<head>
  <title>Report Absen {{ $from || $to ? "-" : "" }} {{ $from && $to ? "($from" : $from }} {{ $from && $to ? '-' : '' }} {{ $from && $to ? "$to)" : $to }}</title>
  <style>
    table, tr, th, td {
      text-align: left;
      border: 1px solid #000;
      border-collapse: collapse;
      padding: 10px;
    }
    table {
      margin-top: 30px;
    }
  </style>
</head>
<body>
  <div style="width: 100%; display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0">
    <table style="border: 0; margin-bottom: 0">
      <tr style="border: 0">
        <td style="border: 0; padding-left: 0">
          <img src="{{ public_path('assets/img/brand/logosmk.jpg') }}" style="width: 80px">
        </td>
        <td style="width: 100%; padding: 0; border: 0">
          <h4 style="margin: 0; text-align: center">LAPORAN DATA ABSEN SISWA SMK DARUL MAWA LAMPUNG TENGAH</h4>
          <h4 style="margin: 0; text-align: center">Jl. Rawa Sawer Kampung Gaya Baru VI, Kec. Seputih Surabaya Lampung Tengah - Lampung</h4>
          <h5 style="margin-top: 5px; margin-bottom: 0; text-align: center">Telp 2147483647, Email smkdarulmawa06@gmail.com</h5>
        </td>
      </tr>
      <tr>
        <td colspan="2" style="padding: 0">
          <div style="background: #000; height: 2px"></div>
        </td>
      </tr>
      <tr>
        <td colspan="2" style="border: 0; padding: 0; padding-top: 40px">
          <span>Mata Pelajaran: </span>
          <span>{{ $pelajaran->nama_pelajaran }}</span>
        </td>
      </tr>
      <tr>
        <td colspan="2" style="border: 0; padding: 0; padding-top: 5px">
          <span>Nama Guru: </span>
          <span>{{ $pelajaran->guru->name }}</span>
        </td>
      </tr>
    </table>
  </div>
  <table style="width: 100%; margin-top: 0">
    <thead>
      <tr>
        <th style="text-align: center; background: #dae8de">No</th>
        <th style="width: 100%; background: #dae8de">Nama Siswa</th>
        <th style="width: auto; background: #dae8de">Status Kehadiran</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($absens as $absen)
        <tr>
          <th style="text-align: center">{{ $loop->iteration }}</th>
          <td style="width: 100%">{{ $absen->user->name }}</td>
          <td style="width: auto">{{ $absen->status }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
  <div style="position: fixed; bottom: 0; margin-left: 570px">
    <div style="width: 116px; border: 1px solid #000"></div>
    <span>(
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp;
    )</span>
  </div>
</body>
</html>
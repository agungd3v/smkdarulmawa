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
  <div style="width: 100%; display: flex; justify-content: space-between; align-items: flex-start">
    <div>
      <h2 style="margin-bottom: 0">Pelajaran</h2>
      <span>{{ $pelajaran->nama_pelajaran }}</span>
    </div>
    <div style="float: right">
      <h2 style="margin-bottom: 0">Guru</h2>
      <span>{{ $pelajaran->guru->name }}</span>
    </div>
  </div>
  @if ($from || $to)
    <h2 style="margin-bottom: 0">Periode</h2>
    <span>{{ $from ? $from : '' }} {{ $from && !$to ? '>' : '' }} {{ $from && $to ? '-' : '' }} {{ !$from && $to ? '<' : '' }} {{ $to ? $to : '' }}</span>
  @endif
  <table style="width: 100%">
    <thead>
      <tr>
        <th style="text-align: center; background: #dae8de">No</th>
        <th style="width: 100%; background: #dae8de">Nama Siswa</th>
        <th style="width: 100%; background: #dae8de">Status Kehadiran</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($absens as $absen)
        <tr>
          <th style="text-align: center">{{ $loop->iteration }}</th>
          <td>{{ $absen->user->name }}</td>
          <td>{{ $absen->status }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>
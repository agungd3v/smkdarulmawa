@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('dashboard', 'active')

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h5>Selamat Datang di Dashboard Guru</h5>
          <h2>Hi, {{ Auth::user()->name }}</h2>
        </div>
      </div>
    </div>
  </div>
@endsection

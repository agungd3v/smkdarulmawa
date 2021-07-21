@extends('layouts.dashboard')
@section('profile', 'Profile')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8 col-md-10 col-sm-12">
    <div class="card">
      <div class="card-header">
        <div class="row align-items-center">
          <div class="col-8">
            <h3 class="mb-0">Edit profile</h3>
          </div>
        </div>
      </div>
      <div class="card-body">
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
        <form action="{{ route('user.profile.update') }}" method="POST">
          @csrf
          <h6 class="heading-small text-muted mb-4">User information</h6>
          <div class="pl-lg-4">
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-name">Nama Lengkap</label>
                  <input type="text" id="input-name" class="form-control" name="name" placeholder="Nama Lengkap" value="{{ $user->name }}">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-email">Email address</label>
                  <input type="email" id="input-email" class="form-control" disabled name="email" placeholder="email@example.com" value="{{ $user->email }}">
                </div>
              </div>
            </div>
            @if ($user->nidn)
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label" for="nidn">{{ $user->role == 'guru' ? 'NIGN' : 'NISN' }}</label>
                    <input type="text" id="nidn" class="form-control" name="nidn" placeholder="First name" value="{{ $user->nidn }}">
                  </div>
                </div>
              </div>
            @endif
          </div>
          <hr class="my-4" />
          <h6 class="heading-small text-muted mb-4">Change Password</h6>
          <div class="pl-lg-4">
            <div class="form-group">
              <label class="form-control-label" for="password">New Password</label>
              <input type="password" class="form-control" name="password" id="password" placeholder="Masukan password baru">
            </div>
          </div>
          <hr class="my-4" />
          <div class="plg-lg-4">
            <div class="form-group">
              <button class="btn btn-primary" type="submit">Update Data</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

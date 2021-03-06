<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'nidn', 'email', 'password', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function pelajaran() {
        return $this->hasMany(Pelajaran::class, 'guru_id', 'id');
    }

    public function absen() {
        return $this->hasMany(Absen::class, 'siswa_id', 'id');
    }

    public function materi() {
        return $this->hasMany(Materi::class, 'guru_id', 'id');
    }

    public function komentar() {
        return $this->hasMany(Komentar::class, 'siswa_id', 'id');
    }

    public function jawaban() {
        return $this->hasMany(Jawaban::class, 'siswa_id', 'id');
    }
}

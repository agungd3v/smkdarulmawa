<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pelajaran extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $table = 'pelajarans';

    public function guru() {
        return $this->belongsTo(User::class, 'guru_id', 'id');
    }

    public function jadwal() {
        return $this->belongsToMany(Jadwal::class, 'jadwal_pelajaran', 'pelajaran_id', 'jadwal_id', 'id')->withTimestamps();
    }

    public function absen() {
        return $this->hasMany(Absen::class, 'pelajaran_id', 'id');
    }

    public function materi() {
        return $this->hasMany(Materi::class, 'pelajaran_id', 'id');
    }

    public function tugas() {
        return $this->hasMany(Tugas::class, 'pelajaran_id', 'id')->orderBy('created_at', 'desc');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    protected $guarded = [];
    protected $table = 'absens';

    public function user() {
        return $this->belongsTo(User::class, 'siswa_id', 'id');
    }

    public function pelajaran() {
        return $this->belongsTo(Pelajaran::class, 'pelajaran_id', 'id');
    }
}

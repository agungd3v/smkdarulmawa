<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $guarded = [];
    protected $table = 'jadwals';

    public function pelajaran() {
        return $this->belongsToMany(Pelajaran::class, 'jadwal_pelajaran', 'jadwal_id', 'pelajaran_id', 'id')
                    ->withPivot('jam_masuk', 'jam_pulang')
                    ->orderBy('jadwal_pelajaran.jam_masuk')
                    ->withTimestamps();
    }
}

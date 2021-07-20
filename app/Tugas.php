<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    protected $guarded = [];
    protected $table = 'tugas';

    public function pelajaran() {
        return $this->belongsTo(Pelajaran::class, 'pelajaran_id', 'id');
    }

    public function jawaban() {
        return $this->hasMany(Jawaban::class, 'tugas_id', 'id');
    }
}

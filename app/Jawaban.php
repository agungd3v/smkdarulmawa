<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    protected $guarded = [];
    protected $table = 'jawabans';

    public function tugas() {
        return $this->belongsTo(Tugas::class, 'tugas_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'siswa_id', 'id');
    }
}

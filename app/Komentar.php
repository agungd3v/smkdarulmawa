<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    protected $guarded = [];
    protected $table = 'komentars';

    public function user() {
        return $this->belongsTo(User::class, 'siswa_id', 'id');
    }

    public function materi() {
        return $this->belongsTo(Materi::class, 'materi_id', 'id');
    }
}

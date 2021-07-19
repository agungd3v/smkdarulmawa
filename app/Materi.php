<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    protected $guarded = [];
    protected $table = 'materis';

    public function user() {
        return $this->belongsTo(User::class, 'guru_id', 'id');
    }

    public function pelajaran() {
        return $this->belongsTo(Pelajaran::class, 'pelajaran_id', 'id');
    }

    public function komentar() {
        return $this->hasMany(Komentar::class, 'materi_id', 'id')->orderBy('created_at', 'desc');
    }
}

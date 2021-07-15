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
}

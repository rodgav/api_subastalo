<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model {
    use HasFactory;

    protected $table = 'comment';

    public function user() {
        return $this->belongsTo('App\Models\User', 'idUser');
    }

    public function subasta() {
        return $this->belongsTo('App\Models\Subasta', 'idSubasta');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokenSession extends Model {
    use HasFactory;

    protected $table = 'token_session';
    public function User(){
        $this->belongsTo('App\Models\User','idUser');
    }
}

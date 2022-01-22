<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pay extends Model {
    use HasFactory;

    protected $table = 'pay';
    public function user() {
        return $this->belongsTo('App\Models\User', 'idUser');
    }public function typePay() {
        return $this->belongsTo('App\Models\TypePay', 'idTypePay');
    }public function statePay() {
        return $this->belongsTo('App\Models\StatePay', 'idStatePay');
    }
}

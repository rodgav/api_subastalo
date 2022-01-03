<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subasta extends Model {
    use HasFactory;

    protected $table = 'subasta';

    public function category() {
        $this->belongsTo('App\Models\Category', 'idCategory');
    }

    public function TypeSubasta() {
        $this->belongsTo('App\Models\TypeSubasta', 'idTypeSubasta');
    }

    public function HoraSubasta() {
        $this->belongsTo('App\Models\HoraSubasta', 'idHoraSubasta');
    }

    public function StateSubasta() {
        $this->belongsTo('App\Models\StateSubasta', 'idStateSubasta ');
    }
}

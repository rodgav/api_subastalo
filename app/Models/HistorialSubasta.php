<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialSubasta extends Model {
    use HasFactory;

    protected $table = 'historial_subasta';

    public function subasta() {
        return $this->belongsTo('App\Models\Subasta', 'idSubasta');
    }
}

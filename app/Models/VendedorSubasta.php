<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendedorSubasta extends Model {
    use HasFactory;

    protected $table = 'vendedor_subasta';

    public function subasta() {
        $this->belongsTo('App\Models\Subasta', 'idSubasta');
    }
}

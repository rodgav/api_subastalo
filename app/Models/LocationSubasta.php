<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationSubasta extends Model {
    use HasFactory;

    protected $table = 'location_subasta';

    public function subasta() {
        return $this->belongsTo('App\Models\Subasta', 'idSubasta');
    }
}

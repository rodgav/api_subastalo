<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distritos extends Model {
    use HasFactory;

    protected $table = 'distritos';

    public function provincia() {
        return $this->belongsTo('App\Models\Departamentos', 'id_departmento');
    }
}

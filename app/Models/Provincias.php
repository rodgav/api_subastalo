<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provincias extends Model {
    use HasFactory;

    protected $table = 'provincias';

    public function departamento() {
        return $this->belongsTo('App\Models\Departamentos', 'id_departmento');
    }
}

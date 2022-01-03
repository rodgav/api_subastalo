<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model {
    use HasFactory;

    protected $table = 'sub_category';

    public function category() {
        $this->belongsTo('App\Models\Category', 'idCategory');
    }
}

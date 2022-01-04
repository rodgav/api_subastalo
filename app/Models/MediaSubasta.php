<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MediaSubasta extends Model {
    use HasFactory;

    protected $table = 'media_subasta';
    protected $fillable = ['path'];

    public function subasta() {
        return $this->belongsTo('App\Models\Subasta', 'idSubasta');
    }

    public function getUrlPathAttribute(){
        return Storage::url($this->path);
    }
}

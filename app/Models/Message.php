<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model {
    use HasFactory;

    protected $table = 'message';

    public function sender() {
        return $this->belongsTo('App\Models\User', 'idSender');
    }

    public function receiver() {
        return $this->belongsTo('App\Models\User', 'idReceiver');
    }
}

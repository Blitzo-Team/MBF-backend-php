<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class sizes extends Model
{
    protected $table = "sizes";
    protected $fillable = [];
    protected $dates = ['created_at', 'updated_at'];
    protected $casts = [
       
    ];

    public function getCreatedAtAttribute($date) {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('m/d/Y H:i:s T');
    }

    public function getUpdatedAtAttribute($date) {  
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('m/d/Y H:i:s T');
    }
}

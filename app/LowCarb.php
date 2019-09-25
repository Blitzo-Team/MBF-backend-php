<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LowCarb extends Model
{
    protected $table = "low_carb";
    protected $fillable = [];
    protected $dates = ['created_at', 'updated_at'];
    protected $casts = [
            "status" => "boolean"
            // "filters" => "array",  
            // "filters_additional_sides" => "array",
            // "sizes" => "array"
    ];

    public function getCreatedAtAttribute($date) {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('m/d/Y H:i:s T');
    }

    public function getUpdatedAtAttribute($date) {  
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('m/d/Y H:i:s T');
    }
}

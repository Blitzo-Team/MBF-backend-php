<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MuscleGain extends Model
{
    protected $table = "muscle_gain";
    protected $fillable = ["size", "id"];
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

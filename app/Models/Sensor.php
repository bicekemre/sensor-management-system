<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sensor extends Model
{
    use HasFactory, SoftDeletes;


    public function users()
    {
        return $this->belongsToMany(User::class, 'user_has_sensor', 'user_id', 'sensor_id');
    }
}

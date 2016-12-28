<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Readings_hour extends Model
{
    protected $table='readings_hour';
    protected $primaryKey = 'rh_id';
    public $timeStamps=false;
}

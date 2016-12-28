<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Readings_day extends Model
{
    protected $table='readings_day';
    protected $primaryKey = 'rd_id';
    public $timeStamps=false;
}

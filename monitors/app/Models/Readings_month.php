<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Readings_month extends Model
{
    protected $table='readings_month';
    protected $primaryKey = 'rm_id';
    public $timeStamps=false;
}

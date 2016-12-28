<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Readings_latest extends Model
{
    protected $table='readings_latest';
    protected $primaryKey = 'rl_id';
    public $timeStamps=false;



}

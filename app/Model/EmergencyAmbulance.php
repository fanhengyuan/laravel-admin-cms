<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class EmergencyAmbulance extends Model
{
    use SoftDeletes;
    protected $table = 'hm_emergency_ambulance';
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Eloquent;

class Zone extends Model
{
    protected $table = "zones";
    protected $fillable = ["zone_name"];

    public function daily_zone_deliveryman_combo()
    {
        return $this->hasMany('App\DailyZoneDeliverymanCombo');
    }
    
}

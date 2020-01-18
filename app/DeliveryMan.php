<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Eloquent;

class DeliveryMan extends Model
{
    protected $table = "delivery_men";
    protected $fillable = ["delivery_man_name","mobile","address"];

    public function daily_zone_deliveryman_combo()
    {
        return $this->hasMany('App\DailyZoneDeliverymanCombo');
    }
}

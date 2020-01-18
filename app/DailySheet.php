<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Eloquent;

class DailySheet extends Model
{
    protected $table = "daily_sheets";
    protected $fillable = ['daily_zone_delivery_man_combo_id','product_id','product_out_amount','product_return_amount','unit_price','total_price','net_unit_price','net_total_price'];

    public function daily_zone_deliveryman_combo()
    {
        return $this->belongsTo('App\DailyZoneDeliverymanCombo');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}

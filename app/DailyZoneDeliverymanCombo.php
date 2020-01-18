<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Eloquent;

class DailyZoneDeliverymanCombo extends Model
{
    protected $table = 'daily_zone_deliveryman_combos';
    protected $fillable = ['zone_id','delivery_man_id','brand_id','net_receivable','total_receivable','total_received','total_due','total_damage','total_company_claim','total_claimable'];

    public function zone()
    {
        return $this->belongsTo('App\Zone');
    }

    public function delivery_man()
    {
        return $this->belongsTo('App\DeliveryMan');
    }

    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }

    public function daily_sheets()
    {
        return $this->hasMany('App\DailySheet');
    }

    public function acc_client_transactions()
    {
        return $this->hasMany('App\AccClientTransaction','daily_zone_deliveryman_id');
    }

    public static function getCompanyClaimForCombo($comboId)
    {
        $claim = DailyZoneDeliveryManCombo::find($comboId);

        return $claim;
    }
}

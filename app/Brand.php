<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Eloquent;

class Brand extends Model
{
    protected $table = 'brands';

    protected $fillable = ['brand_name','brand_contact_detail','brand_mobile_no_1','brand_mobile_no_2','brand_mobile_no_3','brand_account_no'];

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function daily_zone_deliveryman_combos()
    {
        return $this->hasMany('App\DailyZoneDeliverymanCombo');
    }

    public function acc_brand_total()
    {
        return $this->hasOne('App\AccBrandTotal');
    }

    public function acc_brand_transactions()
    {
        return $this->hasMany('App\AccBrandTransaction');
    }

    public function acc_daily_brand_transactions()
    {
        return $this->hasMany('App\AccDailyBrandTransaction');
    }

    public function damage_claims()
    {
        return $this->hasMany('App\DamageClaim');
    }

    public function debit_claims()
    {
        return $this->hasMany('App\DebitClaim');
    }
    
}

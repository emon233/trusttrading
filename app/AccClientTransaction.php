<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Eloquent;

class AccClientTransaction extends Model
{
    protected $table = "acc_client_transactions";
    protected $fillable = [
        'client_id', 'daily_zone_deliveryman_id',
        'transaction_type', 'transaction_amount', 'brand_id'
    ];

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function daily_zone_deliveryman_combo()
    {
        return $this->belongsTo('App\DailyZoneDeliverymanCombo');
    }
}

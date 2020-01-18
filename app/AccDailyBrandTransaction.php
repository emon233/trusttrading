<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Eloquent;

class AccDailyBrandTransaction extends Model
{
    protected $table = "acc_daily_brand_transactions";
    protected $fillable = ['brand_id','date','net_product_sell','product_sell','collection','market_due','due_collection','damage','debit_claim'];

    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }
}

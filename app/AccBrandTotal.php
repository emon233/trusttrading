<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Eloquent;

class AccBrandTotal extends Model
{
    protected $table = 'acc_brand_totals';
    protected $fillable = ['brand_id','total_paid_amount','total_due_amount','total_cash_amount','total_market_due_amount','total_damage_amount','total_claim_amount'];

    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }
}

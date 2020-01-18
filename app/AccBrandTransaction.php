<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Eloquent;

class AccBrandTransaction extends Model
{
    protected $table = 'acc_brand_transactions';
    protected $fillable = ['brand_id','transaction_type','transaction_amount'];

    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }
}

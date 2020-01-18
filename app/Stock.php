<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Eloquent;

class Stock extends Model
{
    protected $table = "stocks";
    protected $fillable = ['product_id','stock_amount'];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}

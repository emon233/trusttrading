<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Eloquent;

class Purchase extends Model
{
    protected $table = "purchases";
    protected $fillable = ['product_id','amount','unit_price','total_price'];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}

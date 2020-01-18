<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Eloquent;

class Product extends Model
{
    protected $table = "products";
    
    protected $fillable = ['brand_id','category_id','product_name','purchase_rate','sell_rate'];

    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function stocks()
    {
        return $this->hasOne('App\Stock');
    }

    public function purchases()
    {
        return $this->hasMany('App\Purchase');
    }

    public function daily_sheets()
    {
        return $this->hasMany('App\DailySheet');
    }
}

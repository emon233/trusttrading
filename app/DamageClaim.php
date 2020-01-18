<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DamageClaim extends Model
{
    protected $table = "damage_claims";

    protected $fillable = ['brand_id','damage_amount','damage_received','remaining_damage','date_till'];

    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }
}

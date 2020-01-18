<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DebitClaim extends Model
{
    protected $table = "debit_claims";

    protected $fillable = ['brand_id','claimable_amount','debit_received','remaining_claim','date_till'];

    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }
}

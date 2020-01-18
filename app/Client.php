<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Eloquent;

class Client extends Model
{
    protected $table = "clients";
    protected $fillable = ["client_name","mobile","address"];

    public function acc_client_transactions()
    {
        return $this->hasMany('App\AccClientTransaction');
    }
}

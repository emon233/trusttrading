<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Eloquent;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = ['category_name'];

    public function products()
    {
        return $this->hasMany('App\Product');
    }
}

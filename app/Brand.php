<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brand';

    protected $fillable = ['brand_title'];

    public function hasProducts(){
    	return $this->hasMany('App\Products');
    }
}

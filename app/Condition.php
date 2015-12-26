<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    protected $table = 'condition';

    protected $fillable = ['condition_title'];

    public function hasProducts(){
    	return $this->hasMany('App\Products');
    }

}

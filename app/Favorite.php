<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $table = 'favorite';

    protected $fillable = ['user_id', 'product_id'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function hasProduct(){
        return $this->hasOne('App\Products');
    }
}

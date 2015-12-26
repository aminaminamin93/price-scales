<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enroll extends Model
{

    protected $table = 'enrollment';

    protected $fillable = ['retailer_id', 'product_id'];

    public function product(){
        return $this->belongsTo('Products');
    }

//    public function retailer(){
//        return $this->belongsTo('Retailer');
//    }
}

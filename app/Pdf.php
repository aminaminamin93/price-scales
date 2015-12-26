<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pdf extends Model
{
    protected $table = 'pdf';

    protected $fillable = ['pricelist_id', 'crawler_id'];

    public function pricelist(){
      return $this->belongsTo('App\PriceList');
    }
    public function retailer(){
      return $this->belongsTo('App\Retailer');
    }
    public function crawler(){
      return $this->belongsTo('App\Crawler');
    }

}

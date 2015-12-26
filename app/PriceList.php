<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceList extends Model
{
    protected $table = 'price_list';

    protected $fillable = ['pricelist_file', 'retailer_id'];

    public function pdf(){
      return $this->belongsTo('App\Pdf');
    }

}

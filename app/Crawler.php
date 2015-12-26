<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Crawler extends Model
{
    protected $table = 'crawler';

    protected $fillable = ['crawler_startdate', 'crawler_enddate', 'crawler_type'];

    public function pdf(){
      return $this->belongsTo('App\Pdf');
    }
    public function website(){
      return $this->belongsTo('App\Website');
    }
    // public function retailer(){
    //   return $this->belongsTo('App\Retailer');
    // }

}

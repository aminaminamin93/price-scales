<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    protected $table = 'website';
    protected $fillable = ['deadlink', 'crawler_id', 'retailer_id'];

    public function crawler(){
      return $this->belongsTo('App\Crawler');
    }
}

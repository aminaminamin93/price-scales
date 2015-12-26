<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retailer extends Model
{
    protected $table = 'retailers';

    protected $fillable = ['retailer_name', 'retailer_email', 'retailer_site', 'retailer_description', 'retailer_link'];

    public function enroll(){
        return $this->belongsTo('App\Enroll');
    }
    public function pdf(){
        return $this->belongsTo('App\Pdf');
    }
}

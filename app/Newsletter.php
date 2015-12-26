<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Newsletter extends Model
{
    protected $table = 'newsletter';
    protected $fillable = ['subscribe_id','newsletter']; //subscribe_id is refer to user_id

    public function user(){
      return $this->belongsTo('App\User');
    }
}

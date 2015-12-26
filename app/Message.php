<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Message extends Model
{
    protected $table = 'messages';

    protected $fillable = ['message_title', 'message_content', 'message_status', 'user_id'];

    public function user(){
       return $this->belongsTo('App\User');
    }


}

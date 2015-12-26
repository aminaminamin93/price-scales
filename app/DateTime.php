<?php

namespace App;
require 'vendor/autoload.php';
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class DateTime extends Model
{
    public function getCurrentDateTime(){
        return Carbon::now('Asia/Kuala_Lumpur');
    }

}

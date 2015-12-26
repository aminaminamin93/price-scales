<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Products;

class Category extends Model
{
    protected $table = 'category';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category_title'];

   public function hasProducts(){
       return $this->hasMany('App\Products');
   }
   
   
}

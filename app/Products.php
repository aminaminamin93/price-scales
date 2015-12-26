<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_name', 'product_price','product_price_temp', 'product_favorite', 'product_reviews', 'picture_link', 'shopper_link','product_location', 'product_shipping' ,'brand_id','condition_id', 'category_id' ];

    public function category(){
        return $this->belongsTo('App\Category');
    }

    public function brand(){
        return $this->belongsTo('App\Brand');
    }

    public function condition(){
        return $this->belongsTo('App\Condition');
    }
}

<?php

namespace Leslie;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'brand', 'type', 'product_id', 'aboveground', 'description'
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
}

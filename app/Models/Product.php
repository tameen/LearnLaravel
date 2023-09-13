<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function productImage()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function productReview()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function productCategory()
    {
        return $this->hasMany(ProductCategory::class);
    }

}

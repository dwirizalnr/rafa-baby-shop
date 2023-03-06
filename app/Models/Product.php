<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name', 'categories_id', 'price', 'description', 'slug', 'has_size'
    ];

    protected $hidden = [];

    public function galleries()
    {
        return $this->hasMany(ProductGallery::class, 'products_id', 'id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'users_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id', 'id');
    }

    public function product_stocks()
    {
        return $this->hasMany(ProductStock::class);
    }
    public function has_size()
    {
        return $this->product_stocks()->where('size', '<>', '')->exists();
    }
    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class, 'products_id', 'id');
    }
    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

}

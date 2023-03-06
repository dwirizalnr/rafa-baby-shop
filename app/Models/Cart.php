<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id', 'users_id', 'quantity', 'size'
    ];

    protected $hidden = [];


    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id', 'slug');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
    public function transactionDetails()
{
    return $this->hasMany(TransactionDetail::class);
}
public function product_stock()
{
    return $this->hasOne(ProductStock::class, 'id', 'product_id');
}
}

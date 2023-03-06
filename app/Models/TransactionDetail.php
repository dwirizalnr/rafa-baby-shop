<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'transactions_id',
        'products_id',
        'price',
        'quantity',
        'size',
        'catatan_tambahan',
        'shipping_status',
        'resi',
        'code'
    ];

    protected $hidden = [];

    public function productc()
    {
        return $this->hasOne(Cart::class, 'id', 'products_id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'id', 'transactions_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
    public function cart()
    {
        return $this->belongsTo(Cart::class, 'users_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Product;
use App\Models\Transaction;

class CheckoutProduct extends Model
{
    use HasFactory;

    protected $table = 'checkout_products';

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'trans_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}

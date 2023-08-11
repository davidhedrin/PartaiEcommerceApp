<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Voucher;
use App\Models\CheckoutProduct;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function products()
    {
        return $this->hasMany(CheckoutProduct::class, 'trans_id');
    }
    
    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'voucher_id');
    }
}

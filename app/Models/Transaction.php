<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Voucher;
use App\Models\CheckoutProduct;
use App\Models\PaymentMethod;
use App\Models\PaymentTransaction;
use App\Models\AddressUser;
use App\Models\StatusTransaction;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';
    protected $casts = [
        'id' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function transaction(){
        return $this->hasOne(PaymentTransaction::class, 'trans_id');
    }

    public function products()
    {
        return $this->hasMany(CheckoutProduct::class, 'trans_id');
    }
    
    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'voucher_id');
    }

    public function payment(){
        return $this->belongsTo(PaymentMethod::class, 'payment_id');
    }

    public function address()
    {
        return $this->belongsTo(AddressUser::class, 'address_id');
    }
    
    public function status()
    {
        return $this->belongsTo(StatusTransaction::class, 'status_id');
    }
}

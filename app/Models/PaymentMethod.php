<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Transaction;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $table = 'payment_methods';

    public function transactions(){
        return $this->hasMany(Transaction::class, 'payment_id');
    }
}

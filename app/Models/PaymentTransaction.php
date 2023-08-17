<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Transaction;

class PaymentTransaction extends Model
{
    use HasFactory;

    protected $table = 'payment_transactions';

    public function transaction(){
        
        return $this->belongsTo(Transaction::class, 'trans_id');
    }
}

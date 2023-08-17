<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Transaction;

class MidtransHistory extends Model
{
    use HasFactory;

    protected $table = 'midtrans_histories';

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'trans_id');
    }
}

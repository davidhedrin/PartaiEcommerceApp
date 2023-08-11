<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Transaction;

class Voucher extends Model
{
    use HasFactory;

    protected $table = 'vouchers';
    
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'voucher_id');
    }
}

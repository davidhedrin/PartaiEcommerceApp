<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\UserDetail;

class Country extends Model
{
    use HasFactory;

    protected $table = 'countries';
    
    public function user_detail()
    {
        return $this->belongsTo(UserDetail::class, 'country_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\UserDetail;
use App\Models\AddressUser;

class Country extends Model
{
    use HasFactory;

    protected $table = 'countries';
    
    public function user_detail()
    {
        return $this->belongsTo(UserDetail::class, 'country_id');
    }

    public function address_user()
    {
        return $this->hasMany(AddressUser::class, 'country_id');
    }
}

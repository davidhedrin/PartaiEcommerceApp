<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Country;

class UserDetail extends Model
{
    use HasFactory;

    protected $table = 'user_details';

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function country(): HasOne
    {
        return $this->hasOne(Country::class, 'country_id');
    }
}

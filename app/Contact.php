<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //
    protected $fillable = ['name', 'user_id', 'nickname', 'address', 'number', 'district', 'city', 'state', 'CEP'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function email()
    {
        return $this->hasMany(Email::class);
    }

    public function phone()
    {
        return $this->hasMany(Phone::class);
    }
}

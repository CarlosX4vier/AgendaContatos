<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    protected $fillable = ['phone', 'contact_id','type_phone_id'];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function typePhone()
    {
        return $this->hasOne(TypePhone::class);
    }
}

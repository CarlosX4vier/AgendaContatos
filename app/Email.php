<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $fillable = ['email', 'contact_id', 'type_email_id'];

    public function contact(){
        return $this->belongsTo(Contact::class);
    }

    public function typeEmail(){
        return $this->hasOne(TypeEmail::class);
    }
}

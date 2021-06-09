<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeEmail extends Model
{
    protected $fillable = ['name', 'type_email'];

    public function email()
    {
        return $this->belongsTo(Email::class);
    }
}

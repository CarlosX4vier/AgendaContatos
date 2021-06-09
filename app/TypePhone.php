<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypePhone extends Model
{
    protected $fillable = ['name'];

    public function phone()
    {
        return $this->belongsTo(Phone::class);
    }
}

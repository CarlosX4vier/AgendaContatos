<?php

namespace App\Http\Helpers;

use App\User;
use Illuminate\Support\Facades\Mail;

class SendEmail
{

    public static function send($mailable)
    {
        $user = User::find(auth()->id());
        return Mail::to($user->email)->queue($mailable);
    }
}

<?php

namespace App\Mail;

use App\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdatedContact extends Mailable
{
    use Queueable, SerializesModels;

    protected $contact;

    public function __construct($contact)
    {
        $this->contact = Contact::find($contact);
    }

    public function build()
    {
        return $this->from('carlos@escritordecodigos.com.br')
            ->subject($this->contact->name . " foi atualizado!")
            ->view('emails.updatedContact', ['contact' => $this->contact]);
    }
}

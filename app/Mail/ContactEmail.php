<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $title;
    public $content;
    public $file;

    public function __construct($email, $title, $content, $file = null)
    {
        $this->email = $email;
        $this->title = $title;
        $this->content = $content;
        $this->file = $file;
    }

    public function build(): ContactEmail
    {
        $email = $this->subject($this->title)
            ->view('emails.contact', [
                'email' => $this->email,
                'content' => $this->content,
            ]);

        if($this->file) {
            $email->attach($this->file->getRealPath(), [
                'as' => $this->file->getClientOriginalName(),
                'mime' => $this->file->getClientMimeType(),
            ]);
        }

        return $email;
    }
}

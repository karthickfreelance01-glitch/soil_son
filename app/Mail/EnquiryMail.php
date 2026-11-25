<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public array $data)
    {
    }

    public function build()
    {
        $subject = 'New enquiry from '.$this->data['name'];
        if (! empty($this->data['service'])) {
            $subject .= ' — '.$this->data['service'];
        }

        $mail = $this->subject($subject)->view('emails.enquiry');
        if (! empty($this->data['email'])) {
            $mail->replyTo($this->data['email'], $this->data['name']);
        }

        return $mail;
    }
}

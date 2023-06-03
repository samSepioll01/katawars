<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendReport extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $message;
    public $name;
    public $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $message, $name, $email)
    {
        $this->subject = $subject;
        $this->message = $message;
        $this->name = $name;
        $this->email = $email;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            to: ['Administrator' => 'slidejam20@gmail.com'],
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'mail.report',
            with: [
                'greeting' => 'Advice User Report:',
                'name' => $this->name,
                'email' => $this->email,
                'introLines' => [
                    $this->message,
                ],
                'outroLines' => [
                    'Regards,',
                    'Katawars.',
                ],
                'slogan' => 'Improve your coding skills with less effort, in less time.',
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}

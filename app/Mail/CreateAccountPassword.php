<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CreateAccountPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $email, $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            to:  [$this->name => $this->email],
            subject: 'Welcome To Katawars',
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
            view: 'mail.github-login-password',
            with: [
                'greeting' => "Hello $this->name!",
                'password' => $this->password,
                'introLines' => [
                    'This is your provisional password that you can use.',
                ],
                'outroLines' => [
                    'For more security, you must update your password early as possible.',
                    'When change the password, can activate more profile features like:',
                    'Two Steps Authentication.',
                    'Log Out Session from others browsers.',
                    'And others funny things.',
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

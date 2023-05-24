<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReportCodeAbuse extends Mailable
{
    use Queueable, SerializesModels;


    public $code;
    public $user;
    protected $abuseDate;
    private const TO = 'slidejam20@gmail.com';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $code, User $user)
    {
        $this->code = $code;
        $this->user = $user;
        $this->abuseDate = now();
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            to: ['Kataway' => self::TO],
            subject: 'Report Code Abuse',
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
            view: 'mail.report-code-abuse',
            with: [
                'greeting' => "Security Risk Detected!",
                'user' => $this->user,
                'code' => $this->code,
                'abuseDate' => $this->abuseDate,
                'introLines' => [
                    "The user tried validate the next code:",
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

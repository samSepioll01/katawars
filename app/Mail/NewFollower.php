<?php

namespace App\Mail;

use App\Models\Profile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewFollower extends Mailable
{
    use Queueable, SerializesModels;

    public $newFollowerName;
    public $name;
    public $email;
    public $url;
    public $numFollowers;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Profile $follower, Profile $followee)
    {
        $this->newFollowerName = $follower->user->name;
        $this->name = $followee->user->name;
        $this->email = $followee->user->email;
        $this->url = $followee->url;
        $this->numFollowers = $followee->followers->count();
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            to: [$this->name => $this->email],
            subject: 'You have a New Follower!',
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
            view: 'mail.new-follower',
            with: [
                'greeting' => "Dear " . $this->name . "!",
                'url' => $this->url,
                'name' => $this->name,
                'numFollowers' => $this->numFollowers,
                'newFollowerName' => $this->newFollowerName,
                'introLines' => [
                    "In this moment you have:"
                ],
                'outroLines' => [
                    'Thanks you so much for using our website.',
                    'Awesome! Continue for this path and enjoy coding!',
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

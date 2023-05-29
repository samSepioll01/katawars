<?php

namespace App\Mail;

use App\Models\Favorite;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AddFavorite extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $voterUsername;
    public $score;
    public $typeScore;
    public $challenge;
    public $url;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($favorite)
    {
        $this->user = $favorite->solution->kata->owner->user;
        $this->voterUsername = $favorite->profile->user->name;
        $this->score = $favorite->scoreRecords->first()->score->points;
        $this->typeScore = $favorite->scoreRecords->first()->score->type;
        $this->challenge = $favorite->solution->kata->challenge->title;
        $this->url = $favorite->solution->kata->challenge->url;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            to: [$this->user->name => $this->user->email],
            subject: 'Your resources has been voted!',
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
            view: 'mail.favorite',
            with: [
                'greeting' => "Dear " . $this->user->name . "!",
                'url' => $this->url,
                'challenge' => $this->challenge,
                'score' => $this->score,
                'typeScore' => $this->typeScore,
                'voterUsername' => $this->voterUsername,
                'introLines' => [
                    "You have won:"
                ],
                'outroLines' => [
                    'Thanks you so much for give content to our website.',
                    'Continue for this path and enjoy coding!',
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

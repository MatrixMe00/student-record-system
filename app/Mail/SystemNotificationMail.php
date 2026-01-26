<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SystemNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $title;
    public $message;
    public $details;
    public $actionUrl;
    public $actionText;

    /**
     * Create a new message instance.
     */
    public function __construct(
        string $subject,
        string $title,
        string $message,
        array $details = [],
        ?string $actionUrl = null,
        ?string $actionText = null
    ) {
        $this->subject = $subject;
        $this->title = $title;
        $this->message = $message;
        $this->details = $details;
        $this->actionUrl = $actionUrl;
        $this->actionText = $actionText;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.system-notification',
            with: [
                'title' => $this->title,
                'message' => $this->message,
                'details' => $this->details,
                'actionUrl' => $this->actionUrl,
                'actionText' => $this->actionText,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

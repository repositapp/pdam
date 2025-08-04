<?php

namespace App\Mail;

use App\Models\Pemasangan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StatusPermohonanMail extends Mailable
{
    use Queueable, SerializesModels;
    public $pemasangan;
    public $statusLama;
    public $statusBaru;


    /**
     * Create a new message instance.
     */
    public function __construct(Pemasangan $pemasangan, $statusLama, $statusBaru)
    {
        $this->pemasangan = $pemasangan;
        $this->statusLama = $statusLama;
        $this->statusBaru = $statusBaru;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Update Status Permohonan Pemasangan Air - ' . config('app.name'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.status_permohonan',
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

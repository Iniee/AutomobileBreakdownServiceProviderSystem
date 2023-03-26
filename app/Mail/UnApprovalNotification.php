<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UnApprovalNotification extends Mailable
{
      use Queueable, SerializesModels;

    protected $provider;
    protected $id;
    protected $agent;

    /**
     * Create a new message instance.
     *
     * @param $provider
     * @param $id
     * @param $agent
     */
    public function __construct($provider, $id, $agent)
    {
        $this->provider = $provider;
        $this->id = $id;
        $this->agent = $agent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Your approval status has been updated";
        $message = "Dear " . $this->id . ",\n\nYour approval status has been updated to 'Pending'.\n\nBest regards,\n" . $this->agent;
        $id = $this->id;
        $agent = $this->agent;
        return $this->to($this->provider)
            ->subject($subject)
            ->view('content.mail.unapproval', ['message' => $message])
            ->with([
                    'id' => $id,
                    'agent' => $agent,
            ])
            ->from('alakeinioluwa21@gmail.com');
    }
}
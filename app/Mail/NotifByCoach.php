<?php

namespace App\Mail;

use App\Team;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifByCoach extends Mailable
{
    use Queueable, SerializesModels;

    protected $team_name;
    protected $event_name;
    protected $event_date;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($team_name, $event_name, $event_date)
    {
        $this->team_name = $team_name;
        $this->event_name = $event_name;
        $this->event_date = $event_date;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $test = $this->team_name;
        return $this->subject('Notification événement')->view('emails.notif_coach')->with([
            'team_name' => $this->team_name,
            'event_name' => $this->event_name,
            'event_date' => $this->event_date
        ]);
    }
}

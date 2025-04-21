<?php

namespace App\Mail;

use App\Models\Interview;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InterviewConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $interview;
    public $confirmed;

    public function __construct(Interview $interview, bool $confirmed = true)
    {
        $this->interview = $interview;
        $this->confirmed = $confirmed;
    }

    public function build()
    {
        $subject = $this->confirmed 
            ? 'Interview Confirmed: ' . $this->interview->job->title
            : 'Interview Reschedule Requested: ' . $this->interview->job->title;
            
        return $this->subject($subject)
                    ->markdown('emails.interviews.confirmation');
    }
}
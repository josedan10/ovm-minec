<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Permit;

class DateToUploadTheRequirementsWasExceeded extends Mailable
{
    use Queueable, SerializesModels;
    public $subject = "Se superó la fecha para cargar los requisitos";
    public $formalitie;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Permit $formalitie)
    {
        $this->$formalitie = $formalitie;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('panel.dashboard.mail.dateFinishMail');
    }
}

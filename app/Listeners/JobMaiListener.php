<?php

namespace App\Listeners;

use App\Events\JobMailEvent;
use App\Mail\JobMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class JobMaiListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(JobMailEvent $event)
    {
        Mail::to($event->candidateMail)->send(new JobMail());
    }
}

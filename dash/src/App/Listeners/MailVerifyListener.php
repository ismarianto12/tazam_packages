<?php

namespace Bryanjack\Dash\App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class MailVerifyListener implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $participant = $event->detail;
        // JOBS: change with parameter config
        Mail::send('dash::mail.verify', ['name' => $participant->name, 'email' => $participant->email, 'link' => $event->link], function ($message) use ($participant) {
            $message->from('info@isms.id', 'Indonesia Strategic Management Society');
            $message->subject('Aktivasi User ISMS');
            $message->to($participant->email);
            // $message->bcc('yusuf.fauzans@gmail.com');
        });
    }
}

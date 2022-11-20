<?php

namespace App\Listeners;

use App\Events\SendTempPassword;
use App\Mail\AdminInvitation;
use Illuminate\Support\Facades\Mail;

class SendNotificationEmail
{
    /**
     * Handle the event.
     *
     * @param  SendTempPassword  $event
     * @return void
     */
    public function handle(SendTempPassword $event)
    {
        Mail::to($event->data['email'])->send(new AdminInvitation($event->data));
    }
}

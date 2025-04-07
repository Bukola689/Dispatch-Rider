<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;
use Illuminate\Queue\InteractsWithQueue;

class LoggedInNotification
{
    private $user;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(User $event)
    {
        ProcessUserLogin::dispatch($event->user)->delay(now()->addMinutes(5));
    }
}

<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Ap\Models\User;
use Illuminate\Queue\InteractsWithQueue;

class ProcessUserRegistrationAnalytics
{
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
    public function handle($event)
    {
        //
    }
}

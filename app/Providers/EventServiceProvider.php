<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use App\Events\UserRegistered;
use App\Events\UserLogin;
use App\Events\UpdateProfile;
use App\Events\ResetPasswordEvent;
use App\Events\ChangePasswordEvent;
use App\Events\ChangePassword;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use App\Listeners\SendWelcomeNotification;
use App\Listeners\ChangeUpdatedPassword;
use App\Listeners\ChangeUpdateProfile;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        Registered::class => [
            SendWelcomeNotification::class,
            //ProcessUserRegistrationAnalytics::class,
        ],

        UserLogin::class => [
            LoggedInNotification::class,
        ],

        UpdateProfile::class => [
            UpdateProfile::class,
        ],

        ChangePassword::class => [
            ChangeUpdatedPassword::class,
        ],

        ChangePasswordEvent::class => [
            ChangeUpdatedNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

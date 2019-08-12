<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        
        'App\Events\Auth\UserRegistered' => [
            'App\Listeners\Auth\SendRegisterNotification',
        ],
        
        'App\Events\Admin\ProductCodeExcess' => [
            'App\Listeners\Admin\SendProductCodeExcess',
        ],
        
        'App\Events\DealNew' => [
            'App\Listeners\SendDealNewAuthor',
            'App\Listeners\SendDealNewInitiator',
        ],
        
        'App\Events\DealAccept' => [
            'App\Listeners\SendDealAcceptAuthor',
            'App\Listeners\SendDealAcceptInitiator',
        ],
        
        'App\Events\DealCancel' => [
            'App\Listeners\SendDealCancelAuthor',
            'App\Listeners\SendDealCancelInitiator',
        ],
        
        'App\Events\ScoreAdd' => [
            'App\Listeners\SendScoreAdd',
        ],
        
        //Отправка сообщ и прекращ рекламы для тех услуг период рекламы которых истек
        'App\Events\OverdueAds' => [
            'App\Listeners\SendOverdueAds',
        ],
        
        //Отправка сообщ и прекращ публикации для тех услуг период публикации которых истек
        'App\Events\EndPublic' => [
            'App\Listeners\SendEndPublic',
        ],
        
        //Отправка сообщ пользователям, которые не прочли сообщения от других пользователей
        'App\Events\UnreadMessages' => [
            'App\Listeners\SendUnreadMessages',
        ],
        
        
        
        
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}

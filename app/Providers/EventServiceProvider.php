<?php

namespace App\Providers;

use App\Events\OrderCancelled;
use App\Listeners\RestoreCustomerCredit;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, list<class-string>>
     */
    protected $listen = [
        OrderCancelled::class => [
            RestoreCustomerCredit::class,
        ],
    ];
}

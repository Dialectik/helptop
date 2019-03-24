<?php

namespace App\Providers;

use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;
use Illuminate\Queue\Events\JobFailed;

class AppServiceProvider extends ServiceProvider
{
    
    public function register()
    {
        //
    }

    public function boot()
    {
        //Метод работы с проваленными заданиями в очередях
        Queue::failing(function (JobFailed $event) {
	       // $event->connectionName
	       // $event->job
	       // $event->exception
   		});
    }
}

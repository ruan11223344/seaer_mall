<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
        'Laravel\Passport\Events\AccessTokenCreated' => [
            'App\Listeners\PassportAccessTokenCreated',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */

    public function handle(\Laravel\Passport\Events\AccessTokenCreated $event)
    {
        $provider = \Config::get('auth.guards.api.provider');
        DB::table('oauth_access_token_providers')->insert([
            "oauth_access_token_id" => $event->tokenId,
            "provider" => $provider,
            "created_at" => new Carbon(),
            "updated_at" => new Carbon(),
        ]);
    }

    public function boot()
    {
        parent::boot();

        //
    }
}

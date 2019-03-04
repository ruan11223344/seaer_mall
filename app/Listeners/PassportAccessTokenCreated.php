<?php

namespace App\Listeners;

use App\Events\Laravel\Passport\Events\AccessTokenCreated;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PassportAccessTokenCreated
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
     * @param  \Laravel\Passport\Events\AccessTokenCreated $event
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
}
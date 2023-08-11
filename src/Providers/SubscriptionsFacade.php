<?php

namespace CryptoDev4\Subscriptions;

use Illuminate\Support\Facades\Facade;

class SubscriptionsFacade extends Facade 
{
    protected static function getFacadeAccessor()
    {
        return 'cryptodev4/laravel-subscriptions';
    }
}
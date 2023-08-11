<?php

declare(strict_types=1);

namespace CryptoDev4\Subscriptions\Providers;

use Illuminate\Support\ServiceProvider;
use CryptoDev4\Subscriptions\Console\Commands\MigrateCommand;
use CryptoDev4\Subscriptions\Console\Commands\PublishCommand;
use CryptoDev4\Subscriptions\Console\Commands\RollbackCommand;

class SubscriptionsServiceProvider extends ServiceProvider
{
    private $_packageTag = 'cryptodev4/laravel-subscriptions';

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        MigrateCommand::class,
        PublishCommand::class,
        RollbackCommand::class,
    ];

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        // 
        $this->mergeConfigFrom(realpath(__DIR__.'/../../config/subscription.php'), 'subscriptions');

        // 
        $this->loadMigrations();
        
        // Register console commands
        $this->commands($this->commands);
    }

    public function loadMigrations()
    {
        if (config('subscriptions.autoload_migrations')) {
            $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        }   
    }


    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $publishTag = $this->_packageTag;

        // Publish Resources
        
        $this->publishes([
            __DIR__.'/config/subscriptions.php' => config_path('subscriptions.php'),
        ], $publishTag.'-config');

        $this->publishes([
            __DIR__.'/database/migrations' => database_path('migrations'),
        ], $publishTag.'-migrations');
    }
}

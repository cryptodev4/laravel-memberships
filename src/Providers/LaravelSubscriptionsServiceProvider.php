<?php

declare(strict_types=1);

namespace CryptoDev4\LaravelSubscriptions\Providers;

use Illuminate\Support\ServiceProvider;
use CryptoDev4\LaravelSubscriptions\Console\Commands\MigrateCommand;
use CryptoDev4\LaravelSubscriptions\Console\Commands\PublishCommand;
use CryptoDev4\LaravelSubscriptions\Console\Commands\RollbackCommand;

class LaravelSubscriptionsServiceProvider extends ServiceProvider
{
    private $_packageTag = 'laravel-subscriptions';

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
        
        $this->mergeConfigFrom(__DIR__.'/../../config/laravel-subscriptions.php', 'config.laravel-subscriptions');

        
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
            __DIR__.'/../../config/laravel-subscriptions.php' => config_path('laravel-subscriptions.php'),
        ], $publishTag.'-config');

        $this->publishes([
            __DIR__.'/../../database/migrations' => database_path('migrations/laravel-subscriptions'),
        ], $publishTag.'-migrations');
    }
}

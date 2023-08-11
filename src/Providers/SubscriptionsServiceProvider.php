<?php

declare(strict_types=1);

namespace CryptoDev4\Subscriptions\Providers;

use CryptoDev4\Subscriptions\Models\Plan;
use Illuminate\Support\ServiceProvider;
use CryptoDev4\Subscriptions\Models\PlanFeature;
use CryptoDev4\Subscriptions\Models\PlanSubscription;
use CryptoDev4\Subscriptions\Models\PlanSubscriptionUsage;
use CryptoDev4\Subscriptions\Console\Commands\MigrateCommand;
use CryptoDev4\Subscriptions\Console\Commands\PublishCommand;
use CryptoDev4\Subscriptions\Console\Commands\RollbackCommand;

class SubscriptionsServiceProvider extends ServiceProvider
{
    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        MigrateCommand::class => 'command.cryptodev4.subscriptions.migrate',
        PublishCommand::class => 'command.cryptodev4.subscriptions.publish',
        RollbackCommand::class => 'command.cryptodev4.subscriptions.rollback',
    ];

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(realpath(__DIR__.'/../../config/config.php'), 'cryptodev4.subscriptions');

        // Bind eloquent models to IoC container
        $this->registerModels([
            'cryptodev4.subscriptions.plan' => Plan::class,
            'cryptodev4.subscriptions.plan_feature' => PlanFeature::class,
            'cryptodev4.subscriptions.plan_subscription' => PlanSubscription::class,
            'cryptodev4.subscriptions.plan_subscription_usage' => PlanSubscriptionUsage::class,
        ]);

        // Register console commands
        $this->registerCommands($this->commands);
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Publish Resources
        $this->publishesConfig('cryptodev4/laravel-subscriptions');
        $this->publishesMigrations('cryptodev4/laravel-subscriptions');
        ! $this->autoloadMigrations('cryptodev4/laravel-subscriptions') || $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
    }
}

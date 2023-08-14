<?php

declare(strict_types=1);

return [

    // Manage autoload migrations
    'autoload_migrations' => false,

    // Subscriptions Database Tables
    'tables' => [

        'plans' => 'plans',
        'plan_features' => 'plan_features',
        'plan_subscriptions' => 'plan_subscriptions',
        'plan_subscription_usage' => 'plan_subscription_usage',

    ],

    // Subscriptions Models
    'models' => [

        'plan' => \CryptoDev4\LaravelSubscriptions\Models\Plan::class,
        'plan_feature' => \CryptoDev4\LaravelSubscriptions\Models\PlanFeature::class,
        'plan_subscription' => \CryptoDev4\LaravelSubscriptions\Models\PlanSubscription::class,
        'plan_subscription_usage' => \CryptoDev4\LaravelSubscriptions\Models\PlanSubscriptionUsage::class,

    ],

];

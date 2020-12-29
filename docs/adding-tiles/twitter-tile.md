---
title: Twitter tile
weight: 5
---

This tile displays Twitter mentions.

![screenshot](https://spatie.be/docs/laravel-dashboard/v2/images/twitter.png)

## Installation

You can install the package via composer:

```bash
composer require spatie/laravel-dashboard-twitter-tile
```

In the `dashboard` config file, you must add this configuration in the `tiles` key. You can add a configuration in the `configurations` key per Twitter tile that you want to display. Any tweet that contains one of the strings in `listen_for` will be display on the dashboard.

```php
// in config/dashboard.php

return [
    // ...
    'tiles' => [
          'twitter' => [
                'configurations' => [
                    'default' => [
                        'access_token' => env('TWITTER_ACCESS_TOKEN'),
                        'access_token_secret' => env('TWITTER_ACCESS_TOKEN_SECRET'),
                        'consumer_key' => env('TWITTER_CONSUMER_KEY'),
                        'consumer_secret' => env('TWITTER_CONSUMER_SECRET'),
                        'listen_for' => [
                            // 
                        ],
                    ],
                ],
                'refresh_interval_in_seconds' => 5,
            ],
    ],
];
```

Under the hood this package uses [`spatie/laravel-twitter-streaming-api`](https://github.com/spatie/laravel-twitter-streaming-api). Take a look in the readme of the package to learn [how you can get the values](https://github.com/spatie/laravel-twitter-streaming-api#getting-credentials) for `access_token`,  `access_token_secret`, `consumer_key`, and `consumer_key`.

## Usage

To starting listening for incoming tweets of the configuration named `default`, you must execute this command:

```bash
php artisan dashboard:listen-twitter-mentions
```

This command will never end. In production should probably want to use something like Supervisord to keep this this task running and to automatically start it when your system restarts.

To start listening for tweets of another configuration, simply add the name of the configuration as an arugment.

```bash
php artisan dashboard:listen-twitter-mentions alternate-configuration-name
```

In your dashboard view you use the `livewire:twitter-tile` component to display tweets of the default configuration.

```html
<x-dashboard>
    <livewire:twitter-tile position="a1:a6"/>
</x-dashboard>
```

To display tweets of another configuration, pass the name of the configuration to the `configuration-name` prop.

```html
<x-dashboard>
    <livewire:twitter-tile position="a1:a6" configuration-name="alternate-configuration-name"/>
</x-dashboard>
```

### Customizing the view

If you want to customize the view used to render this tile, run this command:

```bash
php artisan vendor:publish --provider="Spatie\TwitterTile\TwitterTileServiceProvider" --tag="dashboard-twitter-tile-views"
```

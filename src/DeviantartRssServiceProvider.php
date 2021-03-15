<?php

namespace AngryMoustache\DeviantartRss;

use Illuminate\Support\ServiceProvider;

class DeviantartRssServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/deviantart-rss.php',
            'deviantart-rss'
        );
    }

    public function register()
    {
        $this->publishes([
            __DIR__ . '/../config/deviantart-rss.php' => config_path('deviantart-rss.php'),
        ], 'deviantart-rss');
    }
}

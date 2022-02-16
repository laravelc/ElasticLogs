<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Monolog\Formatter\ElasticsearchFormatter;
use Monolog\Handler\ElasticsearchHandler;

class ElasticLogProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $index = config('elastic_log_channel.index');
        $type = config('elastic_log_channel.type');

        $this->app->bind(Client::class, function ($app) {
            return ClientBuilder::create()->setHosts([config('elastic_log_channel.host')])->build();
        });

        $this->app->bind(ElasticsearchFormatter::class, function ($app) use ($index, $type) {
            return new ElasticsearchFormatter($index, $type);
        });

        $this->app->bind(ElasticsearchHandler::class, function ($app) use ($index, $type) {
            return new ElasticsearchHandler($app->make(Client::class), [
                'index'        => $index,
                'type'         => $type,
                'ignore_error' => false,
            ]);
        });
    }
}

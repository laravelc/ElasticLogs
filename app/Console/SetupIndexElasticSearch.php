<?php

namespace App\Console;

use Elasticsearch\Client;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class SetupIndexElasticSearch extends Command
{
    /**
     * @var Client
     */
    protected Client $client;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic:setup_index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup elastic log index';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $index = ['index' => config('elastic_log_channel.index')];

        if (!$this->client->indices()->exists($index)) {
            $this->client->indices()->create($index);
        }

        return CommandAlias::SUCCESS;
    }
}

<?php

namespace Laravel\Scout\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'scout:flush')]
class FlushCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scout:flush {model : Class name of the model to flush} {--clear-cache : Clear the cache after flushing the model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Flush all of the model's records from the index and optionally, clear cache";

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $class = $this->argument('model');
        $clearCache = $this->option('clear-cache');

        $model = new $class;

        $model::removeAllFromSearch();

        $this->info('All ['.$class.'] records have been flushed.');

        if ($clearCache) {
            $this->call('cache:clear');
            $this->info('Cache cleared successfully.');
        }
    }
}

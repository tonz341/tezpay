<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Binance;
use Illuminate\Support\Facades\Cache;

class ConversionRequestor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'conversion:request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get current value of tezos vs usdt';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $binance = config('services.binance');
        $api = new Binance\API($binance['api'],$binance['secret']);
        Cache::store('file')->put('XTZUSDT',(double)$api->price('XTZUSDT'));
    }
}

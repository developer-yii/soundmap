<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Stocks;

class remove_dispatch_stocklist extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:remove_dispatch_stocklist';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'In the Dispatched Stock List over 5 days, after Received Date will automaticall go to Archived Stock';

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
     * @return int
     */
    public function handle()
    {
        info('remove_dispatch_stocklist');  

        $remove_dispatch_stocklist = Stocks::whereDate('receiving_date',date('Y-m-d ',strtotime('-5 day')) )->where('status_dropdown',1)->where('is_deleted',0)->get();
        foreach($remove_dispatch_stocklist as $data){
            $update = Stocks::find($data->id);
            $update->is_deleted = 1;
            $update->save();
        }
    }
}
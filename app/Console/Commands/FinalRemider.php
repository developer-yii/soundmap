<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Stocks;
use App\Mail\final_reminder;
use Illuminate\Support\Facades\Mail;
use App\Companys;

class FinalRemider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:FinalRemider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'If the stock remains in the Order pending for Collection group for 4 days, and not move to dispatched Stock, send another email to company email ';

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
    public function handle(Request $request)
    {
        info('call Command');
        $dispatch_Reminder = Stocks::whereDate('ready_date_time',date('Y-m-d ',strtotime('-4 day')) )->where('status_dropdown',0)->where('is_deleted',0)->get();
        foreach ($dispatch_Reminder as  $value) {
            $order_no = $value->order_no;
            $ready_date_time = date('Y-m-d H:i:s',strtotime($value->ready_date_time));
            $package_qty = $value->package_qty;
            $details = [
                'order_no'=>$order_no,
                'ready_date_time'=>$ready_date_time,                  
                'title'=>'Final Reminder',
            ];

            $emails = Companys::select('email')->where('id',$value->company_id)->first();
            Mail::to($emails)->send(new final_reminder($details));
        }
    }
}

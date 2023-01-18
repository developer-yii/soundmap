<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;
use App\Checklist;
use App\Task;
use App\User;
use App\TaskCompleted;
use App\ChecklistGroup;
use App\KioskSetting;
use App\ServiceDesk;
use App\UserNotification;
use Auth;
use App\Plan;
use Stripe;
use App\Subscription;
use Session;
use App\Jobs\SyncTransaction;
use App\PaymentTransaction;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
            return view('home');
    
    }

}

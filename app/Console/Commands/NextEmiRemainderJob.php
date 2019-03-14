<?php

namespace App\Console\Commands;
use App\Mail\EmiRemainderMail;
use App\Mail\NextEmiRemainderMail;
use App\Models\admin\UserLoanMgmt;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class NextEmiRemainderJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'NextEmiRemainderJob:nextEmiRemainderJob';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Next Emi Remainder running';

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
        $month=date('m',strtotime('first day of +1 month'));
        $userLoanMgmt = UserLoanMgmt::select('users.id','users.email')->join('users','user_loan_mgmts.user_id','=','users.id')->where('tenuar_status','=',0)->whereMonth('tenuar_date', '=', $month)->groupBy('user_loan_mgmts.user_id')->get();
        foreach($userLoanMgmt as $userLoanMgmts) {
            $userLoanMgmt_1 = UserLoanMgmt::select('user_loan_mgmts.*','users.name','users.email')->join('users','user_loan_mgmts.user_id','=','users.id')->where('tenuar_status','=',0)->whereMonth('tenuar_date', '=', $month)->where('user_loan_mgmts.user_id','=',$userLoanMgmts->id)->get();
            if(!empty($userLoanMgmt_1)) {
                Mail::to($userLoanMgmts->email)->send(new NextEmiRemainderMail($userLoanMgmt_1));
            }
        }
    }
}

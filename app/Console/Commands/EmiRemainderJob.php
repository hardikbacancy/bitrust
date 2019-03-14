<?php
namespace App\Console\Commands;
use App\Mail\EmiRemainderMail;
use App\Models\admin\UserLoanMgmt;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class EmiRemainderJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'EmiRemainderJob:emiRemainderJob';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Emi Remainder Job Cron is Running';

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
        $today_date = date('Y-m-d');
        $userLoanMgmt = UserLoanMgmt::select('users.id','users.email')->join('users','user_loan_mgmts.user_id','=','users.id')->where('tenuar_status','=',0)->whereDate('tenuar_date', '<', $today_date)->groupBy('user_loan_mgmts.user_id')->get()->toArray();

        foreach($userLoanMgmt as $userLoanMgmts) {
            $userLoanMgmt_1 = UserLoanMgmt::select('user_loan_mgmts.*','users.name','users.email')->join('users','user_loan_mgmts.user_id','=','users.id')->where('tenuar_status','=',0)->whereDate('tenuar_date', '<', $today_date)->where('user_loan_mgmts.user_id','=',$userLoanMgmts->id)->get();
            if(!empty($userLoanMgmt_1)) {
                Mail::to($userLoanMgmts->email)->send(new EmiRemainderMail($userLoanMgmt_1));
            }
        }
    }
}

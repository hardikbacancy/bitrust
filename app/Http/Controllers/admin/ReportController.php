<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\admin\LoanRequest;
use App\Models\admin\UserLoanMgmt;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Excel;
use Yajra\Datatables\Facades\Datatables;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
    {
        return view('admin.report');
    }

    public function reportList(Request $request)
    {
        $start_date = $end_date = "";
        if (!empty($request->start_date)) {
            $start_date = $request->start_date;
            $start_date = date('Y-m-d', strtotime($start_date));
        } 
        if (!empty($request->end_date)) {
            $end_date = $request->end_date;
            $end_date = date('Y-m-d', strtotime($end_date));            
        }
            // $loanRequest = LoanRequest::where('request_status', '=', 1)->orderBy('updated_at', 'desc')->get()->toArray();
           
            $rname = $email = '';
            if(!empty($request->name)){
                $rname = $request->name;
            }
            if(!empty($request->email)){
                $email = $request->email;
            }
            $query =  LoanRequest::select('loan_requests.*','loan_requests.id as lid','users.*')->where('request_status', '=', 1);
            //$query->where('request_status', '=', 1);
            $query->join('users', 'users.id', '=', 'loan_requests.user_id');

            //$query->where('name', 'like', 'bacancy');
            if($start_date) $query->whereDate('loan_requests.created_at', '>=', $start_date);
            if($end_date) $query->whereDate('loan_requests.created_at', '<=', $end_date);
            if($rname) $query->where('users.name', 'like','%'.$rname.'%');
            if($email) $query->where('users.email', 'like','%'.$email.'%');

            $query->orderBy('loan_requests.updated_at', 'desc');

            $loanRequest = $query->get()->toArray();
       
      
        foreach ($loanRequest as $key => $value) {
            $loanRequests = User::find($value['user_id'])->toArray();
            $loanRequest[$key]['loan_id'] = $value['id'];
            $loanRequest[$key]['name'] = $loanRequests['name'];
            $loanRequest[$key]['email'] = $loanRequests['email'];
            $loan_amount = $value['loan_amount'];
            $emi_period = $value['tenuar_period'];
            $interest = $value['interest_rate'];
            $laon_amount_including_interest = floor($value['loan_amount'] * $value['interest_rate'] / 100 + $value['loan_amount']);
            $loanRequest[$key]['laon_amount_including_interest'] = $laon_amount_including_interest;
            $emi_amount = ($laon_amount_including_interest) / $emi_period;
            $loanRequest[$key]['emi_amount'] = floor($emi_amount);
            $LoanDetails = UserLoanMgmt::where('request_id', $value['id'])->
            where('user_id', $value['user_id'])->get()->toArray();

            $loanRequest[$key]['created_date'] = date('Y-m-d', strtotime($value['created_at']));

            $i = 0;
            foreach ($LoanDetails as $LoanDetail) {
                $status = $LoanDetail['tenuar_status'];
                if ($status == 1) {
                    $i++;
                }
            }
            if ($i == $emi_period) {
                $loanRequest[$key]['completed'] = "Completed";
            } else {
                $loanRequest[$key]['completed'] = "Processing";
            }
//            $paidEmiAmount = $emi_amount * $i;
//            $loanRequest[$key]['paidEmiAmount'] = floor($paidEmiAmount);
//            $loanRequest[$key]['remainningEmiAmount'] = floor($laon_amount_including_interest - $paidEmiAmount);
            $loanRequest[$key]['paidEmiAmount']=DB::table('user_loan_mgmts')
                ->where('user_id','=',$value['user_id'])->where('request_id','=',$value['id'])->where('tenuar_status','=',1)->sum('emi_amount');

            $loanRequest[$key]['remainningEmiAmount']=DB::table('user_loan_mgmts')
                ->where('user_id','=',$value['user_id'])->where('request_id','=',$value['id'])->where('tenuar_status','=',0)->sum('emi_amount');
        }
        //print_r($loanRequest);die;
        function arrayToCollection($loanRequest)
        {
            foreach ($loanRequest as $key => $value) {
                if (is_array($value)) {
                    $value = arrayToCollection($value);
                    $loanRequest[$key] = $value;
                }
            }
            return collect($loanRequest);
        }

        $loanRequest_1 = arrayToCollection($loanRequest);
        //print_r($loanRequest_1);die;
        return Datatables::of($loanRequest_1)
            ->addColumn('export', function ($loanRequest_1) {
                return ' <span style="margin-right: 2px;"  class="tooltips" title="Detailed Loan Reports" data-placement="top">
                              <a href="' . route(ADMIN . '.report.export', $loanRequest_1['lid']) . '" class="btn btn-primary btn-xs" style="margin-left: 10%;">
                                 <span class="glyphicon glyphicon-export"></span>
                              </a>
                            </span>';
            })
            ->make(true);
    }

    public function checkData(Request $request){
        if (!empty($request->start_date) && !empty($request->end_date)) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $start_date = date('Y-m-d', strtotime($start_date));
            $end_date = date('Y-m-d', strtotime($end_date));
            $loanRequest = LoanRequest::where('request_status', '=', 1)->whereDate('created_at', '>', $start_date)->whereDate('created_at', '<=', $end_date)->get()->toArray();
        } else if (!empty($request->start_date)) {
            $start_date = $request->start_date;
            $start_date = date('Y-m-d', strtotime($start_date));
            $loanRequest = LoanRequest::where('request_status', '=', 1)->whereDate('created_at', '>', $start_date)->get()->toArray();
        } else if (!empty($request->end_date)) {
            $end_date = $request->end_date;
            $end_date = date('Y-m-d', strtotime($end_date));
            $loanRequest = LoanRequest::where('request_status', '=', 1)->whereDate('created_at', '<=', $end_date)->get()->toArray();
        } else {
            $loanRequest = LoanRequest::where('request_status', '=', 1)->get()->toArray();
        }
        return json_encode($loanRequest);
    }

    public function exportRow(Request $request,$Id){

        $type = 'xlsx';
        $loanRdata = LoanRequest::where('id',$Id)->get()->toArray();
        $userData = User::find($loanRdata['0']['user_id'])->toArray();
        //print_r($userData['name']);die;
        $emiData = UserLoanMgmt::where('request_id', $loanRdata['0']['id'])->get()->toArray();

        $j = 0;
        $emi_period = $loanRdata['0']['tenuar_period'];
        foreach ($emiData as $LoanDetail) {
            $status = $LoanDetail['tenuar_status'];
            if ($status == 1) {
                $j++;
            }
        }
        if ($j == $emi_period) {
            $loanRdata['0']['loan_status'] = "Completed";
        } else {
            $loanRdata['0']['loan_status'] = "Processing";
        }
        //print_r($loanRdata);die;

        $fileName = 'detailed_loan_reports_'.time();

        return Excel::create($fileName, function($excel) use ($loanRdata,$userData,$emiData) {
            $excel->sheet('mySheet', function($sheet) use ($loanRdata,$userData,$emiData)
            {
                $sheet->cell('A1', function($cell) {$cell->setValue('Name');   });
                $sheet->cell('B1', function($cell) {$cell->setValue('Email');   });
                $sheet->cell('C1', function($cell) {$cell->setValue('Phone Number');   });
                $sheet->cell('D1', function($cell) {$cell->setValue('Address');   });
                if (!empty($userData)) {
                    $i = 2;
                    $sheet->cell('A'.$i, $userData['name']); 
                    $sheet->cell('B'.$i, $userData['email']); 
                    $sheet->cell('C'.$i, $userData['mobile']); 
                    $sheet->cell('D'.$i, $userData['address']); 
                    
                }

                $sheet->cell('A4', function($cell) {$cell->setValue('Loan Id');   });
                $sheet->cell('B4', function($cell) {$cell->setValue('Loan Amount(in $)');   });
                $sheet->cell('C4', function($cell) {$cell->setValue('EMI Period(in Month)');   });
                $sheet->cell('D4', function($cell) {$cell->setValue('Interest Rate(In %)');   });
                $sheet->cell('E4', function($cell) {$cell->setValue('Loan Amount(Including Interest in $)');   });
                $sheet->cell('F4', function($cell) {$cell->setValue('EMI Amount(Per Month in $)');   });
                $sheet->cell('G4', function($cell) {$cell->setValue('EMI Paid Amount(in $)');   });
                $sheet->cell('H4', function($cell) {$cell->setValue('EMI Remainning Amount(in $)');   });
                $sheet->cell('I4', function($cell) {$cell->setValue('Loan Status');   });
                $sheet->cell('J4', function($cell) {$cell->setValue('Created Date');   });

                if (!empty($loanRdata)) {
                    foreach ($loanRdata as $key => $value) {
                        $i= $key+5;

                        $tlAmount = $value['loan_amount']+($value['loan_amount']*$value['interest_rate'])/100;
                        $emipermonth = round($tlAmount/$value['tenuar_period'],2);

                        $paidEmiAmount = DB::table('user_loan_mgmts')->where('request_id','=',$value['id'])->where('tenuar_status','=',1)->sum('emi_amount');

                        $UnpaidEmiAmount = $tlAmount - $paidEmiAmount;

                        $sheet->cell('A'.$i, $value['id']); 
                        $sheet->cell('B'.$i, $value['loan_amount']); 
                        $sheet->cell('C'.$i, $value['tenuar_period']); 
                        $sheet->cell('D'.$i, $value['interest_rate']);
                        $sheet->cell('E'.$i, $tlAmount);
                        $sheet->cell('F'.$i, $emipermonth);

                        $sheet->cell('G'.$i, $paidEmiAmount); 
                        $sheet->cell('H'.$i, $UnpaidEmiAmount); 
                        $sheet->cell('I'.$i, $value['loan_status']); 

                        $sheet->cell('J'.$i, $value['created_at']); 
                    }
                }

                $sheet->cell('A7', function($cell) {$cell->setValue('EMI Details');   });

                $sheet->cell('A8', function($cell) {$cell->setValue('Sr. No');   });
                $sheet->cell('B8', function($cell) {$cell->setValue('EMI Date');   });
                $sheet->cell('C8', function($cell) {$cell->setValue('EMI Amount');   });
                $sheet->cell('D8', function($cell) {$cell->setValue('EMI Penalty');   });
                $sheet->cell('E8', function($cell) {$cell->setValue('EMI Status');   });


                if (!empty($emiData)) {
                    $srNo = 0;
                    foreach ($emiData as $key => $value) {
                        $srNo++;
                        $i= $key+9;
                        if($value['tenuar_status'] == 0){
                            $emiStatus = "Unpaid";
                        }else{
                            $emiStatus = "Paid";
                        }
                        $sheet->cell('A'.$i, $srNo); 
                        $sheet->cell('B'.$i, $value['tenuar_date']); 
                        $sheet->cell('C'.$i, $value['emi_amount']); 
                        $sheet->cell('D'.$i, $value['penalty']); 
                        $sheet->cell('E'.$i, $emiStatus); 
                    }
                }


            });
        })->download($type);
        
    }
}

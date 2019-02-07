<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\admin\Expense;
use App\Models\admin\ExpenseDetail;
use App\Models\admin\UserLoanMgmt;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class ExpenseController extends Controller
{
    public function expense(Request $request){
        $expenses=Expense::all()->toArray();
        return view('admin.expenses.index',get_defined_vars());
    }
    public function expensePostAjax(Request $request){
        $query=ExpenseDetail::join('expenses','expense_details.expense_id','=','expenses.id');
        if(!empty($request->expense_id)){
            $query=$query->where('expense_id','=',$request->expense_id);
        }
        if(!empty($request->year)){
            $query=$query->where('year','=',$request->year);
        }
        if(!empty($request->month)){
            $query=$query->where('month','=',$request->month);
        }
        $expenseData=$query->get();

        return Datatables::of($expenseData)
            ->addColumn('editDeleteAction', function ($expenseData) {
                return ' <span style="margin-right: 2px;"  class="tooltips" title="View Membership Detail" data-placement="top">
                              <a href="' . route(ADMIN . '.expense.edit', $expenseData->id) . '" class="btn btn-primary btn-xs" style="margin-left: 10%;">
                                <i class="fa fa-edit"></i>
                              </a>
                            </span>
                           ';
            })
            ->make(true);
    }
    public function expenseCreate(Request $request){
        $expenses=Expense::all()->toArray();
        return view('admin.expenses.create',get_defined_vars());
    }
    public function store(Request $request){
        if($request->isMethod('post')){
            $expenseData = ExpenseDetail::where('expense_id', '=', $request->expense_id)->where('year', '=', $request->year)->where('month', '=', $request->month)->first();
            if(empty($expenseData)){
                if($request->expense_amount!=0) {
                    $expense = new ExpenseDetail();
                    $expense->expense_id = $request->expense_id;
                    $expense->year = $request->year;
                    $expense->month = $request->month;
                    $expense->expense = $request->expense_amount;
                    $expense->save();
                    return redirect()->route(ADMIN . '.expense')->with('success', 'Created Successfully');
                }
                else{
                    return back()->with('message', 'Expense should not be zero');
                }
            }
            else{
                return back()->with('message', 'Already Created with Same Expense Year and Month');
            }

        }
    }
    public function editExpense(Request $request,$Id){
        $expensesDetails=ExpenseDetail::where('id','=',$Id)->first();
        return view('admin.expenses.edit',get_defined_vars());
    }

    public function updateExpense(Request $request){
        if($request->isMethod('post')){
                if($request->expense_amount!=0) {
                    $expense = ExpenseDetail::find($request->id);
                    $expense->expense = $request->expense_amount;
                    $expense->save();
                    return redirect()->route(ADMIN . '.expense')->with('success', 'Updated Successfully');
                }
                else{
                    return back()->with('message', 'Expense should not be zero');
                }

        }
    }

}
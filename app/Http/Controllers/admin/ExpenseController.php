<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\admin\Expense;
use App\Models\admin\ExpenseDetail;
use App\Models\admin\UserLoanMgmt;
use App\User;
use Excel;
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
        $query=ExpenseDetail::select('expense_details.*','expenses.expense_type')->join('expenses','expense_details.expense_id','=','expenses.id');
        if(!empty($request->expense_id)){
            $query=$query->where('expense_id','=',$request->expense_id);
        }
        if(!empty($request->year)){
            $query=$query->where('year','=',$request->year);
        }
        if(!empty($request->month)){
            $query=$query->where('month','=',$request->month);
        }
        $expenseData=$query->get()->toArray();

        function arrayToCollection($expenseData)
        {
            foreach ($expenseData as $key => $value) {
                if (is_array($value)) {
                    $value = arrayToCollection($value);
                    $expenseData[$key] = $value;
                }
            }
            return collect($expenseData);
        }

        $expenseData_1 = arrayToCollection($expenseData);
       
        return Datatables::of($expenseData_1)
            ->addColumn('editDeleteAction', function ($expenseData) {
                return ' <span style="margin-right: 2px;"  class="tooltips" title="Edit Expense Type" data-placement="top">
                              <a href="' . route(ADMIN . '.expense.edit', $expenseData['id']) . '" class="btn btn-primary btn-xs" style="margin-left: 10%;">
                                <i class="fa fa-edit"></i>
                              </a>
                            </span>
                            <span style="margin-right: 2px;"  class="tooltips" title="Delete Expense Type" data-placement="top">
                              <a data-expenseId="' . $expenseData['id'] . '" class="btn btn-danger btn-xs danger delete-expense" style="margin-left: 10%;">
                                <i class="fa fa-trash-o"></i>
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
        $expensesDetails=ExpenseDetail::select('expense_details.*','expenses.expense_type')->join('expenses','expenses.id','=','expense_details.expense_id')->where('expense_details.id','=',$Id)->first();
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
    public function addExpenseType(Request $request){
         $expense=new Expense();
         $expense->expense_type = $request->expense_type;
         $expense->save();
         $expenses_details=Expense::all()->toArray();
         return json_encode($expenses_details);
    }

    public function deleteExpense(Request $request){
        $id=$request->expenseId;
        $expense_delete=DB::table('expense_details')->where('id', '=', $id)->delete();
        return json_encode($expense_delete);
    }

}
<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Membership;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class MembershipController extends Controller
{
    public function membership(Request $request)
    {
        $userDetails = User::where('role', '=', 0)->get()->toArray();
        return view('admin.memberships.index', get_defined_vars());
    }

    public function membershipCreate(Request $request, $Id)
    {
        $userDetails = User::select('*')->where('id', '=', $Id)->first();
        $yearArray = array();
        for ($i = 2000; $i <= date('Y'); $i++) {
            $yearArray[] = $i;
        }

        $membershipYear = Membership::select('year')->where('user_id', '=', $Id)->get()->toArray();

        $yearArray1 = array();
        foreach ($membershipYear as $membership_year) {
            $yearArray1[] = $membership_year['year'];
        }

        $year_output = array_merge(array_diff($yearArray, $yearArray1), array_diff($yearArray1, $yearArray));
        return view('admin.memberships.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $membershipData = Membership::where('user_id', '=', $request->user_id)->where('year', '=', $request->year)->first();
        if (empty($membershipData)) {
            $memberData = array();
            $memberData['user_id'] = $request->user_id;
            $memberData['year'] = $request->year;
            $memberData['jan_fees'] = !empty($request->jan_fees) ? $request->jan_fees : '0';
            $memberData['jan_penalty'] = !empty($request->jan_penalty) ? $request->jan_penalty : '0';
            $memberData['feb_fees'] = !empty($request->feb_fees) ? $request->feb_fees : '0';
            $memberData['feb_penalty'] = !empty($request->feb_penalty) ? $request->feb_penalty : '0';
            $memberData['march_fees'] = !empty($request->march_fees) ? $request->march_fees : '0';
            $memberData['march_penalty'] = !empty($request->march_penalty) ? $request->march_penalty : '0';
            $memberData['april_fees'] = !empty($request->april_fees) ? $request->april_fees : '0';
            $memberData['april_penalty'] = !empty($request->april_penalty) ? $request->april_penalty : '0';
            $memberData['may_fees'] = !empty($request->may_fees) ? $request->may_fees : '0';
            $memberData['may_penalty'] = !empty($request->may_penalty) ? $request->may_penalty : '0';
            $memberData['june_fees'] = !empty($request->june_fees) ? $request->june_fees : '0';
            $memberData['june_penalty'] = !empty($request->june_penalty) ? $request->june_penalty : '0';
            $memberData['july_fees'] = !empty($request->july_fees) ? $request->july_fees : '0';
            $memberData['july_penalty'] = !empty($request->july_penalty) ? $request->july_penalty : '0';
            $memberData['aug_fees'] = !empty($request->aug_fees) ? $request->aug_fees : '0';
            $memberData['aug_penalty'] = !empty($request->aug_penalty) ? $request->aug_penalty : '0';
            $memberData['sep_fees'] = !empty($request->sep_fees) ? $request->sep_fees : '0';
            $memberData['sep_penalty'] = !empty($request->sep_penalty) ? $request->sep_penalty : '0';
            $memberData['oct_fees'] = !empty($request->oct_fees) ? $request->oct_fees : '0';
            $memberData['oct_penalty'] = !empty($request->oct_penalty) ? $request->oct_penalty : '0';
            $memberData['nov_fees'] = !empty($request->nov_fees) ? $request->nov_fees : '0';
            $memberData['nov_penalty'] = !empty($request->nov_penalty) ? $request->nov_penalty : '0';
            $memberData['dec_fees'] = !empty($request->dec_fees) ? $request->dec_fees : '0';
            $memberData['dec_penalty'] = !empty($request->dec_penalty) ? $request->dec_penalty : '0';
            if ($memberData['jan_fees'] == 0 && $memberData['feb_fees'] == 0 && $memberData['march_fees'] == 0 && $memberData['april_fees'] == 0 && $memberData['may_fees'] == 0
                && $memberData['june_fees'] == 0 && $memberData['july_fees'] == 0 && $memberData['aug_fees'] == 0
                && $memberData['sep_fees'] == 0 && $memberData['oct_fees'] == 0 && $memberData['nov_fees'] == 0 && $memberData['dec_fees'] == 0) {
                return back()->with('message', 'Please Enter Atleast one-month Fees');
            } else {
                $memberData = Membership::create($memberData);
                return redirect()->route(ADMIN . '.membership.membership_details',$request->user_id)->with('success', 'Created Successfully');
            }
        } else {
            return back()->with('message', 'Already Created with Same User and Year');
        }
    }

    public function membershipPostAjax(Request $request)
    {
        $membershipData = DB::table('memberships')
            ->join('users', 'users.id', '=', 'memberships.user_id')
            ->select('users.*')
            ->groupBy('memberships.user_id')
            ->get();

        return Datatables::of($membershipData)
            ->addColumn('editDeleteAction', function ($membershipData) {
                return ' <span style="margin-right: 2px;"  class="tooltips" title="View Membership Detail" data-placement="top">
                              <a href="' . route(ADMIN . '.membership.membership_details', $membershipData->id) . '" class="btn btn-primary btn-xs" style="margin-left: 10%;">
                                <i class="fa fa-eye"></i>
                              </a>
                            </span>
                           ';
            })
            ->make(true);
    }

    public function editMembership(Request $request, $Id)
    {
        $userDetails = User::where('role', '=', 0)->get()->toArray();
        $membershipData = Membership::select('memberships.*')->leftJoin("users", "users.id", "=", "memberships.user_id")->where('memberships.id', '=', $Id)->first();
        return view('admin.memberships.edit', get_defined_vars());
    }

    public function updateMembership(Request $request)
    {
        $user_id = $request->user_id;
        $memberData = array();
        $Id = $request->member_id;
        $memberData['jan_fees'] = !empty($request->jan_fees) ? $request->jan_fees : '0';
        $memberData['jan_penalty'] = !empty($request->jan_penalty) ? $request->jan_penalty : '0';
        $memberData['feb_fees'] = !empty($request->feb_fees) ? $request->feb_fees : '0';
        $memberData['feb_penalty'] = !empty($request->feb_penalty) ? $request->feb_penalty : '0';
        $memberData['march_fees'] = !empty($request->march_fees) ? $request->march_fees : '0';
        $memberData['march_penalty'] = !empty($request->march_penalty) ? $request->march_penalty : '0';
        $memberData['april_fees'] = !empty($request->april_fees) ? $request->april_fees : '0';
        $memberData['april_penalty'] = !empty($request->april_penalty) ? $request->april_penalty : '0';
        $memberData['may_fees'] = !empty($request->may_fees) ? $request->may_fees : '0';
        $memberData['may_penalty'] = !empty($request->may_penalty) ? $request->may_penalty : '0';
        $memberData['june_fees'] = !empty($request->june_fees) ? $request->june_fees : '0';
        $memberData['june_penalty'] = !empty($request->june_penalty) ? $request->june_penalty : '0';
        $memberData['july_fees'] = !empty($request->july_fees) ? $request->july_fees : '0';
        $memberData['july_penalty'] = !empty($request->july_penalty) ? $request->july_penalty : '0';
        $memberData['aug_fees'] = !empty($request->aug_fees) ? $request->aug_fees : '0';
        $memberData['aug_penalty'] = !empty($request->aug_penalty) ? $request->aug_penalty : '0';
        $memberData['sep_fees'] = !empty($request->sep_fees) ? $request->sep_fees : '0';
        $memberData['sep_penalty'] = !empty($request->sep_penalty) ? $request->sep_penalty : '0';
        $memberData['oct_fees'] = !empty($request->oct_fees) ? $request->oct_fees : '0';
        $memberData['oct_penalty'] = !empty($request->oct_penalty) ? $request->oct_penalty : '0';
        $memberData['nov_fees'] = !empty($request->nov_fees) ? $request->nov_fees : '0';
        $memberData['nov_penalty'] = !empty($request->nov_penalty) ? $request->nov_penalty : '0';
        $memberData['dec_fees'] = !empty($request->dec_fees) ? $request->dec_fees : '0';
        $memberData['dec_penalty'] = !empty($request->dec_penalty) ? $request->dec_penalty : '0';
        if ($memberData['jan_fees'] == 0 && $memberData['feb_fees'] == 0 && $memberData['march_fees'] == 0 && $memberData['april_fees'] == 0 && $memberData['may_fees'] == 0
            && $memberData['june_fees'] == 0 && $memberData['july_fees'] == 0 && $memberData['aug_fees'] == 0
            && $memberData['sep_fees'] == 0 && $memberData['oct_fees'] == 0 && $memberData['nov_fees'] == 0 && $memberData['dec_fees'] == 0) {
            return back()->with('message', 'Please Enter Atleast one-month Fees');
        } else {
            $memberUpdate = Membership::where('id', '=', $Id)
                ->update($memberData);
            return redirect()->route(ADMIN . '.membership.membership_details', $user_id)->with('success', 'Updated Successfully');
        }
    }

    public function deleteMember(Request $request)
    {
        $result = DB::table('memberships')
            ->where('id', '=', $request->input('memberId'))
            ->delete();
        if ($result)
            echo json_encode(['status' => 'success', 'msg' => 'Member has been deleted']);
        else
            echo json_encode(['status' => 'error', 'msg' => 'Sorry! Member has not been deleted']);
        die;
    }

    public function membershipDetails(Request $request, $Id)
    {
        if (\Auth::user()->role != '0') {
            $users = User::where('id', '=', $Id)->first();
        } else {
            if ($Id == \Auth::user()->id) {
                $users = User::where('id', '=', $Id)->first();
            } else {
                return redirect('/admin');
            }
        }
        return view('admin.memberships.membership_details', get_defined_vars());
    }

    public function membershipDetailsPostAjax(Request $request)
    {
        $query = Membership::select('memberships.*', 'users.name', 'users.email')->join('users', 'users.id', 'memberships.user_id')->where('memberships.user_id', '=', $request->userId);
        $membershipData = $query->orderBy('memberships.updated_at', 'desc')->get();


            return Datatables::of($membershipData)
                ->addColumn('total_fees', function ($membershipData) {
                    return $membershipData->jan_fees + $membershipData->feb_fees + $membershipData->march_fees + $membershipData->april_fees + $membershipData->may_fees + $membershipData->june_fees + $membershipData->july_fees + $membershipData->aug_fees + $membershipData->sep_fees + $membershipData->oct_fees + $membershipData->nov_fees + $membershipData->dec_fees;
                })
                ->addColumn('total_penalty', function ($membershipData) {
                    return $membershipData->jan_penalty + $membershipData->feb_penalty + $membershipData->march_penalty + $membershipData->april_penalty + $membershipData->may_penalty + $membershipData->june_penalty + $membershipData->july_penalty + $membershipData->aug_penalty + $membershipData->sep_penalty + $membershipData->oct_penalty + $membershipData->nov_penalty + $membershipData->dec_penalty;
                })
                ->addColumn('total_amount', function ($membershipData) {
                    return $membershipData->jan_penalty + $membershipData->feb_penalty + $membershipData->march_penalty + $membershipData->april_penalty + $membershipData->may_penalty + $membershipData->june_penalty + $membershipData->july_penalty + $membershipData->aug_penalty + $membershipData->sep_penalty + $membershipData->oct_penalty + $membershipData->nov_penalty + $membershipData->dec_penalty + $membershipData->jan_fees + $membershipData->feb_fees + $membershipData->march_fees + $membershipData->april_fees + $membershipData->may_fees + $membershipData->june_fees + $membershipData->july_fees + $membershipData->aug_fees + $membershipData->sep_fees + $membershipData->oct_fees + $membershipData->nov_fees + $membershipData->dec_fees;
                })
                ->addColumn('editDeleteAction', function ($membershipData) {

                    if (\Auth::user()->role != 0) {
                        return '<span style="margin-right: 2px;"  class="tooltips" title="View Membership Detail" data-placement="top">
                              <a href="' . route(ADMIN . '.membership.view', $membershipData->id) . '" class="btn btn-primary btn-xs" style="margin-left: 10%;">
                                <i class="fa fa-eye"></i>
                              </a>
                            </span>
                            <span style="margin-right: 2px;"  class="tooltips" title="Edit Membership Detail" data-placement="top">
                              <a href="' . route(ADMIN . '.membership.edit', $membershipData->id) . '" class="btn btn-primary btn-xs" style="margin-left: 10%;">
                                <i class="fa fa-pencil-square-o"></i>
                              </a>
                        </span>';
                    }
                    else{
                        return '<span style="margin-right: 2px;"  class="tooltips" title="View Membership Detail" data-placement="top">
                              <a href="' . route(ADMIN . '.membership.view', $membershipData->id) . '" class="btn btn-primary btn-xs" style="margin-left: 10%;">
                                <i class="fa fa-eye"></i>
                              </a>
                            </span>';
                    }
                })
                ->make(true);
    }

    public function viewMembership(Request $request, $Id)
    {
        if (\Auth::user()->role != '0') {
            $userDetails = User::where('role', '=', 0)->get()->toArray();
            $membershipData = Membership::select('memberships.*')->leftJoin("users", "users.id", "=", "memberships.user_id")->where('memberships.id', '=', $Id)->first();
        } else {

            $userDetails = User::where('role', '=', 0)->get()->toArray();
            $membershipData = Membership::select('memberships.*')->leftJoin("users", "users.id", "=", "memberships.user_id")->where('memberships.id', '=', $Id)->where('memberships.user_id', '=', \Auth::user()->id)->first();
            if (empty($membershipData->id)) {
                return redirect('/admin');
            }
        }
        return view('admin.memberships.view', get_defined_vars());
    }
}

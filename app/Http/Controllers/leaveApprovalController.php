<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Leave;
use DB;

class leaveApprovalController extends Controller
{
    public function storeLeave(Request $request){
        //dd($request->all());
        $leave=new Leave;

        $this->validate($request,[
            'empID'=>'required|max:7|min:2',
            'reason'=>'required|max:30|min:5',
        ]);

        $leave->emp_id=$request->empID;
        $leave->emp_name=$request->empName;
        $leave->leaveType=$request->reason;
        $leave->fromDate=$request->from;
        $leave->toDate=$request->to;
        //$leave->approval=$request->appby;
        //$leave->approveDate=$request->appdate;
        //$leave->approvedBy=$request->appby;
        $leave->isApproved=0;

        $leave->save();
        //return view('/approval');
        $data=Leave::all();
        return redirect('/leave')->with('leaveForm',$data);
        //dd($data);
       // return view('leaveForm')->with('leaveForm',$data);
        return view('leaveApproval')->with('leaveApproval',$data);
    }

    public function updateLeaveasApproved($leave_id){
        //retrive all the data in Leave model class to leave variable.
        $leave=Leave::find($leave_id);
        $leave->isApproved=1;
        $leave->save();
        return redirect()->back();

    }

    public function updateLeaveasRejected($leave_id){
        $leave=Leave::find($leave_id);
        $leave->isApproved=0;
        $leave->save();
        return redirect()->back();
    }

    public function deleteLeave($leave_id){
        $leave=Leave::find($leave_id);
        $leave->delete();
        return redirect()->back();
    }

    //
}

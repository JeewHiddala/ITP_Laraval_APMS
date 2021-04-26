<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShortLeave;

class ShortLeaveApprovalController extends Controller
{

    public function storeShortLeave(Request $request){
        //dd($request->all());
        $Sleave=new ShortLeave;

        $this->validate($request,[
            'empIDs'=>'required|max:7|min:2',
            'reasons'=>'required|max:30|min:5',
        ]);
    

        $Sleave->emp_id=$request->empIDs;
        $Sleave->emp_name=$request->empNames;
        $Sleave->shortleaveType=$request->reasons;
        $Sleave->Date=$request->dates;
        $Sleave->fromtime=$request->froms;
        $Sleave->totime=$request->tos;
        $Sleave->isApproved=0;

        $Sleave->save();
        //return view('/approval');
        $data=ShortLeave::all();
        return redirect('/sleave')->with('shortLeaveForm',$data);
        //dd($data);
      //  return view('shortLeaveForm')->with('shortLeaveForm',$data);
        return view('shortLeaveApproval')->with('shortLeaveApproval',$data);
    }

    public function updateShortLeaveasApproved($leave_id){
        //retrive all the data in Leave model class to leave variable.
        $Sleave=ShortLeave::find($leave_id);
        $Sleave->isApproved=1;
        $Sleave->save();
        return redirect()->back();

    }

    public function updateShortLeaveasRejected($leave_id){
        $Sleave=ShortLeave::find($leave_id);
        $Sleave->isApproved=0;
        $Sleave->save();
        return redirect()->back();
    }

    public function deleteShortLeave($leave_id){
        $Sleave=ShortLeave::find($leave_id);
        $Sleave->delete();
        return redirect()->back();
    }

    
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Machinery;
use App\EmpDetails;
use App\MachineryUsageLog;
use DB;

class MachineryUsageLogController extends Controller
{
    public function getDetails()
    {
        //$invoices = DB::table('invoices')->pluck("invoice_name","id");
        $emp = EmpDetails::all();
        $machinery = Machinery::all();

        $data = DB::table('machinery_usage_logs')
        ->join('machineries','machineries.id','reg_id')
        ->join('emp_details','emp_details.employee_id','machinery_usage_logs.employee_id')
        ->select('machinery_usage_logs.log_no','machinery_usage_logs.reg_id','machinery_usage_logs.employee_id','machinery_usage_logs.section','machinery_usage_logs.start_date','machinery_usage_logs.start_time','machinery_usage_logs.estimated_end_date','machinery_usage_logs.estimated_end_time','emp_details.name','machineries.model_no')
        ->get();

        return view('/machineryusagelog',compact('machinery','emp','data'));


    }

    public function storemachineryusagelog(Request $request){
      
        //dd($request->all()) ;
      
        $machineryusagelog=new MachineryUsageLog;


      
        $machineryusagelog->log_no=$request->usegelogno;
        $machineryusagelog->reg_id=$request->machinery_regno;
        $machineryusagelog->employee_id=$request->employee_regno;
        $machineryusagelog->section=$request->section;
        $machineryusagelog->start_date=$request->start_date;
        $machineryusagelog->start_time=$request->start_time;
        $machineryusagelog->estimated_end_date=$request->estimated_end_date;
        $machineryusagelog->estimated_end_time=$request->estimated_end_time;

       // dd($machineryusagelog);

        $machineryusagelog->save();
        //return redirect()->back();


        //dd($data);

        $emp = EmpDetails::all();
        $machinery = Machinery::all();
 
        $data = DB::table('machinery_usage_logs')
        ->join('machineries','machineries.id','reg_id')
        ->join('emp_details','emp_details.employee_id','machinery_usage_logs.employee_id')
        ->select('machinery_usage_logs.log_no','machinery_usage_logs.reg_id','machinery_usage_logs.employee_id','machinery_usage_logs.section','machinery_usage_logs.start_date','machinery_usage_logs.start_time','machinery_usage_logs.estimated_end_date','machinery_usage_logs.estimated_end_time','emp_details.name','machineries.model_no')
        ->get();

        return view('/machineryusagelog',compact('machinery','emp','data'));

      // return view('machinerymaintenance')->with('machinerymaintenance',$data);

    }

    public function editmachineryusagelogview($log_no){

        $emp = EmpDetails::all();
        $machinery = Machinery::all();

        $data = DB::table('machinery_usage_logs')
        ->join('machineries','machineries.id','reg_id')
        ->join('emp_details','emp_details.employee_id','machinery_usage_logs.employee_id')
        ->select('machinery_usage_logs.log_no','machinery_usage_logs.reg_id','machinery_usage_logs.employee_id','machinery_usage_logs.section','machinery_usage_logs.start_date','machinery_usage_logs.start_time','machinery_usage_logs.estimated_end_date','machinery_usage_logs.estimated_end_time','emp_details.name','machineries.model_no')->where('machinery_usage_logs.log_no',$log_no)
        ->first();

        //dd($data);


        return view('/editmachineryusagelog',compact('machinery','emp','data'));

        //return view('editmachineryregistration')->with('machinerydata',$machinery);
    }

    public function updatemachineryusagelog(Request $request){

                // dd($request->all());
        

                $log_no =$request->usegelogno;
                $reg_id=$request->machinery_regno;
                $employee_id=$request->employee_regno;
                $section=$request->section;
                $start_date=$request->start_date;
                $start_time=$request->start_time;
                $estimated_end_date=$request->estimated_end_date;
                $estimated_end_time=$request->estimated_end_time;
        
                $data1=MachineryUsageLog::find($log_no);

                $data1->reg_id=$reg_id;
                $data1->employee_id=$employee_id;
                $data1->section=$section;
                $data1->start_date=$start_date;
                $data1->start_time=$start_time;
                $data1->estimated_end_date=$estimated_end_date;
                $data1->estimated_end_time=$estimated_end_time;
        
                $data1->save();

                $emp = EmpDetails::all();
                $machinery = Machinery::all();
         
                $data = DB::table('machinery_usage_logs')
                ->join('machineries','machineries.id','reg_id')
                ->join('emp_details','emp_details.employee_id','machinery_usage_logs.employee_id')
                ->select('machinery_usage_logs.log_no','machinery_usage_logs.reg_id','machinery_usage_logs.employee_id','machinery_usage_logs.section','machinery_usage_logs.start_date','machinery_usage_logs.start_time','machinery_usage_logs.estimated_end_date','machinery_usage_logs.estimated_end_time','emp_details.name','machineries.model_no')
                ->get();
        
                return view('/machineryusagelog',compact('machinery','emp','data'));

    }

    //search
    public function searchMachineryUsageLog(Request $request){

        $search = $request->get('searchBar');

        $emp = EmpDetails::all();
        $machinery = Machinery::all();

        $posts = DB::table('machinery_usage_logs')
        ->join('machineries','machineries.id','reg_id')
        ->join('emp_details','emp_details.employee_id','machinery_usage_logs.employee_id')
        ->select('machinery_usage_logs.log_no','machinery_usage_logs.reg_id','machinery_usage_logs.employee_id','machinery_usage_logs.section','machinery_usage_logs.start_date','machinery_usage_logs.start_time','machinery_usage_logs.estimated_end_date','machinery_usage_logs.estimated_end_time','emp_details.name','machineries.model_no')
        ->where('machineries.model_no','like','%'.$search.'%')->paginate(10);

        // $posts = MachineryUsageLog::where('model_no','like','%'.$search.'%')->paginate(10);
        return view('machineryusagelogsearch' , ['posts'=> $posts]);
    
    }

}

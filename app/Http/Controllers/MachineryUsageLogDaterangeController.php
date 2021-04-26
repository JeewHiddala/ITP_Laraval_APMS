<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Machinery;
use App\EmpDetails;
use App\MachineryUsageLog;
use DB;

class MachineryUsageLogDaterangeController extends Controller
{
    function index(Request $request)
    {
     if(request()->ajax())
     {
      if(!empty($request->from_date))
      {
       $data = DB::table('machinery_usage_logs')
       ->join('machineries','machineries.id','reg_id')
       ->join('emp_details','emp_details.employee_id','machinery_usage_logs.employee_id')
       ->select(['machinery_usage_logs.log_no','machinery_usage_logs.reg_id','machinery_usage_logs.employee_id','machinery_usage_logs.section','machinery_usage_logs.start_date','machinery_usage_logs.start_time','machinery_usage_logs.estimated_end_date','machinery_usage_logs.estimated_end_time','emp_details.name','machineries.model_no'])
       ->whereBetween('machinery_usage_logs.start_date', array($request->from_date, $request->to_date))
        ->get();
      }
      else
      {
       $data = DB::table('machinery_usage_logs')
       ->join('machineries','machineries.id','reg_id')
       ->join('emp_details','emp_details.employee_id','machinery_usage_logs.employee_id')
       ->select(['machinery_usage_logs.log_no','machinery_usage_logs.reg_id','machinery_usage_logs.employee_id','machinery_usage_logs.section','machinery_usage_logs.start_date','machinery_usage_logs.start_time','machinery_usage_logs.estimated_end_date','machinery_usage_logs.estimated_end_time','emp_details.name','machineries.model_no'])
         ->get();
      }
      return datatables()->of($data)->make(true);
     }
     return view('machineryusagelogPDF');
    }
}

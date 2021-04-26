<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Machinery;
use App\EmpDetails;
use App\MachineryMaintenance;
use DB;

class MachineryMaintenanceDaterangeController extends Controller
{
    function index(Request $request)
    {
     if(request()->ajax())
     {
      if(!empty($request->from_date))
      {
       $data = DB::table('machinery_maintenances')
       ->join('machineries','machineries.id','reg_id')
       ->join('emp_details','emp_details.employee_id','machinery_maintenances.employee_id')
       ->select(['machinery_maintenances.maintenance_id','machinery_maintenances.reg_id','machinery_maintenances.maintenance_type','machinery_maintenances.cost','machinery_maintenances.maintenance_date','machinery_maintenances.employee_id','machinery_maintenances.company_name','machinery_maintenances.contact_no','emp_details.name','machineries.model_no'])
       ->whereBetween('machinery_maintenances.maintenance_date', array($request->from_date, $request->to_date))
        ->get();
      }
      else
      {
       $data = DB::table('machinery_maintenances')
       ->join('machineries','machineries.id','reg_id')
       ->join('emp_details','emp_details.employee_id','machinery_maintenances.employee_id')
       ->select(['machinery_maintenances.maintenance_id','machinery_maintenances.reg_id','machinery_maintenances.maintenance_type','machinery_maintenances.cost','machinery_maintenances.maintenance_date','machinery_maintenances.employee_id','machinery_maintenances.company_name','machinery_maintenances.contact_no','emp_details.name','machineries.model_no'])
         ->get();
      }
      return datatables()->of($data)->make(true);
     }
     return view('machinerymaintainancePDF');
    }
}

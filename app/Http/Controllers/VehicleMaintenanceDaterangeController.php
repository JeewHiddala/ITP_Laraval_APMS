<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vehicle;
use App\EmpDetails;
use App\VehicleMaintenance;
use DB;

class VehicleMaintenanceDaterangeController extends Controller
{
    function index(Request $request)
    {
     if(request()->ajax())
     {
      if(!empty($request->from_date))
      {
       $data = DB::table('vehicle_maintenances')
       ->join('vehicles','vehicles.id','reg_id')
       ->join('emp_details','emp_details.employee_id','vehicle_maintenances.employee_id')
       ->select(['vehicle_maintenances.maintenance_id','vehicle_maintenances.reg_id','vehicle_maintenances.maintenance_type','vehicle_maintenances.cost','vehicle_maintenances.maintenance_date','vehicle_maintenances.employee_id','vehicle_maintenances.company_name','vehicle_maintenances.contact_no','emp_details.name','vehicles.vehi_reg_no'])
       ->whereBetween('vehicle_maintenances.maintenance_date', array($request->from_date, $request->to_date))
        ->get();
      }
      else
      {
       $data = DB::table('vehicle_maintenances')
       ->join('vehicles','vehicles.id','reg_id')
       ->join('emp_details','emp_details.employee_id','vehicle_maintenances.employee_id')
       ->select(['vehicle_maintenances.maintenance_id','vehicle_maintenances.reg_id','vehicle_maintenances.maintenance_type','vehicle_maintenances.cost','vehicle_maintenances.maintenance_date','vehicle_maintenances.employee_id','vehicle_maintenances.company_name','vehicle_maintenances.contact_no','emp_details.name','vehicles.vehi_reg_no'])
         ->get();
      }
      return datatables()->of($data)->make(true);
     }
     return view('vehiclemaintainancePDF');
    }
}

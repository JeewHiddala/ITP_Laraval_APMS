<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ResourceReportController extends Controller
{
    //Machinery Maintenance
    public function getMachinerydatabydatepicker(Request $request){

        if(!empty($request->from_date))
        {

            $from_date = $request->from_date;
            $to_date = $request->to_date;

            $data = DB::table('machinery_maintenances')
            ->join('machineries','machineries.id','reg_id')
            ->join('emp_details','emp_details.employee_id','machinery_maintenances.employee_id')
            ->select(['machinery_maintenances.maintenance_id','machinery_maintenances.reg_id','machinery_maintenances.maintenance_type','machinery_maintenances.cost','machinery_maintenances.maintenance_date','machinery_maintenances.employee_id','machinery_maintenances.company_name','machinery_maintenances.contact_no','emp_details.name','machineries.model_no'])
            ->whereBetween('machinery_maintenances.maintenance_date', array($request->from_date, $request->to_date))
            ->paginate(5);

            $total = DB::table('machinery_maintenances')
            // ->join('machineries','machineries.id','reg_id')
            ->select([DB::raw('Sum(machinery_maintenances.cost) OVER () AS total_cost')])
            ->whereBetween('machinery_maintenances.maintenance_date', array($request->from_date, $request->to_date))
            ->value('total_cost');

            //dd($total);

            return view('/machinerymaintainancePDF',compact('data','total','from_date','to_date'));

        }
        else
        {

            $from_date = 0;
            $to_date = 0;
        
            $data = DB::table('machinery_maintenances')
            ->join('machineries','machineries.id','reg_id')
            ->join('emp_details','emp_details.employee_id','machinery_maintenances.employee_id')
            ->select(['machinery_maintenances.maintenance_id','machinery_maintenances.reg_id','machinery_maintenances.maintenance_type','machinery_maintenances.cost','machinery_maintenances.maintenance_date','machinery_maintenances.employee_id','machinery_maintenances.company_name','machinery_maintenances.contact_no','emp_details.name','machineries.model_no'])
            ->paginate(10);

            $total = DB::table('machinery_maintenances')
            // ->join('machineries','machineries.id','reg_id')
            ->select([DB::raw('Sum(machinery_maintenances.cost) OVER () AS total_cost')])
            ->value('total_cost');

            //dd($total);

            return view('/machinerymaintainancePDF',compact('data','total','from_date','to_date'));

        }
    }

    //Vehicle Maintenance
    public function getVehicledatabydatepicker(Request $request){

        if(!empty($request->from_date))
        {

            $from_date = $request->from_date;
            $to_date = $request->to_date;

            $data = DB::table('vehicle_maintenances')
            ->join('vehicles','vehicles.id','reg_id')
            ->join('emp_details','emp_details.employee_id','vehicle_maintenances.employee_id')
            ->select(['vehicle_maintenances.maintenance_id','vehicle_maintenances.reg_id','vehicle_maintenances.maintenance_type','vehicle_maintenances.cost','vehicle_maintenances.maintenance_date','vehicle_maintenances.employee_id','vehicle_maintenances.company_name','vehicle_maintenances.contact_no','emp_details.name','vehicles.vehi_reg_no'])
            ->whereBetween('vehicle_maintenances.maintenance_date', array($request->from_date, $request->to_date))
            ->paginate(10);

            $total = DB::table('vehicle_maintenances')
            // ->join('machineries','machineries.id','reg_id')
            ->select([DB::raw('Sum(vehicle_maintenances.cost) OVER () AS total_cost')])
            ->whereBetween('vehicle_maintenances.maintenance_date', array($request->from_date, $request->to_date))
            ->value('total_cost');

            //dd($total);

            return view('/vehiclemaintainancePDF',compact('data','total','from_date','to_date'));

        }
        else
        {

            $from_date = 0;
            $to_date = 0;
        
            $data = DB::table('vehicle_maintenances')
            ->join('vehicles','vehicles.id','reg_id')
            ->join('emp_details','emp_details.employee_id','vehicle_maintenances.employee_id')
            ->select(['vehicle_maintenances.maintenance_id','vehicle_maintenances.reg_id','vehicle_maintenances.maintenance_type','vehicle_maintenances.cost','vehicle_maintenances.maintenance_date','vehicle_maintenances.employee_id','vehicle_maintenances.company_name','vehicle_maintenances.contact_no','emp_details.name','vehicles.vehi_reg_no'])
            ->paginate(10);

            $total = DB::table('vehicle_maintenances')
            // ->join('machineries','machineries.id','reg_id')
            ->select([DB::raw('Sum(vehicle_maintenances.cost) OVER () AS total_cost')])
            ->value('total_cost');

            //dd($total);

            return view('/vehiclemaintainancePDF',compact('data','total','from_date','to_date'));

        }
    }

    //Machinery Usage Log
    public function getMachineryusagedatabydatepicker(Request $request){

        if(!empty($request->from_date))
        {

            $from_date = $request->from_date;
            $to_date = $request->to_date;

            $data = DB::table('machinery_usage_logs')
            ->join('machineries','machineries.id','reg_id')
            ->join('emp_details','emp_details.employee_id','machinery_usage_logs.employee_id')
            ->select(['machinery_usage_logs.log_no','machinery_usage_logs.reg_id','machinery_usage_logs.employee_id','machinery_usage_logs.section','machinery_usage_logs.start_date','machinery_usage_logs.start_time','machinery_usage_logs.estimated_end_date','machinery_usage_logs.estimated_end_time','emp_details.name','machineries.model_no'])
            ->whereBetween('machinery_usage_logs.start_date', array($request->from_date, $request->to_date))
            ->paginate(10);

            // $total = DB::table('machinery_usage_logs')
            // // ->join('machineries','machineries.id','reg_id')
            // ->select([DB::raw('Sum(vehicle_maintenances.cost) OVER () AS total_cost')])
            // ->whereBetween('machinery_usage_logs.start_date', array($request->from_date, $request->to_date))
            // ->value('total_cost');

            //dd($total);

            return view('/machineryusagelogPDF',compact('data','from_date','to_date'));

        }
        else
        {

            $from_date = 0;
            $to_date = 0;
        
            $data = DB::table('machinery_usage_logs')
            ->join('machineries','machineries.id','reg_id')
            ->join('emp_details','emp_details.employee_id','machinery_usage_logs.employee_id')
            ->select(['machinery_usage_logs.log_no','machinery_usage_logs.reg_id','machinery_usage_logs.employee_id','machinery_usage_logs.section','machinery_usage_logs.start_date','machinery_usage_logs.start_time','machinery_usage_logs.estimated_end_date','machinery_usage_logs.estimated_end_time','emp_details.name','machineries.model_no'])
            ->paginate(10);

            // $total = DB::table('machinery_usage_logs')
            // // ->join('machineries','machineries.id','reg_id')
            // ->select([DB::raw('Sum(vehicle_maintenances.cost) OVER () AS total_cost')])
            // ->value('total_cost');

            //dd($total);

            return view('/machineryusagelogPDF',compact('data','from_date','to_date'));

        }
    }

}

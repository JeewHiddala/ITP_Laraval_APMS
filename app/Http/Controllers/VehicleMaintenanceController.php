<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vehicle;
use App\EmpDetails;
use App\VehicleMaintenance;
use DB;

class VehicleMaintenanceController extends Controller
{
    public function getDetails()
    {
        //$invoices = DB::table('invoices')->pluck("invoice_name","id");
        $emp = EmpDetails::all();
        $vehicle = Vehicle::all();

        $data = DB::table('vehicle_maintenances')
        ->join('vehicles','vehicles.id','reg_id')
        ->join('emp_details','emp_details.employee_id','vehicle_maintenances.employee_id')
        ->select('vehicle_maintenances.maintenance_id','vehicle_maintenances.reg_id','vehicle_maintenances.maintenance_type','vehicle_maintenances.cost','vehicle_maintenances.maintenance_date','vehicle_maintenances.employee_id','vehicle_maintenances.company_name','vehicle_maintenances.contact_no','emp_details.name','vehicles.vehi_reg_no')
        ->get();

        return view('/vehiclemaintenance',compact('vehicle','emp','data'));
    }

    public function storevehiclemaintenance(Request $request){
      
        //dd($request->all()) ;
      
        $vehiclemaintenance=new VehicleMaintenance;

        //Validation
        $this->validate($request,[
            'conpanyname'=>'required|max:100|min:2',
            'contactno'=>'required|max:12|min:10',
            'cost'=>'required|max:1000000000|min:1',
        ]);
      
        $vehiclemaintenance->maintenance_id=$request->maintenanceno;
        $vehiclemaintenance->reg_id=$request->vehicle_regno;
        $vehiclemaintenance->maintenance_type=$request->maintenancetype;
        $vehiclemaintenance->employee_id=$request->employee_regno;
        $vehiclemaintenance->maintenance_date=$request->date;
        $vehiclemaintenance->company_name=$request->conpanyname;
        $vehiclemaintenance->contact_no=$request->contactno;
        $vehiclemaintenance->cost=$request->cost;
        
        $vehiclemaintenance->save();

            //dd($data);

        $emp = EmpDetails::all();
        $vehicle = Vehicle::all();

        $data = DB::table('vehicle_maintenances')
        ->join('vehicles','vehicles.id','reg_id')
        ->join('emp_details','emp_details.employee_id','vehicle_maintenances.employee_id')
        ->select('vehicle_maintenances.maintenance_id','vehicle_maintenances.reg_id','vehicle_maintenances.maintenance_type','vehicle_maintenances.cost','vehicle_maintenances.maintenance_date','vehicle_maintenances.employee_id','vehicle_maintenances.company_name','vehicle_maintenances.contact_no','emp_details.name','vehicles.vehi_reg_no')
        ->get();

        //dd($data);
        return view('/vehiclemaintenance',compact('vehicle','emp','data'));



    }

    public function deletevehiclemaintenance($maintenance_id){
        //dd($maintenance_id); 
        
        $data=VehicleMaintenance::find($maintenance_id);

        // dd($vehiclemaintenance);
        $data->delete();

        // return redirect()->back();

            $emp = EmpDetails::all();
            $vehicle = Vehicle::all();

            
         
            $data = DB::table('vehicle_maintenances')
            ->join('vehicles','vehicles.id','reg_id')
            ->join('emp_details','emp_details.employee_id','vehicle_maintenances.employee_id')
            ->select('vehicle_maintenances.maintenance_id','vehicle_maintenances.reg_id','vehicle_maintenances.maintenance_type','vehicle_maintenances.cost','vehicle_maintenances.maintenance_date','vehicle_maintenances.employee_id','vehicle_maintenances.company_name','vehicle_maintenances.contact_no','emp_details.name','vehicles.vehi_reg_no')
            ->get();

            //dd($data);
           return view('/vehiclemaintenance',compact('vehicle','emp','data'));

    }

    public function editvehiclemaintenanceview($maintenance_id){
        $emp = EmpDetails::all();
        $vehicle = Vehicle::all();

        $data = DB::table('vehicle_maintenances')
        ->join('vehicles','vehicles.id','reg_id')
        ->join('emp_details','emp_details.employee_id','vehicle_maintenances.employee_id')
        ->select('vehicle_maintenances.maintenance_id','vehicle_maintenances.reg_id','vehicle_maintenances.maintenance_type','vehicle_maintenances.cost','vehicle_maintenances.maintenance_date','vehicle_maintenances.employee_id','vehicle_maintenances.company_name','vehicle_maintenances.contact_no','emp_details.name','vehicles.vehi_reg_no')->where('vehicle_maintenances.maintenance_id',$maintenance_id)
        ->first();

        //dd($data);
        return view('/editvehiclemaintenance',compact('vehicle','emp','data'));

    }

    public function updatevehiclemaintenance(Request $request){
        
        //dd($request->all());

        $maintenance_id =$request->maintainregno;
        $reg_id=$request->vehicle_regno;
        $maintenance_type=$request->maintenancetype;
        $cost=$request->cost;
        $maintenance_date=$request->date;
        $employee_id=$request->employee_regno;
        $company_name=$request->conpanyname;
        $contact_no=$request->contactno;

        $data1=VehicleMaintenance::find($maintenance_id);

        //dd($maintenance_id,$reg_id,$maintenance_type,$cost,$maintenance_date,$employee_id,$company_name,$contact_no);

        $data1->reg_id=$reg_id;
        $data1->maintenance_type=$maintenance_type;
        $data1->cost=$cost;
        $data1->maintenance_date=$maintenance_date;
        $data1->employee_id=$employee_id;
        $data1->company_name=$company_name;
        $data1->contact_no=$contact_no;

        $data1->save();

        //dd($data1);

        $emp = EmpDetails::all();
        $vehicle = Vehicle::all();

        $data = DB::table('vehicle_maintenances')
        ->join('vehicles','vehicles.id','reg_id')
        ->join('emp_details','emp_details.employee_id','vehicle_maintenances.employee_id')
        ->select('vehicle_maintenances.maintenance_id','vehicle_maintenances.reg_id','vehicle_maintenances.maintenance_type','vehicle_maintenances.cost','vehicle_maintenances.maintenance_date','vehicle_maintenances.employee_id','vehicle_maintenances.company_name','vehicle_maintenances.contact_no','emp_details.name','vehicles.vehi_reg_no')
        ->get();

        //dd($data);
        return view('/vehiclemaintenance',compact('vehicle','emp','data'));

    }

    //search
    public function searchVehicleMaintenance(Request $request){

        $search = $request->get('searchBar');

        $emp = EmpDetails::all();
        $vehicle = Vehicle::all();

        $posts = DB::table('vehicle_maintenances')
        ->join('vehicles','vehicles.id','reg_id')
        ->join('emp_details','emp_details.employee_id','vehicle_maintenances.employee_id')
        ->select('vehicle_maintenances.maintenance_id','vehicle_maintenances.reg_id','vehicle_maintenances.maintenance_type','vehicle_maintenances.cost','vehicle_maintenances.maintenance_date','vehicle_maintenances.employee_id','vehicle_maintenances.company_name','vehicle_maintenances.contact_no','emp_details.name','vehicles.vehi_reg_no')
        ->where('vehicles.vehi_reg_no','like','%'.$search.'%')->paginate(10);

        // $posts = VehicleMaintenance::where('vehicles.vehi_reg_no','like','%'.$search.'%')->paginate(10);
        return view('vehiclemaintenancesearch' , ['posts'=> $posts]);
    
    }

    //Total cost Calculation
    public function calculateTotalVehimainCost(){
        
        $total = VehicleMaintenance::sum('cost'); 

    }
    

}

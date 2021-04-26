<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Machinery;
use App\EmpDetails;
use App\MachineryMaintenance;
use DB;

class MachineryMaintenanceController extends Controller
{  
    public function getDetails()
    {
        //$invoices = DB::table('invoices')->pluck("invoice_name","id");
        $emp = EmpDetails::all();
        $machinery = Machinery::all();

        $data = DB::table('machinery_maintenances')
        ->join('machineries','machineries.id','reg_id')
        ->join('emp_details','emp_details.employee_id','machinery_maintenances.employee_id')
        ->select('machinery_maintenances.maintenance_id','machinery_maintenances.reg_id','machinery_maintenances.maintenance_type','machinery_maintenances.cost','machinery_maintenances.maintenance_date','machinery_maintenances.employee_id','machinery_maintenances.company_name','machinery_maintenances.contact_no','emp_details.name','machineries.model_no')
        ->get();

        return view('/machinerymaintenance',compact('machinery','emp','data'));


    }

    public function storemachinerymaintenance(Request $request){
      
        //dd($request->all()) ;
      
        $machinerymaintenance=new MachineryMaintenance;

        //Validation
        $this->validate($request,[
            'conpanyname'=>'required|max:100|min:2',
            'contactno'=>'required|max:12|min:10',
            'cost'=>'required|max:1000000000|min:1',
        ]);
      
        $machinerymaintenance->maintenance_id=$request->maintenanceno;
        $machinerymaintenance->reg_id=$request->machinery_regno;
        $machinerymaintenance->maintenance_type=$request->maintenancetype;
        $machinerymaintenance->cost=$request->cost;
        $machinerymaintenance->maintenance_date=$request->date;
        $machinerymaintenance->employee_id=$request->employee_regno;
        $machinerymaintenance->company_name=$request->conpanyname;
        $machinerymaintenance->contact_no=$request->contactno;

       // dd($machinerymaintenance);

        $machinerymaintenance->save();
        //return redirect()->back();


        //dd($data);

        $emp = EmpDetails::all();
        $machinery = Machinery::all();
 
        $data = DB::table('machinery_maintenances')
        ->join('machineries','machineries.id','reg_id')
        ->join('emp_details','emp_details.employee_id','machinery_maintenances.employee_id')
        ->select('machinery_maintenances.maintenance_id','machinery_maintenances.reg_id','machinery_maintenances.maintenance_type','machinery_maintenances.cost','machinery_maintenances.maintenance_date','machinery_maintenances.employee_id','machinery_maintenances.company_name','machinery_maintenances.contact_no','emp_details.name','machineries.model_no')
        ->get();
 
        return view('/machinerymaintenance',compact('machinery','emp','data'));

      // return view('machinerymaintenance')->with('machinerymaintenance',$data);

    }

    public function deletemachinerymaintenance($maintenance_id){

        //dd($maintenance_id);

        $machinerymaintenance=MachineryMaintenance::find($maintenance_id);

        //dd($machinerymaintenance);
        $machinerymaintenance->delete();

        $emp = EmpDetails::all();
        $machinery = Machinery::all();

        $data = DB::table('machinery_maintenances')
        ->join('machineries','machineries.id','reg_id')
        ->join('emp_details','emp_details.employee_id','machinery_maintenances.employee_id')
        ->select('machinery_maintenances.maintenance_id','machinery_maintenances.reg_id','machinery_maintenances.maintenance_type','machinery_maintenances.cost','machinery_maintenances.maintenance_date','machinery_maintenances.employee_id','machinery_maintenances.company_name','machinery_maintenances.contact_no','emp_details.name','machineries.model_no')
        ->get();

        return view('/machinerymaintenance',compact('machinery','emp','data'));


        
    }

    public function editmachinerymaintenaceview($maintenance_id){


        
        $emp = EmpDetails::all();
        $machinery = Machinery::all();

        $data = DB::table('machinery_maintenances')
        ->join('machineries','machineries.id','reg_id')
        ->join('emp_details','emp_details.employee_id','machinery_maintenances.employee_id')
        ->select('machinery_maintenances.maintenance_id','machinery_maintenances.reg_id','machinery_maintenances.maintenance_type','machinery_maintenances.cost','machinery_maintenances.maintenance_date','machinery_maintenances.employee_id','machinery_maintenances.company_name','machinery_maintenances.contact_no','emp_details.name','machineries.model_no')->where('machinery_maintenances.maintenance_id',$maintenance_id)
        ->first();

        //dd($data);


        return view('/editmachinerymaintenance',compact('machinery','emp','data'));

        //return view('editmachineryregistration')->with('machinerydata',$machinery);
}

    public function updatemachinerymaintenance(Request $request){

        //dd($request->all());
        

        $maintenance_id=$request->maintainregno;
        $reg_id=$request->machinery_regno;
        $maintenance_type=$request->maintenancetype;
        $cost=$request->cost;
        $maintenance_date=$request->date;
        $employee_id=$request->employee_regno;
        $company_name=$request->conpanyname;
        $contact_no=$request->contactno;

        $data1=MachineryMaintenance::find($maintenance_id);

        //dd($data1);

        $data1->reg_id=$reg_id;
        $data1->maintenance_type=$maintenance_type;
        $data1->cost=$cost;
        $data1->maintenance_date=$maintenance_date;
        $data1->employee_id=$employee_id;
        $data1->company_name=$company_name;
        $data1->contact_no=$contact_no;

        $data1->save();

        $emp = EmpDetails::all();
        $machinery = Machinery::all();

        $data = DB::table('machinery_maintenances')
        ->join('machineries','machineries.id','reg_id')
        ->join('emp_details','emp_details.employee_id','machinery_maintenances.employee_id')
        ->select('machinery_maintenances.maintenance_id','machinery_maintenances.reg_id','machinery_maintenances.maintenance_type','machinery_maintenances.cost','machinery_maintenances.maintenance_date','machinery_maintenances.employee_id','machinery_maintenances.company_name','machinery_maintenances.contact_no','emp_details.name','machineries.model_no')
        ->get();

        return view('/machinerymaintenance',compact('machinery','emp','data'));

        //return view('machineryregistration')->with('machineryregistration',$data);
    }

        //search
        public function searchMachineryMaintenance(Request $request){

            $search = $request->get('searchBar');

            $emp = EmpDetails::all();
            $machinery = Machinery::all();
    
            $posts = DB::table('machinery_maintenances')
            ->join('machineries','machineries.id','reg_id')
            ->join('emp_details','emp_details.employee_id','machinery_maintenances.employee_id')
            ->select('machinery_maintenances.maintenance_id','machinery_maintenances.reg_id','machinery_maintenances.maintenance_type','machinery_maintenances.cost','machinery_maintenances.maintenance_date','machinery_maintenances.employee_id','machinery_maintenances.company_name','machinery_maintenances.contact_no','emp_details.name','machineries.model_no')
            ->where('machineries.model_no','like','%'.$search.'%')->paginate(10);

            // $posts = MachineryMaintenance::where('model_no','like','%'.$search.'%')->paginate(10);
            return view('machinerymaintenancesearch' , ['posts'=> $posts]);
      
        }

            //Total cost Calculation
            public function calculateTotalVehimainCost(){
                
                $total = DB::table('machinery_maintenances')
                        ->select(DB::raw('sum(cost) as m_cost'))
                        ->get();
                                
                // $total = VehicleMaintenance::sum('cost'); 
                return view('/machinerymaintenance', ['m_cost' => $total]);

            }

}



<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use\App\Vehicle;

class VehicleController extends Controller
{
    public function storevehicle(Request $request){
      
        //dd($request->all()) ;
      
        $vehicle=new Vehicle;

        //Validation
        $this->validate($request,[
            'model'=>'required|max:100|min:1',
            'vehiregno'=>'required|max:100|min:4',
            'insuno'=>'required|max:100|min:1',
        ]);
      
        $vehicle->id=$request->regno;
        $vehicle->model=$request->model;
        $vehicle->type=$request->assettype;
        $vehicle->vehi_reg_no=$request->vehiregno;
        $vehicle->insu_no=$request->insuno;
        $vehicle->insu_type=$request->insutype;
        $vehicle->insu_rew_date=$request->insurewdate;
        $vehicle->save();
        //return redirect()->back();

        $data=Vehicle::all();
        // $data=Vehicle::paginate(10);
        //dd($data);

        return view('vehicleregistration')->with('vehicleregistration',$data);
        // return view('vehicleregistration',['vehicleregistration'=>$data]);
    }

    public function deletevehicle($id){
            $vehicle=Vehicle::find($id);
            $vehicle->delete();
            $data=Vehicle::all();
            return view('vehicleregistration')->with('vehicleregistration',$data);
    }

    public function editvehicleview($id){
            $vehicle=Vehicle::find($id);
            
            return view('editvehicleregistration')->with('vehicledata',$vehicle);
    }

    public function updatevehicle(Request $request){
        
        //dd($request->all());

        $id=$request->regno;
        $model=$request->model;
        $type=$request->assettype;
        $vehi_reg_no=$request->vehiregno;
        $insu_no=$request->insuno;
        $insu_type=$request->insutype;
        $insu_rew_date=$request->insurewdate;

        $data=Vehicle::find($id);

        $data->model=$model;
        $data->type=$type;
        $data->vehi_reg_no=$vehi_reg_no;
        $data->insu_no=$insu_no;
        $data->insu_type=$insu_type;
        $data->insu_rew_date=$insu_rew_date;
        $data->save();
        $data=Vehicle::all();

        return view('vehicleregistration')->with('vehicleregistration',$data);

    }

    //Search
    public function searchVehicleRegistration(Request $request){

        $search = $request->get('searchvehiclereg');
        $posts = Vehicle::where('vehi_reg_no','like','%'.$search.'%')->paginate(10);
        return view('vehicleregistrationsearch' , ['posts'=> $posts]);
  
    }
}

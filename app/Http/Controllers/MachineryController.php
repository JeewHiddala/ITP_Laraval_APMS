<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use\App\Machinery;

class MachineryController extends Controller
{
    public function storemachinery(Request $request){
      
        //dd($request->all()) ;
      
        $machinery=new Machinery;

        //Validation
        $this->validate($request,[
            'model'=>'required|max:100|min:5',
            'mrchmodelno'=>'required|max:100|min:5',
            'insuno'=>'required|max:100|min:7',
        ]);
      
        $machinery->id=$request->regno;
        $machinery->model=$request->model;
        $machinery->type=$request->assettype;
        $machinery->model_no=$request->mrchmodelno;
        $machinery->insu_no=$request->insuno;
        $machinery->insu_type=$request->insutype;
        $machinery->insu_rew_date=$request->insurewdate;
        $machinery->save();
        //return redirect()->back();

        $data=Machinery::all();
        //dd($data);

        return view('machineryregistration')->with('machineryregistration',$data);

    }

    public function deletemachinery($id){
        $machinery=Machinery::find($id);
        $machinery->delete();
        
        $data=Machinery::all();
        return view('machineryregistration')->with('machineryregistration',$data);
    }

    public function editmachineryview($id){
        $machinery=Machinery::find($id);
        
        return view('editmachineryregistration')->with('machinerydata',$machinery);
}

    public function updatemachinery(Request $request){
        
        //dd($request);

        $id=$request->regno;
        $model=$request->model;
        $type=$request->assettype;
        $model_no=$request->mrchmodelno;
        $insu_no=$request->insuno;
        $insu_type=$request->insutype;
        $insu_rew_date=$request->insurewdate;

        $data=Machinery::find($id);

        $data->model=$model;
        $data->type=$type;
        $data->model_no=$model_no;
        $data->insu_no=$insu_no;
        $data->insu_type=$insu_type;
        $data->insu_rew_date=$insu_rew_date;
        $data->save();
        $data=Machinery::all();

        return view('machineryregistration')->with('machineryregistration',$data);
    }

    //search
    public function searchMachineryRegistration(Request $request){

        $search = $request->get('searchBar');
        $posts = Machinery ::where('model_no','like','%'.$search.'%')->paginate(10);
        return view('machineryregistrationsearch' , ['posts'=> $posts]);
  
    }

}

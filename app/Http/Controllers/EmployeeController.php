<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empdetails;
use DB;

class EmployeeController extends Controller
{
    public function store(Request $request){

        $emp=new EmpDetails;
        //validate the input
        $this->validate($request,[
            'empReg'=>'required|max:100|min:5',
        ]);

        $emp->employee_id=$request->empId;
        $emp->name=$request->empReg;
        $emp->address=$request->empReg1;
        $emp->birthday=$request->empReg2;
        $emp->gender=$request->empReg3;
        $emp->designation=$request->empReg4;
        $emp->Salary=$request->empReg5;
        $emp->mobile=$request->empReg6;
        $emp->email=$request->empReg7;
        $emp->nic=$request->empReg8;
      
       
        

        $emp->save();

        $data=EmpDetails::all();

        return view('employeeRegistration')->with('emprg',$data);
        //dd($data);
        //return redirect()->back();
        //dd($request->all());

    }

    public function deleteemp($employee_id){
        $emp=EmpDetails::find($employee_id);
        $emp->delete();
        return redirect()->back();
    }

    public function updateempview($employee_id){
        $emp=EmpDetails::find($employee_id);

        return view('updateemp')->with('empdata',$emp);

    }

    public function empview($employee_id){
        $emp=EmpDetails::find($employee_id);

        return view('viewEmployee')->with('empdata',$emp);

    }


    public function updateemp(Request $request){

        //validate the input
        $this->validate($request,[
            'mobile'=>'required|max:10',
        ]);

        $employee_id=$request->employee_id;
        $name=$request->name;
        $address=$request->address;
        $birthday=$request->birthday;
        $gender=$request->gender;
        $designation=$request->designation;
        $Salary=$request->Salary;
        $mobile=$request->mobile;
        $email=$request->email;
        $nic=$request->nic;
    
        //$password=$request->password;

        $data=EmpDetails::find($employee_id);

        $data->name=$name;
        $data->address=$address;
        $data->birthday=$birthday;
        $data->gender=$gender;
        $data->designation=$designation;
        $data->Salary=$Salary;
        $data->mobile=$mobile;
        $data->email=$email;
        $data->nic=$nic;
    
        //$data->password=$password;

        $data->save();
        $data=EmpDetails::all();
        return redirect('/emp')->with('emprg',$data);
      



    }

   public function viewProfile(Request $request){

    $user_id=$request->id;

   $data=EmpDetails::find($user_id);



    //$data=EmpDetails::all();

    //dd( $data);
    //$data = DB::table('users')
    //->join('emp_details', 'emp_details.employee_id', '=', 'users.id')
   // ->join('country', 'country.country_id', '=', 'state.country_id')
    //->select(all)
    //->where('emp_details.employee_id',$user_id)
    //->get();
    
   // return view('profile', compact('data'));
    
    return view('profile')->with('data',$data);

   // $data->name=$name;

   // dd($data);


   }

  /* public function updateProfview(){

    $employee_id=$request->employee_id;
    $name=$request->name;
    $address=$request->address;
    $birthday=$request->birthday;
    $gender=$request->gender;
    $designation=$request->designation;
    $Salary=$request->Salary;
    $mobile=$request->mobile;
    $email=$request->email;
    $nic=$request->nic;

    //$password=$request->password;

    $data=EmpDetails::find($employee_id);

    $data->name=$name;
    $data->address=$address;
    $data->birthday=$birthday;
    $data->gender=$gender;
    $data->designation=$designation;
    $data->Salary=$Salary;
    $data->mobile=$mobile;
    $data->email=$email;
    $data->nic=$nic;

    //$data->password=$password;

    $data->save();
    $data=EmpDetails::all();
    return view('employeeRegistration')->with('emprg',$data);
  




   }*/

   public function searchEmployee(Request $request){

    $search = $request->get('searchEmp');
    $posts = EmpDetails::where('name','like','%'.$search.'%')->paginate(10);
    return view('searchResultEmp' , ['posts'=> $posts]);

}



}

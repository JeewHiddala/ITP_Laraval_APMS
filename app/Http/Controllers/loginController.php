<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Validator;
//use App\User;
use App\Empdetails;
//use Auth;
//use App\User;
use DB;

class loginController extends Controller
{
  public function loginValidate(Request $request){
    $this->validate($request,[
      'password'=>'required|min:6',
  ]);

           
    //  $rs=mysqli_query($conn,"select * from user where user_id='$user_id' and pass='$pass'");
        $email = $request->email;
      $password1 = $request->password;

   

      $data = DB::table('emp_details')
         ->select('emp_details.name' , 'emp_details.password','emp_details.email','emp_details.employee_id','emp_details.address','emp_details.birthday','emp_details.gender','emp_details.designation','emp_details.Salary','emp_details.mobile','emp_details.nic','emp_details.created_at')
        ->where ('emp_details.email','=',$email)
        ->get();
      // dd($data);
        
      

       // dd($data);
       
           if(!$data->first())
            {
               // echo '<script>alert("Invalid user name and password")</script>'; 
               return redirect('/loginView')
                    ->with('error','Incorrect User Name and Password try again');
               

            }
            else
            {
                foreach($data as $data1){
                if($data1->password==$password1){
              
                    $NAME = $data1->name;
                    $EMAIL = $data1->email;

                    $request->session()->put('my_name',$data1);
                    return redirect('/menu');

                   
                   // return redirect('/session/set');
                    
                    //$this->storeSessionData($NAME);
                   

                  
                }else{
                    return redirect('/loginView')
                    ->with('error','Incorrect User Name and Password try again');
                }
            }
               
            }
        
      
 
 
    }

  public function RegisteredEmployee(Request $request){

    $this->validate($request,[

       'password' => 'min:6',
       'confirm_password' => 'required_with:password|same:password|min:6'
 
 
 
 
        ]);
 
     $employee = new EmpDetails;


     
   //Object->column name in the table =$request->the name that is coming from the request
   $employee->name=$request->username;
 
   $employee->email=$request->email;
   $employee->password=$request->password;
    

   $employee->save();

   $employee=EmpDetails::all();
      //dd($localSupData);
      //return redirect()->back();
     // return view(/task);

     $data = DB::table('emp_details')
     ->select('emp_details.name' , 'emp_details.password','emp_details.email','emp_details.employee_id','emp_details.address','emp_details.birthday','emp_details.gender','emp_details.designation','emp_details.Salary','emp_details.mobile','emp_details.nic','emp_details.created_at')
     ->where ('emp_details.email','=', $request->email)
     ->get();

     

          foreach($data as $data1){
     $request->session()->put('my_name', $data1);
    return redirect('/menu');
          }
   


  }


  public function accessSessionData(Request $request) {
    
    if($request->session()->has('my_name')){

     $name= $request->session()->get('my_name');
       return view('/profile')->with ('name',$name);
    }
    else
       echo 'No data in the session';
 }

function SignOut(){

  return redirect('session/remove');
}

public function deleteSessionData(Request $request) {
  $request->session()->forget('my_name');

  return redirect('/loginView');
 
}

public function  forgotPasswordValidate(Request $request){

           
  //  $rs=mysqli_query($conn,"select * from user where user_id='$user_id' and pass='$pass'");
      $email = $request->email;
    $nic1 = $request->nic;

 

    $data = DB::table('emp_details')
       ->select('emp_details.name' , 'emp_details.password','emp_details.email','emp_details.employee_id','emp_details.address','emp_details.birthday','emp_details.gender','emp_details.designation','emp_details.Salary','emp_details.mobile','emp_details.nic','emp_details.created_at')
      ->where ('emp_details.email','=',$email)
      ->get();
    // dd($data);
      
    

     // dd($data);
     
         if(!$data->first())
          {
             // echo '<script>alert("Invalid user name and password")</script>'; 
             return redirect('/forgetPassword')
                  ->with('error','Incorrect Email and NIC number try again');
             

          }
          else
          {
              foreach($data as $data1){
              if($data1->nic==$nic1){
            
                 // $NAME = $data1->name;
                 // $EMAIL = $data1->email;

                  $request->session()->put('my_name',$data1);

                  return redirect('/resetPassword');

                 
                 // return redirect('/session/set');
                  
                  //$this->storeSessionData($NAME);
                 

                
              }else{
                  return redirect('/forgetPassword')
                  ->with('error','Incorrect Email and NIC number try again');
              }
          }
             
          }
      
}


public function ResetPassword(Request $request){

  $this->validate($request,[

      
    'newPassword' => 'min:6',
    'new_confirm_password' => 'required_with:newPassword|same:newPassword|min:6'




     ]);

     if($request->session()->has('my_name')){

      $name= $request->session()->get('my_name');
       
     }


  $password=$request->newPassword;

  $data =  DB::table('emp_details')
  ->select('emp_details.employee_id')
  ->where ('emp_details.email','=', $name->email)
  ->get();

  foreach($data as $data1){
  $employee=EmpDetails::find($data1->employee_id);
  }

  
//  dd($employee);
  $employee->password=$password;

  $employee->save();

$employee=EmpDetails::all();
   //dd($localSupData);
   //return redirect()->back();
  // return view(/task);

  $data = DB::table('emp_details')
  ->select('emp_details.name' , 'emp_details.password','emp_details.email','emp_details.employee_id','emp_details.address','emp_details.birthday','emp_details.gender','emp_details.designation','emp_details.Salary','emp_details.mobile','emp_details.nic','emp_details.created_at')
  ->where ('emp_details.email','=', $name->email)
  ->get();

  

       foreach($data as $data1){
  $request->session()->put('my_name', $data1);
 return redirect('/menu');
       }




    


  }

public function accessSessionDataStock(Request $request) {

    if($request->session()->has('my_name')){

     $name= $request->session()->get('my_name');

        if($name->designation == 'Store Keeper' || $name->designation == 'Manager Admintration'){
             return view('/subStockMenu')->with ('name',$name);
        }
        else{
            return redirect('/menu')
            ->with('error','You are not having permisson to access Stock Managment Directory');
        }
    }
    else
       echo 'No data in the session';
 }


 public function  accessSessionSupBuyer(Request $request) {

  if($request->session()->has('my_name')){

   $name= $request->session()->get('my_name');
      if($name->designation == 'Manager Admintration'){
           return redirect('/subBuyerMenu');
      }
      else{
          return redirect('/menu')
          ->with('error','You are not having permisson to access Supplier and WholeSale Buyer Management Directory');
      }
  }
  else
     echo 'No data in the session';
}

public function accessSessionOrders(Request $request) {

  if($request->session()->has('my_name')){
   $name= $request->session()->get('my_name');

      if($name->designation == 'Sales Person' || $name->designation == 'Manager Admintration'){
           return redirect('/subBillingMenu');
      }
      else{
          return redirect('/menu')
          ->with('error','You are not having permisson to access Order Managment Directory');
      }
  }
  else
     echo 'No data in the session';
}


public function accessSessionWOrders(Request $request) {

  if($request->session()->has('my_name')){
   $name= $request->session()->get('my_name');

      if($name->designation == 'Sales Person' || $name->designation == 'Manager Admintration'){
           return redirect('/orderManageMenu');
      }
      else{
          return redirect('/menu')
          ->with('error','You are not having permisson to access Order Managment Directory');
      }
  }
  else
     echo 'No data in the session';
}



public function accessSessionTrasport(Request $request) {

  if($request->session()->has('my_name')){
   $name= $request->session()->get('my_name');
      if($name->designation == 'Manager Admintration'){
           return redirect('/tmMenu');
      }
      else{
          return redirect('/menu')
          ->with('error','You are not having permisson to access Transport Managment Directory');
      }
  }
  else
     echo 'No data in the session';
}


public function accessSessionFinance(Request $request) {
  {

      if($request->session()->has('my_name')){
       $name= $request->session()->get('my_name');
          if($name->designation == 'Accountant' || $name->designation == 'Manager Admintration'){
               return redirect('/fmMenu');
          }
          else{
              return redirect('/menu')
              ->with('error','You are not having permisson to access Finance Managment Directory');
          }
      }
      else
         echo 'No data in the session';
   }
}


public function accessSessionFeedback(Request $request) {
  {

      if($request->session()->has('my_name')){
       $name= $request->session()->get('my_name');
          if($name->designation == 'HR Manager' || $name->designation == 'Manager Admintration'){
               return redirect('/viewfeedback');
          }
          else{
              return redirect('/menu')
              ->with('error','You are not having permisson to access Feedback Managment Directory');
          }
      }
      else
         echo 'No data in the session';
   }
}



public function  accessSessionEmployee(Request $request) {
  {

      if($request->session()->has('my_name')){
       $name= $request->session()->get('my_name');
          if($name->designation == 'HR Manager' || $name->designation == 'Manager Admintration'){
               return redirect('/subEmp');
          }
          else{
              return redirect('/menu')
              ->with('error','You are not having permisson to access Employee Managment Directory');
          }
      }
      else
         echo 'No data in the session';
   }
}

public function accessSessionResource(Request $request) {

  if($request->session()->has('my_name')){
   $name= $request->session()->get('my_name');
      if($name->designation == 'Manager Admintration' || $name->designation == 'Manager Admintration'){
           return redirect('/subResourceMenu');
      }
      else{
          return redirect('/menu')
          ->with('error','You are not having permisson to access Resource Managment Directory');
      }
  }
  else
     echo 'No data in the session';
}








}

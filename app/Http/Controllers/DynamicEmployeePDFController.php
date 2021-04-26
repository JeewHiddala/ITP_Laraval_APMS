<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empdetails;
use DB;
use PDF;

class DynamicEmployeePDFController extends Controller
{
    function index(){
        $employee_data = $this->get_employee_data();
        return view('dynamicEmp_pdf')->with('employee_data', $employee_data);  
    }

    function indexLeave(){
        $leave_data = $this->get_leave_data();
        return view('dynamicLeave_pdf')->with('leave_data', $leave_data);
    }

    function indexShortLeave(){
        $shortLeave_data = $this->get_shortLeave_data();
        return view('dynamicShortLeave_pdf')->with('shortLeave_data', $shortLeave_data);
    }

    function indexSingleEmp(){
        $singleEmployee_data = $this->get_singleEmployee_data();
        return view('dynamicSingleEmp_pdf')->with('singleEmployee_data', $singleEmployee_data);  
    }


    function get_employee_data()
    {
        $employee_data = DB::table('emp_details')
                        ->limit(10)//select first 10 records from the table
                        ->get();//excecute the query and return result in array format and store in $employee_data

        return $employee_data;
    }

    function get_leave_data()
    {
        $leave_data = DB::table('leaves')
                    ->limit(10)
                    ->get();
        return $leave_data;
    }

    function get_shortLeave_data()
    {
        $shortLeave_data = DB::table('short_leaves')
                    ->limit(10)
                    ->get();
        return $shortLeave_data;
    }

    function get_singleEmployee_data()
    {
       $singleEmployee_data = DB::table('emp_details')
                        ->limit(10)//select first 10 records from the table
                        ->get();//excecute the query and return result in array format and store in $employee_data

                       // $singleEmployee_data=emp_detail::find($no);
        return $singleEmployee_data;
    }

    public function singleEmployeeProfileView($reg_no){
        $Employee=EmpDetails::find($reg_no);
        return view('/dynamicSingleEmp_pdf',['Employee' => $Employee]);
    }

    
    function pdf()
    {
     $pdf = \App::make('dompdf.wrapper');
     $pdf->loadHTML($this->convert_employee_data_to_html());
     return $pdf->stream();
    }

    function pdfLeave()
    {
     $pdf = \App::make('dompdf.wrapper');
     $pdf->loadHTML($this->convert_leave_data_to_html());
     return $pdf->stream();//show pdf file in browser
    }

    function pdfShortLeave()
    {
     $pdf = \App::make('dompdf.wrapper');
     $pdf->loadHTML($this->convert_shortLeave_data_to_html());
     return $pdf->stream();//show pdf file in browser
    }

    function pdfSingleEmp($reg_no)
    {
     $pdf = \App::make('dompdf.wrapper');
     $pdf->loadHTML($this->convert_singleEmployee_data_to_html($reg_no));
     return $pdf->stream();
    }




    function convert_employee_data_to_html()
    {
     $employee_data = $this->get_employee_data();
     $png = file_get_contents("images/logo.png");
     $pngBase64 = base64_encode($png);
     date_default_timezone_set('Asia/Colombo');
     $date = date('m/d/Y h:i:s a', time());
     $output = '
     <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Supplier Managment</title>
     <style>
     .footer {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
       
        color: black;
        text: center;
        height: 10%;
      
     }
     .inline {
       display: inline;
     }
     div.c {
       text-align: right;
     } 
   
     div.a {
       text-align: center;
     }
    
     </style>
    </head>
   <body>
   <img src="data:image;base64,'.$pngBase64.'" width="110" height="100" style="float:left; margin-top:-2.2% ;padding-left:0.5%">
   
   <h1 align="center">
         <!--<span class="site-heading-upper text-primary mb-3">A Free Bootstrap 4 Business Theme</span>-->
         <span class="site-heading-lower" style="color:#e6a756">Ranjith Motors & Auto Parts</span>
   </h1>
   <br>
   <h5 style = "float:left;"> Address : Colombo Road, Dambokka, Kurunegala, Srilanka 600000</h5>
   <h5 style = "float:right;"> Telephone: +94 372231201/+94 372222902</h5>
   <br><br>
   <hr>
      
      <p> Date and Time : '.$date.'</p>
     <h3 align="center">Ranjith Motors Employee Information Report</h3><br>
     <table width="100%" style="border-collapse: collapse; border: 0px;">
      <tr>
    <th style="border: 1px solid; padding:12px;" width="20%">Employee Id</th>
    <th style="border: 1px solid; padding:12px;" width="30%">Name</th>
    <th style="border: 1px solid; padding:12px;" width="20%">designation</th>
    <th style="border: 1px solid; padding:12px;" width="30%">salary</th>
    <th style="border: 1px solid; padding:12px;" width="15%">email</th>
    <th style="border: 1px solid; padding:12px;" width="20%">NIC</th>
   </tr>
     ';  
     foreach($employee_data as $employee)
     {
      $output .= '
      <tr>
       <td style="border: 1px solid; padding:12px;">'.$employee->employee_id.'</td>
       <td style="border: 1px solid; padding:12px;">'.$employee->name.'</td>
       <td style="border: 1px solid; padding:12px;">'.$employee->designation.'</td>
       <td style="border: 1px solid; padding:12px;">'.$employee->Salary.'</td>
       <td style="border: 1px solid; padding:12px;">'.$employee->email.'</td>
       <td style="border: 1px solid; padding:12px;">'.$employee->nic.'</td>
      </tr>
      ';
     }
     $output .= '</table>

     <div class="footer">
 <hr>
 <div class="inline"  style="float:left;">  
 <p style="LINE-HEIGHT:10px; font-size:12px"> 2020 Ranjith Motors And Auto Parts</p>
 <p style="LINE-HEIGHT:10px;  font-size:12px"> Colombo Road,<p>
 <p style="LINE-HEIGHT:10px; font-size:12px"> Dambokka,</p>
 <p style="LINE-HEIGHT:10px; font-size:12px"> Kurunegala,Srilanka</p>

 </div>

 <div class="a" style="float:center;">
 <p  style="font-size:12px">&copy; 2020 Ranjith Motors All Rights Reserved</p>
</div>
 
 <div class="c" style="display:inline;">
<p style="LINE-HEIGHT:10px; font-size:12px"> +94 372231201</p>
<p style="LINE-HEIGHT:10px; font-size:12px"> +94 372222902</p>
<p  style="LINE-HEIGHT:10px; font-size:12px"> E: info@ranjithmotors.com</p>
</div>

 </div>
    ';
     return $output;
    }


    function convert_leave_data_to_html()
    {
     $leave_data = $this->get_leave_data();
     $png = file_get_contents("images/logo.png");
     $pngBase64 = base64_encode($png);
     date_default_timezone_set('Asia/Colombo');
     $date = date('m/d/Y h:i:s a', time());
     $output = '

     <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Supplier Managment</title>
     <style>
     .footer {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
       
        color: black;
        text: center;
        height: 10%;
      
     }
     .inline {
       display: inline;
     }
     div.c {
       text-align: right;
     } 
   
     div.a {
       text-align: center;
     }
    
     </style>
    </head>
   <body>
   <img src="data:image;base64,'.$pngBase64.'" width="110" height="100" style="float:left; margin-top:-2.2% ;padding-left:0.5%">
   
   <h1 align="center">
         <!--<span class="site-heading-upper text-primary mb-3">A Free Bootstrap 4 Business Theme</span>-->
         <span class="site-heading-lower" style="color:#e6a756">Ranjith Motors & Auto Parts</span>
   </h1>
   <br>
   <h5 style = "float:left;"> Address : Colombo Road, Dambokka, Kurunegala, Srilanka 600000</h5>
   <h5 style = "float:right;"> Telephone: +94 372231201/+94 372222902</h5>
   <br><br>
   <hr>
      
      <p> Date and Time : '.$date.'</p><br>

     <h3 align="center">Ranjith Motors Employee Leave Application Details Report</h3>
     <table width="100%" style="border-collapse: collapse; border: 0px;">
      <tr>
    <th style="border: 1px solid; padding:12px;" width="20%">Leave ID</th>
    <th style="border: 1px solid; padding:12px;" width="30%">Emp ID</th>
    <th style="border: 1px solid; padding:12px;" width="20%">Reason</th>
    <th style="border: 1px solid; padding:12px;" width="30%">Duration From</th>
    <th style="border: 1px solid; padding:12px;" width="15%">To</th>
    <th style="border: 1px solid; padding:12px;" width="20%">Approved=1</th>
   </tr>
     ';  
     foreach($leave_data as $leave)
     {
      $output .= '
      <tr>
       <td style="border: 1px solid; padding:12px;">'.$leave->leave_id.'</td>
       <td style="border: 1px solid; padding:12px;">'.$leave->emp_id.'</td>
       <td style="border: 1px solid; padding:12px;">'.$leave->leaveType.'</td>
       <td style="border: 1px solid; padding:12px;">'.$leave->fromDate.'</td>
       <td style="border: 1px solid; padding:12px;">'.$leave->toDate.'</td>
       <td style="border: 1px solid; padding:12px;">'.$leave->isApproved.'</td>
      </tr>
      ';
     }
     $output .= '</table>

     <div class="footer">
 <hr>
 <div class="inline"  style="float:left;">  
 <p style="LINE-HEIGHT:10px; font-size:12px"> 2020 Ranjith Motors And Auto Parts</p>
 <p style="LINE-HEIGHT:10px;  font-size:12px"> Colombo Road,<p>
 <p style="LINE-HEIGHT:10px; font-size:12px"> Dambokka,</p>
 <p style="LINE-HEIGHT:10px; font-size:12px"> Kurunegala,Srilanka</p>

 </div>

 <div class="a" style="float:center;">
 <p  style="font-size:12px">&copy; 2020 Ranjith Motors All Rights Reserved</p>
</div>
 
 <div class="c" style="display:inline;">
<p style="LINE-HEIGHT:10px; font-size:12px"> +94 372231201</p>
<p style="LINE-HEIGHT:10px; font-size:12px"> +94 372222902</p>
<p  style="LINE-HEIGHT:10px; font-size:12px"> E: info@ranjithmotors.com</p>
</div>

 </div>
    ';
     return $output;
    }


    function convert_shortLeave_data_to_html()
    {

     $shortLeave_data = $this->get_shortLeave_data();
     $png = file_get_contents("images/logo.png");
     $pngBase64 = base64_encode($png);
     date_default_timezone_set('Asia/Colombo');
     $date = date('m/d/Y h:i:s a', time());
     $output = '

     <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Supplier Managment</title>
     <style>
     .footer {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
       
        color: black;
        text: center;
        height: 10%;
      
     }
     .inline {
       display: inline;
     }
     div.c {
       text-align: right;
     } 
   
     div.a {
       text-align: center;
     }
    
     </style>
    </head>
   <body>
   <img src="data:image;base64,'.$pngBase64.'" width="110" height="100" style="float:left; margin-top:-2.2% ;padding-left:0.5%">
   
   <h1 align="center">
         <!--<span class="site-heading-upper text-primary mb-3">A Free Bootstrap 4 Business Theme</span>-->
         <span class="site-heading-lower" style="color:#e6a756">Ranjith Motors & Auto Parts</span>
   </h1>
   <br>
   <h5 style = "float:left;"> Address : Colombo Road, Dambokka, Kurunegala, Srilanka 600000</h5>
   <h5 style = "float:right;"> Telephone: +94 372231201/+94 372222902</h5>
   <br><br>
   <hr>
      
      <p> Date and Time : '.$date.'</p><br>

     <center><h3 align="center">Ranjith Motors Employee Short Leave Application Report</h3><>
     <table width="100%" style="border-collapse: collapse; border: 0px;">
      <tr>
    <th style="border: 1px solid; padding:12px;" width="20%">Short.L ID</th>
    <th style="border: 1px solid; padding:12px;" width="30%">Emp ID</th>
    <th style="border: 1px solid; padding:12px;" width="20%">Reason</th>
    <th style="border: 1px solid; padding:12px;" width="30%">Leave Date</th>
    <th style="border: 1px solid; padding:12px;" width="20%">Approved=1</th>
   </tr>
     ';  
     foreach($shortLeave_data as $shortLeave)
     {
      $output .= '
      <tr>
       <td style="border: 1px solid; padding:12px;">'.$shortLeave->leave_id.'</td>
       <td style="border: 1px solid; padding:12px;">'.$shortLeave->emp_id.'</td>
       <td style="border: 1px solid; padding:12px;">'.$shortLeave->shortleaveType.'</td>
       <td style="border: 1px solid; padding:12px;">'.$shortLeave->Date.'</td>
       <td style="border: 1px solid; padding:12px;">'.$shortLeave->isApproved.'</td>
      </tr>
      ';
     }
     $output .= '</table>

     <div class="footer">
 <hr>
 <div class="a" style="float:center;">
 <p  style="font-size:12px">&copy; 2020 Ranjith Motors All Rights Reserved</p>
</div>
 
 <div class="c" style="display:inline;">
<p style="LINE-HEIGHT:10px; font-size:12px"> +94 372231201</p>
<p style="LINE-HEIGHT:10px; font-size:12px"> +94 372222902</p>
<p  style="LINE-HEIGHT:10px; font-size:12px"> E: info@ranjithmotors.com</p>
</div>

 </div>
    ';
     return $output;
    }


    function convert_singleEmployee_data_to_html($no)
    {
    
     $Employee=EmpDetails::find($no);
     $png = file_get_contents("images/logo.png");
    $pngBase64 = base64_encode($png);
    date_default_timezone_set('Asia/Colombo');
    $date = date('m/d/Y h:i:s a', time());

     $output = ' ';

     $output .= '<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Employee Managment</title>
     <style>
     .footer {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
       
        color: black;
        text: center;
        height: 10%;
      
     }
     .inline {
       display: inline;
     }
     div.c {
       text-align: right;
     } 
   
     div.a {
       text-align: center;
     }
    
     </style>
    </head>
   <body>
   <img src="data:image;base64,'.$pngBase64.'" width="110" height="100" style="float:left; margin-top:-2.2% ;padding-left:0.5%">
   
   <h1 align="center">
         <!--<span class="site-heading-upper text-primary mb-3">A Free Bootstrap 4 Business Theme</span>-->
         <span class="site-heading-lower" style="color:#e6a756">Ranjith Motors & Auto Parts</span>
   </h1>
   <br>
   <h5 style = "float:left;"> Address : Colombo Road, Dambokka, Kurunegala, Srilanka 600000</h5>
   <h5 style = "float:right;"> Telephone: +94 372231201/+94 372222902</h5>
   <br><br>
   <hr>
   </br></br>
   <p style="float:right;"> Date and Time : '.$date.'</p>
   &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
  <center><h2>Employee Profile Report</h2></center>
  <br>
             <div class="input-group">
             <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
           Full Name :&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;
         '.$Employee->name.' 
             </div><br><br>
              
             <div class="input-group">
             <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
             Address :       &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;
          '.$Employee->address.' 
             </div><br><br>

            <div class="input-group">
             <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
             Birthday :&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;
             
           '.$Employee->birthday.'
             <br><br><br>
             Gender :&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;  
         '.$Employee->gender.' 

             
             </div><br><br>
         
             <div class="input-group">
             <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
             Designation :&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;
          '.$Employee->designation.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           
         
             
            <br><br><br>          
            
             Salary :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          '.$Employee->Salary.'
            
             </div><br><br>
        
             <div class="input-group">
             <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
             Mobile Number :&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;
            
           '.$Employee->mobile.'
           <br><br><br>
            Email :&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;
           '.$Employee->email.'
     
            <br><br><br><br>
             <div class="input-group">
             <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
             NIC :&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;
           
          '.$Employee->nic.'
             </div><br>
             <br><br>
             <div class="input-group">
             <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
             Join Date :&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;
           
          '.$Employee->created_at.' 
             </div><br>

             <input type="hidden" name="employee_id" value='.$Employee->employee_id.'/>
    
 </div>
 <div class="footer">
 <hr>
 <div class="inline"  style="float:left;">  
 <p style="LINE-HEIGHT:10px; font-size:12px"> 2020 Ranjith Motors And Auto Parts</p>
 <p style="LINE-HEIGHT:10px;  font-size:12px"> Colombo Road,<p>
 <p style="LINE-HEIGHT:10px; font-size:12px"> Dambokka,</p>
 <p style="LINE-HEIGHT:10px; font-size:12px"> Kurunegala,Srilanka</p>

 </div>

 <div class="a" style="float:center;">
 <p  style="font-size:12px">&copy; 2020 Ranjith Motors All Rights Reserved</p>
</div>
 
 <div class="c" style="display:inline;">
<p style="LINE-HEIGHT:10px; font-size:12px"> +94 372231201</p>
<p style="LINE-HEIGHT:10px; font-size:12px"> +94 372222902</p>
<p  style="LINE-HEIGHT:10px; font-size:12px"> E: info@ranjithmotors.com</p>
</div>

 </div>
';
 return $output;
  }
}

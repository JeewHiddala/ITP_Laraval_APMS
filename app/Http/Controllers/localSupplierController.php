<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;
use App\localSupplier;
use DB;


class localSupplierController extends Controller
{
    //
      

    public function stroreLocalSupplier(Request $request){

       // dd($request->all());//just display

       //to store data in the database
      $lSupplier = new localSupplier;

       //validate input data fields
       $this->validate($request,[

         'localSupName'=>'required|max:100|min:5',
         'mobileNumber'=>'required|min:10|numeric',
         'landNumber'=>'required|min:10|numeric',
         





       ]);
    //Object->column name in the table =$request->the name that is coming from the request
       $lSupplier->name=$request->localSupName;
       $lSupplier->company=$request->company;
       $lSupplier->email=$request->email;
       $lSupplier->address=$request->address;
       $lSupplier->district=$request->district;
       $lSupplier->mobile=$request->mobileNumber;
       $lSupplier->land=$request->landNumber;
       $lSupplier->bank_name=$request->bankName;
       $lSupplier->acc_num=$request->accNo;

       $lSupplier->save();

       $localSupData=localSupplier::all();
       //dd($localSupData);
       //return redirect()->back();
      // return view(/task);



     // return view('supplier')->with('supplier', $localSupData);
     return redirect('/supplierHome') ->with('supplier', $localSupData);


       }

    public function deleteLocalSup($reg_no){

     
     $lSupplier=localSupplier::find($reg_no);
     $lSupplier->delete();
      return redirect()->back();
    }

    public function updateLocalSupView($reg_no){

      $lSupplier=localSupplier::find($reg_no);

      return view('updateLocalSupplier')->with('localSupData', $lSupplier);

    }

   public function updateLocalSupplierData(Request $request){

     //validate input data fields
     $this->validate($request,[

      'localSupName'=>'required|max:100|min:5',
      'mobileNumber'=>'required|min:10|numeric',
      'landNumber'=>'required|min:10|numeric',
      





    ]);

      $reg_no=$request->regNo;
      $name=$request->localSupName;
      $company=$request->company;
      $email=$request->email;
      $address=$request->address;
      $district=$request->district;
      $mobile=$request->mobileNumber;
      $land=$request->landNumber;
      $bank_name=$request->bankName;
      $acc_num=$request->accNo;
         
      $lSupplier=localSupplier::find($reg_no);
    
      $lSupplier->name=$name;
      $lSupplier->company=$company;
      $lSupplier->email=$email;
      $lSupplier->address=$address;
      $lSupplier->district=$district;
      $lSupplier->mobile=$mobile;
      $lSupplier->land=$land;
      $lSupplier->bank_name=$bank_name;
      $lSupplier->acc_num=$acc_num;

      $lSupplier->save();

      $localSupplier = localSupplier::all();
    //  return view('supplier')->with('supplier', $localSupplier);
      return redirect('/supplierHome') ->with('supplier', $localSupplier);
     


    }

    public function searchLocalSup(Request $request){

      $search = $request->get('searchLocal');
      $posts = localSupplier::where('name','like','%'.$search.'%')->paginate(10);
      return view('searchResultLocal' , ['posts'=> $posts]);


    }

   
    function  index_lsupplier(){

      $lSupplier_data = $this->get_lSupplier_data();
      return view('dynamic_pdf_localSupplier')->with('lSupplier_data',$lSupplier_data);
      
  }

  function get_lSupplier_data(){

    $lSupplir_data = DB::table('local_suppliers')
                    ->limit(10)
                    ->get();//returns the result in an array format
    return  $lSupplir_data;

}

function pdf_localSuppliers(){

  $pdf = \App::make('dompdf.wrapper');
  $pdf->loadHTML($this->convert_suppliers_data_to_html());
  $png = file_get_contents("logo.png");
  return $pdf->stream();//Using this method we can show the pdf file in the browser

}

function convert_suppliers_data_to_html(){

  date_default_timezone_set('Asia/Colombo');
  $date = date('m/d/Y h:i:s a', time());
  $lsupplier_data = $this->get_lSupplier_data();
  $png = file_get_contents("logo.png");
  $pngBase64 = base64_encode($png);

  $output = '<head>
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
<h3 align="center">Registered Local Suppliers of Ranjith Auto Parts Company</h3>
  <table style="border-collapse:collapse; border: 0px;">
  <tr>
    =
    <th style="border: 1px solid;" width="1px">Reg_No</th>
      <th style="border: 1px solid;" width="1px">Name</th>
      <th style="border: 1px solid;">Company</th>
      <th style="border: 1px solid;" width="1px">Email</th>
      <th style="border: 1px solid;">Address</th>
   
      <th style="border: 1px solid;">Mobile Number</th>
    
   
   
     
  </tr> ';
  foreach($lsupplier_data as $buyer)
  {
      $output .='
      <tr>
      <td style="border: 1px solid;">'.$buyer->reg_no.'</td>
      <td style="border: 1px solid;"  width="1px">'.$buyer->name.'</td>
      <td style="border: 1px solid;">'.$buyer->company.'</td>
      <td style="border: 1px solid;" width="1px">'.$buyer->email.'</td>
      <td style="border: 1px solid;">'.$buyer->address.'</td>
    
      <td style="border: 1px solid;">'.$buyer->mobile.'</td>
    
      
      
      </tr>
      
      ';
  }
 $output .='</table><div class="footer">
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
</body>';
  return $output;
     
  }

 
  public function singleLocalSupplierProfileView($reg_no){

    $lSupplier=localSupplier::find($reg_no);
    // dd($wBuyer);
    // return view('singleBuyerProfile')->with('buyerData', $wBuyer);
    return view('/singleLocalSupplierProfile',['lSupplier' => $lSupplier]);
  }


function  pdf_singleLocalSupplier($reg_no){

  $pdf = \App::make('dompdf.wrapper');
  $pdf->loadHTML($this->convert_singleLocalSupplier_data_to_html($reg_no));
  return $pdf->stream();//Using this method we can show the pdf file in the browser

}

function convert_singleLocalSupplier_data_to_html($no){

  $png = file_get_contents("logo.png");
  $pngBase64 = base64_encode($png);
  $lSupplier=localSupplier::find($no);
  $png = file_get_contents("logo.png");
  $pngBase64 = base64_encode($png);
  date_default_timezone_set('Asia/Colombo');
  $date = date('m/d/Y h:i:s a', time());
  
      $output = ' ';
  
      $output .='<head>
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
   
<p style="float:right;"> Date and Time : '.$date.'</p>
    

    <h3>Local Supplier Profile Report</h3>
 
      <h2>'.$lSupplier->name.' - '.$lSupplier->company.' Company </h2> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     
     



      
      <br>

      <input type="hidden" name="regNo" value="{{$buyerData->reg_no}}">
      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
      Suppier Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
     '.$lSupplier->name.'
      </div>
      <br>

      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
      Comapny    &nbsp;  &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
      '.$lSupplier->company.' 
      </div>
      <br>
      
      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
     Email Address   &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
     '.$lSupplier->email.'
      </div>
      <br>

      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
      Address    &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;  
     '.$lSupplier->address.'
      </div>
      <br>

      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
     District    &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
     '.$lSupplier->district.' 
      </div>
      <br>

     

      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
     Mobile Number    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
     '.$lSupplier->mobile.' 
    
      </div>
      <br>

      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
      Land Number    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
     '.$lSupplier->land.'
      </div>
      <br>


      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
      Bank   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
     '.$lSupplier->bank_name.' 
    
      </div>
      <br>

      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
      Account Number  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
     '.$lSupplier->acc_num.'
      </div>
      <br>

      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
      Registered Date  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
     '.$lSupplier->created_at.'
      </div>
      <br>

      
      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
      Last Data Updated at   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
     '.$lSupplier->updated_at.'
      </div>
      <br>
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
</body>




     
      

      
      
      
      ';
  

  return $output;
     
  }


  public function  searchlocalSupPDF(Request $request){

    $search = $request->get('searchPDF');
    $posts = localSupplier::where('name','like','%'.$search.'%')->paginate(10);
    return view('localSupplierPDFResult' , ['posts'=> $posts]);


  }

 
      




  
}


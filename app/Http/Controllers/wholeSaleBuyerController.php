<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\wholeSaleBuyer;
use DB;
use PDF;

class wholeSaleBuyerController extends Controller
{
    //
    public function storeBuyer(Request $request){

        // dd($request->all());//just display
 
        //to store data in the database
       $wBuyer = new wholeSaleBuyer;
 
        //validate input data fields
        $this->validate($request,[
 
          'buyerName'=>'required|max:100|min:5',
        
        
         'creditDays'=>'required|numeric',
 
 
 
 
        ]);
     //Object->column name in the table =$request->the name that is coming from the request
     $wBuyer->buyer_name=$request->buyerName;
     $wBuyer->company=$request->bcompany;
     $wBuyer->email=$request->bemail;
     $wBuyer->address=$request->baddress;
     $wBuyer->district=$request->bdistrict;
     $wBuyer->mobile=$request->mobileNumber;
     $wBuyer->land=$request->landNumber;
     $wBuyer->bank_name=$request->bankName;
     $wBuyer->acc_num=$request->accNo;
     $wBuyer->credit_days=$request->creditDays;
     $wBuyer->discount=$request->discount;
     $wBuyer->save();
 
     $buyerData=wholeSaleBuyer::all();
     //dd($buyerData);
    //return redirect()->back();
      
 
 
    // return view('wholeSaleBuyer')->with('wholeSaleBuyer',$buyerData);
     return redirect('/buyerHome') ->with('wholeSaleBuyer', $buyerData);
       
 
 
        }

    public function deleteBuyer($reg_no){

     $wBuyer=wholeSaleBuyer::find($reg_no);
     $wBuyer->delete();
     return redirect()->back();
     //return view('wholeSaleBuyer');

    }

    public function updateBuyerView($reg_no){

        $wBuyer=wholeSaleBuyer::find($reg_no);
        return view('updateWholeBuyer')->with('buyerData', $wBuyer);



    }

    public function updateBuyerData(Request $request){

        $reg_no=$request->regNo;
        $name=$request->buyerName;
        $company=$request->bcompany;
        $email=$request->bemail;
        $address=$request->baddress;
        $district=$request->bdistrict;
        $mobile=$request->mobileNumber;
        $land=$request->landNumber;
        $bank_name=$request->bankName;
        $acc_num=$request->accNo;
        $credit_days=$request->creditDays;
        $discount=$request->discount;

        $wBuyer=wholeSaleBuyer::find($reg_no);

        $wBuyer->buyer_name=$name;
        $wBuyer->company=$company;
        $wBuyer->email=$email;
        $wBuyer->address=$address;
        $wBuyer->district=$district;
        $wBuyer->mobile=$mobile;
        $wBuyer->land=$land;
        $wBuyer->bank_name=$bank_name;
        $wBuyer->acc_num=$acc_num;
        $wBuyer->credit_days=$credit_days;
        $wBuyer->discount=$discount;

        $wBuyer->save();

        $wholeSaleBuyer =wholeSaleBuyer::all();

      //  return view('wholeSaleBuyer')->with('wholeSaleBuyer', $wholeSaleBuyer);
        return redirect('/buyerHome') ->with('wholeSaleBuyer',$wholeSaleBuyer);
    }

    /*function selectDistrict(){

        $district_list = DB::table('whole_sale_buyers')
                    ->groupBy('district')
                    ->get();// select query and return

        return view('wholeSaleBuyer')->with('district_list', $district_list);

    }

    function fetch(Request $request){
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');
        $data = DB::table('whole_sale_buyers')
                ->where($select, $value)
                ->groupBy($dependent ) 
                ->get();

        $output = '<option value="">Select '.ucfirst($dependent).'</option>';
        foreach($data as $row){
            $output = '<option value="'.$row->$dependent.'">'.$row->$dependent.'</option>';
        }

        echo $output; 

    }*/

    public function searchWholeBuyer(Request $request){

    $search = $request->get('searchWbuyer');
      $posts = wholeSaleBuyer::where('buyer_name','like','%'.$search.'%')->paginate(10);
      return view('searchResultBuyer' , ['posts'=> $posts]);

    }
  
    public function searchbuyerPDF(Request $request){

      $search = $request->get('searchPDFbuyer');
        $posts = wholeSaleBuyer::where('buyer_name','like','%'.$search.'%')->paginate(10);
        return view('buyerPDFresult' , ['posts'=> $posts]);
  
      }

    public function bestBuyer(){

        $data = DB::table('whole_sale_buyers')
       
        ->join('invoices','invoices.buyer_id','reg_no')
      
      
        ->select ('whole_sale_buyers.reg_no','whole_sale_buyers.buyer_name',DB::raw('sum(invoices.total) as total1'))
       // ->where ('invoices.total','>',10)
         ->groupBy('whole_sale_buyers.reg_no','whole_sale_buyers.buyer_name')
        ->orderBy('invoices.total', 'desc')
         ->take (5)
        ->get();
      // dd($data);
        

    
       return view('/buyerEvaluateResult',['data' =>$data]);
       //return view('/buyerEvaluate')->with( 'data', $data  );
       // return view('buyerEvaluate')->with('wholeSaleBuyer',$buyerData);
    }

    function index(){

        $buyer_data = $this->get_buyer_data();
        return view('dynmic_pdf_buyer')->with('buyer_data',$buyer_data);
        
    }

    function get_buyer_data(){

        $buyer_data = DB::table('whole_sale_buyers')
                        ->limit(10)
                        ->get();//returns the result in an array format
        return $buyer_data;

    }

    function pdf_buyer(){

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->convert_buyer_data_to_html());
        return $pdf->stream();//Using this method we can show the pdf file in the browser

    }

    function convert_buyer_data_to_html(){

      date_default_timezone_set('Asia/Colombo');
      $date = date('m/d/Y h:i:s a', time());
      $png = file_get_contents("logo.png");
      $pngBase64 = base64_encode($png);
        $buyer_data = $this->get_buyer_data();
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

        <h3 align="center">Registered WholeSaleBuyers of Ranjith Auto Parts Company</h3>
        <table style="border-collapse:collapse; border: 0px;">
        <tr>
            <th style="border: 1px solid;">Reg_No</th>
            <th style="border: 1px solid;" width="1px">Name</th>
            <th style="border: 1px solid;">Company</th>
            <th style="border: 1px solid;" width="1px">Email</th>
            <th style="border: 1px solid;">Address</th>
            <th style="border: 1px solid;">District</th>
            <th style="border: 1px solid;">Mobile Number</th>
          
         
         
            <th style="border: 1px solid;">Discount</th>
        </tr>';
        foreach($buyer_data as $buyer)
        {
            $output .='
            <tr>
            <td style="border: 1px solid;">'.$buyer->reg_no.'</td>
            <td style="border: 1px solid;"  width="1px">'.$buyer->buyer_name.'</td>
            <td style="border: 1px solid;">'.$buyer->company.'</td>
            <td style="border: 1px solid;" width="1px">'.$buyer->email.'</td>
            <td style="border: 1px solid;">'.$buyer->address.'</td>
            <td style="border: 1px solid;">'.$buyer->district.'</td>
            <td style="border: 1px solid;">'.$buyer->mobile.'</td>
          
            
            <td style="border: 1px solid;">'.$buyer->discount.'</td>
            
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

 </div>';
        return $output;
           
        }
            
function  pdf_singleEbuyer($reg_no){

            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($this->convert_SingleEbuyer_data_to_html($reg_no));
            return $pdf->stream();//Using this method we can show the pdf file in the browser
    
}

function convert_SingleEbuyer_data_to_html($no){
  $png = file_get_contents("logo.png");
  $pngBase64 = base64_encode($png);
  date_default_timezone_set('Asia/Colombo');
  $date = date('m.d.Y', time());

    $buyer_data = DB::table('whole_sale_buyers')
    ->join('invoices','invoices.buyer_id','reg_no')
   // ->join('emp_details','emp_details.employee_id','driver_id')
    //->join('vehicles','vehicles.id','vehicle_id')
  //  ->select ('whole_sale_buyers.reg_no','whole_sale_buyers.buyer_name','invoices.total')
  ->select ('whole_sale_buyers.reg_no','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.company',DB::raw('sum(invoices.total) as total1'))
  ->groupBy('whole_sale_buyers.reg_no','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.company')
  ->orderBy('invoices.total', 'desc')
   
  //->take (5)
  
    ->where ('whole_sale_buyers.reg_no','=',$no)
   // ->orderBy('invoices.total', 'desc') 
   // ->take (5)
   ->get();


  
    $output = ' 
    
        
    
      
      
     
     
       
    ';
    foreach($buyer_data as $buyer)
    {
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
       
        <br>
        '.$buyer->buyer_name.'<br>
        '.$buyer->company.'<br>
        '.$buyer->address.'<br>
        '.$date.'<br><br>

        

       Dear '.$buyer->buyer_name.',
       <br>

       <h2 align="center">Congratulations</h2>

       <h3>Your "'.$buyer->company.'" company has been choosen as one of best buyers in our company</h3>
       
    <p align = "justify">
       We would like to extend our appreciation and gratitude toward you and your company for beign a loyal wholeSale Buyer of our Auto Parts Managment System Company.
        <br><br>
      In the presence of numerous companies , you always choose APMS and show your trust in our quality of products and price.To acknowledge your loyalty and your value to 
      us,we are offering you 25% off on your next purchase.
        <br><br>
      We hope to have a continued relationship with you so that we can sureve you in the future as well.
      <br><br>
      With thanks,
      <br><br>
      </p>

      K.A.D.K.S.Kuruppuarachchi
        <br>
      Manager Administrator  
      <br>
      Ranjith Auto Parts Managment System
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
    }
  
    return $output;
       
    }

   
    
    public function singleBuyerProfileView($reg_no){

      //$wBuyer=wholeSaleBuyer::find($reg_no);
      $wBuyer = DB::table('whole_sale_buyers')
      ->join('invoices','invoices.buyer_id','reg_no')
     ->select ('whole_sale_buyers.reg_no','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.company','whole_sale_buyers.email','whole_sale_buyers.district','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.bank_name','whole_sale_buyers.acc_num','whole_sale_buyers.credit_days','whole_sale_buyers.discount',DB::raw('sum(invoices.total) as total1'))
 
      ->groupBy('whole_sale_buyers.reg_no','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.company','whole_sale_buyers.email','whole_sale_buyers.district','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.bank_name','whole_sale_buyers.acc_num','whole_sale_buyers.credit_days','whole_sale_buyers.discount')
      ->orderBy('invoices.total', 'desc')
      ->where ('whole_sale_buyers.reg_no','=',$reg_no)
      ->get();
  





     // dd($wBuyer);
   // return view('singleBuyerProfile')->with('buyerData', $wBuyer);
    return view('/singleBuyerProfile',['wBuyer' =>$wBuyer]);



  }

 
  function  pdf_singleBuyer($reg_no){

    $pdf = \App::make('dompdf.wrapper');
    $pdf->loadHTML($this->convert_Singlebuyer_data_to_html($reg_no));
    return $pdf->stream();//Using this method we can show the pdf file in the browser

}

function convert_Singlebuyer_data_to_html($no){

  $png = file_get_contents("logo.png");
  $pngBase64 = base64_encode($png);
  date_default_timezone_set('Asia/Colombo');
  $date = date('m/d/Y h:i:s a', time());
  $wBuyer = DB::table('whole_sale_buyers')
      ->join('invoices','invoices.buyer_id','reg_no')
     ->select ('whole_sale_buyers.reg_no','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.company','whole_sale_buyers.email','whole_sale_buyers.district','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.bank_name','whole_sale_buyers.acc_num','whole_sale_buyers.credit_days','whole_sale_buyers.discount',DB::raw('sum(invoices.total) as total1'))
 
      ->groupBy('whole_sale_buyers.reg_no','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.company','whole_sale_buyers.email','whole_sale_buyers.district','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.bank_name','whole_sale_buyers.acc_num','whole_sale_buyers.credit_days','whole_sale_buyers.discount')
      ->orderBy('invoices.total', 'desc')
      ->where ('whole_sale_buyers.reg_no','=',$no)
      ->get();
  
      $output = ' 
  
   ';
  foreach($wBuyer as $buyerData)
  {
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

    <h3>WholeSale Buyer Profile Report</h3>
 
    <h2>'.$buyerData->buyer_name.' - '.$buyerData->company.' Company </h2> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     
 
 <br>

      <input type="hidden" name="regNo" value="{{$buyerData->reg_no}}">
      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
      Buyer Name   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
     '.$buyerData->buyer_name.'
      </div>
      <br>

      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
      Comapny    &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;:&nbsp;
      '.$buyerData->company.' 
      </div>
      <br>

      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
      Total Purchased Price Up to Today   &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;:&nbsp; 
     Rs.<strong>'.$buyerData->total1.'</strong>
      </div>
      <br>
      
      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
     Email Address  &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
     '.$buyerData->email.'
      </div>
      <br>

      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
      Address    &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;:&nbsp; 
     '.$buyerData->address.'
      </div>
      <br>

      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
     District   &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;:&nbsp;
     '.$buyerData->district.' 
      </div>
      <br>

      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
     Mobile Number   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
     '.$buyerData->mobile.' 
    
      </div>
      <br>

      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
      Land Number  &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
     '.$buyerData->land.'
      </div>
      <br>


      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
      Bank  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
     '.$buyerData->bank_name.' 
    
      </div>
      <br>

      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
      Account Number &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
     '.$buyerData->acc_num.'
      </div>
      <br>


      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
      Credit Days &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
    '.$buyerData->credit_days.'
    
      </div>
     
      <br>
      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
      Discount  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
     '.$buyerData->discount.'%
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
     
      

      
      
      
      ';
  }

  return $output;
     
  }
      

        

        
    


}

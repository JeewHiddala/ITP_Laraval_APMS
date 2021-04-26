<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\foreignSupplier;
use DB;

class foreignSupplierController extends Controller
{
    //
    public function stroeForeignSupplier(Request $request){

        $fSupplier = new foreignSupplier;

        $this->validate($request,[
 
            'foreignSupName'=>'required|max:100|min:5',
   
   
   
   
          ]);

    //Object->column name in the table =$request->the name that is coming from the request
    $fSupplier->foreign_sup_name=$request->foreignSupName;
    $fSupplier->f_company=$request->fcompany;
    $fSupplier->f_email=$request->femail;
    $fSupplier->f_address=$request->faddress;
    $fSupplier->f_mobile=$request->fmobile;
    $fSupplier->f_land=$request->fland;
    $fSupplier->f_bank_name=$request->fbankName;
    $fSupplier->f_acc_num=$request->faccNo;
    $fSupplier->f_credit_days=$request->fcreditDays;
   
    $fSupplier->save();

    $foreignSupData=foreignSupplier::all();
    //dd($foreignSupData);

   // return view('foreignSupplier')->with('foreignSupplier', $foreignSupData);
    return redirect('/foreignSupplierHome') ->with('foreignSupplier', $foreignSupData);

 
    }

    public function deleteForeignSupplier($reg_no){

        $fSupplier=foreignSupplier::find($reg_no);
        $fSupplier->delete();
        return redirect()->back();

    }

    public function updateForeignSupplierView($reg_no){

       
        $fSupplier=foreignSupplier::find($reg_no);
        return view('updateForeignSupplier')->with('foreignSupData', $fSupplier);
    }

    public function updateForeignSupplierData(Request $request){

        $reg_no=$request->regNo;
        $name=$request->foreignSupName;
        $company=$request->fcompany;
        $email=$request->femail;
        $address=$request->faddress;
        $mobile=$request->fmobile;
        $land=$request->fland;
        $bank_name=$request->fbankName;
        $acc_num=$request->faccNo;
        $credit_days=$request->fcreditDays;

        $fSupplier=foreignSupplier::find($reg_no);

        $fSupplier->foreign_sup_name=$name;
        $fSupplier->f_company=$company;
        $fSupplier->f_email=$email;
        $fSupplier->f_address=$address;
        $fSupplier->f_mobile=$mobile;
        $fSupplier->f_land=$land;
        $fSupplier->f_bank_name=$bank_name;
        $fSupplier->f_acc_num=$acc_num;
        $fSupplier->f_credit_days=$credit_days;

        $fSupplier->save();

        $foreignSupplier=foreignSupplier::all();
 
       // return view('foreignSupplier')->with('foreignSupplier',  $foreignSupplier);
        return redirect('/foreignSupplierHome') ->with('foreignSupplier', $foreignSupplier);
       
       

    }

    public function searchForeignSup(Request $request){

        $search = $request->get('searchForeign');
        $posts = foreignSupplier::where('foreign_sup_name','like','%'.$search.'%')->paginate(10);
        return view('searchResultForeign' , ['posts'=> $posts]);
  
    }

    public function searchfSupPDF(Request $request){

      $search = $request->get('searchForeignPDF');
      $posts = foreignSupplier::where('foreign_sup_name','like','%'.$search.'%')->paginate(10);
      return view('foreignSupPDFresult' , ['posts'=> $posts]);

  }

    public function bestFSupplier(){

        $data = DB::table('goods_receives')
        ->join('items','items.item_no','i_no')
        ->join('foreign_suppliers','foreign_suppliers.reg_no','f_sup_no')
        ->select ('foreign_suppliers.reg_no','foreign_suppliers.foreign_sup_name',DB::raw('sum(items.cost * goods_receives.receive_quantity) as total'),DB::raw('sum(goods_receives.receive_quantity) as amount'))
        ->groupBy('foreign_suppliers.reg_no','foreign_suppliers.foreign_sup_name')
        ->orderBy('total', 'asc')
        ->orderBy('amount', 'desc')
        ->take (5)
        ->get();
       // dd($data);
      
       

    
     return view('/foreignSupplierEvaluate',['data' =>$data]);
       //return view('/buyerEvaluate')->with( 'data', $data  );
       // return view('buyerEvaluate')->with('wholeSaleBuyer',$buyerData);
    }


    

    function   pdf_singleEforeignbSupplier($reg_no){

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->convert_SingleEforeignSupplier_data_to_html($reg_no));
        return $pdf->stream();//Using this method we can show the pdf file in the browser

}

function convert_SingleEforeignSupplier_data_to_html($no){

  $png = file_get_contents("logo.png");
  $pngBase64 = base64_encode($png);
  date_default_timezone_set('Asia/Colombo');
  $date = date('m.d.Y', time());
    $supplier_data = DB::table('goods_receives')
    ->join('items','items.item_no','i_no')
    ->join('foreign_suppliers','foreign_suppliers.reg_no','f_sup_no')
    ->select ('foreign_suppliers.reg_no','foreign_suppliers.foreign_sup_name','foreign_suppliers.f_address','foreign_suppliers.f_company',DB::raw('sum(items.cost * goods_receives.receive_quantity) as total'),DB::raw('sum(goods_receives.receive_quantity) as amount'))
    ->groupBy('foreign_suppliers.reg_no','foreign_suppliers.foreign_sup_name','foreign_suppliers.f_address','foreign_suppliers.f_company')
    ->orderBy('total', 'asc')
    ->orderBy('amount', 'desc')
    ->where ('foreign_suppliers.reg_no','=',$no)
   // ->take (5)
    ->get();


    


  
    $output = ' 
    
        
    
      
      
     
     
       
    ';
    foreach($supplier_data as $supplier)
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
        '.$supplier->foreign_sup_name.'<br>
        '.$supplier->f_company.'<br>
        '.$supplier->f_address.'<br>
        '.$date.'<br><br>
          

        

       Dear '.$supplier->foreign_sup_name.',
       <br>

       <h2 align="center">Congratulations</h2>

       <h3>Your "'.$supplier->f_company.'"  company has been choosen as one of best Suppliers of our company</h3>
       
    <p align = "justify">
       We would like to extend our appreciation and gratitude toward you and your company for beign a loyal Supplier of our Auto Parts Managment System Company.
        <br><br>
      In the presence of numerous companies , we always choose you and you show your trust for the deals.
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

   
    function  index_fsupplier(){

      $fSupplier_data = $this->get_fSupplier_data();
      return view('dynamic_pdf_foreign_supplier')->with('fSupplier_data',$fSupplier_data);
      
  }

  function get_fSupplier_data(){

    $fSupplir_data = DB::table('foreign_suppliers')
                    ->limit(10)
                    ->get();//returns the result in an array format
    return  $fSupplir_data;

}

function pdf_foreignSuppliers(){

  $pdf = \App::make('dompdf.wrapper');
  $pdf->loadHTML($this->convert_foreign_suppliers_data_to_html());
  return $pdf->stream();//Using this method we can show the pdf file in the browser

}

function convert_foreign_suppliers_data_to_html(){

  $fsupplier_data = $this->get_fSupplier_data();
  $png = file_get_contents("images/logo.png");
  $pngBase64 = base64_encode($png);
  date_default_timezone_set('Asia/Colombo');
  $date = date('m/d/Y h:i:s a', time());
  $output = ' <head>
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
  <h3 align="center">Registered Foreign Suppliers of the Ranjith Auto Parts Company</h3>
  <br>
  <table style="border-collapse:collapse; border: 0px;">
  <tr>
    =
    <th style="border: 1px solid;" width="1px">Reg_No</th>
      <th style="border: 1px solid;" width="1px">Name</th>
      <th style="border: 1px solid;">Company</th>
      <th style="border: 1px solid;" width="1px">Email</th>
      <th style="border: 1px solid;">Address</th>
   
      <th style="border: 1px solid;">Mobile Number</th>
    
   
   
     
  </tr>';
  foreach($fsupplier_data as $fSupplier)
  {
      $output .='
      <tr>
      <td style="border: 1px solid;">'.$fSupplier->reg_no.'</td>
      <td style="border: 1px solid;"  width="1px">'.$fSupplier->foreign_sup_name.'</td>
      <td style="border: 1px solid;">'.$fSupplier->f_company.'</td>
      <td style="border: 1px solid;" width="1px">'.$fSupplier->f_email.'</td>
      <td style="border: 1px solid;">'.$fSupplier->f_address.'</td>
    
      <td style="border: 1px solid;">'.$fSupplier->f_mobile.'</td>
    
      
      
      </tr>
      
      ';
  }
 $output .='</table>  <div class="footer">
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


public function singleForeignSupplierProfileView($reg_no){

  //$wBuyer=wholeSaleBuyer::find($reg_no);
  $fsupplier_data = DB::table('goods_receives')
    ->join('items','items.item_no','i_no')
    ->join('foreign_suppliers','foreign_suppliers.reg_no','f_sup_no')
    ->select ('foreign_suppliers.reg_no','foreign_suppliers.foreign_sup_name','foreign_suppliers.f_address','foreign_suppliers.f_company','foreign_suppliers.f_email','foreign_suppliers.f_mobile','foreign_suppliers.f_land','foreign_suppliers.f_bank_name','foreign_suppliers.f_acc_num','foreign_suppliers.f_credit_days','foreign_suppliers.created_at','foreign_suppliers.updated_at',DB::raw('sum(items.cost * goods_receives.receive_quantity) as total'),DB::raw('sum(goods_receives.receive_quantity) as amount'))
    ->groupBy('foreign_suppliers.reg_no','foreign_suppliers.foreign_sup_name','foreign_suppliers.f_address','foreign_suppliers.f_company','foreign_suppliers.f_email','foreign_suppliers.f_mobile','foreign_suppliers.f_land','foreign_suppliers.f_bank_name','foreign_suppliers.f_acc_num','foreign_suppliers.f_credit_days','foreign_suppliers.created_at','foreign_suppliers.updated_at')
    ->orderBy('total', 'asc')
    ->orderBy('amount', 'desc')
    ->where ('foreign_suppliers.reg_no','=',$reg_no)
   // ->take (5)
    ->get();





 // dd($wBuyer);
// return view('singleBuyerProfile')->with('buyerData', $wBuyer);
return view('/singleForeignSupplierProfile',['fsupplier_data' => $fsupplier_data]);



}


function  pdf_singleForeignSupplier($reg_no){

  $pdf = \App::make('dompdf.wrapper');
  $pdf->loadHTML($this->convert_SingleForeignSupplier_data_to_html($reg_no));
  return $pdf->stream();//Using this method we can show the pdf file in the browser

}



function convert_SingleForeignSupplier_data_to_html($reg_no)
{
  $png = file_get_contents("logo.png");
  $pngBase64 = base64_encode($png);
  $ldate = date('Y-m-d H:i:s');
  date_default_timezone_set('Asia/Colombo');
  $date = date('m/d/Y h:i:s a', time());

  $fsupplier_data = DB::table('goods_receives')
  ->join('items','items.item_no','i_no')
  ->join('foreign_suppliers','foreign_suppliers.reg_no','f_sup_no')
  ->select ('foreign_suppliers.reg_no','foreign_suppliers.foreign_sup_name','foreign_suppliers.f_address','foreign_suppliers.f_company','foreign_suppliers.f_email','foreign_suppliers.f_mobile','foreign_suppliers.f_land','foreign_suppliers.f_bank_name','foreign_suppliers.f_acc_num','foreign_suppliers.f_credit_days','foreign_suppliers.created_at','foreign_suppliers.updated_at',DB::raw('sum(items.cost * goods_receives.receive_quantity) as total'),DB::raw('sum(goods_receives.receive_quantity) as amount'))
  ->groupBy('foreign_suppliers.reg_no','foreign_suppliers.foreign_sup_name','foreign_suppliers.f_address','foreign_suppliers.f_company','foreign_suppliers.f_email','foreign_suppliers.f_mobile','foreign_suppliers.f_land','foreign_suppliers.f_bank_name','foreign_suppliers.f_acc_num','foreign_suppliers.f_credit_days','foreign_suppliers.created_at','foreign_suppliers.updated_at')
  ->orderBy('total', 'asc')
  ->orderBy('amount', 'desc')
  ->where ('foreign_suppliers.reg_no','=',$reg_no)
 // ->take (5)
  ->get();
      $output = ' 
  
   ';
  foreach( $fsupplier_data as $buyerData)
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

    
    
     <h3 style="float:center;">Foreign Supplier Profile Report</h3>
     <br><br>
 
    
      
      <h2>'.$buyerData->foreign_sup_name.' - '.$buyerData->f_company.' Company </h2> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    
      
      <br>

      <input type="hidden" name="regNo" value="{{$buyerData->reg_no}}">
      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
      Buyer Name   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
     '.$buyerData->foreign_sup_name.'
      </div>
      <br>

      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
      Comapny    &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;:&nbsp;
      '.$buyerData->f_company.' 
      </div>
      <br>

      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
      Total Number of Supplied Items    &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;:&nbsp;&nbsp;  
     <strong>'.$buyerData->amount.'</strong>
      </div>
      <br>

      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
      Total Purchased Price Up to Today &nbsp;&nbsp;&nbsp;: &nbsp; 
     <strong>Rs.'.$buyerData->total.'</strong>
      </div>
      <br>


      
      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
     Email Address  &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;:&nbsp;
     '.$buyerData->f_email.'
      </div>
      <br>

      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
      Address    &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;:&nbsp; 
     '.$buyerData->f_address.'
      </div>
      <br>

     

      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
     Mobile Number   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
     '.$buyerData->f_mobile.' 
    
      </div>
      <br>

      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
      Land Number   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
     '.$buyerData->f_land.'
      </div>
      <br>


      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
      Bank  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
     '.$buyerData->f_bank_name.' 
    
      </div>
      <br>

      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
      Account Number &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
     '.$buyerData->f_acc_num.'
      </div>
      <br>


      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
      Credit Days  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
    '.$buyerData->f_credit_days.'
    
      </div>
      <br>

      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
     Registered Date  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
    '.$buyerData->created_at.'
    
      </div>

      <br>
     
      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
    Last Data Updated At &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;
    '.$buyerData->updated_at.'
    
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
  }

  return $output;
     
  }
      


}

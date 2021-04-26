<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;
class unavailablePdfController extends Controller
{
    function index()
    {
        $customer_data = $this->get_customer_data();
        return view('unavailablePDF')-> with('customer_data' , $customer_data);
    }

    function get_customer_data()
    {
        $customer_data = DB::table('unavailable_items')
                        ->limit(3)
                        ->get();
        return $customer_data;
    }

    function pdf()
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->convert_customer_data_to_html());

        return $pdf->stream();
    }

    function convert_customer_data_to_html(){

        $customer_data = $this->get_customer_data();
        $png = file_get_contents("images/logo.png");
        $pngBase64 = base64_encode($png);
        date_default_timezone_set('Asia/Colombo');
        $date = date('m/d/Y h:i:s a', time());
        $output = '
        <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Unavailabe Items Report</title>
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
  <h3 align="center">Unavailable Items Report</h3>
  <br>
  <table style="border-collapse:collapse; border: 0px;">
  <tr>


    <th style="border: 1px solid;" width="1px">ID</th>
    <th style="border: 1px solid;">Item No</th>
    <th style="border: 1px solid;">Date</th>
    <th style="border: 1px solid;">Postal Model</th>
    <th style="border: 1px solid;">Customer Name</th>
    <th style="border: 1px solid;">Phone</th>
    <th style="border: 1px solid;">Sales Person</th>
</tr>
        ';
        foreach($customer_data as $customer)
        {
            $output .= '
      <tr>
       <td style="border: 1px solid; padding:12px;">'.$customer->id.'</td>
       <td style="border: 1px solid; padding:12px;">'.$customer->ItemNo.'</td>
       <td style="border: 1px solid; padding:12px;">'.$customer->Date.'</td>
       <td style="border: 1px solid; padding:12px;">'.$customer->Model.'</td>
       <td style="border: 1px solid; padding:12px;">'.$customer->customerName.'</td>
       <td style="border: 1px solid; padding:12px;">'.$customer->phone.'</td>
       <td style="border: 1px solid; padding:12px;">'.$customer->salesperson.'</td>
      </tr>
      ';
        }
        $output .= '</table>  <div class="footer">
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
}

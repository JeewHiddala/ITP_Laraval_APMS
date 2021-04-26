<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;

class DynamicPDFController extends Controller
{
    function courier_services()
    {
        $delivery_c_data = $this->get_courier_service_data();
       // return view('report_about_deliver_through_company_vehicles')->with('delivery_c_data',$delivery_c_data);
    }

    function get_courier_service_data(){

        $data = DB::table('courier_services')
        ->get();


        return $data;
    }


    function Courierpdf()
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->convert_courier_service_data_to_html());
        return $pdf->stream();
    }

    function convert_courier_service_data_to_html()
    {
        $c_data = $this->get_courier_service_data();

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
                    <span class="site-heading-lower" style="color:#e6a756">Ranjith Motors & Auto Parts</span>
                </h1>
                <br>
                    <h5 style = "float:left;"> Address : Colombo Road, Dambokka, Kurunegala, Srilanka 600000</h5>
                    <h5 style = "float:right;"> Telephone: +94 372231201/+94 372222902</h5>
                    <br><br>
                <hr>

        <p style = "float:right;"> Date and Time : '.$date.'</p><br>
        <h3>Currently Registered Courier Services</h3><br>
        <table width="100%" style="border-collapse: collapse; border: 0px;">
        <tr>
            <th style="border: 1px solid; padding:4px;">ID</th>
            <th style="border: 1px solid; padding:4px;">Company Name</th>
            <th style="border: 1px solid; padding:4px;">Address</th>
            <th style="border: 1px solid; padding:4px;">District</th>
            <th style="border: 1px solid; padding:4px;">Land</th>
            <th style="border: 1px solid; padding:4px;">Mobile</th>
            <th style="border: 1px solid; padding:4px;">Fax</th>
            <th style="border: 1px solid; padding:4px;">E-mail</th>
        </tr>
            ';

            foreach($c_data as $data)
            {
            $output .= '
            <tr>
                <td style="border: 1px solid; padding:4px;">'.$data->id.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->company_name.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->address.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->district.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->land.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->mobile.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->fax.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->e_mail.'</td>
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

            /*foreach($data1 as $data){
            $output .= '<br><p style="float:right">Total Delivery Cost : '.$data->d_total.'</p>';
            }*/

            return $output;        
    }

    function RPCompanyPDF($from_date,$to_date)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->RCompanyPDF($from_date,$to_date));
        return $pdf->stream();
    }


    function RCompanyPDF($from_date,$to_date)
    {
        if($from_date != "Not Mentioned"){

        $data = DB::table('deliver_through_company_vehicles')
        ->join('deliveries','deliveries.id','deliver_through_company_vehicles.delivery_id')
        ->join('whole_sale_buyers','whole_sale_buyers.reg_no','buyer_id')
        ->join('emp_details','emp_details.employee_id','deliver_through_company_vehicles.driver_id')
        ->join('vehicles','vehicles.id','deliver_through_company_vehicles.vehicle_id')
        ->select(['deliveries.id','deliveries.invoice_id','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.email','emp_details.name','vehicles.vehi_reg_no','deliveries.date','deliveries.total'])
        ->whereBetween('deliveries.date', array($from_date, $to_date))
        ->get();

        $total = DB::table('deliver_through_company_vehicles')
        ->join('deliveries','deliveries.id','deliver_through_company_vehicles.delivery_id')
        ->select([DB::raw('Sum(deliveries.total) OVER () AS total_cost')])
        ->whereBetween('deliveries.date', array($from_date, $to_date))
        ->value('total_cost');

        }
        else
        {
            $data = DB::table('deliver_through_company_vehicles')
            ->join('deliveries','deliveries.id','deliver_through_company_vehicles.delivery_id')
            ->join('whole_sale_buyers','whole_sale_buyers.reg_no','buyer_id')
            ->join('emp_details','emp_details.employee_id','deliver_through_company_vehicles.driver_id')
            ->join('vehicles','vehicles.id','deliver_through_company_vehicles.vehicle_id')
            ->select(['deliveries.id','deliveries.invoice_id','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.email','emp_details.name','vehicles.vehi_reg_no','deliveries.date','deliveries.total'])
            ->get();

            $total = DB::table('deliver_through_company_vehicles')
            ->join('deliveries','deliveries.id','deliver_through_company_vehicles.delivery_id')
            ->select([DB::raw('Sum(deliveries.total) OVER () AS total_cost')])
            ->value('total_cost');

            //dd($from_date);

        }

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
                    <span class="site-heading-lower" style="color:#e6a756">Ranjith Motors & Auto Parts</span>
                </h1>
                <br>
                    <h5 style = "float:left;"> Address : Colombo Road, Dambokka, Kurunegala, Srilanka 600000</h5>
                    <h5 style = "float:right;"> Telephone: +94 372231201/+94 372222902</h5>
                    <br><br>
                <hr>
         
        
        
        
        
        
        
        
        <p style = "float:right;"> Date and Time : '.$date.'</p><br>


        <h3>Delivery Report | Company Vehicles</h3>
        <p>For the period starting from <b><i>'.$from_date.'</i></b> to <b><i>'.$to_date.'</b></i></p>
        <table width="100%" style="border-collapse: collapse; border: 0px;">
        <tr>
            <th style="border: 1px solid; padding:4px;">Invoice ID</th>
            <th style="border: 1px solid; padding:4px;">Buyer Name</th>
            <th style="border: 1px solid; padding:4px;">Address</th>
            <th style="border: 1px solid; padding:4px;">Mobile</th>
            <th style="border: 1px solid; padding:4px;">E-mail</th>
            <th style="border: 1px solid; padding:4px;">Driver</th>
            <th style="border: 1px solid; padding:4px;">Vehicle No</th>
            <th style="border: 1px solid; padding:4px;">Date</th>
            <th style="border: 1px solid; padding:4px;">Total</th>
        </tr>
            ';

            foreach($data as $data)
            {
            $output .= '
            <tr>
                <td style="border: 1px solid; padding:4px;">'.$data->invoice_id.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->buyer_name.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->address.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->mobile.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->email.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->name.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->vehi_reg_no.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->date.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->total.'</td>
            </tr>
            
            ';
            }
            $output .= '
            <tbody></tbody>
            <tfoot>
                <tr id = "rowid">
                    <th colspan="8" style="text-align:right; border: 1px solid; padding:4px;">Total:</th>
                    <th id = "total_cost" class = "id" style="border: 1px solid; padding:4px;">'.$total.'</th>
                </tr>
            </tfoot>
            ';
            
            
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

            /*foreach($data1 as $data){
            $output .= '<br><p style="float:right">Total Delivery Cost : '.$data->d_total.'</p>';
            }*/

            return $output;      
    }


//Report Delivery By Courier Services

function RPCourierPDF($from_date,$to_date)
{
    $pdf = \App::make('dompdf.wrapper');
    $pdf->loadHTML($this->RCourierPDF($from_date,$to_date));
    return $pdf->stream();
}


function RCourierPDF($from_date,$to_date)
{
    if($from_date != "Not Mentioned"){

        $data = DB::table('deliver_through_courier_services')
        ->join('deliveries','deliveries.id','deliver_through_courier_services.delivery_id')
       ->join('whole_sale_buyers','whole_sale_buyers.reg_no','deliveries.buyer_id')
       ->join('courier_services','courier_services.id','deliver_through_courier_services.courier_id')
       ->select('deliveries.id','deliveries.invoice_id','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.email','courier_services.company_name','deliveries.date','deliveries.total')
       ->whereBetween('deliveries.date', array($from_date, $to_date))
       ->get();

       $total = DB::table('deliver_through_courier_services')
       ->join('deliveries','deliveries.id','deliver_through_courier_services.delivery_id')
       ->select([DB::raw('Sum(deliveries.total) OVER () AS total_cost')])
       ->whereBetween('deliveries.date', array($from_date, $to_date))
       ->value('total_cost');


    }
    else
    {
        $data = DB::table('deliver_through_courier_services')
        ->join('deliveries','deliveries.id','deliver_through_courier_services.delivery_id')
       ->join('whole_sale_buyers','whole_sale_buyers.reg_no','deliveries.buyer_id')
       ->join('courier_services','courier_services.id','deliver_through_courier_services.courier_id')
       ->select('deliveries.id','deliveries.invoice_id','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.email','courier_services.company_name','deliveries.date','deliveries.total')
       ->get();

       $total = DB::table('deliver_through_courier_services')
       ->join('deliveries','deliveries.id','deliver_through_courier_services.delivery_id')
       ->select([DB::raw('Sum(deliveries.total) OVER () AS total_cost')])
       ->value('total_cost');

        //dd($from_date);

    }

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
                <span class="site-heading-lower" style="color:#e6a756">Ranjith Motors & Auto Parts</span>
            </h1>
            <br>
                <h5 style = "float:left;"> Address : Colombo Road, Dambokka, Kurunegala, Srilanka 600000</h5>
                <h5 style = "float:right;"> Telephone: +94 372231201/+94 372222902</h5>
                <br><br>
            <hr>
     
    
    
    
    
    
    
    
    <p style = "float:right;"> Date and Time : '.$date.'</p><br>

    <h3>Delivery Report | Courier Services</h3>
    <p>For the period starting from <b><i>'.$from_date.'</i></b> to <b><i>'.$to_date.'</b></i></p>
    <table width="100%" style="border-collapse: collapse; border: 0px;">
    <tr>
        <th style="border: 1px solid; padding:4px;">Invoice ID</th>
        <th style="border: 1px solid; padding:4px;">Buyer Name</th>
        <th style="border: 1px solid; padding:4px;">Address</th>
        <th style="border: 1px solid; padding:4px;">Mobile</th>
        <th style="border: 1px solid; padding:4px;">Land</th>
        <th style="border: 1px solid; padding:4px;">E-mail</th>
        <th style="border: 1px solid; padding:4px;">Courier Service</th>
        <th style="border: 1px solid; padding:4px;">Date</th>
        <th style="border: 1px solid; padding:4px;">Total</th>
    </tr>
        ';

        foreach($data as $data)
        {
        $output .= '
        <tr>
            <td style="border: 1px solid; padding:4px;">'.$data->invoice_id.'</td>
            <td style="border: 1px solid; padding:4px;">'.$data->buyer_name.'</td>
            <td style="border: 1px solid; padding:4px;">'.$data->address.'</td>
            <td style="border: 1px solid; padding:4px;">'.$data->mobile.'</td>
            <td style="border: 1px solid; padding:4px;">'.$data->land.'</td>
            <td style="border: 1px solid; padding:4px;">'.$data->email.'</td>
            <td style="border: 1px solid; padding:4px;">'.$data->company_name.'</td>
            <td style="border: 1px solid; padding:4px;">'.$data->date.'</td>
            <td style="border: 1px solid; padding:4px;">'.$data->total.'</td>
        </tr>
        
        ';
        }
        $output .= '
        <tbody></tbody>
        <tfoot>
            <tr id = "rowid">
                <th colspan="8" style="text-align:right; border: 1px solid; padding:4px;">Total:</th>
                <th id = "total_cost" class = "id" style="border: 1px solid; padding:4px;">'.$total.'</th>
            </tr>
        </tfoot>
        ';
        
        
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

        /*foreach($data1 as $data){
        $output .= '<br><p style="float:right">Total Delivery Cost : '.$data->d_total.'</p>';
        }*/

        return $output;      
}


//Delivery Report

function RPDeliveryPDF($from_date,$to_date)
{
    $pdf = \App::make('dompdf.wrapper');
    $pdf->loadHTML($this->RDeliveryPDF($from_date,$to_date));
    return $pdf->stream();
}


function RDeliveryPDF($from_date,$to_date)
{
    if($from_date != "Not Mentioned"){

        $data = DB::table('deliveries')
        ->join('whole_sale_buyers','whole_sale_buyers.reg_no','deliveries.buyer_id')
        ->select(['deliveries.id','deliveries.invoice_id','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.email','deliveries.date','deliveries.total'])
        ->whereBetween('deliveries.date', array($from_date, $to_date))
        ->get();

        $total = DB::table('deliveries')
        ->select([DB::raw('Sum(deliveries.total) OVER () AS total_cost')])
        ->whereBetween('deliveries.date', array($from_date, $to_date))
        ->value('total_cost');


    }
    else
    {
        $data = DB::table('deliveries')
        ->join('whole_sale_buyers','whole_sale_buyers.reg_no','deliveries.buyer_id')
        ->select(['deliveries.id','deliveries.invoice_id','whole_sale_buyers.buyer_name','whole_sale_buyers.address','whole_sale_buyers.mobile','whole_sale_buyers.land','whole_sale_buyers.email','deliveries.date','deliveries.total'])
        ->get();

        $total = DB::table('deliveries')
        ->select([DB::raw('Sum(deliveries.total) OVER () AS total_cost')])
        ->value('total_cost');

        //dd($from_date);

    }

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
                <span class="site-heading-lower" style="color:#e6a756">Ranjith Motors & Auto Parts</span>
            </h1>
            <br>
                <h5 style = "float:left;"> Address : Colombo Road, Dambokka, Kurunegala, Srilanka 600000</h5>
                <h5 style = "float:right;"> Telephone: +94 372231201/+94 372222902</h5>
                <br><br>
            <hr>
     
    
    
    
    
    
    
    
    <p style = "float:right;"> Date and Time : '.$date.'</p><br>

    <h3>Delivery Report</h3>
    <p>For the period starting from <b><i>'.$from_date.'</i></b> to <b><i>'.$to_date.'</b></i></p>
    <table width="100%" style="border-collapse: collapse; border: 0px;">
    <tr>
        <th style="border: 1px solid; padding:4px;">Invoice ID</th>
        <th style="border: 1px solid; padding:4px;">Buyer Name</th>
        <th style="border: 1px solid; padding:4px;">Address</th>
        <th style="border: 1px solid; padding:4px;">Mobile</th>
        <th style="border: 1px solid; padding:4px;">Land</th>
        <th style="border: 1px solid; padding:4px;">E-mail</th>
        <th style="border: 1px solid; padding:4px;">Date</th>
        <th style="border: 1px solid; padding:4px;">Total</th>
    </tr>
        ';

        foreach($data as $data)
        {
        $output .= '
        <tr>
            <td style="border: 1px solid; padding:4px;">'.$data->invoice_id.'</td>
            <td style="border: 1px solid; padding:4px;">'.$data->buyer_name.'</td>
            <td style="border: 1px solid; padding:4px;">'.$data->address.'</td>
            <td style="border: 1px solid; padding:4px;">'.$data->mobile.'</td>
            <td style="border: 1px solid; padding:4px;">'.$data->land.'</td>
            <td style="border: 1px solid; padding:4px;">'.$data->email.'</td>
            <td style="border: 1px solid; padding:4px;">'.$data->date.'</td>
            <td style="border: 1px solid; padding:4px;">'.$data->total.'</td>
        </tr>
        
        ';
        }
        $output .= '
        <tbody></tbody>
        <tfoot>
            <tr id = "rowid">
                <th colspan="7" style="text-align:right; border: 1px solid; padding:4px;">Total:</th>
                <th id = "total_cost" class = "id" style="border: 1px solid; padding:4px;">'.$total.'</th>
            </tr>
        </tfoot>
        ';
        
        
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

        /*foreach($data1 as $data){
        $output .= '<br><p style="float:right">Total Delivery Cost : '.$data->d_total.'</p>';
        }*/

        return $output;      
}



//Delivery Report

function RPVisitsPDF($from_date,$to_date)
{
    $pdf = \App::make('dompdf.wrapper');
    $pdf->loadHTML($this->RVisitsPDF($from_date,$to_date));
    return $pdf->stream();
}


function RVisitsPDF($from_date,$to_date)
{
    if($from_date != "Not Mentioned"){

        $data = DB::table('daily_visits')
        ->join('emp_details','emp_details.employee_id','driver_id')
        ->join('vehicles','vehicles.id','vehicle_id')
        ->select('daily_visits.id','daily_visits.date','daily_visits.departure','daily_visits.arrival','daily_visits.fuel','daily_visits.purpose','emp_details.name','vehicles.vehi_reg_no')
        ->whereBetween('daily_visits.date', array($from_date, $to_date))
        ->get();

        $total = DB::table('daily_visits')
        ->select([DB::raw('Sum(daily_visits.fuel) OVER () AS total_cost')])
        ->whereBetween('daily_visits.date', array($from_date, $to_date))
        ->value('total_cost');


    }
    else
    {
        $data = DB::table('daily_visits')
        ->join('emp_details','emp_details.employee_id','driver_id')
        ->join('vehicles','vehicles.id','vehicle_id')
        ->select('daily_visits.id','daily_visits.date','daily_visits.departure','daily_visits.arrival','daily_visits.fuel','daily_visits.purpose','emp_details.name','vehicles.vehi_reg_no')
        ->get();

        $total = DB::table('daily_visits')
        ->select([DB::raw('Sum(daily_visits.fuel) OVER () AS total_cost')])
        ->value('total_cost');

        //dd($from_date);

    }

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
                <span class="site-heading-lower" style="color:#e6a756">Ranjith Motors & Auto Parts</span>
            </h1>
            <br>
                <h5 style = "float:left;"> Address : Colombo Road, Dambokka, Kurunegala, Srilanka 600000</h5>
                <h5 style = "float:right;"> Telephone: +94 372231201/+94 372222902</h5>
                <br><br>
            <hr>
     
    
    
    
    
    
    
    
    <p style = "float:right;"> Date and Time : '.$date.'</p><br>

    <h3>Company Visits</h3>
    <p>For the period starting from <b><i>'.$from_date.'</i></b> to <b><i>'.$to_date.'</b></i></p>
    <table width="100%" style="border-collapse: collapse; border: 0px;">
    <tr>
        <th style="border: 1px solid; padding:4px;">Visit ID</th>
        <th style="border: 1px solid; padding:4px;">Date</th>
        <th style="border: 1px solid; padding:4px;">Departure Time</th>
        <th style="border: 1px solid; padding:4px;">Arrival Time</th>
        <th style="border: 1px solid; padding:4px;">Purpose</th>
        <th style="border: 1px solid; padding:4px;">Driver Name</th>
        <th style="border: 1px solid; padding:4px;">Vehicle No</th>
        <th style="border: 1px solid; padding:4px;">Fuel Cost</th>
    </tr>
        ';

        foreach($data as $datas)
        {
        $output .= '
        <tr>
            <td style="border: 1px solid; padding:4px;">'.$datas->id.'</td>
            <td style="border: 1px solid; padding:4px;">'.$datas->date.'</td>
            <td style="border: 1px solid; padding:4px;">'.$datas->departure.'</td>
            <td style="border: 1px solid; padding:4px;">'.$datas->arrival.'</td>
            <td style="border: 1px solid; padding:4px;">'.$datas->purpose.'</td>
            <td style="border: 1px solid; padding:4px;">'.$datas->name.'</td>
            <td style="border: 1px solid; padding:4px;">'.$datas->vehi_reg_no.'</td>
            <td style="border: 1px solid; padding:4px;">'.$datas->fuel.'</td>
        </tr>
        
        ';
        }
        $output .= '
        <tbody></tbody>
        <tfoot>
            <tr id = "rowid">
                <th colspan="7" style="text-align:right; border: 1px solid; padding:4px;">Total:</th>
                <th id = "total_cost" class = "id" style="border: 1px solid; padding:4px;">'.$total.'</th>
            </tr>
        </tfoot>
        ';
        
        
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

        /*foreach($data1 as $data){
        $output .= '<br><p style="float:right">Total Delivery Cost : '.$data->d_total.'</p>';
        }*/

        return $output;      
}


}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vehicle;
use App\EmpDetails;
use App\VehicleMaintenance;
use DB;
use PDF;

class VehicleMaintenancePDFController extends Controller
{
    
    //root method of the class
    function index(){
        $Vehicle_maintainance_data = $this->get_vehicle_maintainance_data(); 
        return view('vehiclemaintainancePDF')->with('Vehicle_maintainance_data', $Vehicle_maintainance_data);   
    }

    function get_vehicle_maintainance_data(){

        $Vehicle_maintainance_data = DB::table('vehicle_maintenances')
        ->join('vehicles','vehicles.id','reg_id')
        ->join('emp_details','emp_details.employee_id','vehicle_maintenances.employee_id')
        ->select('vehicle_maintenances.maintenance_id','vehicle_maintenances.reg_id','vehicle_maintenances.maintenance_type','vehicle_maintenances.cost','vehicle_maintenances.maintenance_date','vehicle_maintenances.employee_id','vehicle_maintenances.company_name','vehicle_maintenances.contact_no','emp_details.name','vehicles.vehi_reg_no')
        ->limit(10)
        ->get();

        return $Vehicle_maintainance_data;

    }

    function pdf($from_date,$to_date){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->convert_vehicle_maintainance_data_to_html($from_date,$to_date));
        return $pdf->stream();
    }

    function convert_vehicle_maintainance_data_to_html($from_date,$to_date){
        
        if($from_date != 0){

            $data = DB::table('vehicle_maintenances')
            ->join('vehicles','vehicles.id','reg_id')
            ->join('emp_details','emp_details.employee_id','vehicle_maintenances.employee_id')
            ->select('vehicle_maintenances.maintenance_id','vehicle_maintenances.reg_id','vehicle_maintenances.maintenance_type','vehicle_maintenances.cost','vehicle_maintenances.maintenance_date','vehicle_maintenances.employee_id','vehicle_maintenances.company_name','vehicle_maintenances.contact_no','emp_details.name','vehicles.vehi_reg_no')
           ->whereBetween('vehicle_maintenances.maintenance_date', array($from_date, $to_date))
           ->get();
    
           $total = DB::table('vehicle_maintenances')
        //    ->join('machineries','machineries.id','reg_id')
           ->select([DB::raw('Sum(vehicle_maintenances.cost) OVER () AS total_cost')])
           ->whereBetween('vehicle_maintenances.maintenance_date', array($from_date, $to_date))
           ->value('total_cost');
    
    
        }
        else
        {
            $data = DB::table('vehicle_maintenances')
            ->join('vehicles','vehicles.id','reg_id')
            ->join('emp_details','emp_details.employee_id','vehicle_maintenances.employee_id')
            ->select('vehicle_maintenances.maintenance_id','vehicle_maintenances.reg_id','vehicle_maintenances.maintenance_type','vehicle_maintenances.cost','vehicle_maintenances.maintenance_date','vehicle_maintenances.employee_id','vehicle_maintenances.company_name','vehicle_maintenances.contact_no','emp_details.name','vehicles.vehi_reg_no')
           ->get();
    
           $total = DB::table('vehicle_maintenances')
        //    ->join('machineries','machineries.id','reg_id')
           ->select([DB::raw('Sum(vehicle_maintenances.cost) OVER () AS total_cost')])
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
        <title>Resource Management</title>
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
    
        <h3>Maintenance Report | Vehicle Maintenance</h3>
        <p>For the period starting from <b><i>'.$from_date.'</i></b> to <b><i>'.$to_date.'</b></i></p>
        <table width="100%" style="border-collapse: collapse; border: 0px;">
        <tr>
            <th style="border: 1px solid; padding:4px;">Vehicle Maintenance List Number</th>
            <th style="border: 1px solid; padding:4px;">Vehicle Registration Number</th>
            <th style="border: 1px solid; padding:4px;">Maintenance Type</th>
            <th style="border: 1px solid; padding:4px;">Employee Name</th>
            <th style="border: 1px solid; padding:4px;">Date</th>
            <th style="border: 1px solid; padding:4px;">Company Name</th>
            <th style="border: 1px solid; padding:4px;">Contact No</th>
            <th style="border: 1px solid; padding:4px;">Cost</th>

        </tr>
            ';
    
            foreach($data as $data)
            {
            $output .= '
            <tr>
                <td style="border: 1px solid; padding:4px;">'.$data->maintenance_id.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->vehi_reg_no.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->maintenance_type.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->name.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->maintenance_date.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->company_name.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->contact_no.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->cost.'</td>

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

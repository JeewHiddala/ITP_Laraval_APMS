<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Machinery;
use App\EmpDetails;
use App\MachineryUsageLog;
use DB;
use PDF;

class MachineryUsageLogPDFController extends Controller
{
    
    //root method of the class
    function index(){
        $machinery_usage_log_data = $this->get_machinery_usage_log_data(); 
        return view('machineryusagelogPDF')->with('machinery_usage_log_data', $machinery_usage_log_data);   
    }

    function get_machinery_usage_log_data(){

        $machinery_usage_log_data = DB::table('machinery_usage_logs')
        ->join('machineries','machineries.id','reg_id')
        ->join('emp_details','emp_details.employee_id','machinery_usage_logs.employee_id')
        ->select('machinery_usage_logs.log_no','machinery_usage_logs.reg_id','machinery_usage_logs.employee_id','machinery_usage_logs.section','machinery_usage_logs.start_date','machinery_usage_logs.start_time','machinery_usage_logs.estimated_end_date','machinery_usage_logs.estimated_end_time','emp_details.name','machineries.model_no')
        ->limit(10)
        ->get();

        return $machinery_usage_log_data;

    }

    function pdf($from_date,$to_date){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->convert_machinery_usage_log_data_to_html($from_date,$to_date));
        return $pdf->stream();
    }

    function convert_machinery_usage_log_data_to_html($from_date,$to_date){
        
        if($from_date != 0){

            $data = DB::table('machinery_usage_logs')
            ->join('machineries','machineries.id','reg_id')
            ->join('emp_details','emp_details.employee_id','machinery_usage_logs.employee_id')
            ->select('machinery_usage_logs.log_no','machinery_usage_logs.reg_id','machinery_usage_logs.employee_id','machinery_usage_logs.section','machinery_usage_logs.start_date','machinery_usage_logs.start_time','machinery_usage_logs.estimated_end_date','machinery_usage_logs.estimated_end_time','emp_details.name','machineries.model_no')
           ->whereBetween('machinery_usage_logs.start_date', array($from_date, $to_date))
           ->get();
    
        //    $total = DB::table('machinery_usage_logs')
        // //    ->join('machineries','machineries.id','reg_id')
        //    ->select([DB::raw('Sum(machinery_maintenances.cost) OVER () AS total_cost')])
        //    ->whereBetween('machinery_maintenances.maintenance_date', array($from_date, $to_date))
        //    ->value('total_cost');
    
    
        }
        else
        {
            $data = DB::table('machinery_usage_logs')
            ->join('machineries','machineries.id','reg_id')
            ->join('emp_details','emp_details.employee_id','machinery_usage_logs.employee_id')
            ->select('machinery_usage_logs.log_no','machinery_usage_logs.reg_id','machinery_usage_logs.employee_id','machinery_usage_logs.section','machinery_usage_logs.start_date','machinery_usage_logs.start_time','machinery_usage_logs.estimated_end_date','machinery_usage_logs.estimated_end_time','emp_details.name','machineries.model_no')
           ->get();
    
        //    $total = DB::table('machinery_usage_logs')
        // //    ->join('machineries','machineries.id','reg_id')
        //    ->select([DB::raw('Sum(machinery_maintenances.cost) OVER () AS total_cost')])
        //    ->value('total_cost');
    
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
    
        <h3>Usage Log Report | Machinery Usage Log</h3>
        <p>For the period starting from <b><i>'.$from_date.'</i></b> to <b><i>'.$to_date.'</b></i></p>
        <table width="100%" style="border-collapse: collapse; border: 0px;">
        <tr>
            <th style="border: 1px solid; padding:4px;">Log No</th>
            <th style="border: 1px solid; padding:4px;">Machinery Register No</th>
            <th style="border: 1px solid; padding:4px;">Section</th>
            <th style="border: 1px solid; padding:4px;">Employee Name</th>
            <th style="border: 1px solid; padding:4px;">Start Date</th>
            <th style="border: 1px solid; padding:4px;">Start Time</th>
            <th style="border: 1px solid; padding:4px;">Estimated Ending Date</th>
            <th style="border: 1px solid; padding:4px;">Estimated Ending Time</th>

        </tr>
            ';
    
            foreach($data as $data)
            {
            $output .= '
            <tr>
                <td style="border: 1px solid; padding:4px;">'.$data->log_no.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->model_no.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->section.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->name.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->start_date.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->start_time.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->estimated_end_date.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->estimated_end_time.'</td>

            </tr>
            
            ';
            }
            $output .= '
            <tbody></tbody>
            <tfoot>
                <tr id = "rowid">
                    <th colspan="7" style="text-align:right; border: 1px solid; padding:4px;"></th>
                    <th id = "total_cost" class = "id" style="border: 1px solid; padding:4px;"></th>
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


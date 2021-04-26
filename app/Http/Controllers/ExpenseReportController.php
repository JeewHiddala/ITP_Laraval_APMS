<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF; //to convert html to pdf

class ExpenseReportController extends Controller
{
    //
    function ExpensePDF($fromDate, $toDate)
    {
        // dd($fromDate);
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->GeneratePDF($fromDate, $toDate));
        $docName = "Expense Report"; //Giving a name to the report appear after download
        return $pdf->stream($docName." ".$fromDate." to ".$toDate.".pdf");
    }


    function GeneratePDF($fromDate, $toDate)
    {
        if($fromDate != "Select Date from the picker"){
            //fetching data from the table according to the dates given
            $data = DB::table('expenses')
                ->whereBetween('date_of_transaction', array($fromDate, $toDate))
                ->get();
            //calculating total income for the given period        
            $totalExpense = DB::table('expenses')
                ->select([DB::raw('Sum(expenses.amount) AS total_cost')])
                ->whereBetween('date_of_transaction', array($fromDate, $toDate))
                ->value('total_cost');

            //calculating total discount for the given period   
            $totalDiscount = DB::table('expenses')
                ->select([DB::raw('Sum(expenses.discount_received) AS total_discount')])
                ->whereBetween('date_of_transaction', array($fromDate, $toDate))
                ->value('total_discount');

            $printFromDate = $fromDate;
            $printToDate = $toDate;
        }
        else
        {
             //if the date picker is empty, fetch all the data in the table
             $data = DB::table('expenses')
             ->get();

            //calculate sum of the all income records
            $totalExpense = DB::table('expenses')        
                    ->select([DB::raw('Sum(expenses.amount) AS total_expense')])
                    ->value('total_expense');

            //calculate sum of the all discounts
            $totalDiscount = DB::table('expenses')
                    ->select([DB::raw('Sum(expenses.discount_received) AS total_discount')])
                    ->value('total_discount');
            
            $printFromDate = "Period Not Specified";
            $printToDate = "Period Not Specified";
        }

        $png = file_get_contents("images/logo.png");
        $pngBase64 = base64_encode($png);

        date_default_timezone_set('Asia/Colombo');
        $date = date('m/d/Y h:i:s a', time());

        $output = '
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Expense Report</title>
        <link rel="icon" type="image/png" href="images/logo.png">
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
         
        
        <p> Date and Time of report generation : '.$date.'</p><br>


        <p>Total Expense for the period - From <b><i>'.$printFromDate.'</i></b> To <b><i>'.$printToDate.'</i></b> </p><br>
        <table width="100%" style="border-collapse: collapse; border: 0px;">
            <tr>
                <th style="border: 1px solid; padding:4px;">Payment Number</th>
                <th style="border: 1px solid; padding:4px;">Category</th>
                <th style="border: 1px solid; padding:4px;">Description</th>
                <th style="border: 1px solid; padding:4px;">Date of Transaction</th>
                <th style="border: 1px solid; padding:4px;">Amount in LKR</th>
                <th style="border: 1px solid; padding:4px;">Discount Given in LKR</th>
            </tr>
            ';

            foreach($data as $data)
            {
            $output .= '
            <tr>
                <td style="border: 1px solid; padding:4px; text-align:left;">'.$data->payment_number.'</td>
                <td style="border: 1px solid; padding:4px; text-align:left;">'.$data->category.'</td>
                <td style="border: 1px solid; padding:4px; text-align:left;">'.$data->description.'</td>
                <td style="border: 1px solid; padding:4px; text-align:center;">'.$data->date_of_transaction.'</td>
                <td style="border: 1px solid; padding:4px; text-align:right;">'.$data->amount.'.00</td>
                <td style="border: 1px solid; padding:4px; text-align:right;">'.$data->discount_received.'</td>            
            ';
            }
            $output .= '
            <tbody></tbody>
            <tfoot>
                <tr id = "rowid">
                    <th colspan="4" style="text-align:right; border: 1px solid; padding:4px;">Totals</th>
                    <th id = "total_cost" class = "id" style="border: 1px solid; padding:4px; text-align:right;">LKR.'.$totalExpense.'.00</th>
                    <th id = "totalDiscount" class = "id" style="border: 1px solid; padding:4px; text-align:right;">LKR.'.$totalDiscount.'.00</th>
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

            return $output;      
    }
}

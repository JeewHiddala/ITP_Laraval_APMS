<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;

class ProfitReportController extends Controller
{
    //
    //
    function ProfitPDF($fromDate, $toDate)
    {
        // dd($fromDate);
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->GeneratePDF($fromDate, $toDate));
        $docName = "Profit Report"; //Giving a name to the report appear after download
        return $pdf->stream($docName." ".$fromDate." to ".$toDate.".pdf");
    }


    function GeneratePDF($fromDate, $toDate)
    {
        if($fromDate != "Select Date from the picker"){
            //calculating total expense for the given period        
            $totalExpense = DB::table('expenses')
                    ->select([DB::raw('Sum(expenses.amount) AS total_cost')])
                    ->whereBetween('date_of_transaction', array($fromDate, $toDate))
                    ->value('total_cost');

            //calculating total income for the given period   
            $totalIncome = DB::table('incomes')
                    ->select([DB::raw('Sum(incomes.amount) AS total_income')])
                    ->whereBetween('date_of_transaction', array($fromDate, $toDate))
                    ->value('total_income');
                  
            //calculating total wholeSales for the given period        
            $totalWholeSale = DB::table('invoices')
                    ->select(DB::raw('Sum(invoices.total) AS total_wholesale'))
                    ->whereBetween('date', array($fromDate, $toDate))
                    ->value('total_wholesale');
            
            //calculating total sales from individual customers
            $totalIndividualSale = DB::table('bills')
                    ->select(DB::raw('Sum(bills.grand_total) AS total_sales'))
                    ->whereBetween('invoice_date', array($fromDate, $toDate))
                    ->value('total_sales');

            //calculating total sales
            $totalSales = $totalWholeSale + $totalIndividualSale + $totalIncome;
            //calculating profit
            $profit = $totalSales - $totalExpense;

            $printFromDate = $fromDate;
            $printToDate = $toDate;

        } else {
            // dd($data);
            $totalExpense = 0;
            $totalIncome = 0;
            $totalWholeSale = 0;
            $totalIndividualSale = 0;
            $totalSales = 0;
            $profit = 0;
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
        <title>Profit Report</title>
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
                <th style="border: 1px solid; padding:4px; text-align:left;">Total Sales from the Whole Sales</th>
                <th style="border: 1px solid; padding:4px; text-align:right;">'.$totalWholeSale.'.00</th>
            </tr>
            <tr>
                <th style="border: 1px solid; padding:4px; text-align:left;">Total Sales from the Individual Customers </th>
                <th style="border: 1px solid; padding:4px; text-align:right;">'.$totalIndividualSale.'</th>
            </tr>
            <tr>
                <th style="border: 1px solid; padding:4px; text-align:left;">Total Income other than Sales </th>
                <th style="border: 1px solid; padding:4px; text-align:right;">'.$totalIncome.'.00</th>
            </tr>
            <tr>
                <th style="border: 1px solid; padding:4px; text-align:left;">Total Income for all the sources </th>
                <th style="border: 1px solid; padding:4px; text-align:right; background-color:yellow;" >'.$totalSales.'.00</th>
            </tr>
            <tr>
                <th style="border: 1px solid; padding:4px; text-align:left;">Total Expenses </th>
                <th style="border: 1px solid; padding:4px; text-align:right;">-'.$totalExpense.'.00</th>
            </tr>
            <tr>
                <th style="border: 1px solid; padding:4px; text-align:left;">Gross Profit for the Period  </th>
                <th style="border: 1px solid; padding:4px; text-align:right; background-color:yellow;">'.$profit.'.00</th>
            </tr>
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

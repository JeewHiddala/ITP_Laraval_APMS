<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SummaryController extends Controller
{
    //new
    function loadIncomeData(Request $request){
        //checking the date picker is empty
        if(!empty($request->from_date))
        {
            //fetching data from the table according to the dates given
            $data = DB::table('incomes')
                    ->whereBetween('date_of_transaction', array($request->from_date, $request->to_date))
                    ->get();
            //calculating total income for the given period        
            $totalIncome = DB::table('incomes')
                    ->select([DB::raw('Sum(incomes.amount) AS total_cost')])
                    ->whereBetween('date_of_transaction', array($request->from_date, $request->to_date))
                    ->value('total_cost');

            //calculating total discount for the given period   
            $totalDiscount = DB::table('incomes')
                    ->select([DB::raw('Sum(incomes.discount_given) AS total_discount')])
                    ->whereBetween('date_of_transaction', array($request->from_date, $request->to_date))
                    ->value('total_discount');

            $fromDate = $request->from_date;
            $toDate = $request->to_date;        
            //returning data to the view
            return view('incomeSummary',compact('data','totalIncome','totalDiscount','fromDate','toDate'));

        } else {
            //if the date picker is empty, fetch all the data in the table
            $data = DB::table('incomes')
                    ->get();

            //calculate sum of the all income records
            $totalIncome = DB::table('incomes')        
                    ->select([DB::raw('Sum(incomes.amount) AS total_income')])
                    ->value('total_income');

            //calculate sum of the all discounts
            $totalDiscount = DB::table('incomes')
                    ->select([DB::raw('Sum(incomes.discount_given) AS total_discount')])
                    ->value('total_discount');
            // dd($data);
            $fromDate = "Select Date from the picker";
            $toDate = "Select Date from the picker";
            //returning data to the view
            return view('incomeSummary',compact('data','totalIncome','totalDiscount','fromDate','toDate'));
        }
    }

    function loadExpenseData(Request $request){
        //checking the date picker is empty
        if(!empty($request->from_date))
        {
            //fetching data from the table according to the dates given
            $data = DB::table('expenses')
                    ->whereBetween('date_of_transaction', array($request->from_date, $request->to_date))
                    ->get();
            //calculating total expense for the given period        
            $totalExpense = DB::table('expenses')
                    ->select([DB::raw('Sum(expenses.amount) AS total_cost')])
                    ->whereBetween('date_of_transaction', array($request->from_date, $request->to_date))
                    ->value('total_cost');

            //calculating total discount for the given period   
            $totalDiscount = DB::table('expenses')
                    ->select([DB::raw('Sum(expenses.discount_received) AS total_discount')])
                    ->whereBetween('date_of_transaction', array($request->from_date, $request->to_date))
                    ->value('total_discount');

            $fromDate = $request->from_date;
            $toDate = $request->to_date;

            //returning data to the view
            return view('expenseSummary',compact('data','totalExpense','totalDiscount','fromDate','toDate'));

        } else {
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
            // dd($data);
            $fromDate = "Select Date from the picker";
            $toDate = "Select Date from the picker";
            //returning data to the view
            return view('expenseSummary',compact('data','totalExpense','totalDiscount','fromDate','toDate'));
        }
    }

    function loadProfitData(Request $request){
        //checking the date picker is empty
        if(!empty($request->from_date))
        {
            //calculating total expense for the given period        
            $totalExpense = DB::table('expenses')
                    ->select([DB::raw('Sum(expenses.amount) AS total_cost')])
                    ->whereBetween('date_of_transaction', array($request->from_date, $request->to_date))
                    ->value('total_cost');

            //calculating total income for the given period   
            $totalIncome = DB::table('incomes')
                    ->select([DB::raw('Sum(incomes.amount) AS total_income')])
                    ->whereBetween('date_of_transaction', array($request->from_date, $request->to_date))
                    ->value('total_income');
                  
            //calculating total wholeSales for the given period        
            $totalWholeSale = DB::table('invoices')
                    ->select(DB::raw('Sum(invoices.total) AS total_wholesale'))
                    ->whereBetween('date', array($request->from_date, $request->to_date))
                    ->value('total_wholesale');
            
            //calculating total sales from individual customers
            $totalIndividualSale = DB::table('bills')
                    ->select(DB::raw('Sum(bills.grand_total) AS total_sales'))
                    ->whereBetween('invoice_date', array($request->from_date, $request->to_date))
                    ->value('total_sales');

            //calculating total sales
            $totalSales = $totalWholeSale + $totalIndividualSale + $totalIncome;
            //calculating profit
            $profit = $totalSales - $totalExpense;

            $fromDate = $request->from_date;
            $toDate = $request->to_date;

            //returning data to the view
            return view('profitSummary',compact('fromDate','toDate','totalExpense','totalIncome','totalWholeSale','totalIndividualSale','totalSales','profit'));

        } else {
            // dd($data);
            $totalExpense = 0;
            $totalIncome = 0;
            $totalWholeSale = 0;
            $totalIndividualSale = 0;
            $totalSales = 0;
            $profit = 0;
            $fromDate = "Select Date from the picker";
            $toDate = "Select Date from the picker";

            //returning to the view
            return view('profitSummary',compact('fromDate','toDate','totalExpense','totalIncome','totalWholeSale','totalIndividualSale','totalSales','profit'));
        }
    }
}


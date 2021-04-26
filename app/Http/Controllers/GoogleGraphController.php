<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class GoogleGraphController extends Controller
{
    //
    function index(Request $request){
        // dd($request);
        $data = DB::table('expenses')
                ->select(
                    DB::raw('category as category'),
                    DB::raw('count(*) as number')
                )
                ->whereBetween('date_of_transaction', array($request->from_date, $request->to_date))
                ->groupBy('category')
                ->get(); //execute the query
        
        $array[] = ['Category', 'Number'];
        foreach($data as $key=>$value){
            $array[++$key] = [$value->category,$value->number];
        }

        return view('chartCategory')->with('category', json_encode(
            $array));
    }
    
    function indexBar(Request $request){
        // dd($request);
        $data = DB::table('expenses')
                ->select(
                    DB::raw('category as category'),
                    DB::raw('count(*) as number')
                )
                ->whereBetween('date_of_transaction', array($request->from_date, $request->to_date))
                ->groupBy('category')
                ->get(); //execute the query
        
        $array[] = ['Category', 'Number'];
        foreach($data as $key=>$value){
            $array[++$key] = [$value->category,$value->number];
        }
        return view('chartCategoryBar')->with('category', json_encode($array));
    }
    
    function incomePie(Request $request){
        // dd($request);
        $data = DB::table('incomes')
                ->select(
                    DB::raw('category as category'),
                    DB::raw('count(*) as number')
                )
                ->whereBetween('date_of_transaction', array($request->from_date, $request->to_date))
                ->groupBy('category')
                ->get(); //execute the query
        
        $array[] = ['Category', 'Number'];
        foreach($data as $key=>$value){
            $array[++$key] = [$value->category,$value->number];
        }
        return view('chartCategoryIncome')->with('category', json_encode(
            $array));
    }

    function incomeBar(Request $request){
        // dd($request);
        $data = DB::table('incomes')
                ->select(
                    DB::raw('category as category'),
                    DB::raw('count(*) as number')
                )
                ->whereBetween('date_of_transaction', array($request->from_date, $request->to_date))
                ->groupBy('category')
                ->get(); //execute the query
        
        $array[] = ['Category', 'Number'];
        foreach($data as $key=>$value){
            $array[++$key] = [$value->category,$value->number];
        }
        return view('chartCategoryIncomeBar')->with('category', json_encode($array));
    }
}

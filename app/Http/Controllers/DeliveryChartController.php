<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class DeliveryChartController extends Controller
{
    function index(Request $request)
    {
     $data = DB::table('deliveries')
       ->select([DB::raw('d_type as d_type'),DB::raw('count(*) as number')])
       ->whereBetween('deliveries.date', array($request->from_date, $request->to_date))
       ->groupBy('d_type')
       ->get();
     $array[] = ['d_type', 'Number'];
     foreach($data as $key => $value)
     {
      $array[++$key] = [$value->d_type, $value->number];
     }
     //dd($array);
     return view('/DeliveryPieChart')->with('d_type', json_encode($array));
    }

    function index2(Request $request)
    {
     $data = DB::table('deliveries')
       ->select([DB::raw('d_type as d_type'),DB::raw('count(*) as number')])
       ->whereBetween('deliveries.date', array($request->from_date, $request->to_date))
       ->groupBy('d_type')
       ->get();
     $array[] = ['d_type', 'Number'];
     foreach($data as $key => $value)
     {
      $array[++$key] = [$value->d_type, $value->number];
     }
     //dd($array);
     return view('/DeliveryBarChart')->with('d_type', json_encode($array));
    }
}

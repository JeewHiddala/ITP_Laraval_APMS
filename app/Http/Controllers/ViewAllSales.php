<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bill;
use App\Invoice;
use DB;

class ViewAllSales extends Controller
{
     //
     public function viewAll(){
        // Fetching data from the database table
        $data =  Bill::paginate(3);
        $data1 = Invoice::paginate(3);

        // dd($data);
        // Returning to the viewAllSales view
        return view('viewAllSales',['individualSales'=>$data,'wholeSalers'=>$data1]);
    }
}

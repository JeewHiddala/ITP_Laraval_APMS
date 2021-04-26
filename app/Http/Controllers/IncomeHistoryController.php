<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\IncomeHistory;
use DB;

class IncomeHistoryController extends Controller
{
    public function historyView(){
        //fetching data from the table with paginate
        $data = IncomeHistory::paginate(3);

        // dd($data);
        return view('/incomeHistory',['history'=>$data]); //directing to the view with the fetched data
    }
}

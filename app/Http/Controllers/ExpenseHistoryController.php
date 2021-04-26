<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ExpenseHistory;
use DB;

class ExpenseHistoryController extends Controller
{
    public function historyView(){
        //fetching data from the table with paginate
        $data = ExpenseHistory::paginate(3);

        // dd($data);
        return view('/expenseHistory',['history'=>$data]); //directing to the view with the fetched data
    }
}

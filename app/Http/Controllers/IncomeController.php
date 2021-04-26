<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Income;
use DB;

class IncomeController extends Controller
{

    public function showAll(){
        //fetching according to paginate value
        $income = Income::paginate(5);

        //return view with paginated records
        return view('businessIncome',['Income'=>$income]);
    }

    public function store(Request $request){
        // dd($request->all());

        $income = new Income;

        $this->validate($request,[
            'receiptNumber'=>'required|max:10|min:4',
            'transactionDate'=>'required',
            'incomeAmount'=>'required',
            'category'=>'required',
        ]);

        //Entering values to the database
        $income->receipt_number=$request->receiptNumber;
        $income->amount=$request->incomeAmount;
        $income->description=$request->description;
        $income->date_of_transaction=$request->transactionDate;
        $income->discount_given=$request->dis_given;
        $income->category=$request->category;
        $income->save(); //pre-defined method to save data

        //redirect to business income view
        return redirect()->back();
    }

    public function updateIncomeView($id){
        $income=Income::find($id); //fetching all the details of the income related to the id passed
        return view('updateIncome')->with('incomeData',$income); //loading the update page with the data included in a variable
    }

    public function updateIncome(Request $request){
        // dd($request);

        //Taking the edited values to the variables
        $id = $request->id;
        $recNumber = $request->receiptNumber;
        $amount = $request->amount;
        $discount = $request->discount;
        $des = $request->description;
        $category = $request->category;
        $date = $request->dot;

        $data = Income::find($id); //finding the required record through id
        $data->receipt_number=$recNumber;
        $data->amount=$amount;
        $data->description=$des;
        $data->date_of_transaction=$date;
        $data->discount_given=$discount;
        $data->category=$category;
        $data->save(); //saving the data

        return redirect('/income');
    }

    public function deleteIncome($id){
        $income=Income::find($id); //Searching the entry to be deleted

        $income->delete(); //pre-defined delete function
        return redirect()->back(); //direct back to the Income view
    }

    public function searchIncome(Request $request){
        //fetching the entered number
        $search = $request->get('searchBar');
    
        //searching through the database records
        $income = DB::table('incomes')->where('receipt_number','LIKE', '%'.$search.'%')->paginate(5);

        //returning the search results to the view
        return view('incomeSearchResults',['Income'=>$income]);
    }
}

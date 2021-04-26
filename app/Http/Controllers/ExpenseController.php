<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expense;
use DB;

class ExpenseController extends Controller
{
    public function showAll(){
        //fetching according to paginate value
        $ex = Expense::paginate(5);

        //return view with paginated records
        return view('businessExpense',['Expense'=>$ex]);
    }
    public function store(Request $request){
        //dd($request->all()); //just echo the data taken from the form(die dom)
        $expense=new Expense;

        //validating
        $this->validate($request,[
            'paymentNumber'=>'required|max:10|min:4',
            'transactionDate'=>'required',
            'expenseAmount'=>'required',
            'category'=>'required',
        ]);

        //entering values to the database
        $expense->payment_number=$request->paymentNumber;
        $expense->amount=$request->expenseAmount;
        $expense->description=$request->description;
        $expense->date_of_transaction=$request->transactionDate;
        $expense->discount_received=$request->dis_received;
        $expense->category=$request->category;
        $expense->save(); //pre-defined method save() 

        // $data=Expense::all();
        // dd($data);
        
        return redirect()->back();

        //Return all the data to the view as 'Expense'
        // return view('businessExpense')->with('Expense',$data);
    }

    public function deleteExpense($id){
        $expense=Expense::find($id);

        $expense->delete();
        return redirect()->back();
    }

    public function updateExpenseView($id){
        $expense=Expense::find($id);
        return view('updateExpense')->with('expData',$expense);
    }

    public function updateExpense(Request $request){
        // dd($request);
        //taking values to the variables
        $id = $request->id;
        $pnumber = $request->paymentNumber;
        $amount = $request->amount;
        $discount = $request->discount;
        $description = $request->description;
        $category = $request->category;
        $date = $request->dot;

        $data = Expense::find($id);
        $data->payment_number=$pnumber;
        $data->amount=$amount;
        $data->description=$description;
        $data->date_of_transaction=$date;
        $data->discount_received=$discount;
        $data->category=$category;
        $data->save();

        // $all=Expense::all();

        // return view('businessExpense')->with('Expense', $all);
        return redirect('/expense');
    }

    public function searchExpense(Request $request){
        //fetching the entered number
        $search = $request->get('searchBar');
    
        //searching through the database records
        $expense = DB::table('expenses')->where('payment_number','LIKE', '%'.$search.'%')->paginate(5);

        //returning the search results to the view
        return view('expenseSearchResults',['Expense'=>$expense]);
    }

}

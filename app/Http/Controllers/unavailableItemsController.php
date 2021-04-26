<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\unavailableItems;

class unavailableItemsController extends Controller
{
    public function storeUn(Request $request){
        $UnItem = new unavailableItems;
        // dd($request->all());

        $this->validate($request,[
            'ItemNo'=>'required|max:10|min:5',
            'Date'  =>  'required|after:yesterday',
            'customerName'  =>  'required|',
            'salesperson'  =>  'required|',




        ]);


        $UnItem->ItemNo=$request->ItemNo;
        $UnItem->Date=$request->Date;
        $UnItem->Model=$request->Model;
        $UnItem->customerName=$request->customerName;
        $UnItem->phone=$request->phone;
        $UnItem->salesperson=$request->salesperson;

        $UnItem->save();

        $data2=unavailableItems::all();
       // dd($data);
        return view('unavailableItems')->with('unavailableItems',$data2);
    }

    public function updateTaskAsCompleted($id){

        $UnItem=unavailableItems::find($id);
        $UnItem->iscompleted=1;
        $UnItem->save();
        return redirect()->back();
    }

    public function updateTaskAsNotCompleted($id){
        $UnItem=unavailableItems::find($id);
        $UnItem->iscompleted=0;
        $UnItem->save();
        return redirect()->back();
    }

    public function DeteleEntry($id){
        $UnItem=unavailableItems::find($id);
        $UnItem->delete();
        return redirect()->back();
    }

    public function editUnItems($id){
        $UnItem=unavailableItems::find($id);

        return view('updateUnItems')->with('UnItemdata',$UnItem);


    }
    public function updateItems(Request $request){
        //dd($request);
        $id=$request->id;
        $ItemNo=$request->ItemNo;
        $Date=$request->Date;
        $Model=$request->Model;
        $customerName=$request->customerName;
        $phone=$request->phone;
        $salesperson=$request->salesperson;

        $UnItemData = unavailableItems::find($id);

        $UnItemData->ItemNo=$ItemNo;
        $UnItemData->Date=$Date;
        $UnItemData->Model=$Model;
        $UnItemData->customerName=$customerName;
        $UnItemData->phone=$phone;
        $UnItemData->salesperson=$salesperson;

        $UnItemData->save();

        $UnItemData=unavailableItems::all();
        return redirect('/unavailableItems')->with('unavailableItems', $UnItemData);



    }

    public function SearchUnItems(Request $request){
        $search = $request->get('searchUnitems');
        $posts = unavailableItems::where('ItemNo','like','%'.$search.'%')->paginate(10);
        return view('SearchUNitems' , ['posts'=> $posts]);

    }
}

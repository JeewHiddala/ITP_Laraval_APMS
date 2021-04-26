<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use PDF;

use view;
use App\item;
use App\invoice_item;
use App\invoice;
use App\stock;
use App\wholeSaleBuyer;


class controllerPage extends Controller
{
    public function ninvoice(Request $request){

        $nwinvoive =new invoice;

        $this->variable($request,[
            //'invoice_no'=>'required|max:100|min:2',
           'date'=>'required|max:100|min:2',
           'discount'=>'required|max:100|min:2',
           'total'=>'required|max:10|min:2',
           //'type'=>'required|max:10|min:2',
           'buyer_id'=>'required|max:100|min:2',
           'seller_id'=>'required|max:100|min:2',

        ]);

            $invoice->date=$request->date;
            $invoice->discount=$request->discount;
            $invoice->total=$request->total;
            $invoice->buyer_id=$request->buyer_id;
            $invoice->seller_id=$request->seller_id;
            $invoice->save();

            $data= invoice::all();

            return view('/invoice_no')->with('invoice',$data);

    }

    
    
    //View NewInvoice Page (tables , dropdowns)
    public function newI(Request $request){
        $list = item::all();
        //$stock_has_items = stock_has_item::all();
        //$stocks= stock::all();
        $invoice_item = invoice_item::all();
        //$invoice = invoice::all();       
        $invoice_id=$request->invoice_id;

        //get Values To table
        $data2 =DB::table('invoice_items')
            ->join('items','items.item_no','=','invoice_items.item_no')
            ->select('invoice_items.i_List','invoice_items.item_no','items.item_description','invoice_items.quantity','invoice_items.price','invoice_items.total')->where('invoice_items.invoice_no',$invoice_id)
            ->get();


        $data =DB::table('invoices')->latest('id')->first();
        //dd($data2);
        //////////NEW CODE/////////

        /* $data =invoice::select('id')
        ->where('total','=',0)
        ->get();*/
        
        ///////////////////////////
      

        return view('/newInvoice',compact('list','data2','data'));
        
    }
    public function newGI(Request $request){
        $list = item::all();
        //$stock_has_items = stock_has_item::all();
        //$stocks= stock::all();
        $invoice_item = invoice_item::all();
        $buyerinfo = wholeSaleBuyer::all();
        
        //$invoice = invoice::all();       
        $invoice_id=$request->invoice_id;

        //get Values To table
        $data2 =DB::table('invoice_items')
            ->join('items','items.item_no','=','invoice_items.item_no')
            ->select('invoice_items.i_List','invoice_items.item_no','items.item_description','invoice_items.quantity','invoice_items.price','invoice_items.total')->where('invoice_items.invoice_no',$invoice_id)
            ->get();


        $data =DB::table('invoices')->latest('id')->first();
        //dd($data2);
        //////////NEW CODE/////////

        /* $data =invoice::select('id')
        ->where('total','=',0)
        ->get();*/
        
        ///////////////////////////
      

        return view('/visitNewInvoice',compact('list','buyerinfo','data2','data'));
        
    }

    //Insert Values to the 'invoice_item' table

public function insert(Request $req){

  //dd($req->all());

  
  $invoice_number = $req->input('invoice_Id');
  $brand = $req->input('brand');
  $model = $req->input('v_model');
  $item_description = $req->input('item_description');
  $price = $req->input('price');
  $qty = $req->input('qty1');

  //$invoice_id=$req->invoice_id;

  $item_numb = DB::table('items')
  ->select('item_no')
  ->where('v_model','=',$model)
  ->where('brand', '=', $brand)
  ->where('item_description', '=', $item_description)

  ->value('item_no');
  
  echo $item_numb;
  //dd($item_numb);
  $total= $price * $qty; 
  $list_array = array('invoice_no'=>$invoice_number,'item_no'=>$item_numb,'quantity'=>$qty,'price'=>$price,'total'=>$total);
  DB::table('invoice_items')->insert($list_array);
  
  $data =DB::table('invoices')->latest('id')->first();
  
  $data2 =DB::table('invoice_items')
      ->join('items','items.item_no','=','invoice_items.item_no')
      ->select('invoice_items.i_List','invoice_items.item_no','items.item_description','invoice_items.quantity','invoice_items.price','invoice_items.total')
      ->where('invoice_items.invoice_no','=',$invoice_number)
      ->get();

  $list = item::all();
  $stock_has_items = stock_has_item::all();
  $stocks= stock::all();
  
  $sumtot = DB::table('invoice_items')
      //->join('items','items.item_no','=','invoice_items.item_no')
      ->select(DB::raw('sum(invoice_items.total)'))
      ->groupBy('invoice_items.invoice_no')
      ->where('invoice_items.invoice_no','=',$invoice_number)
      ->get();
      

  //echo "Insert Successfuly";

  return view('/newInvoice',compact('list','data2','data'));

}

    //show normal total


    //Function to create new InvoiceId when the button
    public function createInvoiceID(){
        
        $list = invoice::all();
        $ldate = date('Y-m-d H:i:s');
        $list_arrayn = array(
        
        'date'=>$ldate,
        'discout'=>"0",
        'total'=>"0",
        'type'=>"New Invoice",
        'buyer_id'=>"null",
        'seller_id'=>"null"
        );

        DB::table('invoices')->insert($list_arrayn);
        return redirect('/visitNewInvoice');
        
    }

    //Function to create Good Return InvoiceId when the button
   /* public function createGRInvoiceID(){
        
        $list = invoice::all();
        $ldate = date('Y-m-d H:i:s');
        $list_arrayn = array(
        
        'date'=>$ldate,
        'discout'=>"0",
        'total'=>"0",
        'type'=>"GoodReturn Invoice",
        'buyer_id'=>"null",
        'seller_id'=>"null"
        );

        DB::table('invoices')->insert($list_arrayn);
        return redirect('/searchResultInvoice');
        
    }

    public function newGI(Request $request){
        $list = item::all();
        $stock_has_items = stock_has_item::all();
        $stocks= stock::all();
        $invoice_item = invoice_item::all();
        //$invoice = invoice::all();       
        $invoice_id=$request->invoice_id;

        //get Values To table
       /* $data2 =DB::table('invoice_items')
            ->join('items','items.item_no','=','invoice_items.item_no')
            ->select('invoice_items.i_List','invoice_items.item_no','items.item_description','invoice_items.quantity','invoice_items.price','invoice_items.total')->where('invoice_items.invoice_no',$invoice_id)
            ->get();

            
        $gdata =DB::table('invoices')->latest('id')->first();
       
        return view('/searchResultInvoice',compact('list','gdata'));
        
    }*/
    //Enter sales person ID and customer ID
    public function readyids(Request $req, $invoice_Id){
        
        $semp = $req->input('semp');
        $buyer_id = $req->input('buyer_id');

        DB::update('update invoices set buyer_id = ? , seller_id = ?  where id = ?', [$buyer_id, $semp ,$invoice_Id]);

        $list= item::all();
        $list2 = invoice::all();

        $data =DB::table('invoices')->latest('id')->first();



         $data2 =DB::table('invoice_items')
        ->join('items','items.item_no','=','invoice_items.item_no')
        ->select('invoice_items.i_List','invoice_items.item_no','items.item_description','invoice_items.quantity','invoice_items.price','invoice_items.total')
        ->where('invoice_items.invoice_no',$invoice_Id)
        ->get();



        

        return view('/newInvoice',compact('list','list2','data','data2'));

    }

    public function fetch(Request $request){

        $select= $request->get('select');
        $value= $request->get('value');
        $dependent= $request->get('dependent');
        $data=  DB::table('items')->where($select,$value)->groupBy($dependent)->get();

        $output = '<option value="">Select Brand </option>';

        foreach($data as $row){
            $output .= '<option value="'.$row->$dependent.'">'.$row->$dependent.'</option>';
        }
        echo $output;

    }

    public function newIndex(){
        $item_list= DB::table('items')->groupBy('brand')->get();
        return view('newInvoice')->with('item_list',$item_list);
    }

    

    //Delete Selected Value
    public function itemdelete($id,$invoice_id){
        //dd($hai);
        invoice_item::where('i_List',$id)
        ->delete();
        
        $list = item::all();
        
        $data =DB::table('invoices')->latest('id')->first();

        $data2 =DB::table('invoice_items')
        ->join('items','items.item_no','=','invoice_items.item_no')
        ->select('invoice_items.i_List','invoice_items.item_no','items.item_description','invoice_items.quantity','invoice_items.price','invoice_items.total')->where('invoice_items.invoice_no',$invoice_id)
        ->get();

          return view('/newInvoice',compact('list','data2','data'));
    }

        //AddReturnGoods
        public function itemAdd(Request $request){
            //  invoice_item::where('i_List',$id); 
              
             // $list = item::all();
      
             $invoice_item = new invoice_item;
              
          //$data =DB::table('invoices')->latest('id')->first();
      
            //$invoice_item-> invoice_no = $id-> id;
            $invoice_item-> invoice_no = $request-> invoiceNo;
            $invoice_item-> item_no = $request-> itemNo;
            //$invoice_item-> item_description = $request-> itemDes;
            
            $invoice_item-> quantity = $request-> qty;
            $invoice_item-> price = $request-> price;
            $invoice_item-> total = $request-> total;
            
            //dd($invoice_item);
      
            $invoice_item-> save();
      
            $goodData=invoice_item::all();
            //$details= invoice::find($id);
      
            $data = DB::table('invoices')
            ->select('invoices.id')
            ->where('invoices.id','=',$request->invoiceNo);
      
            if(!empty($request-> invoiceNo)){
                $datas = DB::table('invoice_items')
                ->select('invoice_items.item_no','invoice_items.quantity','invoice_items.price','invoice_items.total')
                ->where('invoice_items.invoice_no',$request->invoiceNo)
                ->update(array(
                  'invoice_items.total'=>DB::raw('invoice_items.quantity * invoice_items.price'),
                ));
                  
            //dd($datas);
            }
            else
            {
                $datas = "Nothing to Display" ;
                //dd($datas);
            }
           
      
             $data5 =DB::table('invoice_items')
              ->join('items','items.item_no','=','invoice_items.item_no')
              ->select('invoice_items.i_List','invoice_items.item_no','invoice_items.invoice_no','items.item_description','invoice_items.quantity','invoice_items.price','invoice_items.total')
              ->where('invoice_items.invoice_no',$request->invoiceNo)
              ->get();

              $id = $request->invoiceNo;

      //dd($data3);
                //return view('/searchResult',compact('list','data')); 
                return view('goodView', compact('id','data5')); 
          
              
          }
      
          //good return item add
          public function itemAddview($i_List,$id){
      
              $itemData=invoice_item::find($i_List);
      
              $id1 = $id;
              //$in1 = $in;
      
             
             // $addGRI = DB::table('invoice_items')
            //  ->select('invoice_items.i_List','invoice_items.item_no','invoice_items.quantity','invoice_items.price','invoice_items.total','invoice_items.invoice_no')
            //  ->where(['invoice_items.invoice_no','=',$id],['invoice_items.i_List','=',$i_List]);
          
              return view('goodReturnAdd',compact('itemData','id1'));
      
      
      
          }

    //AddReturnGoods
    /*public function itemAdd(Request $request){
      //  invoice_item::where('i_List',$id); 
        
       // $list = item::all();

       $invoice_item = new invoice_item;
       $item = new item;
        
    //$data =DB::table('invoices')->latest('id')->first();

      //$invoice_item-> invoice_no = $id-> id;
      $invoice_item-> invoice_no = $request-> invoiceNo;
      $item-> item_no = $request-> itemNo;
      //$invoice_item-> item_no = $request-> itemNo;
      $item-> item_description = $request-> itemdis;
      
      $invoice_item-> quantity = $request-> qty;
      $invoice_item-> price = $request-> price;
      $invoice_item-> total = $request-> total;
      
      //dd($invoice_item);

      $invoice_item-> save();
      $item->save();

      $goodData=invoice_item::all();
      $itemDetails= item::all();

      $data = DB::table('invoices')
      ->select('invoices.id')
      ->where('invoices.id','=',$request->invoiceNo);

      if(!empty($request-> invoiceNo)){
      /*$datas = DB::table('invoice_items')
      ->select('invoice_items.item_no','invoice_items.quantity','invoice_items.price','invoice_items.total')
      ->where('invoice_items.invoice_no',$request->invoiceNo)
      ->update(array(
        'invoice_items.total'=>DB::raw('invoice_items.quantity * invoice_items.price'),
        ))

        $datas =DB::table('invoice_items')
            ->join('items','items.item_no','=','invoice_items.item_no')
            ->select('invoice_items.i_List','invoice_items.item_no','items.item_description','invoice_items.quantity','invoice_items.price','invoice_items.total')
            ->where('invoice_items.invoice_no',$request->invoiceNo)
            ->update(array(
                'invoice_items.total'=>DB::raw('invoice_items.quantity * invoice_items.price'),
                )) ;
      //dd($datas);
      }
    
      else
      {
          $datas = "Nothing to Display" ;
          //dd($datas);
      }

      /*  $data3 =DB::table('invoice_items')
        ->join('items','items.item_no','=','invoice_items.item_no')
        ->select('invoice_items.i_List','invoice_items.item_no','items.item_description','invoice_items.quantity','invoice_items.price','invoice_items.total')
        ->where('invoice_items.invoice_no',$invoice_id)
        ->get();

          //return view('/searchResult',compact('list','data')); 
          return redirect('/searchResultInvoice',compact('data','goodData','datas','itemDetails')) ; 
    
        
    }

    //good return item add
    public function itemAddview($i_List,$id,$item_no,$ino){

        $itemData=invoice_item::find($i_List);
        $itemName = item::find($item_no);

        $id1 = $id;
        $ino1 = $ino;


       
       // $addGRI = DB::table('invoice_items')
      //  ->select('invoice_items.i_List','invoice_items.item_no','invoice_items.quantity','invoice_items.price','invoice_items.total','invoice_items.invoice_no')
      //  ->where(['invoice_items.invoice_no','=',$id],['invoice_items.i_List','=',$i_List]);
    
        return view('goodReturnAdd',compact('itemData','id1','itemName','ino1'));



    }*/


    //   discount
    public function addDis(Request $req,$invoice_Id){

        $dis= $req->input('discount');
        //$model = $req->input('invoice_Id');
        //dd($invoice_Id);
        //$invoice_item = invoice_item::all();
        //$invoice= invoice::all();
        //dd($dis);
       
        

        /*$invoice_id = DB::table('invoices')
        ->select('invoices.id')->where('id',$invoice_Id)
        ->value('invoice_Id');*/
        
        $list = invoice::all();
        $data =DB::table('invoices')->latest('id')->first();
       

            
        $data2 =DB::table('invoice_items')
        ->join('items','items.item_no','=','invoice_items.item_no')
        ->select('invoice_items.i_List','invoice_items.item_no','items.item_description','invoice_items.quantity','invoice_items.price','invoice_items.total')
        ->where('invoice_items.invoice_no',$invoice_Id)
        ->get();


        $sumtot = DB::table('invoice_items')
        //->join('items','items.item_no','=','invoice_items.item_no')
        ->select(DB::raw('sum(invoice_items.total) as tot'))
        ->where('invoice_items.invoice_no','=',$invoice_Id)
        ->value('tot');

        //dd($sumtot);

        
        
        $ftot = $sumtot - ($sumtot * ($dis/ 100)) ;
        DB::update('update invoices set discout = ? , total= ? where id = ?', [$dis,$ftot,$invoice_Id]);
       

        //dd($ftot);
        
        return view('/newInvoice',compact('list','data2','data','ftot'));


        
        /*$purchases = DB::table('invoice_items')
        ->join('invoices','invoices.id','=','invoice_items.invoice_no')
        ->where('invoices.id', '=', 'invoice_items.invoice_no')
        ->sum('invoice_items.total');*/

        /*$addDis = new invoice;
        $addDis->discout=$dis;
        $addDis->save();


        $sumtot = DB::table('invoice_items')
        //->join('items','items.item_no','=','invoice_items.item_no')
        ->select(DB::raw('sum(invoice_items.total)'))

        ->groupBy('invoice_items.invoice_no')

        ->where('invoice_items.invoice_no','=',$model)
        ->get();

        
        
        $ftot = $sumtot - $sumtot * ($dis/ 100) ;
       

        dd($ftot);

        //$i = new invoice;
        //$i->total=$ftot;

       return redirect('/newInvoice')->with(ftot,$ftot);*/

    }

    //update edit
    /*public function update(Request $request,$id){
        $this->validate($request,[
            'brand' => 'required',
            'model' => 'required',
            'item_name' => 'required',
            'qty' => 'required',
            'price' => 'required',
        ]);

        $brand = $req->input('brand1');
        $model = $req->input('invoice_Id');
        $item_name = $req->input('item_name');
        $price = $req->input('price');
        $qty = $req->input('qty1');

        //dd($model);
        $total= $price * $qty; 
        $list_array = array('invoice_no'=>$model,'item_no'=>$item_name,'quantity'=>$qty,'price'=>$price,'total'=>$total);
        DB::table('invoice_items')->insert($list_array);



    }*/
    
    //edit new invoice
    public function  updateInvoiceView($i_List){

        $ninvoive=invoice_item::find($i_List);
        //dd($ninvoive);
        return view('editInvoice')->with('ninvoive', $ninvoive);



    }
    
    //update  new invoice
    public function updateInvoiceData(Request $request,$i_List){
        
        //dd('dcvfdvdvdvdvdvdvdvdvdvdfv');
        $quantity = $request->input('qty1');
        $price = $request->input('price');
        $tot = $quantity * $price;
        DB::update('update invoice_items set quantity = ?,price=?,total=? where i_List = ?',[$quantity,$price,$tot,$i_List]);

        $invoice_id = DB::table('invoice_items')
       ->select('invoice_items.invoice_no')->where('i_List',$i_List)
       ->value('i_List');

        
       //$id = (string)$invoice_id;
       //dd($invoiceId);
       
       $list = item::all();
        $data =DB::table('invoices')->latest('id')->first();

        $data2 =DB::table('invoice_items')
        ->join('items','items.item_no','=','invoice_items.item_no')
        ->select('invoice_items.i_List','invoice_items.item_no','items.item_description','invoice_items.quantity','invoice_items.price','invoice_items.total')
        ->where('invoice_items.invoice_no',$invoice_id)
        ->get();

        

          return view('/newInvoice',compact('list','data2','data'));

        

        

        //->with('success','Data Updated');

        /*
        $i_List=$request->iNo;
        $ninvoive=invoice_item::find($i_List);
        $quantity=$request->input('qty1');;
        $price=$request->input('price');;

       // $i_List = $request->input('iNo');
        $invoice_no = $request->invoiceNo;
       // $item_no = $request->input('itemNo');
        //$quantity = $request->input('qty1');
        //$price = $request->input('price'); 
        $total= $price * $quantity; 
        
        $wBuyer=invoice_item::find($i_List);

        
        $wBuyer->quantity=  $quantity;
        $wBuyer->price= $price;
        $wBuyer->total= $total;

      //  $list_array = array('invoice_no'=>$invoice_no,'item_no'=>$item_no,'quantity'=>$quantity,'price'=>$price,'total'=>$total);
        //DB::table('invoice_items')->insert($list_array)
        //->where('i_List',$i_List);

       
        // $list_array = array('quantity'=>$quantity,'price'=>$price,'total'=>$total);
        ////DB::table('invoice_items')->insert($list_array);
        
        
       // $data2 =DB::table('invoice_items')
         //   ->select('invoice_items.i_List','invoice_items.quantity','invoice_items.price','invoice_items.total')
           // ->get();
        
        $wBuyer->save();
        $data =DB::table('invoices')->latest('id')->first();
        
        $data2 =DB::table('invoice_items')
        ->select('invoice_items.i_List','invoice_items.quantity','invoice_items.price','invoice_items.total')->where('invoice_items.invoice_no',$invoice_no)
        ->get();

        $list = item::all();
        
        $newI =invoice_item::all();
        */
      //  return view('wholeSaleBuyer')->with('wholeSaleBuyer', $wholeSaleBuyer);
        //return redirect('/newInvoice');
        //return redirect('newInvoice')->with('success','Data Updated');
    }


    //insert total to the invoice table
    public function finish(){
            

    }

    public function search(Request $request){
        $search = $request->get('search');
        //$posts = DB::table('invoice_item')->where('invoice_no','LIKE','%'.$search.'%');
        $posts = DB::table('invoice_item')->where('invoice_no','.$search.');
        //return view('',['Item'=>$posts]);


        return view('searchResultInvoice',compact('search'),['Item'=>$posts]);
    }

    public function index(Request $request){
        return view ('$request.qty');

    }

    public function editI(){
        return view('/editInvoice');
    }

    public function gudRI(){
        return view('/gdrInvoice');
    }
    public function egudRI(){
        return view('/editGRInvoice');
    }

    public function wsbuyer(){
        return view('/wsbuyer');
    }

    
    public function editGRI($item_no){
        
    }

    //edit relevent item qty and price
    /*public function editItem(){
        $list = item::all();
        $list2 = invoice_item::all();

        $data =DB::table('invoice_items')
            ->join('items','items.item_no','item_no')
            ->select('invoice_items.item_no','items.item_description','invoice_items.quantity','invoice_items.price')
            ->where('invoice_items.item_no','=','items.item_no')
            ->get();

        
        

        return view('/editInvoice')->with('Items($data)');
    }*/

    public function editItemView($i_List){

        $invoiceItem = invoice_item::find($i_List);
       //// dd($i_List);
        return view('editInvoice')->with('InvoiceData',  $invoiceItem);


    }

    public function searchInvoice(Request $request){

        $search = $request->get('search');
        $posts =  invoice_item::where('invoice_no','like',$search)->paginate(10);

        /*$posts =DB::table('invoice_items')
            ->join('items','invoice_items.item_no','=','items.item_no')
            ->select('invoice_items.i_List','invoice_items.item_no','items.item_description','invoice_items.quantity','invoice_items.price','invoice_items.total')
            ->where('invoice_items.invoice_no','like',$search)
            ->paginate(10);*/
        

        $list = invoice::all();
        $ldate = date('Y-m-d H:i:s');
        $list_arrayn = array(
        
        'date'=>$ldate,
        'discout'=>"0",
        'total'=>"0",
        'type'=>"GoodReturn Invoice",
        'buyer_id'=>"null",
        'seller_id'=>"null"
        );

        DB::table('invoices')->insert($list_arrayn);
       

        //return view('searchResultInvoice' , ['posts'=> $posts]);


        $list = item::all();
        //$stock_has_items = stock_has_item::all();
        //$stocks= stock::all();
        $invoice_item = invoice_item::all();
        //$invoice = invoice::all();       
        $invoice_id=$request->invoice_id;

        //get Values To table
        $data2 =DB::table('invoice_items')
            ->join('items','items.item_no','=','invoice_items.item_no')
            ->select('invoice_items.i_List','invoice_items.item_no','items.item_description','invoice_items.quantity','invoice_items.price','invoice_items.total')
            ->where('invoice_items.invoice_no',$invoice_id)
            ->get();


        $data =DB::table('invoices')->latest('id')->first();
        //dd($data2);
        
        //////////NEW CODE/////////

        /* $data =invoice::select('id')
        ->where('total','=',0)
        ->get();*/
        
        ///////////////////////////
        if(!empty($invoiceNo)){
            $datas = DB::table('invoice_items')
            ->select('invoice_items.item_no','invoice_items.quantity','invoice_items.price','invoice_items.total')->where('invoice_items.invoice_no',$invoiceNo)
            ->get();
           // dd($datas);
            }
            else
            {
                $datas = array('item_no'=>0,'quantity'=>0,'price'=>0,'total'=>0);

                //dd($datas);

                //$datas->item_no =  "0"; 
                //dd($datas);
            }
      

        return view('searchResultInvoice',compact('list','data2','data','datas'),['posts'=> $posts]);
    }

    //finish view
    public function finishInvoiceView($id){

        $fInvoice=invoice::find($id);
        /*$itemInvoice= DB::table('invoice_items')
        ->select('invoice_items.item_no','invoice_items.invoice_no','invoice_items.quantity','invoice_items.price','invoice_items.total')
        ->where('invoice_items.invoice_no','=',$id)
        ->get();*/

        $itemdetails =item::all();

        $itemInvoice= DB::table('invoice_items')
        ->join('items','invoice_items.item_no','=','items.item_no')
        ->select('invoice_items.item_no','invoice_items.invoice_no','items.item_description','invoice_items.quantity','invoice_items.price','invoice_items.total')
        ->where('invoice_items.invoice_no','=',$id)
        ->get();


       // dd($fInvoice,$itemInvoice);
        return view('finalView',compact('fInvoice','itemInvoice','itemdetails'));



    }


    //for create document :

        function  index_in_item_Detail(){

            $invoiceItem_data = $this->get_invoiceItem_data();
            return view('dynamic_pdf_Invoice')->with('invoiceItem_data',$invoiceItem_data);
            
        }

        function get_invoiceItem_data(){

            $invoiceItem_data = DB::table('invoice_items')
                            ->limit(10)
                            ->get();//returns the result in an array format
            return  $invoiceItem_data;
        
        }
        
        function pdf_invoice($id){
        
          $pdf = \App::make('dompdf.wrapper');
          $pdf->loadHTML($this->convert_invoiceItem_data_to_html($id));
          //$png = file_get_contents("logo.png");
          return $pdf->stream();//Using this method we can show the pdf file in the browser
        
        }
        
        function convert_invoiceItem_data_to_html($id){
        
            
        $fInvoice=invoice::find($id);
        $itemdetails =item::all();

        $itemInvoice= DB::table('invoice_items')
        ->join('items','invoice_items.item_no','=','items.item_no')
        ->select('invoice_items.item_no','invoice_items.invoice_no','items.item_description','invoice_items.quantity','invoice_items.price','invoice_items.total')
        ->where('invoice_items.invoice_no','=',$id)
        ->get();

          $png = file_get_contents("images/logo.png");
          $pngBase64 = base64_encode($png);

          $output = '';
        
          $output = '<head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
         
          <title>Invoice Details</title>
          <style>
          .footer {
             position: fixed;
             left: 0;
             bottom: 0;
             width: 100%;
             background-color:#e6a756 ;
             color: white;
             text-align: center;
          }
          th{
              padding: 8px;
          }

          td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
          }
          
          </style>
         
        
          
        </head>
        <body>
        
        
        <img src="data:image;base64,'.$pngBase64.'" width="110" height="100" style="float:left; margin-top:-2.2% ;padding-left:0.5%">
        
        <h1 align="center">
              <!--<span class="site-heading-upper text-primary mb-3">A Free Bootstrap 4 Business Theme</span>-->
              <span class="site-heading-lower" style="color:#e6a756">Ranjith Motors & Auto Parts</span>
        </h1>
        
        
        <br>
        <h5 style = "float:left;"> Address : Colombo Road, Dambokka, Kurunegala, Srilanka 600000</h5>
        <h5 style = "float:right;"> Telephone: +94 372231201/+94 372222902</h5>
        
         <br><br>
        <hr>
        <br>
        
        <div class="input-group">

        <br>
        
      <h4>
        Invoice No &nbsp; :  &nbsp;&nbsp;&nbsp;
      '.$fInvoice->id.' &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; 
      &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;  Date : &nbsp;&nbsp; 
    '.$fInvoice->date.'&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; 
    &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Type : &nbsp;&nbsp;  
    '.$fInvoice->type.'
    <br><br>
    Saler ID &nbsp; :  &nbsp;&nbsp;&nbsp;
      '.$fInvoice->seller_id.' 
      <br><br> Whole Sale Buyer ID &nbsp; : &nbsp;&nbsp; 
    '.$fInvoice->buyer_id.'
    
    </h4>

          <br>
          
    <table  style="width:100%" >
                     <tr>
                    <th style="border: 1px solid;"> Item No</th>
                    <th style="border: 1px solid;"> Item Name</th>
                    <th style="border: 1px solid;"> Quantity</th>
                    <th style="border: 1px solid;"> Price</th>
                    <th style="border: 1px solid;">Total</th>
                    
                    </tr>';
                     foreach($itemInvoice as $item){
                $output.=' <tr text-align: "left" >
                       <td style="border: 1px solid; " >&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;  '.$item->item_no.'</td>
                       <td style="border: 1px solid; " >&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;  '.$item->item_description.'</td>
                      
                      <td style="border: 1px solid;">&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; '.$item->quantity.'</td>
                     <td style="border: 1px solid;">&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;  '.$item->price.'</td>
                        <td style="border: 1px solid;">&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; '.$item->total.'</td>
                
                 </tr>
                 ';}
                 $output.='   </table>

            <br>
            <h4 style = "float:right;">Discount :  &nbsp;&nbsp;&nbsp;&nbsp;
            '.$fInvoice->discout.' &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; 
            <br> <br> Total : &nbsp;&nbsp; &nbsp;
          '.$fInvoice->total.' &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;
          </h4>
          
        </div>
        <br>



        
        </body>
           
       
              ';
          
      
          return $output;
             
          }
          
          function pdf_grinvoice($id){

            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($this->convert_gri($id));
            return $pdf->stream();//Using this method we can show the pdf file in the browser
          
          }
          public function convert_gri($id){

            $gInvoice=invoice::find($id);
            $gitemdetails =item::all();

            $data3 =DB::table('invoice_items')
            ->join('items','items.item_no','=','invoice_items.item_no')
            ->select('invoice_items.i_List','invoice_items.item_no','invoice_items.invoice_no','items.item_description','invoice_items.quantity','invoice_items.price','invoice_items.total')
            ->where('invoice_items.invoice_no',$id)
            ->get();

            
          $png = file_get_contents("images/logo.png");
          $pngBase64 = base64_encode($png);

          $output = '';
        
          $output = '<head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
         
          <title>Invoice Details</title>
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
          th{
              padding: 8px;
          }

          td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
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
        
        <br>
        <img src="data:image;base64,'.$pngBase64.'" width="110" height="100" style="float:left; margin-top:-2.2% ;padding-left:0.5%">
        
        <h1 align="center">
              <!--<span class="site-heading-upper text-primary mb-3">A Free Bootstrap 4 Business Theme</span>-->
              <span class="site-heading-lower" style="color:#e6a756">Ranjith Motors & Auto Parts<br>Invoice</span>
        </h1>
        
        
        <br>
        <h5 style = "float:left;"> Address : Colombo Road, Dambokka, Kurunegala, Srilanka 600000</h5>
        <h5 style = "float:right;"> Telephone: +94 372231201/+94 372222902</h5>
        
         <br><br>
        <hr>
        <br>
        
        <div class="input-group">

        <br>
        
        <h4>
        Invoice No &nbsp; :  &nbsp;&nbsp;&nbsp;
      '.$gInvoice->id.' &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; 
      &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;  Date : &nbsp;&nbsp; 
    '.$gInvoice->date.'&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp; &nbsp;&nbsp;
    &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Type : &nbsp;&nbsp;  
    '.$gInvoice->type.'
    <br><br>
  
    
    </h4>

          <br>
          
    <table  style="width:100%" >
                     <tr>
                    <th style="border: 1px solid;"> Item No</th>
                    
                    <th style="border: 1px solid;"> Quantity</th>
                    <th style="border: 1px solid;"> Price</th>
                    <th style="border: 1px solid;">Total</th>
                    
                    </tr>';
                     foreach($data3 as $item){
                $output.=' <tr text-align: "left" >
                       <td style="border: 1px solid; " >&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;  '.$item->item_no.'</td>
                    
                      
                      <td style="border: 1px solid;">&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; '.$item->quantity.'</td>
                     <td style="border: 1px solid;">&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;  '.$item->price.'</td>
                        <td style="border: 1px solid;">&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; '.$item->total.'</td>
                
                 </tr>
                 ';}
                 $output.='   </table>

            <br>

            <h4 style = "float:right;">Discount :  &nbsp;&nbsp;&nbsp;&nbsp;
            '.$gInvoice->discout.' &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; 
            <br> <br> Total : &nbsp;&nbsp; &nbsp;
          '.$gInvoice->total.' &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;
          </h4>
           
        </div>
        <br>
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



        
        </body>
           
       
              ';
          
      
          return $output;


          }


}

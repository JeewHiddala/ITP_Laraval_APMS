<?php

namespace App\Http\Controllers;

use App\Item;
use App\Stock;
use App\StockHasItem;
use Illuminate\Http\Request;
use Response;
use Redirect;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class StockItemController extends Controller
{

    static $st_before_value;

    public function getItemNos()
    {

        $item_no = Item::all();

        //dd($invoices);

        return $item_no;

    }

    public function getItemDetails(Request $request)
    {

        $data= Item::select('item_description','m_category','s_category','brand','country','quality','warranty','v_model_no','v_model_name','v_class','year','quantity','cost','selling_price')->where('id',$request->id)->first();
        return response()->json($data);//then sent this data to ajax success

    }

    public function store(Request $request) {

        //$this->max_quantity = 100;
        if($this->manageStocks($request->i_number, $request->stock_type)){

            return Redirect::back()->withErrors(['Cannot Add stock, Already exists']);

        }
        else
        {

            $stock = new Stock;
            $this->validate($request,[
                'stock_des'=>'required|max:100|min:2|unique:stocks,stock_description',
                'i_number'=>'required',
                'stock_type'=> 'required',
            ]);

            $stock->stock_description = $request->stock_des;
            $stock->stock_type = $request->stock_type;
            $stock->st_quantity = $request->stock_quantity;
            //$stock->last_inserted_quantity = $request->l_stock_quantity;
            $stock->rol = $request->rol;
            $stock->department = $request->department;
            $stock->line_no = $request->line_no;

            $itemNo = $request->i_number;



            $stock->save();

            //var_dump($stock->id);
            //die();

            $stockItem = new StockHasItem;

            $stockItem->st_id = $stock->id;
            $stockItem->it_id = $itemNo;

            $stockItem->save();

            $this->updateItemQuantity($itemNo, $request->stock_quantity);


            return redirect()->back();

        }


    }

    public function manageStocks($ino, $s_type) {

        $data = DB::table('stock_has_items')
            ->join('stocks','stocks.stock_id','st_id')
            ->join('items','items.id','it_id')
            ->orderBy('stocks.stock_id', 'ASC')
            ->whereRaw('id = "'.$ino.'"and stock_type = "'.$s_type.'"')
            //->where('stocks.stock_type', '=', $s_type)
            ->get();

        if(count($data) > 0) {

            return true;

        }
        else
        {
            return false;
        }

    }

    public function  updateItemQuantity($id, $stq) {
        $item = Item::find($id);
        $item->quantity = $item->quantity + $stq;
        $item->save();
    }

    public function  updateStockQuantity($id, $liq) {
        $stock = Stock::where('stock_id', '=', $id)->firstOrFail();
        $stock->st_quantity = $stock->st_quantity + $liq;
        Stock::where('stock_id', $id)->update(array('st_quantity' =>$stock->st_quantity));
    }

    public function index(Request $request) {
        //join query
        $data = DB::table('stock_has_items')
            ->join('stocks','stocks.stock_id','st_id')
            ->join('items','items.id','it_id')
            ->orderBy('stocks.stock_id', 'ASC')
            //->get();
            ->paginate(5);

        //dd($data);

        return view('add_stock',['stockItems'=> $data, 'item_no'=>$this->getItemNos()]);

    }


    public function edit($id)
    {
        //dd($id);
        $stockItem = StockHasItem::where('stock_item_id', '=', $id)->firstOrFail();

        $data = DB::table('stock_has_items')
            ->join('stocks','stocks.stock_id','st_id')
            ->join('items','items.id','it_id')
            ->orderBy('stocks.stock_id', 'ASC')
            ->where('stock_item_id', '=', $id)
            ->get();

        //dd($data);

        return view('stockItems_update', ['stockItems'=> $data, 'item_no'=>$this->getItemNos()], compact('stockItem', 'id'));

    }

    public function update(Request $request,$id)
    {

        $stockItem = StockHasItem::where('stock_item_id', '=', $id)->firstOrFail();

        $stock = Stock::where('stock_id', '=', $stockItem->st_id)->firstOrFail();


        $this->validate($request, [

            'stock_quantity' => 'required'
        ]);

        Stock::where('stock_id', $stockItem->st_id)->update(array('st_quantity' =>$request->post('stock_quantity')));
        Stock::where('stock_id', $stockItem->st_id)->update(array('last_inserted_quantity' =>$request->post('l_stock_quantity')));
        Stock::where('stock_id', $stockItem->st_id)->update(array('rol' =>$request->post('rol')));
        Stock::where('stock_id', $stockItem->st_id)->update(array('department' =>$request->post('department')));
        Stock::where('stock_id', $stockItem->st_id)->update(array('line_no' =>$request->post('line_no')));



        $item = Item::where('id', '=', $stockItem->it_id)->firstOrFail();
        Item::where('id', $stockItem->it_id)->update(array('quantity' =>$request->post('quantity')));

        $this->updateItemQuantity($item->id, $request->l_stock_quantity);

        $this->updateStockQuantity($stock->stock_id, $request->l_stock_quantity);

        return redirect()->route('add_stock' )->with('Success', 'Data Updated');
    }

    public function destroy($id) {
        $stockItem = StockHasItem::where('stock_item_id', '=', $id)->firstOrFail();
        $stock = Stock::where('stock_id', '=', $stockItem->st_id)->firstOrFail();

        StockHasItem::where('stock_item_id', '=', $id)->delete();
        Stock::where('stock_id', $stockItem->st_id)->delete();

        return redirect()->route('add_stock')->with('Success', 'Data Deleted');
    }

    public function rolItems(Request $request) {

        $data = DB::table('stock_has_items')
            ->join('stocks','stocks.stock_id','st_id')
            ->join('items','items.id','it_id')
            ->orderBy('stocks.stock_id', 'ASC')
            ->whereRaw('st_quantity < CAST(rol*0.25 as Int) and stock_type="good_stock"')
            ->get();


        return view('reOrderLevelItems',['stockItems'=> $data, 'item_no'=>$this->getItemNos()]);
        //dd($data);

    }

    public function rolItemsSearch(Request $request)
    {
        $search = $request->get('searchBar');
        $data = DB::table('stock_has_items')
            ->join('stocks', 'stocks.stock_id', 'st_id')
            ->join('items', 'items.id', 'it_id')
            ->orderBy('stocks.stock_id', 'ASC')
            ->whereRaw('st_quantity < CAST(rol*0.25 as Int) and stock_type="good_stock"')
            ->Where('items.item_description','LIKE', '%'.$search.'%')
            ->orWhere('items.item_no', 'LIKE', '%'.$search.'%')
            ->paginate(5);

        return view('rol_itemsSearchResults', ['stockItems' => $data, 'item_no' => $this->getItemNos()]);
    }

    public function rolItemsReportAll(Request $request) {
        $data = DB::table('stock_has_items')
            ->join('stocks','stocks.stock_id','st_id')
            ->join('items','items.id','it_id')
            ->orderBy('stocks.stock_id', 'ASC')
            ->whereRaw('st_quantity < CAST(rol*0.25 as Int) and stock_type="good_stock"')
            ->get();

        return view('rol_items_reports',['stockItems'=> $data, 'item_no'=>$this->getItemNos()]);
    }

    public function rolStocksReportPDF(Request $request)
    {

            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($this->SearchedROLItemspdf());
            $pdf->setPaper('A4', 'landscape');
            return $pdf->stream();
    }

    function SearchedROLItemspdf()
    {
        $data = DB::table('stock_has_items')
            ->join('stocks','stocks.stock_id','st_id')
            ->join('items','items.id','it_id')
            ->orderBy('stocks.stock_id', 'ASC')
            ->whereRaw('st_quantity < CAST(rol*0.25 as Int) and stock_type="good_stock"')
            ->paginate(5);

        $total  = DB::table('stock_has_items')
            ->join('stocks','stocks.stock_id','st_id')
            ->join('items','items.id','it_id')
            ->orderBy('stocks.stock_id', 'ASC')
            ->whereRaw('st_quantity < CAST(rol*0.25 as Int) and stock_type="good_stock"')
            ->select([DB::raw('Sum(st_quantity) OVER () AS total_stocks')])
            ->value('total_stocks');

        $totalItems  = DB::table('stock_has_items')
            ->join('stocks','stocks.stock_id','st_id')
            ->join('items','items.id','it_id')
            ->orderBy('stocks.stock_id', 'ASC')
            ->whereRaw('st_quantity < CAST(rol*0.25 as Int) and stock_type="good_stock"')
            ->select([DB::raw('Count(item_no) OVER () AS total_rol_items')])
            ->value('total_rol_items');


        $png = file_get_contents("images/logo.png");
        $pngBase64 = base64_encode($png);

        date_default_timezone_set('Asia/Colombo');
        $date = date('m/d/Y h:i:s a', time());

        $output = '
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Re-Order Items Reports</title>
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
                <img src="data:image;base64,'.$pngBase64.'" width="110" height="100" style="float:left; margin-top:-2.2% ;padding-left:0.5%">

                <h1 align="center">
                    <span class="site-heading-lower" style="color:#e6a756">Ranjith Motors & Auto Parts</span>
                </h1>
                <br>
                    <h5 style = "float:left;"> Address : Colombo Road, Dambokka, Kurunegala, Srilanka 600000</h5>
                    <h5 style = "float:right;"> Telephone: +94 372231201/+94 372222902</h5>
                    <br><br>
                <hr>








        <p> Date and Time : '.$date.'</p><br>


        <p>Re-Order Items Stock</p><br>
        <table width="100%" style="border-collapse: collapse; border: 0px;">
        <tr>
                <th style="border: 1px solid; padding:4px;">Stock ID</th>
                <th style="border: 1px solid; padding:4px;">Stock Description</th>
                <th style="border: 1px solid; padding:4px;">Stock Type</th>
                <th style="border: 1px solid; padding:4px;">Stock Quantity</th>
                <th style="border: 1px solid; padding:4px;">Department</th>
                <th style="border: 1px solid; padding:4px;">Line No</th>
                <th style="border: 1px solid; padding:4px;">Item No</th>
                <th style="border: 1px solid; padding:4px;">Item Description</th>
                <th style="border: 1px solid; padding:4px;">Main Category</th>
                <th style="border: 1px solid; padding:4px;">Brand</th>
                <th style="border: 1px solid; padding:4px;">Quality</th>
                <th style="border: 1px solid; padding:4px;">Vehicle Model No</th>
                <th style="border: 1px solid; padding:4px;">Cost</th>
                <th style="border: 1px solid; padding:4px;">Selling Price</th>
                <th style="border: 1px solid; padding:4px;">Quantity</th>
        </tr>
            ';

        foreach($data as $data)
        {

            $output .= '
            <tr>
                <td style="border: 1px solid; padding:4px;">'.$data->stock_id.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->stock_description.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->stock_type.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->st_quantity.'</td>
                <td style="border: 1px solid; padding:4px;text-align:center;">'.$data->department.'</td>
                <td style="border: 1px solid; padding:4px;text-align:center;">'.$data->line_no.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->item_no.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->item_description.'</td>
                <td style="border: 1px solid; padding:4px;text-align:center;">'.$data->m_category.'</td>
                <td style="border: 1px solid; padding:4px;text-align:center;">'.$data->brand.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->quality.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->v_model_no.'</td>
                <td style="border: 1px solid; padding:4px;text-align:right;">'.$data->cost.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->selling_price.'</td>
                <td style="border: 1px solid; padding:4px;text-align:center;">'.$data->quantity.'</td>
            </tr>

            ';
        }
        $output .= '
            <tbody></tbody>
            <tfoot>
                <tr id = "rowid1">
                    <th colspan="14" style="text-align:right; border: 1px solid; padding:4px;">Number of Re-Order Items :</th>
                    <th id = "total_stocks" class = "id" style="border: 1px solid; padding:4px;">'.$totalItems.'</th>
                </tr>
                <tr id = "rowid">
                    <th colspan="14" style="text-align:right; border: 1px solid; padding:4px;">Total Re-Order Items Stock Quantity :</th>
                    <th id = "total_stocks" class = "id" style="border: 1px solid; padding:4px;">'.$total.'</th>
                </tr>
            </tfoot>
            ';


        $output .= '</table>

            <div class="footer">
                <hr>
                    <div class="inline"  style="float:left;">
                        <p style="LINE-HEIGHT:10px; font-size:12px"> 2020 Ranjith Motors And Auto Parts</p>
                        <p style="LINE-HEIGHT:10px;  font-size:12px"> Colombo Road,<p>
                        <p style="LINE-HEIGHT:10px; font-size:12px"> Dambokka,</p>
                        <p style="LINE-HEIGHT:10px; font-size:12px"> Kurunegala,Srilanka</p>

            </div>

            <div class="a" style="float:bottom">
            <p  style="font-size:12px">&copy; 2020 Ranjith Motors All Rights Reserved</p>
            </div>

            <div class="c" style="display:inline;">
                <p style="LINE-HEIGHT:10px; font-size:12px"> +94 372231201</p>
                <p style="LINE-HEIGHT:10px; font-size:12px"> +94 372222902</p>
                <p  style="LINE-HEIGHT:10px; font-size:12px"> E: info@ranjithmotors.com</p>
            </div>

 </div>
            ';

        return $output;
    }



    public  function stocksReportAll(Request $request) {

        if(!empty($request->from_date))
        {

            $from_date = $request->from_date;
            $to_date = $request->to_date;


            $data = DB::table('stock_has_items')
                ->join('stocks','stocks.stock_id','st_id')
                ->join('items','items.id','it_id')
                ->orderBy('stocks.stock_id', 'ASC')
                ->whereBetween('stock_has_items.updated_at', array($request->from_date, $request->to_date))
                ->paginate(5);

            $total = DB::table('stock_has_items')
                ->join('stocks','stocks.stock_id','st_id')
                ->join('items','items.id','it_id')
                ->orderBy('stocks.stock_id', 'ASC')
                ->select([DB::raw('Sum(st_quantity) OVER () AS total_stocks')])
                ->whereBetween('stock_has_items.updated_at', array($request->from_date, $request->to_date))
                ->value('total_stocks');

            //dd($total);

            return view('stocksReports',['stockItems'=> $data, 'item_no'=>$this->getItemNos()], compact('data','total','from_date','to_date'));


        }
        else
        {

            $from_date = 0;
            $to_date = 0;

            $data = DB::table('stock_has_items')
                ->join('stocks','stocks.stock_id','st_id')
                ->join('items','items.id','it_id')
                ->orderBy('stocks.stock_id', 'ASC')
                ->paginate(5);

            $total = DB::table('stock_has_items')
                ->join('stocks','stocks.stock_id','st_id')
                ->join('items','items.id','it_id')
                ->orderBy('stocks.stock_id', 'ASC')
                ->select([DB::raw('Sum(st_quantity) OVER () AS total_stocks')])
                ->value('total_stocks');

            //dd($total);

            return view('stocksReports',['stockItems'=> $data, 'item_no'=>$this->getItemNos()], compact('data','total','from_date','to_date'));

        }

    }

    function stocksReportPDF($from_date,$to_date)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->Stockspdf($from_date,$to_date));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream();
    }

    function Stockspdf($from_date,$to_date)
    {
        if($from_date != 0){

            $data = DB::table('stock_has_items')
                ->join('stocks','stocks.stock_id','st_id')
                ->join('items','items.id','it_id')
                ->orderBy('stocks.stock_id', 'ASC')
                ->whereBetween('stock_has_items.updated_at', array($from_date, $to_date))
                ->get();


            $total = DB::table('stock_has_items')
                ->join('stocks','stocks.stock_id','st_id')
                ->join('items','items.id','it_id')
                ->orderBy('stocks.stock_id', 'ASC')
                ->select([DB::raw('Sum(st_quantity) OVER () AS total_stocks')])
                ->whereBetween('stock_has_items.updated_at', array($from_date, $to_date))
                ->value('total_stocks');

        }
        else
        {
            $data = DB::table('stock_has_items')
                ->join('stocks','stocks.stock_id','st_id')
                ->join('items','items.id','it_id')
                ->orderBy('stocks.stock_id', 'ASC')
                ->get();

            $total = DB::table('stock_has_items')
                ->join('stocks','stocks.stock_id','st_id')
                ->join('items','items.id','it_id')
                ->orderBy('stocks.stock_id', 'ASC')
                ->select([DB::raw('Sum(st_quantity) OVER () AS total_stocks')])
                ->value('total_stocks');


        }

        $png = file_get_contents("images/logo.png");
        $pngBase64 = base64_encode($png);

        date_default_timezone_set('Asia/Colombo');
        $date = date('m/d/Y h:i:s a', time());

        $output = '
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Stocks Reports</title>
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
                <img src="data:image;base64,'.$pngBase64.'" width="110" height="100" style="float:left; margin-top:-2.2% ;padding-left:0.5%">

                <h1 align="center">
                    <span class="site-heading-lower" style="color:#e6a756">Ranjith Motors & Auto Parts</span>
                </h1>
                <br>
                    <h5 style = "float:left;"> Address : Colombo Road, Dambokka, Kurunegala, Srilanka 600000</h5>
                    <h5 style = "float:right;"> Telephone: +94 372231201/+94 372222902</h5>
                    <br><br>
                <hr>








        <p> Date and Time : '.$date.'</p><br>


        <p>Spare Parts Stocks</p><br>
        <table width="100%" style="border-collapse: collapse; border: 0px;">
        <tr>
                <th style="border: 1px solid; padding:4px;">Stock ID</th>
                <th style="border: 1px solid; padding:4px;">Stock Description</th>
                <th style="border: 1px solid; padding:4px;">Stock Type</th>
                <th style="border: 1px solid; padding:4px;">Stock Quantity</th>
                <th style="border: 1px solid; padding:4px;">Department</th>
                <th style="border: 1px solid; padding:4px;">Line No</th>
                <th style="border: 1px solid; padding:4px;">Item No</th>
                <th style="border: 1px solid; padding:4px;">Item Description</th>
                <th style="border: 1px solid; padding:4px;">Main Category</th>
                <th style="border: 1px solid; padding:4px;">Brand</th>
                <th style="border: 1px solid; padding:4px;">Quality</th>
                <th style="border: 1px solid; padding:4px;">Vehicle Model No</th>
                <th style="border: 1px solid; padding:4px;">Cost</th>
                <th style="border: 1px solid; padding:4px;">Selling Price</th>
                <th style="border: 1px solid; padding:4px;">Quantity</th>
        </tr>
            ';

        foreach($data as $data)
        {

            $output .= '
            <tr>
                <td style="border: 1px solid; padding:4px;">'.$data->stock_id.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->stock_description.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->stock_type.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->st_quantity.'</td>
                <td style="border: 1px solid; padding:4px;text-align:center;">'.$data->department.'</td>
                <td style="border: 1px solid; padding:4px;text-align:center;">'.$data->line_no.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->item_no.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->item_description.'</td>
                <td style="border: 1px solid; padding:4px;text-align:center;">'.$data->m_category.'</td>
                <td style="border: 1px solid; padding:4px;text-align:center;">'.$data->brand.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->quality.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->v_model_no.'</td>
                <td style="border: 1px solid; padding:4px;text-align:right;">'.$data->cost.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->selling_price.'</td>
                <td style="border: 1px solid; padding:4px;text-align:center;">'.$data->quantity.'</td>
            </tr>

            ';
        }
        $output .= '
            <tbody></tbody>
            <tfoot>
                <tr id = "rowid">
                    <th colspan="14" style="text-align:right; border: 1px solid; padding:4px;">Total Stock Quantity:</th>
                    <th id = "total_stocks" class = "id" style="border: 1px solid; padding:4px;">'.$total.'</th>
                </tr>
            </tfoot>
            ';


        $output .= '</table>

            <div class="footer">
                <hr>
                    <div class="inline"  style="float:left;">
                        <p style="LINE-HEIGHT:10px; font-size:12px"> 2020 Ranjith Motors And Auto Parts</p>
                        <p style="LINE-HEIGHT:10px;  font-size:12px"> Colombo Road,<p>
                        <p style="LINE-HEIGHT:10px; font-size:12px"> Dambokka,</p>
                        <p style="LINE-HEIGHT:10px; font-size:12px"> Kurunegala,Srilanka</p>

            </div>

            <div class="a" style="float:bottom">
            <p  style="font-size:12px">&copy; 2020 Ranjith Motors All Rights Reserved</p>
            </div>

            <div class="c" style="display:inline;">
                <p style="LINE-HEIGHT:10px; font-size:12px"> +94 372231201</p>
                <p style="LINE-HEIGHT:10px; font-size:12px"> +94 372222902</p>
                <p  style="LINE-HEIGHT:10px; font-size:12px"> E: info@ranjithmotors.com</p>
            </div>

 </div>
            ';


        return $output;
    }


    public function searchItems(Request $request) {
        $search = $request->get('searchBar');
        $data = DB::table('stock_has_items')
            ->join('stocks','stocks.stock_id','st_id')
            ->join('items','items.id','it_id')
            ->orderBy('stocks.stock_id', 'ASC')->where('items.item_no','LIKE', '%'.$search.'%')->paginate(5);
        //dd($request->all());
        return view('stockItems_searchReports',['stockItems'=> $data, 'item_no'=>$this->getItemNos()]);
    }

    function searchedStocksReportPDF($item_no)
    {

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->SearchedStockspdf($item_no));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream();
    }


    function SearchedStockspdf($item_no)
    {
        $data = DB::table('stock_has_items')
            ->join('stocks','stocks.stock_id','st_id')
            ->join('items','items.id','it_id')
            ->orderBy('stocks.stock_id', 'ASC')->where('items.item_no', '=', $item_no)
            ->paginate(5);

        $total  = DB::table('stock_has_items')
              ->join('stocks','stocks.stock_id','st_id')
              ->join('items','items.id','it_id')
              ->orderBy('stocks.stock_id', 'ASC')->where('items.item_no', '=', $item_no)
              ->select([DB::raw('Sum(st_quantity) OVER () AS total_stocks')])
              ->value('total_stocks');

        $png = file_get_contents("images/logo.png");
        $pngBase64 = base64_encode($png);

        date_default_timezone_set('Asia/Colombo');
        $date = date('m/d/Y h:i:s a', time());

        $output = '
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Stocks Reports</title>
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
                <img src="data:image;base64,'.$pngBase64.'" width="110" height="100" style="float:left; margin-top:-2.2% ;padding-left:0.5%">

                <h1 align="center">
                    <span class="site-heading-lower" style="color:#e6a756">Ranjith Motors & Auto Parts</span>
                </h1>
                <br>
                    <h5 style = "float:left;"> Address : Colombo Road, Dambokka, Kurunegala, Srilanka 600000</h5>
                    <h5 style = "float:right;"> Telephone: +94 372231201/+94 372222902</h5>
                    <br><br>
                <hr>








        <p> Date and Time : '.$date.'</p><br>


        <p>'.$item_no.' Item Stock</p><br>
        <table width="100%" style="border-collapse: collapse; border: 0px;">
        <tr>
                <th style="border: 1px solid; padding:4px;">Stock ID</th>
                <th style="border: 1px solid; padding:4px;">Stock Description</th>
                <th style="border: 1px solid; padding:4px;">Stock Type</th>
                <th style="border: 1px solid; padding:4px;">Stock Quantity</th>
                <th style="border: 1px solid; padding:4px;">Department</th>
                <th style="border: 1px solid; padding:4px;">Line No</th>
                <th style="border: 1px solid; padding:4px;">Item No</th>
                <th style="border: 1px solid; padding:4px;">Item Description</th>
                <th style="border: 1px solid; padding:4px;">Main Category</th>
                <th style="border: 1px solid; padding:4px;">Brand</th>
                <th style="border: 1px solid; padding:4px;">Quality</th>
                <th style="border: 1px solid; padding:4px;">Vehicle Model No</th>
                <th style="border: 1px solid; padding:4px;">Cost</th>
                <th style="border: 1px solid; padding:4px;">Selling Price</th>
                <th style="border: 1px solid; padding:4px;">Quantity</th>
        </tr>
            ';

        foreach($data as $data)
        {

            $output .= '
            <tr>
                <td style="border: 1px solid; padding:4px;">'.$data->stock_id.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->stock_description.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->stock_type.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->st_quantity.'</td>
                <td style="border: 1px solid; padding:4px;text-align:center;">'.$data->department.'</td>
                <td style="border: 1px solid; padding:4px;text-align:center;">'.$data->line_no.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->item_no.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->item_description.'</td>
                <td style="border: 1px solid; padding:4px;text-align:center;">'.$data->m_category.'</td>
                <td style="border: 1px solid; padding:4px;text-align:center;">'.$data->brand.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->quality.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->v_model_no.'</td>
                <td style="border: 1px solid; padding:4px;text-align:right;">'.$data->cost.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->selling_price.'</td>
                <td style="border: 1px solid; padding:4px;text-align:center;">'.$data->quantity.'</td>
            </tr>

            ';
        }
        $output .= '
            <tbody></tbody>
            <tfoot>
                <tr id = "rowid">
                    <th colspan="14" style="text-align:right; border: 1px solid; padding:4px;">Total Stock Quantity for Item '.$item_no.':</th>
                    <th id = "total_stocks" class = "id" style="border: 1px solid; padding:4px;">'.$total.'</th>
                </tr>
                <tr id = "rowid1">
                    <th colspan="14" style="text-align:right; border: 1px solid; padding:4px;">Total '.$item_no.' Item Quantity :</th>
                    <th id = "total_stocks" class = "id" style="border: 1px solid; padding:4px;">'.$data->quantity.'</th>
                </tr>
            </tfoot>
            ';


        $output .= '</table>

            <div class="footer">
                <hr>
                    <div class="inline"  style="float:left;">
                        <p style="LINE-HEIGHT:10px; font-size:12px"> 2020 Ranjith Motors And Auto Parts</p>
                        <p style="LINE-HEIGHT:10px;  font-size:12px"> Colombo Road,<p>
                        <p style="LINE-HEIGHT:10px; font-size:12px"> Dambokka,</p>
                        <p style="LINE-HEIGHT:10px; font-size:12px"> Kurunegala,Srilanka</p>

            </div>

            <div class="a" style="float:bottom">
            <p  style="font-size:12px">&copy; 2020 Ranjith Motors All Rights Reserved</p>
            </div>

            <div class="c" style="display:inline;">
                <p style="LINE-HEIGHT:10px; font-size:12px"> +94 372231201</p>
                <p style="LINE-HEIGHT:10px; font-size:12px"> +94 372222902</p>
                <p  style="LINE-HEIGHT:10px; font-size:12px"> E: info@ranjithmotors.com</p>
            </div>

 </div>
            ';

        return $output;
    }


    public function searchStocks(Request $request) {
        //dd($request->all());
        $search = $request->get('searchBar');
        $data = DB::table('stock_has_items')
            ->join('stocks','stocks.stock_id','st_id')
            ->join('items','items.id','it_id')
            ->orderBy('stocks.stock_id', 'ASC')
            ->where('stocks.stock_description','LIKE', '%'.$search.'%')
            ->orWhere('stocks.stock_id', 'LIKE', '%'.$search.'%')
            ->orWhere('stocks.stock_type', 'LIKE', '%'.$search.'%')
            ->orWhere('items.item_description','LIKE', '%'.$search.'%')
            ->orWhere('items.item_no', 'LIKE', '%'.$search.'%')->paginate(5);
        return view('stocksSearchResults',['stockItems'=> $data, 'item_no'=>$this->getItemNos()]);
    }


    public function stocksCharts(Request $request) {

        if(!empty($request->from_date))
        {
            $from_date = $request->from_date;
            $to_date = $request->to_date;

            $data = DB::table('stock_has_items')
                ->join('stocks','stocks.stock_id','st_id')
                ->join('items','items.id','it_id')
                ->orderBy('stocks.stock_id', 'ASC')
                ->whereBetween('stock_has_items.updated_at', array($from_date, $to_date))
                ->get();

            //dd($total);

            return view('stocks_charts',['stockItems'=> $data, 'item_no'=>$this->getItemNos()], compact('data','from_date','to_date'));


        }
        else
        {

            $from_date = 0;
            $to_date = 0;

            $data = DB::table('stock_has_items')
                ->join('stocks','stocks.stock_id','st_id')
                ->join('items','items.id','it_id')
                ->orderBy('stocks.stock_id', 'ASC')
                ->get();

            return view('stocks_charts',['stockItems'=> $data, 'item_no'=>$this->getItemNos()], compact('data','from_date','to_date'));

        }
    }

    function stocksBarCharts($from_date,$to_date)
    {
        $data = DB::table('stock_has_items')
            ->join('stocks','stocks.stock_id','st_id')
            ->join('items','items.id','it_id')
            ->orderBy('stocks.stock_id', 'ASC')
            ->where('stocks.st_quantity', '>', 0)
            ->whereBetween('stock_has_items.updated_at', array($from_date, $to_date))
            ->paginate(10);
        //dd($items);
        return view('stocks_barCharts',['stockItems'=> $data, 'item_no'=>$this->getItemNos()], compact('data','from_date','to_date'));
    }

    function stocksPieCharts($from_date,$to_date)
    {

        $data = DB::table('stock_has_items')
            ->join('stocks','stocks.stock_id','st_id')
            ->join('items','items.id','it_id')
            ->orderBy('stocks.stock_id', 'ASC')
            ->where('stocks.st_quantity', '>', 0)
            ->whereBetween('stock_has_items.updated_at', array($from_date, $to_date))
            ->paginate(10);
        //dd($items);
        return view('stocks_pieCharts',['stockItems'=> $data, 'item_no'=>$this->getItemNos()], compact('data','from_date','to_date'));
    }


    public function rolItemsCharts(Request $request) {

        $data = DB::table('stock_has_items')
            ->join('stocks','stocks.stock_id','st_id')
            ->join('items','items.id','it_id')
            ->orderBy('stocks.stock_id', 'ASC')
            ->whereRaw('st_quantity < CAST(rol*0.25 as Int) and stock_type="good_stock"')
            ->get();


            return view('rol_items_charts',['stockItems'=> $data, 'item_no'=>$this->getItemNos()], compact('data'));

    }

    function rolItemsBarCharts(Request $request)
    {
        $data = DB::table('stock_has_items')
            ->join('stocks','stocks.stock_id','st_id')
            ->join('items','items.id','it_id')
            ->orderBy('stocks.stock_id', 'ASC')
            ->whereRaw('st_quantity < CAST(rol*0.25 as Int) and stock_type="good_stock"')
            ->paginate(10);
        //dd($items);
        return view('rol_itemsBarCharts',['stockItems'=> $data, 'item_no'=>$this->getItemNos()], compact('data'));
    }

    function rolItemsPieCharts(Request $request)
    {

        $data = DB::table('stock_has_items')
            ->join('stocks','stocks.stock_id','st_id')
            ->join('items','items.id','it_id')
            ->orderBy('stocks.stock_id', 'ASC')
            ->whereRaw('st_quantity < CAST(rol*0.25 as Int) and stock_type="good_stock"')
            ->paginate(10);
        //dd($items);
        return view('rol_itemsPieCharts',['stockItems'=> $data, 'item_no'=>$this->getItemNos()], compact('data'));
    }

}

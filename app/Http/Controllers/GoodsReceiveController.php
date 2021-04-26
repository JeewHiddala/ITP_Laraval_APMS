<?php

namespace App\Http\Controllers;

use App\Item;
use App\ForeignSupplier;
use App\goodsReceive;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use function Sodium\increment;

class GoodsReceiveController extends Controller
{
    public function getItemNos()
    {

        $item_no = Item::all();

       // dd($item_no);

        return $item_no;

    }

    public function getItemDetails(Request $request)
    {

        //dd($request->all());

        $data= Item::select('item_description','cost','selling_price')->where('id',$request->id)->first();
        return response()->json($data);//then sent this data to ajax success

    }

    public function getForeignSupplierNos()
    {

        $f_sup_no = ForeignSupplier::all();

        //dd($f_sup_no);

        return $f_sup_no;

    }

    public function getForeignSupplierDetails(Request $request)
    {

        //$data = ForeignSupplier::all();
        //dd($request);

        //$data= ForeignSupplier::select('foreign_sup_name')->where('reg_no',$request->id)->value('foreign_sup_name');
        $data= ForeignSupplier::select('foreign_sup_name')->where('reg_no',$request->id)->first();
        //dd($data);
        //error_log('Some message here.');
        return response()->json($data);//then sent this data to ajax success

    }

    public function store(Request $request) {
        $goodsReceive = new goodsReceive;
        $this->validate($request,[
            'grn_no'=>'required|max:100|min:2|unique:goods_receives,grn_no',
            'i_number'=>'required',
        ]);

        $goodsReceive->grn_no = $request->grn_no;
        $goodsReceive->grn_date = $request->r_date;
        $goodsReceive->receive_quantity = $request->r_quantity;

        $itemNo = $request->i_number;
        $goodsReceive->i_no = $itemNo;

        $foreignSupNo = $request->f_sup_no;
        $goodsReceive->f_sup_no = $foreignSupNo;

        $goodsReceive->save();

        //var_dump($stock->id);
        //die();

        //$data = Stock::all();
        return redirect()->back();
    }

    public function index(Request $request) {

        $data = DB::table('goods_receives')
            ->join('items', 'goods_receives.i_no', '=', 'items.id')
            ->join('foreign_suppliers', 'goods_receives.f_sup_no', '=', 'foreign_suppliers.reg_no')
            ->select('goods_receives.id','items.item_no','items.item_description','items.cost','items.selling_price','foreign_suppliers.reg_no','foreign_suppliers.foreign_sup_name','goods_receives.grn_no','goods_receives.grn_date','goods_receives.receive_quantity')
            ->get();

        //dd($data);


        return view('goods_receive',['goodsReceives'=> $data, 'item_no'=>$this->getItemNos(), 'reg_no'=>$this->getForeignSupplierNos()]);
        //dd($request->all());
    }

    public function edit($id)
    {
        //dd($id);
        $goodsReceive = goodsReceive::find($id);
        //dd($goodsReturn->it_id);

        $data = DB::table('goods_receives')
            ->join('items','items.id','i_no')
            ->join('foreign_suppliers','foreign_suppliers.reg_no','f_sup_no')
            ->select('goods_receives.id','items.item_no','items.item_description','items.cost','items.selling_price','foreign_suppliers.reg_no','foreign_suppliers.foreign_sup_name','goods_receives.grn_no','goods_receives.grn_date','goods_receives.receive_quantity')
            ->where('goods_receives.id', '=', $goodsReceive->id)
            //->where('f_sup_no', '=', $goodsReceive->f_sup_no)
            ->get();

        //dd($data);

        return view('goods_receive_update', ['goodsReceives'=> $data, 'item_no'=>$this->getItemNos(), 'reg_no'=>$this->getForeignSupplierNos()], compact('goodsReceive', 'id'));

    }

    function goodsReceivedNotesPDF($item_no, $grn_no, $f_sup_no)
    {

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->GRNpdf($item_no, $grn_no, $f_sup_no));
        //$pdf->setPaper('A4', 'landscape');
        return $pdf->stream();
    }


    function GRNpdf($item_no, $grn_no, $f_sup_no)
    {
        $data = DB::table('goods_receives')
            ->join('items', 'goods_receives.i_no', '=', 'items.id')
            ->join('foreign_suppliers', 'goods_receives.f_sup_no', '=', 'foreign_suppliers.reg_no')
            ->orderBy('goods_receives.id', 'ASC')
            ->where('items.item_no', '=', $item_no)
            ->where('goods_receives.grn_no', '=', $grn_no)
            ->where('goods_receives.f_sup_no', '=', $f_sup_no)
            ->paginate(5);


        $png = file_get_contents("images/logo.png");
        $pngBase64 = base64_encode($png);

        date_default_timezone_set('Asia/Colombo');
        $date = date('m/d/Y h:i:s a', time());

        $output = '
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Goods Received Notes</title>
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
            <>
                <img src="data:image;base64,' . $pngBase64 . '" width="110" height="100" style="float:left; margin-top:-2.2% ;padding-left:0.5%">

                <h1 align="center">
                    <span class="site-heading-lower" style="color:#e6a756">Ranjith Motors & Auto Parts</span>
                </h1>
                <br>
                    <h5 style = "float:left;"> Address : Colombo Road, Dambokka, Kurunegala, Srilanka 600000</h5>
                    <h5 style = "float:right;"> Telephone: +94 372231201/+94 372222902</h5>
                    <br><br>
                <hr>

       <p> Date and Time : ' . $date . '</p><br>


        <h3 style="text-align: center">'. $grn_no . ' Goods Received Note</h3><br>
        ';

        foreach($data as $data)
        {

            $output .= '

                    <label for="i_number" style="font-weight: bold">Item No:</label>&nbsp;&nbsp;&nbsp;
                    <label >' . $data->item_no . '</label>
                    <br><br>
                    <label for="i_des" style="font-weight: bold">Item Description:</label>&nbsp;&nbsp;&nbsp;
                    <label >' . $data->item_description . '</label>
                    <label for="i_cost" style="font-weight: bold">Item Cost:</label>&nbsp;&nbsp;&nbsp;
                    <label >Rs.' . $data->cost . '.00</label>
                    <br><br>
                    <label for="i_s_price" style="font-weight: bold">Item Selling Price:</label>&nbsp;&nbsp;&nbsp;
                    <label >Rs.' . $data->selling_price . '.00</label>
                    <br><br>
                    <label for="sup_no" style="font-weight: bold">Supplier No:</label>&nbsp;&nbsp;&nbsp;
                    <label >' . $data->reg_no . '</label>
                    <br><br>
                    <label for="sup_name" style="font-weight: bold">Supplier Name:</label>&nbsp;&nbsp;&nbsp;
                    <label >' . $data->foreign_sup_name . '</label>
                    <br><br>
                    <label for="grn_nos" style="font-weight: bold">Goods Received No:</label>&nbsp;&nbsp;&nbsp;
                    <label >' . $data->grn_no . '</label>
                    <br><br>
                    <label for="r_date" style="font-weight: bold">Goods Received Date:</label>&nbsp;&nbsp;&nbsp;
                    <label >' . $data->grn_date . '</label>
                    <br><br>
                    <label for="r_quant" style="font-weight: bold">Received Quantity:</label>&nbsp;&nbsp;&nbsp;
                    <label >' . $data->receive_quantity . '</label>
                    <br><br>

            ';
        }
        $output .= '
               <br><br><br><br><br><br><br><br><br><br>
              <p> Signature : ...............................................</p><br>

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

    public function update(Request $request,$id)
    {

        $goodsReceive = goodsReceive::find($id);


        $this->validate($request, [

            'r_quantity' => 'required'
        ]);

        $goodsReceive->grn_date = $request->post('r_date');
        $goodsReceive->receive_quantity = $request->post('r_quantity');
        $goodsReceive->save();
        //dd($id);
        return redirect()->route('receivedGoods' )->with('Success', 'Data Updated');
    }

    public function destroy($id) {
        $goodsReceive = goodsReceive::find($id);
        $goodsReceive->delete();


        return redirect()->route('receivedGoods')->with('Success', 'Data Deleted');
    }

    public function searchGRNs(Request $request) {
        //dd($request->all());
        $search = $request->get('searchBar');
        $data = DB::table('goods_receives')
            ->join('items', 'goods_receives.i_no', '=', 'items.id')
            ->join('foreign_suppliers', 'goods_receives.f_sup_no', '=', 'foreign_suppliers.reg_no')
            ->orderBy('goods_receives.id', 'ASC')
            ->where('goods_receives.grn_no','LIKE', '%'.$search.'%')
            ->orWhere('items.item_description','LIKE', '%'.$search.'%')
            ->orWhere('items.item_no', 'LIKE', '%'.$search.'%')
            ->orWhere('foreign_suppliers.reg_no', 'LIKE', '%'.$search.'%')
            ->orWhere('foreign_suppliers.foreign_sup_name', 'LIKE', '%'.$search.'%')->paginate(5);
        return view('goods_receiveSearchResults',['goodsReceives'=> $data, 'item_no'=>$this->getItemNos(), 'reg_no'=>$this->getForeignSupplierNos()]);
    }


    public function grnReportAll(Request $request){

        if(!empty($request->from_date))
        {

            $from_date = $request->from_date;
            $to_date = $request->to_date;


            $data = DB::table('goods_receives')
                ->join('items','items.id','i_no')
                ->join('foreign_suppliers','foreign_suppliers.reg_no','f_sup_no')
                ->orderBy('goods_receives.id', 'ASC')
                ->whereBetween('goods_receives.grn_date', array($request->from_date, $request->to_date))
                ->paginate(5);

            $total = DB::table('goods_receives')
                ->join('items','items.id','i_no')
                ->join('foreign_suppliers','foreign_suppliers.reg_no','f_sup_no')
                ->orderBy('goods_receives.id', 'ASC')
                ->select([DB::raw('Sum(goods_receives.receive_quantity) OVER () AS total_receive_goods')])
                ->whereBetween('goods_receives.grn_date', array($request->from_date, $request->to_date))
                ->value('total_receive_goods');

            //dd($total);

            return view('goods_receive_reports',['goodsReceives'=> $data, 'item_no'=>$this->getItemNos(), 'reg_no'=>$this->getForeignSupplierNos()], compact('data','total','from_date','to_date'));


        }
        else
        {

            $from_date = 0;
            $to_date = 0;

            $data = DB::table('goods_receives')
                ->join('items','items.id','i_no')
                ->join('foreign_suppliers','foreign_suppliers.reg_no','f_sup_no')
                ->orderBy('goods_receives.id', 'ASC')
                ->paginate(5);

            $total = DB::table('goods_receives')
                ->join('items','items.id','i_no')
                ->join('foreign_suppliers','foreign_suppliers.reg_no','f_sup_no')
                ->orderBy('goods_receives.id', 'ASC')
                ->select([DB::raw('Sum(goods_receives.receive_quantity) OVER () AS total_receive_goods')])
                ->value('total_receive_goods');

            //dd($total);

            return view('goods_receive_reports',['goodsReceives'=> $data, 'item_no'=>$this->getItemNos(), 'reg_no'=>$this->getForeignSupplierNos()], compact('data','total','from_date','to_date'));

        }
    }

    function GoodsReceivePDF($from_date,$to_date)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->GoodsReceivePrintpdf($from_date,$to_date));
        return $pdf->stream();
    }

    function GoodsReceivePrintpdf($from_date,$to_date)
    {
        if($from_date != 0){

            $data = DB::table('goods_receives')
                ->join('items','items.id','i_no')
                ->join('foreign_suppliers','foreign_suppliers.reg_no','f_sup_no')
                ->orderBy('goods_receives.id', 'ASC')
                ->whereBetween('goods_receives.grn_date', array($from_date, $to_date))
                ->get();


            $total = DB::table('goods_receives')
                ->join('items','items.id','i_no')
                ->join('foreign_suppliers','foreign_suppliers.reg_no','f_sup_no')
                ->orderBy('goods_receives.id', 'ASC')
                ->select([DB::raw('Sum(goods_receives.receive_quantity) OVER () AS total_receive_goods')])
                ->whereBetween('goods_receives.grn_date', array($from_date, $to_date))
                ->value('total_receive_goods');

        }
        else
        {
            $data = DB::table('goods_receives')
                ->join('items','items.id','i_no')
                ->join('foreign_suppliers','foreign_suppliers.reg_no','f_sup_no')
                ->orderBy('goods_receives.id', 'ASC')
                ->get();

            $total = DB::table('goods_receives')
                ->join('items','items.id','i_no')
                ->join('foreign_suppliers','foreign_suppliers.reg_no','f_sup_no')
                ->orderBy('goods_receives.id', 'ASC')
                ->select([DB::raw('Sum(goods_receives.receive_quantity) OVER () AS total_receive_goods')])
                ->value('total_receive_goods');


            //dd($from_date);

        }

        $png = file_get_contents("images/logo.png");
        $pngBase64 = base64_encode($png);

        date_default_timezone_set('Asia/Colombo');
        $date = date('m/d/Y h:i:s a', time());

        $output = '
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Goods Receive Reports</title>
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


        <p>Returned Items</p><br>
        <table width="100%" style="border-collapse: collapse; border: 0px;">
        <tr>
            <th style="border: 1px solid; padding:4px;">GReturn No</th>
            <th style="border: 1px solid; padding:4px;">Item No</th>
            <th style="border: 1px solid; padding:4px;">Item Description</th>
            <th style="border: 1px solid; padding:4px;">Item Cost</th>
            <th style="border: 1px solid; padding:4px;">Item Selling Price</th>
            <th style="border: 1px solid; padding:4px;">Supplier No</th>
            <th style="border: 1px solid; padding:4px;">Supplier Name</th>
            <th style="border: 1px solid; padding:4px;">Received Date</th>
            <th style="border: 1px solid; padding:4px;">Received Quantity</th>
        </tr>
            ';

        foreach($data as $data)
        {
            $output .= '
            <tr>
                <td style="border: 1px solid; padding:4px;">'.$data->grn_no.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->item_no.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->item_description.'</td>
                <td style="border: 1px solid; padding:4px;text-align:right;">'.$data->cost.'</td>
                <td style="border: 1px solid; padding:4px;text-align:right;">'.$data->selling_price.'</td>
                <td style="border: 1px solid; padding:4px;text-align:right;">'.$data->reg_no.'</td>
                <td style="border: 1px solid; padding:4px;text-align:right;">'.$data->foreign_sup_name.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->grn_date.'</td>
                <td style="border: 1px solid; padding:4px;text-align:right;">'.$data->receive_quantity.'</td>
            </tr>

            ';
        }
        $output .= '
            <tbody></tbody>
            <tfoot>
                <tr id = "rowid">
                    <th colspan="8" style="text-align:right; border: 1px solid; padding:4px;">Total Received Quantity:</th>
                    <th id = "total_receive_goods" class = "id" style="border: 1px solid; padding:4px;">'.$total.'</th>
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


    public function goodsReceiveCharts(Request $request) {

    if(!empty($request->from_date))
    {
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        $data = DB::table('goods_receives')
            ->join('items', 'goods_receives.i_no', '=', 'items.id')
            ->join('foreign_suppliers', 'goods_receives.f_sup_no', '=', 'foreign_suppliers.reg_no')
            ->orderBy('goods_receives.id', 'ASC')
            ->whereBetween('goods_receives.grn_date', array($from_date, $to_date))
            ->get();

        //dd($total);

        return view('goods_receive_charts',['goodsReceives'=> $data, 'item_no'=>$this->getItemNos(), 'reg_no'=>$this->getForeignSupplierNos()], compact('data','from_date','to_date'));


    }
    else
    {

        $from_date = 0;
        $to_date = 0;

        $data = DB::table('goods_receives')
            ->join('items', 'goods_receives.i_no', '=', 'items.id')
            ->join('foreign_suppliers', 'goods_receives.f_sup_no', '=', 'foreign_suppliers.reg_no')
            ->orderBy('goods_receives.id', 'ASC')
            ->get();

        return view('goods_receive_charts',['goodsReceives'=> $data, 'item_no'=>$this->getItemNos(), 'reg_no'=>$this->getForeignSupplierNos()], compact('data','from_date','to_date'));

    }
}

    function goodsReceiveBarCharts($from_date,$to_date)
    {
        $data = DB::table('goods_receives')
            ->join('items', 'goods_receives.i_no', '=', 'items.id')
            ->join('foreign_suppliers', 'goods_receives.f_sup_no', '=', 'foreign_suppliers.reg_no')
            ->orderBy('goods_receives.id', 'ASC')
            ->where('goods_receives.receive_quantity', '>', 0)
            ->whereBetween('goods_receives.grn_date', array($from_date, $to_date))
            ->paginate(10);
        //dd($items);
        return view('goods_receive_barCharts',['goodsReceives'=> $data, 'item_no'=>$this->getItemNos(), 'reg_no'=>$this->getForeignSupplierNos()], compact('data','from_date','to_date'));
    }

    function goodsReceivePieCharts($from_date,$to_date)
    {

        $data = DB::table('goods_receives')
            ->join('items', 'goods_receives.i_no', '=', 'items.id')
            ->join('foreign_suppliers', 'goods_receives.f_sup_no', '=', 'foreign_suppliers.reg_no')
            ->orderBy('goods_receives.id', 'ASC')
            ->where('goods_receives.receive_quantity', '>', 0)
            ->whereBetween('goods_receives.grn_date', array($from_date, $to_date))
            ->paginate(10);
        //dd($items);
        return view('goods_receive_pieCharts',['goodsReceives'=> $data, 'item_no'=>$this->getItemNos(), 'reg_no'=>$this->getForeignSupplierNos()], compact('data','from_date','to_date'));
    }

}

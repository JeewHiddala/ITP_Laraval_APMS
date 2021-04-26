<?php

namespace App\Http\Controllers;

use App\Item;
use App\goodsReturn;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GoodsReturnController extends Controller
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

    public function store(Request $request) {
        $goodsReturn = new goodsReturn;
        $this->validate($request,[
            'gre_no'=>'required|max:100|min:2|unique:goods_returns,gre_no',
            'i_number'=>'required',
        ]);

        $goodsReturn->gre_no = $request->gre_no;
        $goodsReturn->gre_date = $request->r_date;
        $goodsReturn->return_quantity = $request->r_quantity;
        $goodsReturn->damage_status = $request->d_status;

        $itemNo = $request->i_number;

        $goodsReturn->it_id = $itemNo;

        $goodsReturn->save();

        //var_dump($stock->id);
        //die();

        //$data = Stock::all();
        return redirect()->back();
    }

    public function index(Request $request) {
        //join query
        $data = DB::table('goods_returns')
            ->join('items','items.id','it_id')
            ->select('goods_returns.id', 'items.item_no', 'items.item_description','items.cost', 'items.selling_price', 'goods_returns.gre_no', 'goods_returns.return_quantity', 'goods_returns.damage_status','goods_returns.gre_date')
            ->get();

        //dd($data);

        return view('goods_return',['goodsReturns'=> $data, 'item_no'=>$this->getItemNos()]);
        //dd($request->all());
    }

    public function edit($id)
    {
        //dd($id);
        $goodsReturn = goodsReturn::find($id);

        $data = DB::table('goods_returns')
            ->join('items','items.id','it_id')
            ->where('goods_returns.it_id', '=', $goodsReturn->it_id)
            ->get();

        //dd($data);

        return view('goods_return_update', ['goodsReturns'=> $data, 'item_no'=>$this->getItemNos()], compact('goodsReturn', 'id'));

    }

    function goodsReturnNotesPrintPDF($item_no, $gre_no)
    {

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->GoodsReturnPrintpdf($item_no, $gre_no));
        //$pdf->setPaper('A4', 'landscape');
        return $pdf->stream();
    }


    function GoodsReturnPrintpdf($item_no, $gre_no)
    {
        $data = DB::table('goods_returns')
            ->join('items', 'goods_returns.it_id', '=', 'items.id')
            ->orderBy('goods_returns.id', 'ASC')
            ->where('items.item_no', '=', $item_no)
            ->where('goods_returns.gre_no', '=', $gre_no)
            ->paginate(5);

        //dd($data);

        $png = file_get_contents("images/logo.png");
        $pngBase64 = base64_encode($png);

        date_default_timezone_set('Asia/Colombo');
        $date = date('m/d/Y h:i:s a', time());

        $output = '
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Goods Return Notes</title>
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


        <h3 style="text-align: center">'. $gre_no . ' Goods Return Note</h3><br>
        ';

        foreach($data as $data)
        {

            $output .= '

                    <label for="i_number" style="font-weight: bold">Item No:</label>&nbsp;&nbsp;&nbsp;
                    <label >' . $data->item_no . '</label>
                    <br><br>
                    <label for="i_des" style="font-weight: bold">Item Description:</label>&nbsp;&nbsp;&nbsp;
                    <label >' . $data->item_description . '</label>
                    <br><br>
                    <label for="i_cost" style="font-weight: bold">Item Cost:</label>&nbsp;&nbsp;&nbsp;
                    <label >Rs.' . $data->cost .'.00</label>
                    <br><br>
                    <label for="i_se_price" style="font-weight: bold">Item Selling Price:</label>&nbsp;&nbsp;&nbsp;
                    <label >Rs.' . $data->selling_price . '.00</label>
                    <br><br>
                    <label for="retn_no" style="font-weight: bold">Goods Return No:</label>&nbsp;&nbsp;&nbsp;
                    <label >' . $data->gre_no . '</label>
                    <br><br>
                    <label for="retn_date" style="font-weight: bold">Goods Return Date:</label>&nbsp;&nbsp;&nbsp;
                    <label >' . $data->gre_date . '</label>
                    <br><br>
                    <label for="retn_quant" style="font-weight: bold">Return Quantity:</label>&nbsp;&nbsp;&nbsp;
                    <label >' . $data->return_quantity . '</label>
                    <br><br>
                    <label for="d_status" style="font-weight: bold">Damage Status:</label>&nbsp;&nbsp;&nbsp;
                    <label >' . $data->damage_status . '</label>
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

        $goodsReturn = goodsReturn::find($id);


        $this->validate($request, [

            'r_quantity' => 'required'
        ]);

        $goodsReturn->gre_date = $request->post('r_date');
        $goodsReturn->return_quantity = $request->post('r_quantity');
        $goodsReturn->damage_status = $request->post('d_status');
        $goodsReturn->save();
        //dd($id);
        return redirect()->route('returnGoods' )->with('Success', 'Data Updated');
    }

    public function destroy($id) {
        $goodsReturn = goodsReturn::find($id);
        $goodsReturn->delete();


        return redirect()->route('returnGoods')->with('Success', 'Data Deleted');
    }

    public function searchGREs(Request $request)
    {
        $search = $request->get('searchBar');
        $data = DB::table('goods_returns')
            ->join('items', 'items.id', 'it_id')
            ->where('goods_returns.gre_no','LIKE', '%'.$search.'%')
            ->orWhere('items.item_description','LIKE', '%'.$search.'%')
            ->orWhere('items.item_no', 'LIKE', '%'.$search.'%')
            ->paginate(5);


        //dd($data);

        return view('goods_returnSearchResults', ['goodsReturns' => $data, 'item_no' => $this->getItemNos()]);
    }


    public function greReportAll(Request $request){

        if(!empty($request->from_date))
        {

            $from_date = $request->from_date;
            $to_date = $request->to_date;


            $data = DB::table('goods_returns')
                ->join('items','items.id','it_id')
                ->whereBetween('goods_returns.gre_date', array($request->from_date, $request->to_date))
                ->paginate(5);

            $total = DB::table('goods_returns')
                ->join('items','items.id','it_id')
                ->select([DB::raw('Sum(goods_returns.return_quantity) OVER () AS total_return_goods')])
                ->whereBetween('goods_returns.gre_date', array($request->from_date, $request->to_date))
                ->value('total_return_goods');

            //dd($total);

            return view('goods_return_reports',['goodsReturns'=> $data, 'item_no'=>$this->getItemNos()], compact('data','total','from_date','to_date'));


        }
        else
        {

            $from_date = 0;
            $to_date = 0;

            $data = DB::table('goods_returns')
                ->join('items','items.id','it_id')
                ->paginate(5);

            $total = DB::table('goods_returns')
                ->join('items','items.id','it_id')
                ->select([DB::raw('Sum(goods_returns.return_quantity) OVER () AS total_return_goods')])
                ->value('total_return_goods');

            //dd($total);

            return view('goods_return_reports',['goodsReturns'=> $data, 'item_no'=>$this->getItemNos()], compact('data','total','from_date','to_date'));

        }
    }

    function GoodsReturnPDF($from_date,$to_date)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->GREpdf($from_date,$to_date));
        return $pdf->stream();
    }

    function GREpdf($from_date,$to_date)
    {
        if($from_date != 0){

            $data = DB::table('goods_returns')
                ->join('items','items.id','it_id')
                ->whereBetween('goods_returns.gre_date', array($from_date, $to_date))
                ->get();


            $total = DB::table('goods_returns')
                ->join('items','items.id','it_id')
                ->select([DB::raw('Sum(goods_returns.return_quantity) OVER () AS total_return_goods')])
                ->whereBetween('goods_returns.gre_date', array($from_date, $to_date))
                ->value('total_return_goods');

        }
        else
        {
            $data = DB::table('goods_returns')
                ->join('items','items.id','it_id')
                ->get();

            $total = DB::table('goods_returns')
                ->join('items','items.id','it_id')
                ->select([DB::raw('Sum(goods_returns.return_quantity) OVER () AS total_return_goods')])
                ->value('total_return_goods');


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
        <title>Goods Return Reports</title>
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
            <th style="border: 1px solid; padding:4px;">Return Date</th>
            <th style="border: 1px solid; padding:4px;">Return Quantity</th>
            <th style="border: 1px solid; padding:4px;">Damage Status</th>
        </tr>
            ';

        foreach($data as $data)
        {
            $output .= '
            <tr>
                <td style="border: 1px solid; padding:4px;">'.$data->gre_no.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->item_no.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->item_description.'</td>
                <td style="border: 1px solid; padding:4px;text-align:right;">'.$data->cost.'</td>
                <td style="border: 1px solid; padding:4px;text-align:right;">'.$data->selling_price.'</td>
                <td style="border: 1px solid; padding:4px;text-align:center;">'.$data->gre_date.'</td>
                <td style="border: 1px solid; padding:4px;text-align:right;">'.$data->return_quantity.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->damage_status.'</td>
            </tr>

            ';
        }
        $output .= '
            <tbody></tbody>
            <tfoot>
                <tr id = "rowid">
                    <th colspan="7" style="text-align:right; border: 1px solid; padding:4px;">Total Return Quantity:</th>
                    <th id = "total_return_goods" class = "id" style="border: 1px solid; padding:4px;">'.$total.'</th>
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


    public function goodsReturnCharts(Request $request) {

        if(!empty($request->from_date))
        {
            $from_date = $request->from_date;
            $to_date = $request->to_date;

            $data = DB::table('goods_returns')
                ->join('items', 'goods_returns.it_id', '=', 'items.id')
                ->orderBy('goods_returns.id', 'ASC')
                ->whereBetween('goods_returns.gre_date', array($from_date, $to_date))
                ->get();

            //dd($total);

            return view('goods_return_charts',['goodsReturns'=> $data, 'item_no'=>$this->getItemNos()], compact('data','from_date','to_date'));


        }
        else
        {

            $from_date = 0;
            $to_date = 0;

            $data = DB::table('goods_returns')
                ->join('items', 'goods_returns.it_id', '=', 'items.id')
                ->orderBy('goods_returns.id', 'ASC')
                ->get();

            return view('goods_return_charts',['goodsReturns'=> $data, 'item_no'=>$this->getItemNos()], compact('data','from_date','to_date'));

        }
    }

    function goodsReturnBarCharts($from_date,$to_date)
    {
        $data = DB::table('goods_returns')
            ->join('items', 'goods_returns.it_id', '=', 'items.id')
            ->orderBy('goods_returns.id', 'ASC')
            ->where('goods_returns.return_quantity', '>', 0)
            ->whereBetween('goods_returns.gre_date', array($from_date, $to_date))
            ->paginate(10);
        //dd($items);
        return view('goods_returnBarCharts',['goodsReturns'=> $data, 'item_no'=>$this->getItemNos()], compact('data','from_date','to_date'));
    }

    function goodsReturnPieCharts($from_date,$to_date)
    {

        $data = DB::table('goods_returns')
            ->join('items', 'goods_returns.it_id', '=', 'items.id')
            ->orderBy('goods_returns.id', 'ASC')
            ->where('goods_returns.return_quantity', '>', 0)
            ->whereBetween('goods_returns.gre_date', array($from_date, $to_date))
            ->paginate(10);
        //dd($items);
        return view('goods_returnPieCharts',['goodsReturns'=> $data, 'item_no'=>$this->getItemNos()], compact('data','from_date','to_date'));
    }

}

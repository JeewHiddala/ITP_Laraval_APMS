<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use App\Item;
use Illuminate\Support\Facades\DB;


class ItemController extends Controller
{
    public function store(Request $request) {

        $item = new Item;
        $this->validate($request,[
            'i_number'=>'required|max:1000|min:1|unique:items,item_no',
        ]);

        $item->item_no = $request->i_number;
        $item->item_description = $request->item_des;
        $item->m_category = $request->main_category;
        $item->s_category = $request->sub_category;
        $item->brand = $request->brand;
        $item->country = $request->country;
        $item->quality = $request->quality;
        $item->warranty = $request->warranty;
        $item->v_model_no = $request->vehicle_model_no;
        $item->v_model_name = $request->vehicle_model;
        $item->v_class = $request->vehicle_class;
        $item->year = $request->year;
        $item->quantity = $request->quantity;
        $item->cost = $request->cost;
        $item->selling_price = $request->selling_price;

        $item->save();

        $data = Item::all();

        return redirect()->back();
        //return  view('item_registration')->with('items',$data);
       // dd($request->all());
    }

    public function index(Request $request) {

        $data = DB::table('items')
            ->paginate(5);

        //dd($data);

        return view('item_registration')->with('items',$data);

    }

    public function edit($id)
    {
        $item = Item::find($id);
        /*data = DB::table('items')
            ->where('id', '=' $id)
            ->get();*/
        return view('item_update', compact('item', 'id'));
    }

    public function update(Request $request,$id)
    {

         $this->validate($request, [

            'item_des' => 'required'
        ]);
        $item = Item::find($id);
        //$item->item_no = $request->post('i_number');
        $item->item_description = $request->post('item_des');
        $item->m_category = $request->post('main_category');
        $item->s_category = $request->post('sub_category');
        $item->brand = $request->post('brand');
        $item->country = $request->post('country');
        $item->quality = $request->post('quality');
        $item->warranty = $request->post('warranty');
        $item->v_model_no = $request->post('vehicle_model_no');
        $item->v_model_name = $request->post('vehicle_model');
        $item->v_class = $request->post('vehicle_class');
        $item->year = $request->post('year');
        $item->quantity = $request->post('quantity');
        $item->cost = $request->post('cost');
        $item->selling_price = $request->post('selling_price');
        $item->save();


        //return redirect()->back();
        //return  view('item_registration')->with('items',$data);

        return redirect()->route('item_registration')->with('Success', 'Data Updated');
    }

    public function destroy($id) {
        $item = Item::find($id);
        $item->delete();
        return redirect()->route('item_registration')->with('Success', 'Data Deleted');
    }

    public function search(Request $request) {
        //dd($request->all());
        $search = $request->get('searchBar');
        $item = DB::table('items')
            ->where('item_description','LIKE', '%'.$search.'%')
            ->orWhere('item_no', 'LIKE', '%'.$search.'%')->paginate(5);
        return view('itemSearchResults',['items'=> $item]);
    }

    public function itemsReportAll(Request $request) {

        if(!empty($request->from_date))
        {

            $from_date = $request->from_date;
            $to_date = $request->to_date;


            $data = DB::table('items')
                ->whereBetween('created_at', array($request->from_date, $request->to_date))
                ->paginate(5);

            $total = DB::table('items')
                ->select([DB::raw('Sum(quantity) OVER () AS total_items')])
                ->whereBetween('created_at', array($request->from_date, $request->to_date))
                ->value('total_items');

            //dd($total);

            return view('itemsReport_whole',['items'=> $data], compact('data','total','from_date','to_date'));


        }
        else
        {

            $from_date = 0;
            $to_date = 0;

            $data = DB::table('items')
                ->paginate(5);

            $total = DB::table('items')
                ->select([DB::raw('Sum(quantity) OVER () AS total_items')])
                ->value('total_items');

            //dd($total);

            return view('itemsReport_whole',['items'=> $data], compact('data','total','from_date','to_date'));

        }
    }





    public function itemsCharts(Request $request) {

        if(!empty($request->from_date))
        {

            $from_date = $request->from_date;
            $to_date = $request->to_date;


            $data = DB::table('items')
                ->whereBetween('created_at', array($request->from_date, $request->to_date))
                ->get();

            //dd($total);

            return view('items_charts',['items'=> $data], compact('data','from_date','to_date'));


        }
        else
        {

            $from_date = 0;
            $to_date = 0;

            $data = DB::table('items')
                ->get();

            //dd($total);

            return view('items_charts',['items'=> $data], compact('data','from_date','to_date'));

        }
    }

    function itemsBarCharts($from_date,$to_date)
    {
        $items = DB::table('items')
               ->where('quantity', '>', 0)
               ->whereBetween('created_at', array($from_date, $to_date))
               ->paginate(10);
        //dd($items);
        return view('items_barCharts',compact('items'));
    }

    function itemsPieCharts($from_date,$to_date)
    {

        $items = DB::table('items')
            ->where('quantity', '>', 0)
            ->whereBetween('created_at', array($from_date, $to_date))
            ->paginate(10);
        //dd($items);
        return view('items_pieCharts',compact('items'));
    }

    function itemsReportPDF($from_date,$to_date)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->Itemspdf($from_date,$to_date));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream();
    }

    function Itemspdf($from_date,$to_date)
    {
        if($from_date != 0){

            $data = DB::table('items')
                ->whereBetween('created_at', array($from_date, $to_date))
                ->get();


            $total = DB::table('items')
                ->select([DB::raw('Sum(quantity) OVER () AS total_items')])
                ->whereBetween('created_at', array($from_date, $to_date))
                ->value('total_items');

        }
        else
        {
            $data = DB::table('items')
                ->get();

            $total = DB::table('items')
                ->select([DB::raw('Sum(quantity) OVER () AS total_items')])
                ->value('total_items');


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
        <title>Items Reports</title>
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


        <p>Spare Parts Items</p><br>
        <table width="100%" style="border-collapse: collapse; border: 0px;">
        <tr>
            <th style="border: 1px solid; padding:4px;">ID</th>
            <th style="border: 1px solid; padding:4px;">Item No</th>
            <th style="border: 1px solid; padding:4px;">Item Description</th>
            <th style="border: 1px solid; padding:4px;">Main Category</th>
            <th style="border: 1px solid; padding:4px;">Sub Category</th>
            <th style="border: 1px solid; padding:4px;">Brand</th>
            <th style="border: 1px solid; padding:4px;">Country</th>
            <th style="border: 1px solid; padding:4px;">Quality</th>
            <th style="border: 1px solid; padding:4px;">Warranty</th>
            <th style="border: 1px solid; padding:4px;">Vehicle Model No</th>
            <th style="border: 1px solid; padding:4px;">Vehicle Class</th>
            <th style="border: 1px solid; padding:4px;">Year</th>
            <th style="border: 1px solid; padding:4px;">Quantity</th>
            <th style="border: 1px solid; padding:4px;">Cost</th>
            <th style="border: 1px solid; padding:4px;">Selling Price</th>
            <th style="border: 1px solid; padding:4px;">Registered Date</th>
        </tr>
            ';

        foreach($data as $data)
        {

            $output .= '
            <tr>
                <td style="border: 1px solid; padding:4px;">'.$data->id.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->item_no.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->item_description.'</td>
                <td style="border: 1px solid; padding:4px;text-align:center;">'.$data->m_category.'</td>
                <td style="border: 1px solid; padding:4px;text-align:center;">'.$data->s_category.'</td>
                <td style="border: 1px solid; padding:4px;text-align:center;">'.$data->brand.'</td>
                <td style="border: 1px solid; padding:4px;text-align:right;">'.$data->country.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->quality.'</td>
                <td style="border: 1px solid; padding:4px; text-align:center;">'.$data->warranty.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->v_model_no.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->v_class.'</td>
                <td style="border: 1px solid; padding:4px;text-align:right;">'.$data->year.'</td>
                <td style="border: 1px solid; padding:4px;text-align:center;">'.$data->quality.'</td>
                <td style="border: 1px solid; padding:4px;text-align:right;">'.$data->cost.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->selling_price.'</td>
                <td style="border: 1px solid; padding:4px;">'.$data->created_at.'</td>
            </tr>

            ';
        }
        $output .= '
            <tbody></tbody>
            <tfoot>
                <tr id = "rowid">
                    <th colspan="15" style="text-align:right; border: 1px solid; padding:4px;">Total Item Quantity:</th>
                    <th id = "total_items" class = "id" style="border: 1px solid; padding:4px;">'.$total.'</th>
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

}

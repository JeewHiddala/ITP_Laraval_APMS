<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\bill;
use App\InvoiceProduct;
use DB;

class InvoiceController extends Controller
{
    public function index()
    {
        $bills = bill::orderBy('created_at', 'desc')
            ->paginate(8);

        return view('bills.index', compact('bills'));
    }

    public function create()
    {
        //dd("scscscscsc" );
        return view('bills.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
           'invoice_no' => 'required|alpha_dash|unique:bills',
            'client' => 'required|max:255',
            'client_address' => 'required|max:255',
            'invoice_date' => 'required|date_format:Y-m-d',
            'due_date' => 'required|date_format:Y-m-d',
            'title' => 'required|max:255',
            'discount' => 'required|numeric|min:0',
            'products.*.name' => 'required|max:255',
            'products.*.price' => 'required|numeric|min:1',
            'products.*.qty' => 'required|integer|min:1'
        ]);

        $products = collect($request->products)->transform(function($product) {
            $product['total'] = $product['qty'] * $product['price'];
            return new InvoiceProduct($product);
        });

        //dd("cvdscscscsc");
        echo "xxxxxxxxxxxxxxxx";

        if($products->isEmpty()) {
            return response()
            ->json([
                'products_empty' => ['One or more Product is required.']
            ], 422);
        }

        $data = $request->except('products');
        $data['sub_total'] = $products->sum('total');
        $data['grand_total'] = $data['sub_total'] - $data['discount'];

        $bill = bill::create($data);


        $bill->products()->saveMany($products);



        return response()
            ->json([
                'created' => true,
                'id' => $bill->id
            ]);

    }


    public function show($id)
    {
        $bill = bill::with('products')->findOrFail($id);
        return view('bills.show', compact('bill'));
    }

    public function edit($id)
    {
        $bill = bill::with('products')->findOrFail($id);
        return view('bills.edit', compact('bill'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'invoice_no' => 'required|alpha_dash|unique:bills,invoice_no,'.$id.',id',
            'client' => 'required|max:255',
            'client_address' => 'required|max:255',
            'invoice_date' => 'required|date_format:Y-m-d',
            'due_date' => 'required|date_format:Y-m-d',
            'title' => 'required|max:255',
            'discount' => 'required|numeric|min:0',
            'products.*.name' => 'required|max:255',
            'products.*.price' => 'required|numeric|min:1',
            'products.*.qty' => 'required|integer|min:1'
        ]);

        $bill = bill::findOrFail($id);

        $products = collect($request->products)->transform(function($product) {
            $product['total'] = $product['qty'] * $product['price'];
            return new InvoiceProduct($product);
        });

        if($products->isEmpty()) {
            return response()
            ->json([
                'products_empty' => ['One or more Product is required.']
            ], 422);
        }

        $data = $request->except('products');
        $data['sub_total'] = $products->sum('total');
        $data['grand_total'] = $data['sub_total'] - $data['discount'];

        $bill->update($data);

        InvoiceProduct::where('bill_id', $bill->id)->delete();

        $bill->products()->saveMany($products);

        return response()
            ->json([
                'updated' => true,
                'id' => $bill->id
            ]);
    }

    public function destroy($id)
    {
        $bill = bill::findOrFail($id);

        InvoiceProduct::where('bill_id', $bill->id)
            ->delete();

        $bill->delete();

        return redirect()
            ->route('bills.index');
    }

    public function SearchBillItems(Request $request){
        $search = $request->get('searchBills');
        $posts = bill::where('invoice_no','like','%'.$search.'%')->paginate(10);
        return view('SearchBills' , ['posts'=> $posts]);

    }

    /* pdf code */

    function index2()
    {
        $customer_data = $this->get_customer_data();
        return view('billPDF')-> with('customer_data' , $customer_data);
    }

    function get_customer_data()
    {
        $customer_data = DB::table('bills')
            ->limit(10)
            ->get();
        return $customer_data;
    }
    function convert_bill_data_to_html()
    {
        $png = file_get_contents("logo.png");
        $pngBase64 = base64_encode($png);
        $ldate = date('Y-m-d H:i:s');
        date_default_timezone_set('Asia/Colombo');
        $date = date('m/d/Y h:i:s a', time());


    }



    /* pdf code */

function pdf_singleBill($invoice_no){
    $pdf = \App::make('dompdf.wrapper');
    $pdf->loadHTML($this->convert_SingleBill_data_to_html($invoice_no));
    return $pdf->stream();//Using this method we can show the pdf file in the browser
}

function convert_SingleBill_data_to_html($invoice_no){
    $png = file_get_contents("images/logo.png");
    $pngBase64 = base64_encode($png);
    $bill = bill::with('products')->findOrFail($invoice_no);

    $output = ' ';
    $output .='<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Bills</title>
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
            <!--<span class="site-heading-upper text-primary mb-3">A Free Bootstrap 4 Business Theme</span>-->
            <span class="site-heading-lower" style="color:#e6a756">Ranjith Motors & Auto Parts</span>
      </h1>
      <br>
      <h5 style = "float:left;"> Address : Colombo Road, Dambokka, Kurunegala, Srilanka 600000</h5>
      <h5 style = "float:right;"> Telephone: +94 372231201/+94 372222902</h5>
      <br><br>
      <hr>
<div class="panel panel-default">
       <div class="panel-body">
            <div class="row">
               <div class="col-sm-4">
                    <div class="form-group">
                        <label>Invoice No.</label>
                        <p>'.$bill->invoice_no.'</p>
                    </div>
                    <div class="form-group">
                        <label>Grand Total</label>
                        <p>'.$bill->grand_total.'</p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Client</label>
                        <p>'.$bill->client.'</p>
                    </div>
                    <div class="form-group">
                        <label>Client Address</label>
                        <pre class="pre">'.$bill->client_address.'</pre>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Title</label>
                        <p>'.$bill->title.'</p>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Invoice Date</label>
                            <p>'.$bill->invoice_date.'</p>
                        </div>
                        <div class="col-sm-6">
                            <label>Due Date</label>
                            <p>'.$bill->due_date.'</p>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>';
                    foreach($bill->products as $product){
                      $output.='  <tr>
                            <td class="table-name">'.$product->name.'</td>
                            <td class="table-price">'.$product->price.'</td>
                            <td class="table-qty">'.$product->qty.'</td>
                            <td class="table-total text-right">'.$product->qty * $product->price.'</td>
                        </tr>';
                        }

               $output.=' </tbody>
                <tfoot>
                    <tr>
                        <td class="table-empty" colspan="2"></td>
                        <td class="table-label">Sub Total</td>
                        <td class="table-amount">'.$bill->sub_total.'</td>
                    </tr>
                    <tr>
                        <td class="table-empty" colspan="2"></td>
                        <td class="table-label">Discount</td>
                        <td class="table-amount">'.$bill->discount.'</td>
                    </tr>
                    <tr>
                        <td class="table-empty" colspan="2"></td>
                        <td class="table-label">Grand Total</td>
                        <td class="table-amount">'.$bill->grand_total.'</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

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

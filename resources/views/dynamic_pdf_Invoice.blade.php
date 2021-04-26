<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>readyToBill</title>
</head>
<body>


    <h4> Ready to Bill </h4>
        <a href="{{ url('dynamic_pdf_Invoice/pdf')}}">Ready to Print </a>

        
    
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                 <th>Item No</th>
                 <th>Item Name</th>
                <th>Qty</th>
                 <th> Price</th>
                <th>Total</th>
                </tr>
            </thead>
            <tbody>
            @foreach($invoiceItem_data as $item)
            <tr>
                <td>{{$item->item_no}}</td>
                <td>{{$item->item_description}}</td>
                <td>{{$item->quantity}}</td>
                <td>{{$item->price}}</td>
                <td>{{$item->total}}</td>
                
            </tr>
            @endforeach
            </tbody>
        </table>
</div>








</body>
</html>
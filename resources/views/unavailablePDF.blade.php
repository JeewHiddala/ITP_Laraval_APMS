<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <style>

        table.table.table-dark {
            margin-top: 40px !important;
        }

        .btn-warning {
            white-space: nowrap;
        }

        .btn-danger {
            white-space: nowrap;
        }

        .btn-primary {
            white-space: nowrap;
        }
        input.btn.btn-primary {
            width: 90px;
        }

        input.btn.btn-warning {
            width: 90px;
        }

        input[type="date"]:not(.has-value):before {
            color: #495057;
            content: attr(placeholder);
        }

        input[type="date"]{
            white-space: nowrap;
        }
    </style>
    <title>Unavailable Items</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>
<link href="css/business-casual.min.css" rel="stylesheet">

<br />
<div class="container">
    <h3 align="center">Unavailable Items Report</h3><br />

    <div class="row">
        <div class="col-md-7" align="center">
            <!--<h4>Customer and Requested Item Data</h4> -->
        </div>
        <div class="col-md-5" align="right">
         <!--   <a href="{{ url('/Tpdf/pdf') }}" class="btn btn-danger">Convert into PDF</a> -->
        </div>
    </div>
    <br />
    <div id="bt" style="text-align: right;"><a href="{{ url('/Tpdf/pdf') }}" class="btn btn-danger">Convert into PDF</a></div>
    <br>
    <br>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Item No</th>
                <th>Date</th>
                <th>Vehicle Model</th>
                <th>Customer Name</th>
                <th>Phone Number</th>
                <th>Salesperson</th>

            </tr>
            </thead>
            <tbody>
            @foreach($customer_data as $customer)
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->ItemNo }}</td>
                    <td>{{ $customer->Date }}</td>
                    <td>{{ $customer->Model }}</td>
                    <td>{{ $customer->customerName }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>{{ $customer->salesperson }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>
</html>

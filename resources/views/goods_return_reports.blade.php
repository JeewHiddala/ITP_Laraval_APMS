<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goods Return Reports</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <link rel="icon" type="image/png" href="images/logo.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="{{ URL::asset('css/business-casual.min.css') }}" rel="stylesheet" type="text/css" >
</head>
<body>

<!--header-->
<img src="images/logo.png" alt="logo" width="110" height="100" style="float:left; margin-top:-2.2% ;padding-left:0.5%">
<h1 class="site-heading text-center text-white d-none d-lg-block">
    <span class="site-heading-lower" style="color:#e6a756">Ranjith Motors & Auto Parts</span>
</h1>

<nav class="navbar navbar-expand-lg navbar-dark py-lg-4" id="mainNav" >
    <div class="container">
        <a class="navbar-brand text-uppercase text-expanded font-weight-bold d-lg-none" href="#">Start Bootstrap</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ">
                <li class="nav-item px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="/menu">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="/subStockMenu">Menu</a>
                </li>
                <li class="nav-item px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="/about">About</a>
                </li>
                <li class="nav-item px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="/itemsReports">Reports</a>
                </li>
                <li class="nav-item px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="/itemsCharts">Charts</a>
                </li>
            </ul>

        </div>
    </div>
    <div class="col-md-1 float-right">
        <a href="/signOut" onclick="return confirm('Are you sure you want to sign out?')" class="btn btn-primary">Sign Out</a>
    </div>
</nav>
<!--/header-->


<div class="container-lg pt-5">
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link {{request() -> is('/itemsReports') ? 'active' : null }}" href="{{url('/itemsReports')}}"
               role="tab">Items Reports</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{request () -> is('/stocksReports') ? 'active' : null }}" href="{{url('/stocksReports')}}"
               role="tab">Stocks Reports</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{request() -> is('/goodsReceiveReports') ? 'active' : null }}" href="{{url('/goodsReceiveReports')}}"
               role="tab">Received Goods Reports</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active {{request () -> is('/goodsReturnReports') ? 'active' : null }}" href="{{url('/goodsReturnReports')}}"
               role="tab">Return Goods Reports</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{request () -> is('/reorderItems/reports') ? 'active' : null }}" href="{{url('/reorderItems/reports')}}"
               role="tab">ROL Reports</a>
        </li>


    </ul>

    <div class="container">
        <br>
        <h2>Select Date Range</h2>
        <form method="GET" action="/goodsReturnReports">
            <div class="form-group">
                From
                <input type="date" name="from_date" class="form-control">
                To
                <input type="date" name="to_date" class="form-control">
                <br>
                <input type="submit" value="Filter" class="btn btn-success">
                <input type="reset" value="Clear Dates" class="btn btn-warning">
            </div>
        </form>
    </div>
</div>
<div class="container-lg pt-5">
    <div><a href = "/goodsReturnReports/PDF/{{$from_date}}/{{$to_date}}"  class ="btn btn-danger"   style = "float:right">Convert to PDF</a> </div><br><br>
    <p>For the period starting from <b><i>{{$from_date}}</i></b> to <b><i>{{$to_date}}</i></b></p>
    <table class="table table-bordered table-striped">
        <tr>
            <th>GReturn No</th>
            <th>Item No</th>
            <th>Item Description</th>
            <th>Item Cost</th>
            <th>Item Selling Price</th>
            <th>Return Date</th>
            <th>Return Quantity</th>
            <th>Damage Status</th>
        </tr>
        @foreach( $goodsReturns as $goodsReturn)
            <tr>
                <td>{{$goodsReturn->gre_no}}</td>
                <td>{{$goodsReturn->item_no}}</td>
                <td>{{$goodsReturn->item_description}}</td>
                <td>{{$goodsReturn->cost}}</td>
                <td>{{$goodsReturn->selling_price}}</td>
                <td>{{$goodsReturn->gre_date}}</td>
                <td>{{$goodsReturn->return_quantity}}</td>
                <td>{{$goodsReturn->damage_status}}</td>
            </tr>
        @endforeach

    </table>

    <br>
    <a href="/goodsReturnReports" class="btn btn-primary">Back</a>
    <br>
    <br>
</div>
<!--Footer-->
<footer class="footer text-faded text-center py-5">
    <div style = "text-align: left; margin-top:-2.2%; padding-left:0.5%;color:#e6a756">
        <h3 class="m-0 small"> 2020 Ranjith Motors And Auto Parts</h3>
        <h3 class="m-0 small"> Colombo Road,</h3>
        <h3 class="m-0 small"> Dambokka,</h3>
        <h3 class="m-0 small"> Kurunegala,Srilanka</h3>
        <h3 class="m-0 small"> 600000</h3>
    </div>

    <div class="container" style = "margin-top:-2.5%;color:#e6a756">
        <p class="m-0 small">&copy; 2020 Ranjith Motors All Rights Reserved</p>
    </div>

    <div style = "text-align: right; margin-top:-3.5%; padding-right:1%;color:#e6a756">
        <h3 class="m-0 small"> +94 372231201</h3>
        <h3 class="m-0 small"> +94 372222902</h3><br>
        <h3 class="m-0 small"> E: info@ranjithmotors.com</h3>
    </div>

</footer>
</body>
</html>

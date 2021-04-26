<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <title>Edit Unavailable Items</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

</head>
<body>
<link href="{{ URL::asset('css/business-casual.min.css') }}" rel="stylesheet" type="text/css" >
<link href="css/business-casual.min.css" rel="stylesheet">
<img src="{{ asset('images/logo.png') }}" alt="logo" width="110" height="100" style="float:left; margin-top:-2.2% ;padding-left:0.5%">
<h1 class="site-heading text-center text-white d-none d-lg-block">
    <!--<span class="site-heading-upper text-primary mb-3">A Free Bootstrap 4 Business Theme</span>-->
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
                <li class="nav-item active px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="/menu">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>

                <li class="nav-item active px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="/subBillingMenu">Menu
                        <span class="sr-only">(current)</span>
                    </a>
                </li>

                <li class="nav-item px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="/about">About</a>
                </li>

                <li class="nav-item px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="/feedbackpdf/pdf">Reports</a>
                </li>
            </ul>

        </div>
    </div>
    <div class="col-md-2 float-right">
        <form action="/searchCu" method="GET">
            {{csrf_field()}}
            <div class="input-group">
                <input type="search" name="searchBar" placeholder="Buyer Name" class="form-control">
                <span class="input-group-prepend">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </span>
            </div>
        </form>
</nav>
<br>

    <div class="container">
        <center><h1> Edit Unavailable Item Entry</h1></center>
        <br>
        <br>
        <br>
        <br>

        <form action="/UpdateUnItem" method="post">
            {{csrf_field()}}


            <input type="text" class="form-control" name="ItemNo" value="{{$UnItemdata->ItemNo}}"/>
            <input type="text" class="form-control" name="Date" value="{{$UnItemdata->Date}}"/>
            <input type="text" class="form-control" name="Model" value="{{$UnItemdata->Model}}"/>
            <input type="text" class="form-control" name="customerName" value="{{$UnItemdata->customerName}}"/>
            <input type="phone" class="form-control" name="phone"  pattern="[0-9]{10}" value="{{$UnItemdata->phone}}" required=""/>
            <input type="text" class="form-control" name="salesperson" value="{{$UnItemdata->salesperson}}"/>
            <input type="hidden" name="id" value="{{$UnItemdata->id}}"/>
            <input type="submit" class="btn btn-warning" value="Save Changes"/>
            &nbsp;&nbsp;<input type="button" class="btn btn-danger" value="Cancel"/>



        </form>
    </div>































</body>
</html>

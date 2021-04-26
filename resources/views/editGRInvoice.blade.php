<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ URL::asset('css/business-casual.min.css') }}" rel="stylesheet" type="text/css" >
    <title>Edit GoodReturn In-</title>
</head>
<body>
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
                <a class="nav-link text-uppercase text-expanded" href="index.html">Home
                  <span class="sr-only">(current)</span>
                </a>
              </li>
              
              <li class="nav-item px-lg-4">
                <a class="nav-link text-uppercase text-expanded" href="/wsbuye.blade.php">About</a>
              </li>
              <li class="nav-item px-lg-4">
                <a class="nav-link text-uppercase text-expanded" href="about.html">About</a>
              </li>
              <li class="nav-item px-lg-4">
                <a class="nav-link text-uppercase text-expanded" href="products.html">Contact</a>
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
      </nav><br>
<div class="container">
<h1> Edit Good Retrun Invoice  </h1>

<div class="container">
    <form method="post" action="/editgrInvice" >
    {{csrf_field()}}
    
    <p style="text-align:left">Invoice Number</p>
    <input type="text" class = "form-control" action="read-only" name="invoice_no" value="{{$->}}" /><br>
    
    <p style="text-align:left">Item No :</p>
    <input type="text" class = "form-control" action="read-only" name="item_no" value="{{$->}}"  ><br>
    
    <p style="text-align:left">Item Name</p>
    <input type="text" class = "form-control" action="read-only"  name="item_name" value="{{$->}}"  /><br>
    
    <p style="text-align:left">Quantity</p>
    <input type="text" class = "form-control" name="qty" value="{{$->}}"  /><br>
    
    <p style="text-align:left">Price </p>
    <input type="text" class = "form-control" action="read-only" name="price" value="{{$->}}"  /><br>
  
    <input type="submit" name="update" value ="Add">

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

  </div>
</body>
</html>
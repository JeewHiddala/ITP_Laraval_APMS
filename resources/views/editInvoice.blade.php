<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="{{ URL::asset('css/business-casual.min.css') }}" rel="stylesheet" type="text/css" >
    <title>Edit Invoice</title>

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
                <a class="nav-link text-uppercase text-expanded" href="/menu">Home
                  <span class="sr-only">(current)</span>
                </a>
              </li>


              <li class="nav-item px-lg-4">
                <a class="nav-link text-uppercase text-expanded" href="/orderManageMenu">Menu</a>
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
<h1> Edit Invoice  </h1>
   
   <form method="post" action="/updateInvoice/{{$ninvoive->i_List}}">
   {{csrf_field()}}

   <input type="hidden" name="iNo" value="{{$ninvoive->i_List}}">
   <input type="hidden" name="invoiceNo" value="{{$ninvoive->invoice_no}}">
   <input type="hidden" name="itemNo" value="{{$ninvoive->item_no}}">
   
        <div class="row input qty">
                  <div class="col-md-3">
                    <p style="text-align:left">No of Items</p>
                    <input type="text" class = "form-control" id="qty1" name="qty1" value="{{$ninvoive->quantity}}" onclick="return myFunction()" required/><br>

                  </div>
          </div>

                
          <div class="row input qty">    
                  <div class="col-md-3">
                    <p style="text-align:left">Price</p>
                    <input type="text" class = "form-control" id="price" name="price" value="{{$ninvoive->price}}" onclick="return myFunction()"  required/><br>
                  </div>
          </div> 
                <br>

                <input type="submit" class="btn btn-primary" value="Update">

  


    
    </form>






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
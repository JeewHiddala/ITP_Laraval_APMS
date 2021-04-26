<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="{{ URL::asset('/css/business-casual.min.css') }}" rel="stylesheet" type="text/css" >
    <link rel="icon" type="image/png" href={{URL::asset('/images/logo.png')}}>
    <title>Update | Deliver | Courier Services</title>

</head>
<body>

    <img src="{{ asset('/images/logo.png') }}" alt="logo" width="110" height="100" style="float:left; margin-top:-2.2% ;padding-left:0.5%">
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
                <a class="nav-link text-uppercase text-expanded" href="/tmMenu">Menu</a>
              </li>
              <li class="nav-item px-lg-4">
                <a class="nav-link text-uppercase text-expanded" href="/about">About</a>
              </li>
            </ul>
            
          </div>
        </div>
        <div class="col-md-3 float-right">
          <a href="/signOut" class="btn btn-primary" style="float:right" onclick="return confirm('Are you sure you want to sign out?')">Sign Out</a>
            
         </div>
      </nav><br>

    <br><h2 style="text-align:center">Update Delivery Note</h2><br>
    <div class="container">
        <div class="form-group">

    <form method="post" action = "/updatedeliveries2">
        {{csrf_field()}}

        <p style="text-align:left">Invoice ID</p>
        <input type="hidden" name="delivery_id" value="{{$data->id}}" class = "delivary_id form-control"/>
        <input type="text" name="invoice_id" value="{{$data->invoice_id}}" class = "invoice_id form-control" disabled/>
        <p style="text-align:left">Customer Name</p>
        <input type="text" class = "buyer_name form-control" value="{{$data->buyer_name}}" name="buyer_name"  placeholder = "" disabled/><br>
        <p style="text-align:left">Address</p>
        <input type="text" class = "address form-control" value="{{$data->address}}" name="address" placeholder = "" disabled/><br>
        <p style="text-align:left">Mobile-Phone</p>
        <input type="text" class = "mobile form-control" value="{{$data->mobile}}" name="mobile" placeholder = "" disabled/><br>
        <p style="text-align:left">Land-Phone</p>
        <input type="text" class = "land form-control" value="{{$data->land}}" name="land" placeholder = "" disabled/><br>
        <p style="text-align:left">E-mail</p>
        <input type="text" class = "email form-control" value="{{$data->email}}" name="email" placeholder = "" disabled/><br>
        <p>Courier Serive:</p>

                            <select name="courier_id" class="courier form-control" style="width:250px" id="courier_id">
                                <option value="{{$data->courier_id}}" hidden>{{$data->company_name}}</option>
                                @foreach ($courier as $value)
                                <option value="{{ $value->id }}">{{ $value->company_name }}</option>
                                @endforeach
                            </select><br>

        <p style="text-align:left">Date</p>
        <input type="date" class = "date form-control" value="{{$data->date}}" name="date" style="width:250px" placeholder = "" /><br>

        <p style="text-align:left">Total</p>
        <input type="number" class = "total form-control" value="{{$data->total}}" style="width:250px"  name="total" placeholder = ""/><br>
        <input  type="submit" class="btn btn-primary" value="Save" onclick="return confirm('Are you sure you want to update?')"/>&nbsp;&nbsp;
        <a href="/deliver2"  class="btn btn-danger" >Cancel</a>
        </form>
        </div></div>

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
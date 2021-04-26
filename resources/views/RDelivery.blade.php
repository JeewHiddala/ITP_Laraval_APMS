<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    
    <link rel="icon" type="image/png" href="images/logo.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="{{ URL::asset('css/business-casual.min.css') }}" rel="stylesheet" type="text/css" >
    <link rel="icon" type="image/png" href={{URL::asset('/images/logo.png')}}>
    <title>Report | Delivery</title>
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
                <a class="nav-link text-uppercase text-expanded" href="/tmMenu">Menu</a>
              </li>
              <li class="nav-item px-lg-4">
                <a class="nav-link text-uppercase text-expanded" href="/about">About</a>
              </li>
              <li class="nav-item px-lg-4">
                <a class="nav-link text-uppercase text-expanded" href="/deliveries_pie_chart">Charts</a>
              </li>
              <li class="nav-item px-lg-4">
                <a class="nav-link text-uppercase text-expanded" href="products.html">Reports</a>
              </li>
            </ul>
            
          </div>
        </div>
        <div class="col-md-3 float-right">
          <a href="/signOut" class="btn btn-primary" style = "float:right" onclick="return confirm('Are you sure you want to sign out?')">Sign Out</a>
         </div>

      </nav><br>
    <br>
    <!--/header-->

<!--Tab Pane-->
    <div class="container">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active  {{request() -> is('/RDelivery') ? 'active' : null }}"  href="{{url('/RDelivery')}}" role="tab">Delivery Report</a>
            </li>
            <li class="nav-item">
                <a class="nav-link  {{request () -> is('/RCompany') ? 'active' : null }}" href="{{url('/RCompany')}}" role="tab">Delivery Report | Company Vehicles</a>
            </li>
            <li class="nav-item">
                <a class="nav-link  {{request () -> is('/RCourier') ? 'active' : null }}" href="{{url('/RCourier')}}" role="tab">Delivery Report | Courier Services</a>
            </li>
            <li class="nav-item">
                <a class="nav-link  {{request () -> is('/RVisits') ? 'active' : null }}" href="{{url('/RVisits')}}" role="tab">Company Visits</a>
            </li>
        
        </ul><!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane {{request() ->is('/RDelivery') ? 'active' : null }}" id="{{url('/RDelivery')}}" role="tabpanel">
            <p>Deliver By Company Vehicles</p>
        </div>
        <div class="tab-pane {{request() ->is('/RCompany') ? 'active' : null }}" id="{{url('/RCompany')}}" role="tabpanel">
            <p>Deliver By Courier Service</p>
        </div>
        <div class="tab-pane {{request() ->is('/RCourier') ? 'active' : null }}" id="{{url('/RCourier')}}" role="tabpanel">
            <p>Deliver By Courier Service</p>
        </div>
        <div class="tab-pane {{request() ->is('/RVisits') ? 'active' : null }}" id="{{url('/RVisits')}}" role="tabpanel">
            <p>Deliver By Courier Service</p>
        </div>
    </div>


<br><br>


<div class="container">
        <h4>Select date range</h4><br>
        <form method="GET" action="/RDeliveryFilter">
            <div class="form-group">
                <h5>From</h5><br>
                <input type="date" name="from_date" class="form-control"><br>
                <h5>To</h5><br>
                <input type="date" name="to_date" class="form-control">
                <br>
                <input type="submit" value="Filter data" class="btn btn-success">
                <input type="reset" value="Clear date" class="btn btn-warning">
            </div>
        </form>
    </div>
</div><br><br>




<!--Table-->
<div class="container">
    <div class="form-group">

      <!-- PDF BUTTON -->

    <div><a href = "/RDelivery/pdf/{{$from_date}}/{{$to_date}}"  class ="btn btn-danger"   style = "float:right">Convert in to PDF</a> </div><br>
    <p>For the period starting from <b><i>{{$from_date}}</i></b> to <b><i>{{$to_date}}</b></i></p>

        <table class="table table-dark table-bordered table-striped">
        <thead>
          <th>Invoice ID</th>
          <th>Buyers Name</th>
          <th>Address</th>
          <th>Mobile</th>
          <th>Land</th>
          <th>E-mail</th>
          <th>Date</th>
          <th>Delivery Cost</th>
        
            @foreach($data as $datas)
            <tr  id = "table">
                <td>{{$datas->invoice_id}}</td>
                <td>{{$datas->buyer_name}}</td>
                <td>{{$datas->address}}</td>
                <td>{{$datas->mobile}}</td>
                <td>{{$datas->land}}</td>
                <td>{{$datas->email}}</td>
                <td>{{$datas->date}}</td>
                <td>{{$datas->total}}</td>      
            </tr>
            @endforeach
          </thead>
          <tbody></tbody>
          <tfoot>
              <tr id = "rowid">
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th style="text-align:right">Total:</th>
                  <th id = "total_cost" class = "id">{{$total}}</th>
              </tr>
          </tfoot>
            
        
        </table>
        {{$data->links()}}
    </div>
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
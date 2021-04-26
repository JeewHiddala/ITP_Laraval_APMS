<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
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
                </a>
              </li>
              <li class="nav-item px-lg-4">
                <a class="nav-link text-uppercase text-expanded" href="/subResourceMenu">Menu</a>
              </li>
              <li class="nav-item px-lg-4">
                <a class="nav-link text-uppercase text-expanded" href="/about">About</a>
              </li>
              <!--<li class="nav-item px-lg-4">
                <a class="nav-link text-uppercase text-expanded" href="#">Charts</a>
              </li>-->
              <li class="nav-item px-lg-4">
                <a class="nav-link text-uppercase text-expanded" href="/machinerymaintainancePDF">Reports
                  <span class="sr-only">(current)</span></a>
              </li>
            </ul>
            
          </div>
        </div>
        <div class="col-md-2 float-right">
          <a href="/signOut" class="btn btn-primary" onclick="return confirm('Are you sure you want to sign out?')">Sign Out</a>
        </div>
      </div>
      </nav><br>
    <br>
    <!--/header-->

<!--Tab Pane-->
    <div class="container">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link  {{request() -> is('/vehiclemaintainancePDF') ? 'active' : null }}"  href="{{url('/vehiclemaintainancePDF')}}" role="tab">Vehicle Maintenance Report</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active  {{request () -> is('/machinerymaintainancePDF') ? 'active' : null }}" href="{{url('/machinerymaintainancePDF')}}" role="tab">Machinery Maintenance Report</a>
            </li>
            <li class="nav-item">
                <a class="nav-link  {{request () -> is('/machineryusagelogPDF') ? 'active' : null }}" href="{{url('/machineryusagelogPDF')}}" role="tab">Machinery Usage Log Report</a>
            </li>
        
        </ul><!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane {{request() ->is('/vehiclemaintainancePDF') ? 'active' : null }}" id="{{url('/vehiclemaintainancePDF')}}" role="tabpanel">
            <p>Vehicle Maintenance Report</p>
        </div>
        <div class="tab-pane {{request() ->is('/machinerymaintainancePDF') ? 'active' : null }}" id="{{url('/machinerymaintainancePDF')}}" role="tabpanel">
            <p>Machinery Maintenance Report</p>
        </div>
        <div class="tab-pane {{request() ->is('/machineryusagelogPDF') ? 'active' : null }}" id="{{url('/machineryusagelogPDF')}}" role="tabpanel">
            <p>Machinery Usage Log Report</p>
        </div>
    </div>

<br><br>


<div class="container">
  <h4>Select date range</h4><br>
        <form method="GET" action="/machinerymaintainancedatepicker">
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

      <div><a href = "/machinerymaintainancePDF/pdf/{{$from_date}}/{{$to_date}}"  class ="btn btn-danger"   style = "float:right">Convert in to PDF</a> </div><br>
      <p>For the period starting from <b><i>{{$from_date}}</i></b> to <b><i>{{$to_date}}</b></i></p>
      

        <table class="table table-dark table-bordered table-striped">
        <thead>
            <th>Machinery Maintenance List Number</th>
            <th>Machinery Model Number</th>
            <th>Maintenance Type</th>
            <th>Employee Name</th>
            <th>Date</th>
            <th>Company Name</th>
            <th>Contact No</th>
            <th>Cost</th>
        
            @foreach($data as $datas)
            <tr  id = "table">
                <td>{{$datas->maintenance_id}}</td>
                <td>{{$datas->model_no}}</td>
                <td>{{$datas->maintenance_type}}</td>
                <td>{{$datas->name}}</td>
                <td>{{$datas->maintenance_date}}</td>
                <td>{{$datas->company_name}}</td>
                <td>{{$datas->contact_no}}</td>
                <td>{{$datas->cost}}</td>
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
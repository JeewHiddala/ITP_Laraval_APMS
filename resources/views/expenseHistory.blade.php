<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense History</title>
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
                <a class="nav-link text-uppercase text-expanded" href="/fmMenu">Menu</a>
              </li>
              <li class="nav-item px-lg-4">
                <a class="nav-link text-uppercase text-expanded" href="/fmCharts">Charts</a>
              </li>
              <li class="nav-item px-lg-4">
                <a class="nav-link text-uppercase text-expanded" href="/expenseSummary">Reports</a>
              </li>
            </ul>
            
          </div>
        </div>
        <a href="/signOut" class="btn btn-primary" style="float:right" onclick="return confirm('Are you sure you want to sign out?')">Sign Out</a>
        <!--Search Bar-->
        <div class="col-md-2 float-right">
            <form action="/searchExpense" method="GET">
                {{csrf_field()}}
                <div class="input-group">
                    <input type="search" name="searchBar" placeholder="Payment Number" class="form-control">
                    <span class="input-group-prepend">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </span>
                </div>
            </form>
      </nav><br>
    <br>
    <!--/header-->


    <div class="container-lg pt-5">
        <h1>Delete/Update Log</h1>
        <br>
        <h4>Note:You cannot perform any operation here.</h4>
        <br>
        <table class="table table-dark">
            <tr>
                <th>Payment Number</th>
                <th>Amount</th>
                <th>Description</th>
                <th>Date of transaction</th>
                <th>Discount Received</th>
                <th>Category</th>
                <th>Status</th>
                <th>Changed Date</th>
            </tr>
            @foreach($history as $log)
            <tr>
                <td>{{$log->payment_number}}</td>
                <td>{{$log->amount}}</td>
                <td>{{$log->description}}</td>
                <td>{{$log->date_of_transaction}}</td>
                <td>{{$log->discount_received}}</td>
                <td>{{$log->category}}</td>
                <td>{{$log->action}}</td>
                <td>{{$log->changed_date}}</td>
            </tr>
            @endforeach
        </table>
        {{$history->links()}}
        <br>
        <br>
        <a href="/expense" class="btn btn-success">Back</a>
    </div>

    <br>
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
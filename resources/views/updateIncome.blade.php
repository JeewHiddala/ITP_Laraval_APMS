<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Expense</title>
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
    <img src="{{ asset('images/logo.png') }}" alt="logo" width="110" height="100" style="float:left; margin-top:-2.2% ;padding-left:0.5%">
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
                <a class="nav-link text-uppercase text-expanded" href="/about">About</a>
              </li>
            </ul>
            
          </div>
        </div>
        <a href="/signOut" class="btn btn-primary" style="float:right" onclick="return confirm('Are you sure you want to sign out?')">Sign Out</a>
        <!--Search Bar-->
        <div class="col-md-2 float-right">
            <form action="/searchIncome" method="GET">
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
        <h1>Update Your Income Here!</h1>
        <form action="/updateIncome" method="POST">
            {{csrf_field()}} <!--protect from cross site request forger attacks-->
        <div class="form-group">
            <input type="hidden" name="id" value="{{$incomeData->id}}"/>
            <p>Receipt Number</p>
            <input type="text" name="receiptNumber" class="form-control" value="{{$incomeData->receipt_number}}"/> <br>
            <p>Amount</p>
            <input type="text" name="amount" class="form-control" value="{{$incomeData->amount}}"/> <br>
            <p>Discount Given</p>
            <input type="text" name="discount" class="form-control" value="{{$incomeData->discount_received}}" placeholder="Add discount"/> <br>
            <p>Description</p>
            <input type="text" name="description" class="form-control" value="{{$incomeData->description}}" placeholder="Add description"/> <br>
            <p>Category</p>
            <select name="category" class="form-control">
            <option value="{{$incomeData->category}}">{{$incomeData->category}}</option>
            <option value="Interest Income">Interest Income</option>    
            <option value="Delivery Income">Delivery Income</option>    
            <option value="Commission Income">Commission Income</option>    
            <option value="Other">Other</option>
            </select> <br>
            <p>Transaction Date</p>
            <input type="date" name="dot" class="form-control" value="{{$incomeData->date_of_transaction}}"/>
            <br>
            <input type="submit" class="btn btn-warning" value="Update">
            &nbsp; <!--horizontal spacing-->
            <a href="/income" class="btn btn-danger">Cancel</a>
        </div>
        </form>
    </div>  
    <br> 
    
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
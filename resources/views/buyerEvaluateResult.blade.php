
               <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="images/logo.png">
    <title>Supplier Managment-WholeSaleBuyer</title>

 

      <link href="css/business-casual.min.css" rel="stylesheet">
</head>
<body style = " ">

<img src="images/logo.png" alt="logo" width="110" height="100" style="float:left; margin-top:-2.2% ;padding-left:0.5%">
    <h1 class="site-heading text-center text-white d-none d-lg-block">
        <!--<span class="site-heading-upper text-primary mb-3">A Free Bootstrap 4 Business Theme</span>-->
        <span class="site-heading-lower" style="color:#e6a756">Ranjith Motors & Auto Parts</span>
      </h1>

    <nav class="navbar navbar-expand-lg navbar-dark py-lg-4" id="mainNav" style="position:relative">
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
                <a class="nav-link text-uppercase text-expanded" href="/subBuyerMenu">Menu</a>
              </li>
              <li class="nav-item px-lg-4">
                <a class="nav-link text-uppercase text-expanded" href="/about">About</a>
              </li>

              <li class="nav-item px-lg-4">
                <a class="nav-link text-uppercase text-expanded" href="/dynamic_pdf_buyer">Reports</a>
              </li>
            </ul>
            
          </div>
        </div>
        <div class="col-md-2.5 float-right">
        <form action="/searchWholeBuyer" method="get">

<div class="input-group">
    <input type="search" name="searchWbuyer" class="form-control" placeholder="Search by Name">
    <span class="input-group-prepend">
        <button type="submit" class="btn btn-primary">Search</button>&nbsp;&nbsp;
    </span>
  

</form>
<a href="/signOut" class="btn btn-primary" onclick="return confirm('Are you sure you want to sign out?')">Sign Out</a>
</div>
</div>
      </nav><br>

<div class="container">
    
    
    <div class="text-center">
    
      <h1>WholeSaleBuyer Evaluation</h1>
     <?php date_default_timezone_set('Asia/Colombo')?>

     <p style="float:right;">
     Date and Time : {{$date = date('m/d/Y h:i:s a', time())}}
     </p>
      <br><br>

      <h2>Top 5 Wholesale Buyer of Our Company</h2>
    </div>
   <!-- <form method="get" action="/bestBuyer">
        <input type="submit" class="btn btn-warning" value="Get the Top 5 Whole Sale Buyers">
    </form>-->

      <div class="col-md-3">
   
    </div>

            <div class="row">
                <div class="col-md-12">

               

        <br>
        <h4>Note : </h4>
        <h5>The system determines the five wholesale buyers who have purchased the most items from the company as the best wholesale buyers of the company.</h5>
<br><br>

       

                 <table class="table table-dark" >
                  <th>Registration Number</th>
                  <th>Buyer'S Name</th>
                  <th>Amount</th>
                  <th>Send</th>

                  @foreach($data as $data1)
                  <tr>
                  <td>{{$data1->reg_no}}</td>
                  <td>{{$data1->buyer_name}}</td>
                  <td>Rs.{{$data1->total1}}.00</td>
                  <td><a href="/dynamic_pdf_SingleEbuyer/pdf/{{$data1->reg_no}}" class="btn btn-warning">Send an Evaluation Letter</a></td>
                   
                  
                  
                
                  

                  
                  


                  </tr>
                  @endforeach


                 </table>
                </div>
            </div>
</div>
    
</div>
</body>

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
</html>


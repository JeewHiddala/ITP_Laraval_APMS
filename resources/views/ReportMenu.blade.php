<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Menu</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link href="{{ URL::asset('css/business-casual.min.css') }}" rel="stylesheet" type="text/css" >
    <link rel="icon" type="image/png" href={{URL::asset('/images/logo.png')}}>

   

<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
   

    <link href="/css/app.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="/js/app.js"></script>      

</head>
<body>

    <img src="images/logo.png" alt="logo" width="110" height="100" style="float:left; margin-top:-2.2% ;padding-left:0.5%">
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
                <a class="nav-link text-uppercase text-expanded" href="/about">About</a>
              </li>
              <li class="nav-item px-lg-4">
                <a class="nav-link text-uppercase text-expanded" href="#">Reports</a>
              </li>

            </ul>
            
          </div>
        </div>
        <div class="col-md-4 float-right">
          <a href="/signOut" class="btn btn-primary" style="float:right" onclick="return confirm('Are you sure you want to sign out?')">Sign Out</a>
            
         </div>
      </nav>
    <br>

    <!--1st Row-->
   
   
   <?php
   
  echo $request=session()->get('data12');
?>
<br>
<center><h3><strong>Report Inspection</strong></h3></center>
<br><br>



                <center>
                        <div>
                          <a href="/itemsReports" class="btn btn-primary btn-lg" role="button"><span class="glyphicon glyphicon-list-alt"></span> <img class="card-img-top" src="images/warehouse.png" alt="Card image" style="width:100px; height:100px; margin-right:auto; margin-left:auto; "> <br/>Stock</a>&nbsp;&nbsp;
                          <a href="#" class="btn btn-primary btn-lg" role="button"><span class="glyphicon glyphicon-bookmark"></span><img class="card-img-top" src="images/product.png" alt="Card image" style="width:100px; height:100px; margin-right:auto; margin-left:auto; "> <br/>Supplier/Buyer</a>&nbsp;&nbsp;
                          <a href="/Tpdf" class="btn btn-primary btn-lg" role="button"><span class="glyphicon glyphicon-signal"></span><img class="card-img-top" src="images/investor.png" alt="Card image" style="width:100px; height:100px; margin-right:auto; margin-left:auto; "> <br/>Items</a>&nbsp;&nbsp;
                          <a href="/RDelivery" class="btn btn-primary btn-lg" role="button"><span class="glyphicon glyphicon-comment"></span> <img class="card-img-top" src="images/courier.png" alt="Card image" style="width:100px; height:100px; margin-right:auto; margin-left:auto; "><br/>Delivery</a>&nbsp;&nbsp;

                        </div><br>
                        <div>
                        <a href="/vehiclemaintainancePDF" class="btn btn-primary btn-lg" role="button"><span class="glyphicon glyphicon-comment"></span> <img class="card-img-top" src="images/productivity.png" alt="Card image" style="width:100px; height:100px; margin-right:auto; margin-left:auto; "><br/>Resources</a>&nbsp;&nbsp;
                        <a href="/dynamicEmp_pdf" class="btn btn-primary btn-lg" role="button"><span class="glyphicon glyphicon-comment"></span><img class="card-img-top" src="images/woman.png" alt="Card image" style="width:100px; height:100px; margin-right:auto; margin-left:auto; "> <br/>Employees</a>&nbsp;&nbsp;
                        <a href="/expenseSummary" class="btn btn-primary btn-lg" role="button"><span class="glyphicon glyphicon-comment"></span><img class="card-img-top" src="images/money.png" alt="Card image" style="width:100px; height:100px; margin-right:auto; margin-left:auto; "><br/>Finance</a>&nbsp;&nbsp;
                        </div>
                </center>

   
<br><br><br><br>

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
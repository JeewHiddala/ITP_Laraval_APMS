<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Menu</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link href="{{ URL::asset('/css/business-casual.min.css') }}" rel="stylesheet" type="text/css" >

</head>
<body>

    <img src="/images/logo.png" alt="logo" width="110" height="100" style="float:left; margin-top:-2.2% ;padding-left:0.5%">
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
                <a class="nav-link text-uppercase text-expanded" href="/about">About</a>
              </li>
            </ul>
            
          </div>
        </div>
        <div class="col-md-3 float-right">
               <a href="/signOut" class="btn btn-primary" style="float:right" onclick="return confirm('Are you sure you want to sign out?')">Sign Out</a>
                 
              </div>

      </nav>
    <br>
    <div class="container-lg pt-5">
        <!--1st Row-->
       
       
       <?php
       
      echo $request=session()->get('data12');
    ?>
    
        <div class="card-deck">
        <!--Stock Managemnt-->
        <div class="col-md-10 offset-2 mt-6">
                @include('flash-message')
                @yield('content')
        </div>
                
               
    
                <div class="card" style="height:21rem; width: 15rem;">
            <img class="card-img-top" src="images/factory.png" alt="Card image" style="width:150px; height:150px; margin-right:auto; margin-left:auto; ">
                <div class="card-body">
                    <h4 class="card-title" style="align:center;"><center>Stock Management</center></h4>
                    <!--<p class="card-text">Operations related to individual order management</p>--><br><br>
                  <center>  <a href="/checkRole" class="btn btn-primary">Enter</a></center>
                </div>
            </div>
    
      
      
               
            
             <!--Supplier and Buyer Managemnt-->
             <div class="card" style="height:21rem; width: 15rem;">
                <img class="card-img-top" src="images/product.png" alt="Card image" style="width:150px; height:150px; margin-right:auto; margin-left:auto; ">
                <div class="card-body">
                   <center> <h4 class="card-title">Supplier & Buyer Management</h4></center>
                 <!--   <p class="card-text">Operations related to supplier & buyer management</p>--><br>
                 <center>  <a href="/checkRoleSupBuyer" class="btn btn-primary">Enter</a> <center> 
                </div>
            </div>
            
             <!--Order Managemnt - Individual Customers-->
            <div class="card" style="height:21rem; width: 15rem;">
            <img class="card-img-top" src="images/buyer.png" alt="Card image" style="width:150px; height:150px; margin-right:auto; margin-left:auto; ">
                <div class="card-body">
                    <h4 class="card-title" style="align:center;"><center>Order Management</center><center> Individual Buyers</center></h4>
                    <!--<p class="card-text">Operations related to individual order management</p>--><br>
                  <center>  <a href="/checkRolerOrders" class="btn btn-primary">Enter</a></center>
                </div>
            </div>
    
            <!--Order Managemnt - WholeSale Buyers-->
            <div class="card" style="height:21rem; width: 15rem;">
                <img class="card-img-top" src="images/investor.png" alt="Card image"  style="width:150px; height:150px; margin-right:auto; margin-left:auto; ">
                <div class="card-body">
                    <center><h4 class="card-title">Order Management Wholesale Buyers</h4></center>
                    <!--<p class="card-text">Operations related to wholesale order management</p>--><br>
                    <center>    <a href="/checkRolerwOrders" class="btn btn-primary">Enter</a></center>
                </div>
            </div>
        </div>
        <br>
        <!--2nd Row-->
         <!--Transport Managemnt-->
        <div class="card-deck">
            <div class="card"  style="height:21rem; width: 15rem;">
                <img class="card-img-top" src="images/delivery.png" alt="Card image"  style="width:150px; height:150px; margin-right:auto; margin-left:auto; ">
                <div class="card-body">
                <center>  <h4 class="card-title">Transport Management</h4></center>
                      <!-- <p class="card-text">Operations related to transport management</p>-->
                    <center>   <a href="/checkRoleTrasport" class="btn btn-primary">Enter</a></center>
                </div>
            </div>
    
            <!--Resource Managemnt-->
            <div class="card"  style="height:21rem; width: 15rem;">
                <img class="card-img-top" src="images/productivity.png" alt="Card image" style="width:150px; height:150px; margin-right:auto; margin-left:auto; ">
                <div class="card-body">
                <center>    <h4 class="card-title">Resource Management</h4></center>
                  <!-- <p class="card-text">Operations related to resource management</p>-->
                 <center>   <a href="/checkRoleResource" class="btn btn-primary">Enter</a></center>
                </div>
            </div>
    
            <!--Employee Managemnt-->
            <div class="card" style="height:21rem; width: 15rem;">
                <img class="card-img-top" src="images/woman.png" alt="Card image" style="width:150px; height:150px; margin-right:auto; margin-left:auto; ">
                <div class="card-body">
                <center> <h4 class="card-title">Employee Management</h4></center>
                      <!--  <p class="card-text">Operations related to employee management</p>-->
                    <center> <a href="/checkRoleEmployee" class="btn btn-primary">Enter</a></center>
                </div>
            </div>
    
            <!--Finance Managemnt-->
            <div class="card"  style="height:21rem; width: 15rem;">
                <img class="card-img-top" src="images/money.png" alt="Card image" style="width:150px; height:150px; margin-right:auto; margin-left:auto; ">
                <div class="card-body">
                <center>  <h4 class="card-title">Finance Management</h4></center>
                      <!--   <p class="card-text">Operations related to finance management</p>--><br>
                    <center>   <a href="/checkRoleFinance" class="btn btn-primary">Enter</a></center>
                </div>
            </div>
        </div>
        <br>
    
        <!--3rd Row-->
    
        <!--Profile-->
        <div class="card-deck">
            <div class="card" style="height:21rem; width:15rem;">
        
                <img class="card-img-top" src="images/competence.png" alt="Card image"  style="width:150px; height:150px; margin-right:auto; margin-left:auto; ">
                <div class="card-body">
                <center> <h4 class="card-title">Profile</h4></center>
                      <!--<p class="card-text">Manage your profile here</p>--><br>
                    <center>  <a href="/profile" class="btn btn-primary">Enter</a></center>
                </div>
            </div>
    
            <!--Profile-->
            <div class="card" style="height:21rem; width:15rem;">
                <img class="card-img-top" src="images/feedback.png" alt="Card image" style="width:150px; height:150px; margin-right:auto; margin-left:auto; ">
                <div class="card-body">
                <center>   <h4 class="card-title">Customer Feedback</h4></center>
                     <!-- <p class="card-text">Check customer feedbacks</p>--><br>
                    <center>  <a href="/checkRoleFeedback" class="btn btn-primary">Enter</a></center>
                </div>
            </div>
    
          <!--Leaving-->
          
            <div class="card" style="height:21rem; width:15rem;">
        
                <img class="card-img-top" src="images/leaving.png" alt="Card image" style="width:150px; height:150px; margin-right:auto; margin-left:auto; ">
                <div class="card-body">
                <center> <h4 class="card-title">Leave Applications</h4></center><br>
                  
                    <center> <a href="/leave" class="btn btn-primary">Enter</a></center>
                </div>
            </div>
    
    
            <!--Reports-->
            <div class="card" style="height:21rem; width:15rem;">
                <img class="card-img-top" src="images/files-and-folders.png" alt="Card image" style="width:150px; height:150px; margin-right:auto; margin-left:auto; ">
                <div class="card-body">
                <center>   <h4 class="card-title">Reports</h4></center>
                     <!-- <p class="card-text">Generate several reports as your requirement</p>--><br>
                    <center>   <a href="/rmenu" class="btn btn-primary">Enter</a></center>
                </div>
            </div>
        </div>
    </div>
    <br><br>

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
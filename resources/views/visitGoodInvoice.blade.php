<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>Visit To New Invoice</title>

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
                <a class="nav-link text-uppercase text-expanded" href="/orderManageMenu">Menu</a>
              </li>

              <li class="nav-item px-lg-4">
                <a class="nav-link text-uppercase text-expanded" href="/about">About</a>
              </li>
              
            </ul>
            
          </div>
        </div>



        <div class="col-md-2.5.loat-right">


            
            <a href="/signOut" class="btn btn-primary" onclick="return confirm('Are you sure you want to sign out?')">Sign Out</a>
            </div>
            </div>
      </nav><br>




      <div class="container">
    <div class="text-center">
        <br><br>
        <h1>Good Return Invoice :</h1>
         
        <input type="text" class = "form-control" name="invoice_Id" value = "{{$data->id}}" readonly/><br>
            
        
        <form  action="/greadyids/{{$data->id}}" method="post">
      {{csrf_field()}}
      <input type="hidden" class = "form-control" name="invoice_Id" value = "{{$data->id}}" readonly/><br>
      <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
            
             <p style="text-align:left">Sales Person</p>
            <input type="text" class = "form-control" name="semp" placeholder = "employee ID" onclick="return myFunction()" required/><br>
          
           <div class="form-group">
    
                <p style="text-align:left">WholeShale Buyer ID</p>

                <select name="buyer_id">
                  <option>Select WholeShale Buyer ID</option>
                  @foreach($buyerinfo as $whole_sale_buyer)
                  <option value="{{$whole_sale_buyer->reg_no}}">{{$whole_sale_buyer->reg_no}}</option>
                  @endforeach
                </select> 
            </div>

            <input  type="submit" a href="/readyids" name="ready" class="btn btn-success" value="Ready To Go"/>  

      </form>












          
        <br><br>        

     
    </div>
    </div>
    </div>  
    </div> 

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

      <script>
          function myFunction() {
            var x;

            // Get the value of the input field with id="numb"
            x = document.getElementById("semp").value;

            if(!/^[0-9]+$/.test(x)){
              alert("Please Enter User ID");
            }
            
          }
</script>
</body>
</html>
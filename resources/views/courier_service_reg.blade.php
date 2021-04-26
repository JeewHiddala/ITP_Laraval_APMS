<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="{{ URL::asset('/css/business-casual.min.css') }}" rel="stylesheet" type="text/css" >
    <title>Courier Service</title>
    <link rel="icon" type="image/png" href="images/logo.png">
</head>
<body >


  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>  

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
        <div class="col-md-2.5 float-right">
            <form action="/searchCu" method="GET">
                {{csrf_field()}}
                <div class="input-group">
                    <input type="search" name="searchBar" placeholder="Courier Service" class="form-control">
                    <span class="input-group-prepend">
                        <button type="submit" class="btn btn-primary">Search</button>&nbsp;&nbsp;
                    </span>
                    </form>
                    <a href="/signOut" class="btn btn-primary" onclick="return confirm('Are you sure you want to sign out?')">Sign Out</a>
                </div>
            
      </nav><br>




    <div class='container'>

    <div class='text-center'>
      <h3>Courrier Service Registration</h3><br>
    
    <div class='row'>
        <div class="col-md-12">

            @foreach($errors->all() as $error)
            
            <div class ="alert alert-danger" role="alert">
                
                {{$error    }} 
             
            </div>

            @endforeach


           

            <form method="post" action = "/save_courier">
            {{csrf_field()}}
                <p style="text-align:left">Company Name</p>
                <input type="text" class = "form-control" name="company_name" placeholder = "Enter Company Name"/><br>
                <p style="text-align:left">Company Address</p>
                <input type="text" class = "form-control" name="address" placeholder = "Enter Company address"/><br>
                <p style="text-align:left">District</p>
                <input type="text" class = "form-control" name="district" placeholder = "Enter Company District"/><br>
                <p style="text-align:left">Land Phone No</p>
                <input type="text" class = "form-control" name="land" pattern="[0-9]{10}" placeholder = "Enter Company Land"/><br>
                <p style="text-align:left">Mobile Phone No Name</p>
                <input type="text" class = "form-control" name="mobile" pattern="[0-9]{10}" placeholder = "Enter Company Mobile"/><br>
                <p style="text-align:left">Fax No</p>
                <input type="text" class = "form-control" name="fax" pattern="[0-9]{10}" placeholder = "Enter Company Fax"/><br>
                <p style="text-align:left">E-mail</p>
                <input type="text" class = "form-control" name="e_mail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder = "Enter Company E-mail"/><br>
                <div style = "float:left">
                <input  type="submit" class="btn btn-primary" value="Save"/>
                <input type="reset"   class="btn btn-warning" style="color:white;" value="Cancel"/>
                </div>
            </form>
        <br>
    <div><a href = "{{ url('courier_company/pdf')}}"  class ="btn btn-danger"   style = "float:right">Convert in to PDF</a> </div><br><br>

        <table class="table table-dark">
            <th>ID</th>
            <th>Company Name</th>
            <th>Address</th>
            <th>Land No</th>
            <th>Mobile No</th>
            <th>Fax</th>
            <th>E-mail</th>

            @foreach($courier_service as $courier_services)
            <tr>
                <td>{{$courier_services->id}}</td>
                <td>{{$courier_services->company_name}}</td>  
                <td>{{$courier_services->address}}</td>
                <td>{{$courier_services->land}}</td>
                <td>{{$courier_services->mobile}}</td>
                <td>{{$courier_services->fax}}</td>
                <td>{{$courier_services->e_mail}}</td>
                <td><a href="/updatecourier/{{$courier_services->id}}" class="btn btn-success">Update</a></td>
                <td><a href="/delcourier/{{$courier_services->id}}" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
                
            </tr>
            @endforeach

</table>
{{$courier_service->links()}}
</div>
</div>
</div>  
    </div> <br>

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
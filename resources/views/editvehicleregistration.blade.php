<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="images/logo.png">
    <link href="{{ URL::asset('/css/business-casual.min.css') }}" rel="stylesheet" type="text/css" >
    <img src="{{ asset('/images/logo.png') }}" alt="logo" width="110" height="100" style="float:left; margin-top:-2.2% ;padding-left:0.5%">
    
    <title>Edit Vehicle Details</title>
    
    <!--<img src="images/logo.png" alt="logo" width="110" height="100" style="float:left; margin-top:-2.2% ;padding-left:0.5%">-->
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
                </a>
              </li>
              <li class="nav-item px-lg-4">
                <a class="nav-link text-uppercase text-expanded" href="/subResourceMenu">Menu
                  <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item px-lg-4">
                <a class="nav-link text-uppercase text-expanded" href="/about">About</a>
              </li>
            </ul>
            
          </div>
        </div>
        <div class="col-md-4 float-right">
            <form action="/searchVehiReg" method="GET">

                <div class="input-group">
                    <input type="search" name="searchBar" placeholder="Vehicle Register number" class="form-control">
                    <span class="input-group-prepend">
                        <button type="submit" class="btn btn-primary">Search</button>&nbsp;&nbsp;
                    </span>

            </form>
            <a href="/signOut" class="btn btn-primary" onclick="return confirm('Are you sure you want to sign out?')">Sign Out</a>
          </div>
        </div>
      </nav><br>

</head>
<body>

    <div class = "vehiregcontainer">
        <div class = "vregnavigationcontainer">

        </div>

        @foreach($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{$error}}
            </div>
        @endforeach

        <form  method="post" action="/updatevehicle">
        {{csrf_field()}}

                <div class = "vehiregdetailscontainer">
                    <div class="col-md-6">
                      <h3 style="text-align: center;">Edit Vehicle Registration</h3>
                        <div class = "vehicaldetailscontainer">
                           <input type="hidden" value="{{$vehicledata->id}}" name="regno" id="one" size="30" ><br><br>
                            Model &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="text" value="{{$vehicledata->model}}" style="width:50%" class ="form-control" name="model" id="one" size="30" pattern="[0-9A-Za-z#_-^{10}]"><br><br>
                            Type &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <select id="type" name="assettype" style="width:50%" class ="form-control">
                                <option hidden>{{$vehicledata->type}}</option>
                                <option value="Heavy Vehicle" >Heavy Vehicle</option>
                                <option value="Light Vehicle">Light Vehicle</option>
                            </select><br><br>
                            Vehicle Register No &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="text" value="{{$vehicledata->vehi_reg_no}}" style="width:50%" class ="form-control" name="vehiregno" id="one" size="30" pattern="[0-9A-Za-z#_-^{10}]"><br><br>
                        </div><br>
                    </div>
                    <div class="col-md-6">
                        <div class = "insuarancedetailscontainer">
                            Insurance No &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="text" value="{{$vehicledata->insu_no}}" name="insuno" id="one" size="30" pattern="[0-9A-Za-z#_-^{10}]" style="width:50%" class ="form-control"><br><br>
                            Insurance Type &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <!--<input type="text" value="{{$vehicledata->insu_type}}" name="insutype" id="one" size="30" pattern="[0-9A-Za-z#_-^{10}]"><br><br>-->
                            <select id="type" name="insutype" style="width:50%" class ="form-control">
                                <option hidden>{{$vehicledata->insu_type}}</option>
                                <option value="Full Insurance" >Full Insurance</option>
                                <option value="Third Party">Third Party</option>
                            </select><br><br>
                            Insurance Renew Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="date" value="{{$vehicledata->insu_rew_date}}" name="insurewdate" id="one" size="30" pattern="[0-9A-Za-z#_-^{10}]" style="width:40%" class ="form-control"><br><br>
                        </div>
                    </div>
                </div>
                    <div class = btncontainer>
                            <input type="submit" value="Update" name="Update" onclick="" class="btn btn-primary">  
                            <a href="/vehicleregistration"><input type="button" value="Cancel" name="back" onclick="" class="btn btn-warning"></a>  
                    </div>
        </form>

        
    </div><br>
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

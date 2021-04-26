<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Official Visit</title>
    <link rel="icon" type="image/png" href="images/logo.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="{{ URL::asset('/css/business-casual.min.css') }}" rel="stylesheet" type="text/css" >

</head>
<body>

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
          <li class="nav-item px-lg-4">
            <a class="nav-link text-uppercase text-expanded" href="/RVisits">Report</a>
          </li>

        </ul>
        
      </div>
    </div>
    <div class="col-md-2.5 float-right">
        <form action="/searchVi" method="GET">
            {{csrf_field()}}
            <div class="input-group">
                <input type="search" name="searchBar" placeholder="Visits" class="form-control" >
                <span class="input-group-prepend">
                    <button type="submit" class="btn btn-primary">Search</button>&nbsp;&nbsp;
                </span> 
              </form>
                <a href="/signOut" class="btn btn-primary" onclick="return confirm('Are you sure you want to sign out?')">Sign Out</a>
            </div>
    </div>
  </nav><br>

    <br><h3 style="text-align:center">Official Visits</h3><br>
    <div class="container">
                <div class="form-group">

                    @foreach($errors->all() as $error)
            
                    <div class ="alert alert-danger" role="alert">
                        
                        {{$error}} 
                     
                    </div>
                       
                    @endforeach

                    <form method="post" action = "/save_visits">
                        {{csrf_field()}}
                    <p style="text-align:left">Date</p>
                    <input type="date" name="date" class = "date form-control" style="width:250px" /><br>
                    <p style="text-align:left">Departure Time</p>
                    <input type="time" name="departure" class = "departure form-control" style="width:250px" /><br>
                    <p style="text-align:left">Arrival Time</p>
                    <input type="time" name="arrival" class = "Arrival form-control" style="width:250px" /><br>
                    <p style="text-align:left">Purpose</p>
                    <textarea type="textarea" name="purpose" rows="4" class = "departure form-control" style="width:550px" ></textarea><br>

                    <p>Driver Name:</p>
                    <select name="driver_id" class="driver form-control" style="width:250px" id="driver_id">
                        <option value="driver">--- Select Driver ---</option>
                        @foreach ($driver as $value)
                        <option value="{{ $value->employee_id }}">{{ $value->name }}</option>
                        @endforeach
                    </select><br>

                    <p>Vehicle No:</p>
                    <select name="vehicle_id" class="vehicle form-control" style="width:250px" id="vehicle_id">
                        <option value="vehicle">--- Select Vehicle ---</option>
                        @foreach ($vehicle as $value)
                        <option value="{{ $value->id }}">{{ $value->vehi_reg_no }}</option>
                        @endforeach
                    </select><br>

                    <p style="text-align:left">Fuel Cost</p>
                    <input type="number" name="fuel" class = "fuel form-control" style="width:250px" /><br>
                    <input  type="submit" class="btn btn-primary" value="Save"/>
                    <input type="reset"  class="btn btn-warning" style="color:white" value ="Cancel"/>
                    </form><br><br>

                    <table class="table table-dark">
                        <th>Visit ID</th>
                        <th>Date</th>
                        <th>Departure Time</th>
                        <th>Arrival Time</th>
                        <th>Purpose</th>
                        <th>Driver Name</th>
                        <th>Vehicle Name</th>
                        <th>Fuel Cost</th>

                        @foreach($data as $datas)
                        <tr>
                            <td>{{$datas->id}}</td>
                            <td>{{$datas->date}}</td>
                            <td>{{$datas->departure}}</td>
                            <td>{{$datas->arrival}}</td>
                            <td>{{$datas->purpose}}</td>
                            <td>{{$datas->name}}</td>
                            <td>{{$datas->vehi_reg_no}}</td>
                            <td>{{$datas->fuel}}</td>

                            <td><a href="/updatevisit/{{$datas->id}}"  class="btn btn-success">Update</a></td>
                            <td><a href="/delvisit/{{$datas->id}}" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
                            
                        </tr>
                        @endforeach
            
            </table>
            {{$data->links()}}
                
                </div></div>

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
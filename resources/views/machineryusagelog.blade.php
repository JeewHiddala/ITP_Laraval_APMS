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
    <link href="css/business-casual.min.css" rel="stylesheet">
    
    <title>Machinery Usage Log</title>

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
                </a>
              </li>
              <li class="nav-item px-lg-4">
                <a class="nav-link text-uppercase text-expanded" href="/subResourceMenu">Menu
                  <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item px-lg-4">
                <a class="nav-link text-uppercase text-expanded" href="/about">About</a>
              </li>
              <li class="nav-item px-lg-4">
                <a class="nav-link text-uppercase text-expanded" href="/machineryusagelogPDF">Reports</a>
              </li>
            </ul>
            
          </div>
        </div>
        <div class="col-md-3 float-right">
            <form action="/searchMachUsageLog" method="GET">
                
                <div class="input-group">
                    <input type="search" name="searchBar" placeholder="Model Number" class="form-control">
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
<div>


        
        
        <form  method="post" action="/saveMachineryUsageLog">
          {{csrf_field()}}

        <div>
            <div>
                <div>
                Machinery Model Number &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <select name="machinery_regno" class="machinery form-control" style="width:250px" id="machinery_regno" >
                                        <option value="machinery">--- Select Machinery ---</option>                         
                                        @foreach ($machinery as $value)
                                        <option value="{{ $value->id }}">{{ $value->model_no }}</option>
                                        @endforeach
                  
                </select><br><br>

                Section &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <select name="section" class="machinery form-control" style="width:285px" id="machinery_regno" >
                                      <option value="section">--- Select Department ---</option>
                                      <option value="Maintenance Department">Maintenance Department</option>                         
                                      <option value="Stock Management Department">Stock Management Department</option> 
                                      <option value="Transport Management Department">Transport Management Department</option>
                 
                </select><br><br>

                Employee Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <select name="employee_regno" class="employee form-control" style="width:250px" id="employee_regno" >
                                      <option value="employee">--- Select Employee ---</option>
                                      @foreach ($emp as $value)
                                      <option value="{{ $value->employee_id }}">{{ $value->name }}</option>
                                      @endforeach
                </select><br><br>

                </div>
            </div>
            <div>
                <div>
                  <p>Starting Data & Time</p>

                    Starting Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="date" placeholder = "Type Company Name" name="start_date" id="one" size="30" ><br><br>

                    Starting Time &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="time" placeholder = "Type Contact No" name="start_time" id="one" size="30" ><br><br> 

                </div><br>
                <div>
                  <p>Estimated Ending Data & Time</p>

                    Estimated Ending Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="date" placeholder = "Type Company Name" name="estimated_end_date" id="one" size="30" ><br><br>

                    Estimated Ending Time &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="time" placeholder = "Type Contact No" name="estimated_end_time" id="one" size="30" ><br><br>

                </div>    
            </div>
        </div>

        <div>
            <input type="submit" value="Add" name="save"  class="btn btn-primary">  
            <input type="button" value="Clear" name="back" onclick="window.location.reload()" class="btn btn-warning">
            <a href="/subResourceMenu" class="btn btn-dark">Back</a>
        </div>

        </form><br>

        <div>
        <h5>In Maintenance Machineries Table</h5><br>
            <table class="table table-dark" id="dataTable" width="100%" cellspacing="0">

                  <tr>
										<th>Log No</th>
										<th>Machinery Model No</th>
										<th>Section</th>
                    <th>Employee Name</th>
                    <th>Start Date</th>
                    <th>Start Time</th>
                    <th>Estimated Ending Date</th>
                    <th>Estimated Ending Time</th>
									</tr>
                                    
                                  @foreach($data as $data)
                                    <tr>
                                      <td>{{$data->log_no }}</td>
                                      <td>{{$data->model_no}}</td>
                                      <td>{{$data->section}}</td>
                                      <td>{{$data->name}}</td>
                                      <td>{{$data->start_date}}</td>
                                      <td>{{$data->start_time}}</td>
                                      <td>{{$data->estimated_end_date}}</td>
                                      <td>{{$data->estimated_end_time}}</td>
                                        <td><a href="/editmachineryusagelog/{{$data->log_no}}"><input type="button" value="Edit" name="edit"  class="btn btn-success"></a></td>

                                    </tr>
                                    @endforeach

            </table>
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
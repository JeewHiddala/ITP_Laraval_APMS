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
    <link href="/css/business-casual.min.css" rel="stylesheet">
    
    <title>Machinery Maintenance</title>

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
                <a class="nav-link text-uppercase text-expanded" href="/machinerymaintainancePDF">Reports</a>
              </li>
            </ul>
            
          </div>
        </div>
        <div class="col-md-3 float-right">
            <form action="/searchMachMain" method="GET">

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
        <div>
                            <!--dfh -->
                            <div class="container">
                              <ul class="nav nav-tabs" role="tablist">
                              <li class="nav-item">
                                  <a class="nav-link  {{request () -> is('/vehiclemaintenance') ? 'active' : null }}"  href="{{url('/vehiclemaintenance')}}" role="tab">Vehicle Maintenance</a>
                              </li>
                              <li class="nav-item">
                                  <a class="nav-link active {{request () -> is('/machinerymaintenance') ? 'active' : null }}" href="{{url('/machinerymaintenance')}}" role="tab">Machinery Maintenance</a>
                              </li>
                              
                            </ul><!-- Tab panes -->
                            <div class="tab-content">
                              <div class="tab-pane {{request() ->is('/vehiclemaintenance') ? 'active' : null }}" id="{{url('/vehiclemaintenance')}}" role="tabpanel">
                                  <p>Local Suppliers</p>
                              </div>
                              <div class="tab-pane {{request() ->is('/machinerymaintenance') ? 'active' : null }}" id="{{url('/machinerymaintenance')}}" role="tabpanel">
                                  <p>Foreign Suppliers</p>
                              </div>
                              
                            </div>
                            </div>
                  
                            <!--dfs-->

        </div>
        
                <!--show errors in inputs-->
                @foreach($errors->all() as $error)
                <div class="alert alert-danger" role="alert">
                    {{$error}}
                </div>
                @endforeach


        <form  method="post" action="/saveMachineryMaintenance">
        {{csrf_field()}}

        <div>
            <div>
                <div>
                Machinery Model Number &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <select name="machinery_regno" class ="form-control" style="width:50%" id="machinery_regno" >
                <option value="machinery">--- Select Machinery ---</option>
                                        @foreach ($machinery as $value)
                                        <option value="{{ $value->id }}">{{ $value->model_no }}</option>
                                        @endforeach
                                
                </select><br><br>
                
                Maintenance Type &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <select id="mtype" class ="form-control" style="width:50%" id="vehicle_regno" name="maintenancetype">
                    <option value="maintenancetype">Select Maintenance Type</option>
                    <option value="Repair">Repair</option>
                    <option value="Service">Service</option>
                </select><br><br>


                Employee Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <select name="employee_regno" class ="form-control" style="width:50%" id="employee_regno" >
                <option value="employee">--- Select Employee ---</option>
                                        @foreach ($emp as $value)
                                        <option value="{{ $value->employee_id }}">{{ $value->name }}</option>
                                        @endforeach
                </select><br><br>

                Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="date"  name="date" class ="form-control" style="width:40%" size="30" ><br><br>

                </div>
            </div>
            <div>
                <div>
                <p>Maintenance Company Details</p>

                    Company Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="text" placeholder = "Type Company Name" name="conpanyname" class ="form-control" style="width:50%" size="30" pattern="[0-9A-Za-z#_-^{10}]"><br><br>

                    Contact No &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="text" placeholder = "Type Contact No" name="contactno" class ="form-control" style="width:50%" size="30" pattern="[0-9A-Za-z+#_-^{10}]"><br><br> 

                </div>
            <div>

            Cost &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="number" placeholder = "Type Company Name" name="cost" class ="form-control" style="width:50%" size="30"><br><br>

            </div>    
            </div>
        </div>

        <div>
            <input type="submit" value="Add" name="save"  class="btn btn-primary">  
            <input type="button" value="Clear" name="back" onclick="window.location.reload()" class="btn btn-warning">
            <a href="/subResourceMenu" class="btn btn-dark">Back</a>  
        </div><br>

        </form>

        <div>
        <h5>In Maintenance Machineries Table</h5><br>
            <table class="table table-dark" id="dataTable" width="100%" cellspacing="0">

                                    <tr>
                                        <th>Machinery Maintenance List Number</th>
                                        <th>Machinery Model Number</th>
                                        <th>Maintenance Type</th>
                                        <th>Employee Name</th>
                                        <th>Date</th>
                                        <th>Company Name</th>
                                        <th>Contact No</th>
                                        <th>Cost</th>
									                  </tr>
                                    
                                @foreach($data as $data)
                                    <tr>
                                        <td>{{$data->maintenance_id}}</td>
                                        <td>{{$data->model_no}}</td>
                                        <td>{{$data->maintenance_type}}</td>
                                        <td>{{$data->name}}</td>
                                        <td>{{$data->maintenance_date}}</td>
                                        <td>{{$data->company_name}}</td>
                                        <td>{{$data->contact_no}}</td>
                                        <td>{{$data->cost}}</td>
                                        <td><a href="/editmachinerymaintenance/{{$data->maintenance_id}}" class="btn btn-success">Edit</a></td>
                                        <td><a href="/deletemachinerymaintenance/{{$data->maintenance_id}}" class="btn btn-danger" onclick="return confirm('Are you sure want to delete?')">Delete</a></td>
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
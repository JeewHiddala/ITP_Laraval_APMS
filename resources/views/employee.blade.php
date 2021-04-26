<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
 
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style type="text/css">
   .box{
    width:600px;
    margin:0 auto;
    border:1px solid #ccc;
   }
  </style>
</head>
<body>
<link href="css/business-casual.min.css" rel="stylesheet">
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
                <a class="nav-link text-uppercase text-expanded" href="/dynamicEmp_pdf">Report</a>
              </li>
            </ul>
            
          </div>
        </div>

        <div class="col-md-2.5 float-right">
          <form action="/searchEmp" method="GET">
                {{csrf_field()}}
                <div class="input-group">
                    <input type="search" name="searchEmp" placeholder="Search By Employee Name" class="form-control" >
                    <span class="input-group-prepend">
                        <button type="submit" class="btn btn-primary" style="background-color:#e6a756;" >Search</button>&nbsp;&nbsp;
                    </span>
                   
           </form>
           <a href="/signOut" class="btn btn-primary" onclick="return confirm('Are you sure want to sign out?')">Sign Out</a>
               
               </div>
           </div>

        <!--<div class="col-md-2.5 float-right">
            <form action="/searchEmp" method="GET">
                {{csrf_field()}}
                <div class="input-group">
                    <input type="search" name="searchEmp" placeholder="Search By Employee Name" class="form-control">
                    <span class="input-group-prepend">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </span>
                </div>
            </form>
            <a href="/signOut" class="btn btn-primary">Sign Out</a>
               
               </div>
           </div>-->
      </nav><br>

      <!-- <div class="col-md-2.5 float-right">
          <form action="/searchDC" method="GET">
                {{csrf_field()}}
                <div class="input-group">
                    <input type="search" name="searchEmp" placeholder="Search By Employee Name" class="form-control" >
                    <span class="input-group-prepend">
                        <button type="submit" class="btn btn-primary" style="background-color:#e6a756;" >Search</button>&nbsp;&nbsp;
                    </span>
                   
           </form>
           <a href="/signOut" class="btn btn-primary">Sign Out</a>
               
               </div>
           </div>

      -->
    
<div class="container"> 
        <div class="text-center">
        
        <h1>Employee Registration Management</h1>
        <br>

        <table class="table table-dark">
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>View Details</th>
                    <th>Update Infomation</th>
                    <th>Delete</th>
                    

                    @foreach($emprg as $empr)
                    <tr>
                        <td>{{$empr->employee_id}}</td>
                        <td>{{$empr->name}}</td>
                        <td><a href="/empview/{{$empr->employee_id}}" class="btn btn-success">View</a>
                        </td>
                        <td><a href="/updateemp/{{$empr->employee_id}}" class="btn btn-warning">Update</a>
                        </td>
                        <td>
                        <a href="/deleteemp/{{$empr->employee_id}}" class="btn btn-danger" onclick="return confirm('Are you sure want to delete?')">Delete</a></td>
                        
                    </tr>
                    @endforeach
                   
        </table>
        </div>
</div>

&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;
        &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;
        <a href="/subEmp" class="btn btn-primary">Go Back</a></br></br>

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
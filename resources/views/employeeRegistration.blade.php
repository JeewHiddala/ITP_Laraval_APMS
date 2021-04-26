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
            </ul>
            
          </div>
        </div>
        <div class="col-md-2 float-right">
            <form action="/searchEmp" method="GET">
                {{csrf_field()}}
                <div class="input-group">
                    <input type="search" name="searchBar" placeholder="Employee Name" class="form-control">
                    <span class="input-group-prepend">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </span>
                </div>
            </form>
      </nav><br>
    <div class="container">
    <div class="text-center">
    <h1>Employee Registration</h1><br>
        <div class="row">
            <div class="col-md-12">
                
                @foreach($errors->all() as $error)

                <div class="alert alert-danger" role="alert">
                {{$error}}
                </div>

                @endforeach
                

                <form method="post" action="/saveEmpDetails">
                {{csrf_field()}}

                
             

              
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
              Employee ID  &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;
              <input type="text" class="form-control" name="empId" value="
               print_r($user);?>">
                </div><br>
              

                <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                Full Name  &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;
                <input type="text" class="form-control" name="empReg" value="<?php  $user = auth()->user()->name; 
               print_r($user);?>">
                </div><br>

                <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                Address        &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;
                <input type="text" class="form-control" name="empReg1" placeholder="Enter Employee Address">
                </div><br>

                <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                Birthday &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;
                <input type="text" class="form-control" name="empReg2" placeholder="Enter Employee Birthday">
                
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Gender&nbsp;&nbsp;&nbsp;&nbsp;
                <select name="empReg3" class="form-control"  id="gender">
                                <option value="gender">--- Select Gender ---</option>

                                <option value="Female">Female</option>
                                <option value="Male">Male</option>
                               
                             </select>
                </div><br>

                <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                Designation&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;
                
                <select name="empReg4" class="form-control"  id="designation">
                                <option value="designation">--- Select Designation ---</option>

                                <option value="Driver">Driver</option>
                                <option value="Store Keeper">Store Keeper</option>
                                <option value="Sales Person">Sales Person</option>
                             </select>

                                


              
                
                 &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Salary&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="text" class="form-control" name="empReg5" placeholder="Enter Employee Salary">
                </div><br>

                <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                Mobile Number&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;
                <input type="text" class="form-control" name="empReg6" placeholder="Enter Employee Mobile Number">
               
                &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="text" class="form-control" name="empReg7" value="<?php  $user = auth()->user()->email; 
               print_r($user);?>">
                </div><br>

                <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                NIC &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;
                <input type="text" class="form-control" name="empReg8" placeholder="Enter Employee NIC Number">
              
                </div><br>

                
                
                <input type="submit" class="btn btn-primary" value="SAVE">
                <input type="button" class="btn btn-warning" value="CLEAR"
                onclick="window.location.reload();">

                </form>

                <br>
                <table class="table table-dark">
                    <th>Employee_Id</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Birthday</th>
                    <th>Gender</th>
                    <th>Designation</th>
                    <th>Salary</th>
                    <th>Mobile</th>
                    <th>E-mail</th>
                    <th>NIC</th>
                    <th>Join Date and Time</th>
                    <th>Delete</th>
                    <th>Update</th>
                    

                    @foreach($emprg as $empr)
                    <tr>
                        <td>{{$empr->employee_id}}</td>
                        <td>{{$empr->name}}</td>
                        <td>{{$empr->address}}</td>
                        <td>{{$empr->birthday}}</td>
                        <td>{{$empr->gender}}</td>
                        <td>{{$empr->designation}}</td>
                        <td>{{$empr->Salary}}</td>
                        <td>{{$empr->mobile}}</td>
                        <td>{{$empr->email}}</td>

                        <td>{{$empr->nic}}</td>
                        <td>{{$empr->created_at}}</td>

                      
                        
                        <td>
                        <a href="/deleteemp/{{$empr->employee_id}}" class="btn btn-warning">Delete</a></td>
                        <td><a href="/updateemp/{{$empr->employee_id}}" class="btn btn-success">Update</a>
                        </td>

                       </tr>
                       @endforeach

                </table>

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
</body>
</html>
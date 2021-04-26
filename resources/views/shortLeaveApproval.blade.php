<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>Document</title>
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
                <a class="nav-link text-uppercase text-expanded" href="/dynamicShortLeave_pdf">Report</a>
              </li>
            </ul>
            
          </div>
        </div>
        <div class="col-md-2.5 float-right">
          <!--<form action="/searchDC" method="GET">
                {{csrf_field()}}
                <div class="input-group">
                    <input type="search" name="searchBar" placeholder="" class="form-control" disabled>
                    <span class="input-group-prepend">
                        <button type="submit" class="btn btn-primary" style="background-color:#e6a756;" disabled>Search</button>&nbsp;&nbsp;
                    </span>
                   
           </form>-->
             <a href="/signOut" class="btn btn-primary" onclick="return confirm('Are you sure want to sign out?')">Sign Out</a>
               
            </div>
        </div>
      </nav><br>



<div class="container"> 
        <div class="text-center">
        <h1>Short Leave Form Approval</h1>
        <br>

        <div class="container">
    <ul class="nav nav-tabs" role="tablist">
	<li class="nav-item">
		<a class="nav-link {{request () -> is('/approval') ? 'active' : null }}"  href="{{url('/approval')}}" role="tab">Leave Approval</a>
	</li>
	<li class="nav-item">
		<a class="nav-link active {{request () -> is('/sapproval') ? 'active' : null }}" href="{{url('/sapproval')}}" role="tab">ShortLeave Approval</a>
	</li>
	
</ul><!-- Tab panes -->
<div class="tab-content">
	<div class="tab-pane {{request() ->is('/approval') ? 'active' : null }}" id="{{url('/approval')}}" role="tabpanel">
		<p>Leave Approval</p>
	</div>
	<div class="tab-pane {{request() ->is('/sapproval') ? 'active' : null }}" id="{{url('/sapproval')}}" role="tabpanel">
		<p>ShortLeave Approval</p>
	</div>
  </div>
  </div>
  <br>
        <div>
        <table class="table table-dark">
                    <th>Leave_ID</th>
                    <th>Employee_ID</th>
                    <th>Employee_Name</th>
                    <th>Submited Date and Time</th>
                    <th>Reason for the leave</th>
                    <th>Leave Date</th>
                    <th>Time From</th>
                    <th>Time To</th>
                    <th>Status</th>
                    <th>Action</th>
                    <th>Delete</th>
                   
                    @foreach($shortLeaveApproval as $formS)
                    <tr>
                     <td>{{$formS->leave_id}}</td>
                     <td>{{$formS->emp_id}}</td>
                     <td>{{$formS->emp_name}}</td>
                     <td>{{$formS->created_at}}</td>
                     <td>{{$formS->shortleaveType}}</td>
                     <td>{{$formS->Date}}</td>
                     <td>{{$formS->fromtime}}</td>
                     <td>{{$formS->totime}}</td>
                     
                     <td>
                     @if($formS->isApproved)
                     <button class="btn btn-success">Approved</button>
                     @else
                     <button class="btn btn-warning">Rejected</button>
                     @endif
                     </td>
                     <td>
                     
                     @if(!$formS->isApproved)
                        <a href="/markSasapproved/{{$formS->leave_id}}" class="btn btn-primary">Mark as approved</a>
                     @else
                        <a href="/markSasnotapproved/{{$formS->leave_id}}" class="btn btn-danger">Mark as rejected</a>
                     
                     @endif
                     <td>
                        <a href="deleteSLeave/{{$formS->leave_id}}" class="btn btn-warning" onclick="return confirm('Are you sure want to delete?')">DELETE</a>
                     </td>
                    
                     </td>
                    </tr>
                    @endforeach
        </table>
        </div>
        </div>
</div> 
        &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;
        &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;
        <a href="/subEmp" class="btn btn-primary">Back</a></br></br>
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
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Employee Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
   
</head>
<body>

<link href="{{ URL::asset('css/business-casual.min.css') }}" rel="stylesheet" type="text/css" >
<link href="css/business-casual.min.css" rel="stylesheet">
<img src="{{ asset('images/logo.png') }}" alt="logo" width="110" height="100" style="float:left; margin-top:-2.2% ;padding-left:0.5%">
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
            <!--<form action="/searchCu" method="GET">
                {{csrf_field()}}
                <div class="input-group">
                    <input type="search" name="searchBar" placeholder="Buyer Name" class="form-control">
                    <span class="input-group-prepend">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </span>
                </div>
            </form>-->
      </nav>
    <br />
        <div class="container">

        <div class="container">
    <ul class="nav nav-tabs" role="tablist">
	<li class="nav-item">
		<a class="nav-link {{request () -> is('/dynamicEmp_pdf') ? 'active' : null }}"  href="{{url('/dynamicEmp_pdf')}}" role="tab">Employee Registration Reports</a>
	</li>
	<li class="nav-item">
		<a class="nav-link  {{request () -> is('/dynamicLeave_pdf') ? 'active' : null }}" href="{{url('/dynamicLeave_pdf')}}" role="tab">Leave Application Report</a>
	</li>
    <li class="nav-item">
		<a class="nav-link active {{request () -> is('/dynamicShortLeave_pdf') ? 'active' : null }}" href="{{url('/dynamicShortLeave_pdf')}}" role="tab">Short Leave Application Report</a>
	</li>
	
</ul><!-- Tab panes -->
<div class="tab-content">
	<div class="tab-pane {{request() ->is('/dynamicEmp_pdf') ? 'active' : null }}" id="{{url('/dynamicEmp_pdf')}}" role="tabpanel">
		<p>Registration Application</p>
	</div>
	<div class="tab-pane {{request() ->is('/dynamicLeave_pdf') ? 'active' : null }}" id="{{url('/dynamicLeave_pdf')}}" role="tabpanel">
		<p>Leave Application</p>
	</div>
    <div class="tab-pane {{request() ->is('/dynamicShortLeave_pdf') ? 'active' : null }}" id="{{url('/dynamicShortLeave_pdf')}}" role="tabpanel">
		<p>Short Leave Application</p>
	</div>
  </div>
  </div><br><br>


            <h3 align="center">Employee Short Leave Application Details Report
            </h3><br /> 

            <div class="row">
                <div claa="col-md-7" align="right">
                    <h4 align="center">Short Leave Application Report</h4><br>
                </div>
                <div class="col-md-12" align="right">
                <a href="{{ url('dynamicShortLeave_pdf/pdf') }}" class="btn btn-danger" >Genarate Short Leave Application Report In PDF</a>
                </div>
            </div>
           <br>
            <div class="table-responsive">
                <table class="table table-stript
                table-bordered">
                    <thead>
                        <tr>
                            <th>Short Leave ID</th>
                            <th>Emp ID</th>
                            <th>Reason</th>
                            <th>Leave Date</th>
                            <th>Status(Approved=1)</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($shortLeave_data as
                    $shortLeave)
                        <tr>
                        <td>{{ $shortLeave->leave_id}}</td>
                        <td>{{ $shortLeave->emp_id}}</td>
                        <td>{{ $shortLeave->shortleaveType}}</td>
                        <td>{{ $shortLeave->Date}}</td>
                        <td>{{ $shortLeave->isApproved}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    </table>
   </div>
  </div><br>
  &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;
        &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;
        <a href="/sapproval" class="btn btn-primary">Back</a></br></br>

  </br></br>
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
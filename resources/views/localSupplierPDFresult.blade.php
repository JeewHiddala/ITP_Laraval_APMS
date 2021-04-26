<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="icon" type="image/png" href="images/logo.png">
 

      <link href="css/business-casual.min.css" rel="stylesheet">
    <title>Supplier Managment</title>
</head>
<body>
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
                <a class="nav-link text-uppercase text-expanded" href="/subBuyerMenu">Menu</a>
              </li>
              <li class="nav-item px-lg-4">
                <a class="nav-link text-uppercase text-expanded" href="/about">About</a>
              </li>
              <li class="nav-item px-lg-4">
                <a class="nav-link text-uppercase text-expanded" href="/dynamic_pdf_localSupplier">Reports</a>
              </li>
            </ul>
            
          </div>
        </div>
        <div class="col-md-2.5 float-right">
        <form action="/searchLocalSupPDF" method="get">

  

<div class="input-group">
        <input type="search" name="searchPDF" class="form-control"  placeholder="Search by Local Supplier Name">
        <span class="input-group-prepend">
            <button type="submit" class="btn btn-primary">Search</button>&nbsp;&nbsp;
        </span>

  
    </form>
    <a href="/signOut" class="btn btn-primary" onclick="return confirm('Are you sure you want to sign out?')">Sign Out</a>
    </div>
    </div>
      </nav><br>
    <div class="container">
    <div class="text-center">
    
    <h1>Supplier Managment</h1>
    <br><br>
    <div class="container">
    <ul class="nav nav-tabs" role="tablist">
	<li class="nav-item">
		<a class="nav-link active {{request () -> is('/dynamic_pdf_localSupplier') ? 'active' : null }}"  href="{{url('/dynamic_pdf_localSupplier')}}" role="tab">Local Suppliers</a>
	</li>
	<li class="nav-item">
		<a class="nav-link {{request () -> is('/dynamic_pdf_foreign_supplier') ? 'active' : null }}" href="{{url('/dynamic_pdf_foreign_supplier')}}" role="tab">Foreign Suppliers</a>
	</li>
  <li class="nav-item">
		<a class="nav-link {{request () -> is('/dynamic_pdf_buyer') ? 'active' : null }}" href="{{url('/dynamic_pdf_buyer')}}" role="tab">WholeSale Buyers</a>
	</li>
	
</ul><!-- Tab panes -->
<div class="tab-content">
	<div class="tab-pane {{request() ->is('/dynamic_pdf_localSupplier') ? 'active' : null }}" id="{{url('/dynamic_pdf_localSupplier')}}" role="tabpanel">
		<p>Local Suppliers</p>
	</div>
	<div class="tab-pane {{request() ->is('/dynamic_pdf_foreign_supplier') ? 'active' : null }}" id="{{url('/dynamic_pdf_foreign_supplier')}}" role="tabpanel">
		<p>Foreign Suppliers</p>
	</div>
  <div class="tab-pane {{request() ->is('/dynamic_pdf_buyer') ? 'active' : null }}" id="{{url('/dynamic_pdf_buyer')}}" role="tabpanel">
		<p>WholeSale Buyers</p>
	</div>
	
</div>
</div>


<br>
<div class="col-md-4 float-right">
        <a href="{{url('dynamic_pdf_localSupplier/pdf')}}" class="btn btn-danger">Generate all Local Suppliers' Report</a>
    </div>


<div class="col-md-3">

    

  



    
    
</div>




<br>
            <div class="row">
                <div class="col-md-12">

                @foreach($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">

                        {{$error}}

                    </div>
                @endforeach

             

                <br><br>

                <table class="table table-dark table-responsive">

                <th>Registration Number</th>
                <th>Supplier Name</th>
                <th>Company</th>
                <th>Email</th>
                <th>Address</th>
                <th>District</th>
                <th>Mobile Number</th>
                <th>Land Number</th>
                <th>Bank Name</th>
                <th>Account Number</th>
                <th>Profile Report</th>
              
                
                @foreach($posts as $localSup)
                <tr>
                    <td>{{$localSup->reg_no}}</td>
                    <td>{{$localSup->name}}</td>
                    <td>{{$localSup->company}}</td>
                    <td>{{$localSup->email}}</td>
                    <td>{{$localSup->address}}</td>
                    <td>{{$localSup->district}}</td>
                    <td>{{$localSup->mobile}}</td>
                    <td>{{$localSup->land}}</td>
                    <td>{{$localSup->bank_name}}</td>
                    <td>{{$localSup->acc_num}}</td>
                    <td><a href="/singleLocalSupplierProfile/{{$localSup->reg_no}}" class="btn btn-success">Profile Report</a></td>
        
                </tr>
                @endforeach
              
                </table>

                <div>
      <a href="/dynamic_pdf_localSupplier" class="btn btn-primary" style = "float:left">Back</a>
     </div>
                </div>
            </div>
</div>
    
</div>

</body>

</html>
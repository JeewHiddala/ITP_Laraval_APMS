<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="images/logo.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="{{ URL::asset('/css/business-casual.min.css') }}" rel="stylesheet" type="text/css" >
    <title>Search of Registered Machineries</title>
</head>
<body>

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
            </ul>
            
          </div>
        </div>
        <div class="col-md-2 float-right">
          <a href="/signOut" class="btn btn-primary" onclick="return confirm('Are you sure you want to sign out?')">Sign Out</a>
      </nav><br>

    

    <div class='container'>
        <div class='text-center'>
        <h2>Search Results</h2><br>
        <div class='row'>
            <div class="col-md-12">
    
              <!--show errors in inputs-->  
              @foreach($errors->all() as $error)
                
                <div class ="alert alert-danger" role="alert"> 
                    {{$error}} 
                </div>
    
              @endforeach
    

            <br><br>
            <table class="table table-dark">
                <tr>
                    <th>Register No</th>
                    <th>Model</th>
                    <th>Type</th>
                    <th>Model No</th>
                    <th>Insurance No</th>
                    <th>Insurance Type</th>
                    <th>Insurance Renew Date</th>
                </tr>
    
                @foreach($posts as $data)
                <tr>
                    <td>{{$data->id}}</td>
                    <td>{{$data->model}}</td>
                    <td>{{$data->type}}</td>
                    <td>{{$data->model_no}}</td>
                    <td>{{$data->insu_no}}</td>
                    <td>{{$data->insu_type}}</td>
                    <td>{{$data->insu_rew_date}}</td>
                    <td><a href="/editmachinery/{{$data->id}}" class="btn btn-success">Update</a></td>
                    <td><a href="/deletemachinery/{{$data->id}}" class="btn btn-danger" onclick="return confirm('Are you sure want to delete?')">Delete</a></td>
                    
                </tr>
                @endforeach
    
    </table>
    </div>
    <div>
      <a href="/machineryregistration" class="btn btn-primary" style = "float:left">Back</a>
     </div>
    </div>
</div>
</div>

  


    

</body>
</html>
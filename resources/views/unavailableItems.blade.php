<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <style>

        table.table.table-dark {
            margin-top: 40px !important;
        }

        .btn-warning {
            white-space: nowrap;
        }

        .btn-danger {
            white-space: nowrap;
        }

        .btn-primary {
            white-space: nowrap;
        }
        input.btn.btn-primary {
            width: 90px;
        }

        input.btn.btn-warning {
            width: 90px;
        }

        input[type="date"]:not(.has-value):before {
            color: #495057;
            content: attr(placeholder);

        }

        input[type="date"]{
            white-space: nowrap;
        }
    </style>
    <title>Unavailable Items</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
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

                <li class="nav-item active px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="/subBillingMenu">Menu
                        <span class="sr-only">(current)</span>
                    </a>
                </li>

                <li class="nav-item px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="/about">About</a>
                </li>

                <li class="nav-item px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="/Tpdf/pdf">Reports</a>
                </li>
            </ul>

        </div>
    </div>
    <div class="col-md-2 float-right">
        <form action="/searchUnitems" method="GET">
            {{csrf_field()}}
            <div class="input-group">
                <input type="search" name="searchUnitems" placeholder="Item Number" class="form-control">
                <span class="input-group-prepend">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </span>
            </div>
        </form>
</nav><br>



    <div class="container">
        <div class="text-center">
            <h1>Unavailable Items</h1>
            <div class = "row">
                <div class="col-md-12">

                    @foreach($errors->all() as $error)
               <div class="alert alert-danger" role="alert">

                    {{$error}}
                </div>
                    @endforeach

                    <form method="post" action="/unavailableItems">
                        {{csrf_field()}}
                    <input type ="text" class="form-control " name="ItemNo" placeholder="Item Number"><br>
                    <input type ="date" class="form-control " name="Date" placeholder="Date :"><br>
                    <input type ="text" class="form-control " name=" Model" placeholder="Vehicle Model"><br>
                    <input type ="text" class="form-control " name="customerName" placeholder="Customer Name"><br>
                        <input type ="tel" class="form-control " name="phone"  pattern="[0-9]{10}" placeholder="Customer Phone Number"><br>
                <!--    <input type ="text" class="form-control " name="salesperson" placeholder="salesperson"><br> -->
                        <select id="cars" class="form-control " name="salesperson" placeholder="salesperson">
                            <option value="volvo">salesperson</option>
                            <option value="Tharushika De Alwis">Tharushika De Alwis</option>
                            <option value="Tharuvi Mathangaweera">Tharuvi Mathangaweera</option>
                            <option value="Kasuni Sandeepa">Kasuni Sandeepa</option>
                            <option value="Shanel Anuththara">Shanel Anuththara</option>
                        </select>

                    <input type="submit" class="btn btn-primary"value="Add">
                    <input type="button" class="btn btn-warning"value="Clear" onclick="window.location.reload()">

                        <div id="bt" style="text-align: right;"><a href="{{ url('/Tpdf/pdf') }}" class="btn btn-danger">Convert into PDF</a></div>

                    </form>


                    <table class="table table-dark">
                        <th>ID</th>
                        <th>Item No</th>
                        <th>Date</th>
                        <th>Vehicle Model</th>
                        <th>Customer Name</th>
                        <th>Phone Number</th>
                        <th>Salesperson</th>
                        <th>Completed</th>
                        <th>Action</th>
                        <th>Delete</th>
                        <th>Edit</th>


                        @foreach($unavailableItems as $UnItem)
                        <tr>
                            <td>{{$UnItem->id}}</td>
                            <td>{{$UnItem->ItemNo}}</td>
                            <td style="white-space: nowrap;">{{$UnItem->Date}}</td>
                            <td>{{$UnItem->Model}}</td>
                            <td>{{$UnItem->customerName}}</td>
                            <td>{{$UnItem->phone}}</td>
                            <td>{{$UnItem->salesperson}}</td>
                            <td>
                            @if($UnItem->iscompleted)
                            <button class="btn btn-success">Completed</button>
                            @else
                                    <button class="btn btn-warning">Not Completed</button>
                            @endif
                            </td>
                            <td>
                            @if(!$UnItem->iscompleted)

                                <a href="/markascompleted/{{$UnItem->id}}" class="btn btn-primary">Mark as Completed</a>
                                @else
                                    <a href="/markasnotcompleted/{{$UnItem->id}}" class="btn btn-danger">Mark as Not Completed</a>
                                @endif
                                <td>
                                <a href="/deleteEntry/{{$UnItem->id}}" class="btn btn-warning">Delete</a>
                                </td>

                            <td><a href="/updateUnItems/{{$UnItem->id}}" class="btn btn-success">Edit</a>
                            </td>
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

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
                    <a class="nav-link text-uppercase text-expanded" href="about.html">About</a>
                </li>
                <li class="nav-item px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="products.html">Contact</a>
                </li>
                <li class="nav-item px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="/Tpdf/pdf">Reports</a>
                </li>
            </ul>

        </div>
    </div>

</nav><br>

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


                    @foreach( $posts as $UnItem)
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

    <a href="/unavailableItems" class="btn btn-primary" style = "float:left">Back</a>
</div>



</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>


    <meta charset="UTF-8">
    <title>Feedbacks</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.css">

    <link rel="stylesheet" href="@sweetalert2/themes/dark/dark.css">
    <script src="sweetalert2/dist/sweetalert2.min.js"></script>


    <style>



        table.table.table-bordered {
            margin-top: 50px;
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

                <li class="nav-item active px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="/subBillingMenu">Menu
                        <span class="sr-only">(current)</span>
                    </a>
                </li>

                <li class="nav-item px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="/about">About</a>
                </li>

                <li class="nav-item px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="/feedbackpdf/pdf">Reports</a>
                </li>
            </ul>

        </div>
    </div>
    <div class="col-md-2 float-right">
        <form action="/searchCu" method="GET">
            {{csrf_field()}}
            <div class="input-group">
                <input type="search" name="searchBar" placeholder="Buyer Name" class="form-control">
                <span class="input-group-prepend">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </span>
            </div>
        </form>
</nav>
<br>


<div class="container">
    <div class="text-center">
        <h1>Customer Feedbacks</h1>
        <div class="row">
            <div class="col-md-12">
                <div id="bt" style="text-align: right;"><a href="{{ url('/feedbackpdf/pdf') }}" class="btn btn-danger">Convert into PDF</a></div>
                <table class="table table-bordered">
                    <th>ID</th>
                    <th>Feedback</th>
                    <th>Date</th>
                    <th>Customer Name</th>

                    @foreach($customer_data as $customer)
                        <tr>
                            <td>{{$customer->id}}</td>
                            <td>{{$customer->feedback}}</td>
                            <td>{{$customer->date}}</td>
                            <td>{{$customer->CustomerName}}</td>

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


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src ="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.js"></script>

<script>
    $('#btnres').on('click',function () {
        console.log("btn click");
        var data= $('#fed').val();
        var data= $('#date').val();
        var data= $('#cusname').val();

        console.log(data);


        Swal.fire({
            position: 'top-middle',
            icon: 'success',
            title: 'Thank you',
            showConfirmButton: false,
            timer: 500000
        })
    })
</script>
</body>
</html>


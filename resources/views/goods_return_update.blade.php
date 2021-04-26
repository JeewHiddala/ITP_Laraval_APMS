<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Goods Return Note</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

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
                    <a class="nav-link text-uppercase text-expanded" href="/subStockMenu">Menu</a>
                </li>
                <li class="nav-item px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="/about">About</a>
                </li>
                <li class="nav-item px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="/itemsReports">Reports</a>
                </li>
                <li class="nav-item px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="/itemsCharts">Charts</a>
                </li>
            </ul>

        </div>
    </div>
    <div class="col-md-1 float-right">
        <a href="/signOut" onclick="return confirm('Are you sure you want to sign out?')" class="btn btn-primary">Sign Out</a>
    </div>
</nav>
<br>

<div class="col-md-12">
    <h1 align="center">Update Goods Return Note</h1>
    <br/>

    @if(count($errors) > 0)
        <div class="alert alert-danger" role="alert" >
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>

        </div>
    @endif
    @if(\Session::has('success'))
        <div class ="alert alert-success">
            <p>{{\Session::get('success')}}</p>
        </div>

    @endif
    <div class="container">


        <form method ="post" action="{{action('GoodsReturnController@update', $id)}}" >
            {{csrf_field()}}

            @foreach($goodsReturns as $goodsReturn)
            <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
                <label for="i_number">Item No</label>&nbsp;
                <input type="text" id="i_number" name="i_number" value="{{$goodsReturn->item_no}}" class="goodsReturn form-control" placeholder="Item Number" readonly>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label for="i_des">Item Description</label>&nbsp;
                <input type="text" id="i_des" name="i_des" class="form-control" value="{{$goodsReturn->item_description}}" placeholder="Item Description" readonly>
            </div>
                <br/>

                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
                    <label for="cost">Cost</label>&nbsp;
                    <input type="text" id="cost" name="cost" class="form-control" value="{{$goodsReturn->cost}}" placeholder="Cost" readonly>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label for="selling_price">Item Selling Price</label>&nbsp;
                    <input type="text" id="selling_price" name="selling_price" class="form-control" value="{{$goodsReturn->selling_price}}" placeholder="Selling Price" readonly>
                </div>
                <br/>

            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
                <label for="gre_no">Goods Return Number</label>&nbsp;&nbsp;
                <input type="text" id="gre_no" name="gre_no" class="form-control" value="{{$goodsReturn->gre_no}}" placeholder="Goods Return Number" readonly>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label for="r_date">Return Date</label>&nbsp;
                <input type="date" id="r_date" name="r_date" class="form-control" value="{{$goodsReturn->gre_date}}">
            </div>
            <br/>

            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
                <label for="r_quantity">Return Quantity</label>&nbsp;
                <input type="number" min="1" id="r_quantity" name="r_quantity" class="form-control" value="{{$goodsReturn->return_quantity}}" placeholder="Return Quantity">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label for="d_status">Damage Status</label>&nbsp;
                <select id="d_status" name="d_status" class=" form-control" required>
                    <option value="{{$goodsReturn->damage_status}}">{{$goodsReturn->damage_status}}</option>
                    <option value="" disabled>--- Select Damage Status ---</option>
                    <option value="Scratched">Scratched</option>
                    <option value="Perforated">Perforated</option>
                    <option value="Faded">Faded</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <br/>

            @endforeach
            <br/>
            <input type="submit" value="Return" class="btn btn-success btn-lg" />

            <input type="button" class="btn btn-danger btn-lg" value="Cancel" onclick="window.location='{{ url("/display/ReturnGoods") }}'"/>
            <div><a href = "/goodsReturnNotes/Print/PDF/{{$goodsReturn->item_no}}/{{$goodsReturn->gre_no}}"  class ="btn btn-primary btn-lg"   style = "float:right">Print</a> </div><br><br>

        </form>
    </div>
</div>
<br>


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

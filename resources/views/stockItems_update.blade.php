<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Stock</title>
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
    <h1 align="center">Stock Update</h1>
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
        <form method ="post" action="{{action('StockItemController@update', $id)}}" >
            {{csrf_field()}}

            @foreach($stockItems as $stockItem)
            <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
            <label for="stock_des">Stock Description</label>&nbsp;
            <input type="text" id="stock_des" name="stock_des" value="{{$stockItem->stock_description}}" class="form-control" placeholder="Stock Name" readonly>
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             <label for="stock_type">Stock Type</label>&nbsp;
             <input id="stock_type" name="stock_type" value="{{$stockItem->stock_type}}" class="stockItem form-control" placeholder="Stock Name" readonly>
            </div>
            <br/>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <label for="stock_quantity" >Stock Quantity</label>&nbsp;
                    <input type="text" id="stock_quantity" name="stock_quantity" value="{{$stockItem->st_quantity}}" class="form-control" size="20" placeholder="Stock Quantity" readonly>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label for="l_stock_quantity" >Last Inserted Stock Quantity</label>&nbsp;
                    <input type="text" id="l_stock_quantity" name="l_stock_quantity" value="{{0}}" class="form-control" size="20" placeholder="Last Inserted Stock Quantity">
                </div>
                <br/>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <label for="rol" >Maximum Capacity</label>&nbsp;
                    <input type="text" id="rol" name="rol" value="{{$stockItem->rol}}" class="form-control" size="20" placeholder="Maximum Capacity" readonly>
                </div>
                <br/>

                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <label for="department" >Department</label>&nbsp;
                    <input type="text" id="department" name="department" value="{{$stockItem->department}}" class="form-control" size="20" placeholder="Department">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label for="line_no" >Line No</label>&nbsp;
                    <input type="text" id="line_no" name="line_no" value="{{$stockItem->line_no}}" class="form-control" size="20" placeholder="Line no">
                </div>
            <br/>
            <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
            <label for="i_number">Item No</label>&nbsp;
            <input type="text" id="i_number" name="i_number" value="{{$stockItem->item_no}}" class="stockItem form-control" placeholder="Item Number" readonly>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <label for="i_des">Item Description</label>&nbsp;
            <input type="text" id="i_des" name="i_des" class="form-control" value="{{$stockItem->item_description}}" placeholder="Item Description" readonly>
            </div>
            <br/>

            <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
                <label for="main_category">Main Category</label>&nbsp;
                <input type="text" id="main_category" name="main_category" class="form-control" value="{{$stockItem->m_category}}" placeholder="Main Category" readonly>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                <label for="sub_category">Sub Category</label>&nbsp;
                <input type="text" id="sub_category" name="sub_category" class="form-control" value="{{$stockItem->s_category}}" placeholder="Sub Category" readonly>
            </div>
                <br/>

            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
             <label for="brand">Brand</label>&nbsp;
             <input type="text" id="brand" name="brand" class="form-control" value="{{$stockItem->brand}}" placeholder="Brand" readonly>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label for="country">Country</label>&nbsp;
                <input type="text" id="country" name="country" class="form-control" value="{{$stockItem->country}}" placeholder="Country" readonly>
            </div>
                <br/>

            <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
                <label for="quality">Quality</label>&nbsp;
                <input type="text" id="quality" name="quality" class="form-control" value="{{$stockItem->quality}}" placeholder="Quality" readonly>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label for="warranty">Warranty</label>&nbsp;
                <input type="text" id="warranty" name="warranty" class="form-control" value="{{$stockItem->warranty}}" placeholder="Warranty" readonly>
            </div>
                <br/>

                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
                <label for="v_model_no">Vehicle Model No</label>&nbsp;
                <input type="text" id="v_model_no" name="v_model_no" class="form-control" value="{{$stockItem->v_model_no}}" placeholder="Vehicle Model No" readonly>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                <label for="v_model">Vehicle Model</label>&nbsp;
                <input type="text" id="v_model_name" name="v_model_name" class="form-control" value="{{$stockItem->v_model_name}}" placeholder="Vehicle Model Name" readonly>
                </div>
                <br/>

                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
                <label for="v_class">Vehicle Class</label>&nbsp;
                <input type="text" id="v_class" name="v_class" class="form-control" value="{{$stockItem->v_class}}" placeholder="Vehicle Class" readonly>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label for="year">Year</label>&nbsp;
                <input type="text" id="year" name="year" class="form-control" value="{{$stockItem->year}}" placeholder="Year" readonly>
                </div>
                <br/>

                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
                    <label for="cost">Cost</label>&nbsp;
                    <input type="number" min="0.0" id="cost" name="cost" class="form-control" value="{{$stockItem->cost}}" placeholder="Cost" readonly>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label for="selling_price">Item Selling Price</label>&nbsp;
                    <input type="number" min="0.0" id="selling_price" name="selling_price" class="form-control" value="{{$stockItem->selling_price}}" placeholder="Selling Price" readonly>
                </div>
                <br/>

                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
                <label for="quantity">Quantity</label>&nbsp;
                <input type="text" id="quantity" name="quantity" class="form-control" value="{{$stockItem->quantity}}" placeholder="Quantity" readonly>
                </div>
                <br/>

            @endforeach
            <br/>
            <input type="submit" class="btn btn-primary btn-lg" value="Save" />
            &nbsp;&nbsp;&nbsp;
            <input type="button" class="btn btn-danger btn-lg" value="Cancel" onclick="window.location='{{ url("/display/stocks") }}'"/>
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

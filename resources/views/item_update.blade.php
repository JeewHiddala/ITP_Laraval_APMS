<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Item Update</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">


</head>

<body>

<link href="{{ URL::asset('css/business-casual.min.css') }}" rel="stylesheet" type="text/css" >
{{--<link href="css/business-casual.min.css" rel="stylesheet">--}}
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
    <h1 align="center">Item Update</h1>
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

    <div class="container">
    <form method ="post" action="{{action('ItemController@update', $id)}}" >
        {{csrf_field()}}

        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
        <label for="i_number">Item No</label>&nbsp;
        <input type="text" id="i_number" name="i_number" class="form-control" value="{{$item->item_no}}" placeholder="Item Number" readonly>
        <br>
            &nbsp;&nbsp;&nbsp;
        <label for="i_des">Item Description</label>&nbsp;
        <input type="text" id="item_des" name="item_des" class="form-control" value="{{$item->item_description}}" placeholder="Item Description" required>
        </div>
        <br>

        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
        <label for="main_category">Main Category</label>&nbsp;
        <select id="main_category" name="main_category" class="form-control"  value="{{$item->m_category}}" required>
            <option value="" disabled>--Select Main Category--</option>
            <option value="lights">Lights</option>
            <option value="glasses">Glasses</option>
            <option value="wheels">Wheels</option>
        </select>
        &nbsp;&nbsp;&nbsp;

        <label for="sub_category">Sub Category</label>&nbsp;
        <select id="sub_category" name="sub_category" class="form-control" value="{{$item->s_category}}">
            <option value="" disabled>--Select Sub Category--</option>
            <option value="Head Light">Head Light</option>
            <option value="Fog Light">Fog Light</option>
            <option value="Signal Light">Signal Light</option>
            <option value="Front Glass">Front Glass</option>
            <option value="Back Glass">Back Glass</option>
            <option value="Side Glass">Side Glass</option>
            <option value="Wheel1">Wheel1</option>
            <option value="Wheel2">Wheel2</option>
            <option value="Wheel3">Wheel3</option>

        </select>
        </div>
        <br>

        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
        <label for="brand">Brand</label>&nbsp;
        <select id="brand" name="brand" class="form-control" value="{{$item->brand}}">
            <option value="" disabled>--- Select Brand ---</option>
            <option value="Toyota">Toyota</option>
            <option value="Audi">Audi</option>
            <option value="Honda">Honda</option>
            <option value="Ferrari">Ferrari</option>
            <option value="Suzuki">Suzuki</option>
        </select>
        &nbsp;&nbsp;&nbsp;

        <label for="country">Country</label>&nbsp;
        <select id="country" name="country" class="form-control" value="{{$item->country}}" >
            <option value="" disabled>--- Select Country ---</option>
            <option value="Australia">Australia</option>
            <option value="Canada">Canada</option>
            <option value="USA">USA</option>
            <option value="Japan">Japan</option>
        </select>
        </div>
        <br>

        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
        <label for="quality">Quality</label>&nbsp;
        <select id="quality" name="quality" class="form-control" value="{{$item->quality}}">
            <option value="" disabled >--- Select Quality ---</option>
            <option value="Brand New">Brand New</option>
            <option value="Recondition">Recondition</option>
            <option value="Second Hand">Second Hand</option>
        </select>
        &nbsp;&nbsp;&nbsp;

        <label for="warranty">Warranty</label>&nbsp;
        <input type="text" id="warranty" name="warranty" class="form-control" value="{{$item->warranty}}" size="20" placeholder="Item Warranty">
        </div>
        <br>

        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
        <label for="v_model_no">Vehicle Model No</label>&nbsp;
        <select id="v_model_no" name="vehicle_model_no" class="form-control" value="{{$item->v_model_no}}">
            {{--<option value="" disabled selected>--Select Vehicle Model Number--</option>--}}
            <option value="vehicle01">Vehicle001</option>
            <option value="vehicle02">Vehicle002</option>
            <option value="vehicle03">Vehicle003</option>
        </select>
        &nbsp;&nbsp;&nbsp;

        <label for="v_model">Vehicle Model</label>&nbsp;
        <select id="v_model" name="vehicle_model" class="form-control" value="{{$item->v_model_name}}" >
            {{--<option value="" disabled selected>--Select Vehicle Model Name--</option>--}}
            <option value="vehicle01001">Vehicle01001</option>
            <option value="vehicle01002">Vehicle01002</option>
            <option value="vehicle01003">Vehicle01003</option>
            <option value="vehicle02001">Vehicle02001</option>
            <option value="vehicle02002">Vehicle02002</option>
            <option value="vehicle02003">Vehicle02003</option>
            <option value="vehicle03001">Vehicle03001</option>
            <option value="vehicle03002">Vehicle03002</option>
            <option value="vehicle03003">Vehicle03003</option>
        </select>
        </div>
        <br>

        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
        <label for="v_class">Vehicle Class</label>&nbsp;
        <select id="v_class" name="vehicle_class" class="form-control" value="{{$item->v_class}}" >
            <option value="" disabled>--Select Vehicle Class--</option>
            <option value="Vehicle Class1">Vehicle Class1</option>
            <option value="Vehicle Class2">Vehicle Class2</option>
            <option value="Vehicle Class3">Vehicle Class3</option>
            <option value="Vehicle Class4">Vehicle Class4</option>
        </select>
        &nbsp;&nbsp;&nbsp;

        <label for="year">Year</label>&nbsp;
        <select id="year" name="year" class="form-control" value="{{$item->year}}" >
            <option value="" disabled>--Select Year--</option>
            <option value="2020">2020</option>
            <option value="2019">2019</option>
            <option value="2018">2018</option>
            <option value="2017">2017</option>
            <option value="2016">2016</option>
            <option value="2015">2015</option>
            <option value="2014">2014</option>
            <option value="2013">2013</option>
            <option value="2012">2012</option>
            <option value="2011">2011</option>
            <option value="2010">2010</option>
        </select>
        </div>
        <br>

        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
        <label for="cost">Cost</label>&nbsp;
            <input type="number" min="0.0" id="cost" name="cost" class="form-control" value="{{$item->cost}}" size="20" placeholder="Item Cost">
        &nbsp;&nbsp;&nbsp;

        <label for="selling_price">Item Selling Price</label>&nbsp;
            <input type="number" min="0.0" id="selling_price" class="form-control" name="selling_price" value="{{$item->selling_price}}" size="20" placeholder="Item Selling Price">
        </div>
        </br>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
            <label for="quantity">Quantity</label>&nbsp;
            <input type="text" id="quantity" name="quantity"  class="form-control" value="{{$item->quantity}}" size="20" placeholder="Item Quantity">
        </div>
        <br>

        <input type="submit" class="btn btn-primary btn-lg" value="Save" />
        &nbsp;&nbsp;&nbsp;
        <input type="button" class="btn btn-danger btn-lg" value="Cancel" onclick="window.location='{{ url("/item/register") }}'"/>

    </form>

        <!--{{method_field('POST')}}-->



    </div>

</div>
</br>
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




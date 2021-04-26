<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Registration</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <script type="text/javascript">
        var subcategory = {
            Lights: ["Head Light", "Fog Light", "Signal Light"],
            Glasses: ["Front Glass", "Back Glass", "Side Glass"],
            Wheels: ["Wheel1", "Wheel2", "Wheel3"]
        }

        function makeSubmenu(value) {
            if (value.length == 0) document.getElementById("sub_category").innerHTML = "<option></option>";
            else {
                var citiesOptions = "";
                for (categoryId in subcategory[value]) {
                    citiesOptions += "<option>" + subcategory[value][categoryId] + "</option>";
                }
                document.getElementById("sub_category").innerHTML = citiesOptions;
            }
        }

        function resetSelection() {
            document.getElementById("main_category").selectedIndex = 0;
            document.getElementById("sub_category").selectedIndex = 0;
        }
    </script>


    <script type="text/javascript">
        var subVehicleCategory = {
            vehicle01: ["vehicle01001", "vehicle01002", "vehicle01002"],
            vehicle02: ["vehicle02001", "vehicle02002", "vehicle02003"],
            vehicle03: ["vehicle03001", "vehicle03002", "vehicle03003"]
        }

        function makeSubVehicleMenu(value) {
            if (value.length == 0) document.getElementById("v_model").innerHTML = "<option></option>";
            else {
                var citiesOptions = "";
                for (categoryId in subVehicleCategory[value]) {
                    citiesOptions += "<option>" + subVehicleCategory[value][categoryId] + "</option>";
                }
                document.getElementById("v_model").innerHTML = citiesOptions;
            }
        }

        function resetSelection() {
            document.getElementById("v_model_no").selectedIndex = 0;
            document.getElementById("v_model").selectedIndex = 0;
        }
    </script>



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
    <div class="col-md-2 float-right">
        <form action="/search" method="GET">
            {{csrf_field()}}
            <div class="input-group">
                <input type="search" name="searchBar" placeholder="Item No/Name" class="form-control">
                <span class="input-group-prepend">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </span>
            </div>
        </form>

    </div>
    <br><br>
    <a href="/signOut" onclick="return confirm('Are you sure you want to sign out?')" class="btn btn-primary">Sign Out</a>
</nav>
<br>

<div class="col-md-12">
<h1 align="center">Item Registration</h1>
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


    <form method ="post" action="/saveItem" >
        {{csrf_field()}}
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
            <label for="i_number">Item No</label>&nbsp;
            <input type="text" id="i_number" name="i_number" class="form-control" size="20" placeholder="Item Number" required>
            &nbsp;&nbsp;
            <label for="i_des">Item Description</label>&nbsp;
            <input type="text" id="i_des" name="item_des" class="form-control" placeholder="Item Description" required>

        </div>
        <br/>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
            <label for="main_category">Main Category</label>&nbsp;
            <select id="main_category" name="main_category" class="form-control" onchange="makeSubmenu(this.value)" required>
                <option value="" disabled selected>--Select Main Category--</option>
                <option value="Lights">Lights</option>
                <option value="Glasses">Glasses</option>
                <option value="Wheels">Wheels</option>
            </select>
            &nbsp;&nbsp;&nbsp;
            <label for="sub_category">Sub Category</label>&nbsp;
            <select id="sub_category" name="sub_category" class="form-control">
                <option value=""  disabled selected>--Select Sub Category--</option>
            </select>
        </div>
        <br/>

        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
        <label for="brand">Brand</label>&nbsp;
        <select id="brand" name="brand" class="form-control" >
            <option value="" disabled selected>--- Select Brand ---</option>
            <option value="Toyota">Toyota</option>
            <option value="Audi">Audi</option>
            <option value="Honda">Honda</option>
            <option value="Ferrari">Ferrari</option>
            <option value="Suzuki">Suzuki</option>
        </select>
        &nbsp;&nbsp;

        <label for="country">Country</label>&nbsp;
        <select id="country" name="country" class="form-control" >
            <option value="" disabled selected>--- Select Country ---</option>
            <option value="Australia">Australia</option>
            <option value="Canada">Canada</option>
            <option value="USA">USA</option>
            <option value="Japan">Japan</option>
        </select>
        </div>
        <br/>

        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
        <label for="quality">Quality</label>&nbsp;
        <select id="quality" name="quality" class="form-control" required>
            <option value="" disabled selected>--- Select Quality ---</option>
            <option value="Brand New">Brand New</option>
            <option value="Recondition">Recondition</option>
            <option value="Second Hand">Second Hand</option>
        </select>
            &nbsp;&nbsp;
        <label for="warranty">Warranty</label>&nbsp;
        <input type="text" id="warranty" name="warranty" class="form-control" size="20" placeholder="Item Warranty">
        </div>
        <br/>

        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
        <label for="v_model_no">Vehicle Model No</label>&nbsp;
        <select id="v_model_no" name="vehicle_model_no" class="form-control" onchange="makeSubVehicleMenu(this.value)">
            <option value="" disabled selected>--Select Vehicle Model Number--</option>
            <option value="vehicle01">Vehicle001</option>
            <option value="vehicle02">Vehicle002</option>
            <option value="vehicle03">Vehicle003</option>
        </select>
        &nbsp;&nbsp;

        <label for="v_model">Vehicle Model</label>&nbsp;
        <select id="v_model" name="vehicle_model" class="form-control" >
            <option value="" disabled selected>--Select Vehicle Model Name--</option>
        </select>
        </div>
        <br>

        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
        <label for="v_class">Vehicle Class</label>&nbsp;
        <select id="v_class" name="vehicle_class" class="form-control">
            <option value="" disabled selected>--Select Vehicle Class--</option>
            <option value="Vehicle Class1">Vehicle Class1</option>
            <option value="Vehicle Class2">Vehicle Class2</option>
            <option value="Vehicle Class3">Vehicle Class3</option>
            <option value="Vehicle Class4">Vehicle Class4</option>
        </select>
        &nbsp;&nbsp;

        <label for="year">Year</label>&nbsp;
        <select id="year" name="year" class="form-control">
            <option value="" disabled selected>--Select Year--</option>
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
        <input type="number" min="0.0" id="cost" name="cost" class="form-control" size="20" placeholder="Item Cost">
        &nbsp;&nbsp;

        <label for="selling_price">Item Selling Price</label>&nbsp;
        <input type="number" min="0.0" id="selling_price" name="selling_price" class="form-control" size="20" placeholder="Item Selling Price">
        </div>
        <br/>

        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
            <label for="quantity">Quantity</label>&nbsp;
            <input type="number" min="0" id="quantity" name="quantity" class="form-control" size="20" placeholder="Item Quantity">
        </div>
        <br/>

        <input type="submit" value="Submit" class="btn btn-success btn-lg">
        <input type="button" class="btn btn-warning btn-lg" value="Clear"
               onclick="window.location.reload();">
    </form>
    </div>
</div>
        <br>
        <table id="item_table_id" class="table table-dark table-striped">
            <tr>
                <th>ID</th>
                <th>Item No</th>
                <th>Item Description</th>
                <th>Main Category</th>
                <th>Sub Category</th>
                <th>Brand</th>
                <th>Country</th>
                <th>Quality</th>
                <th>Warranty</th>
                <th>Vehicle Model No</th>
                <th>Vehicle Model</th>
                <th>Vehicle Class</th>
                <th>Year</th>
                <th>Quantity</th>
                <th>Cost</th>
                <th>Selling Price</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>

            @foreach($items as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->item_no}}</td>
                    <td>{{$item->item_description}}</td>
                    <td>{{$item->m_category}}</td>
                    <td>{{$item->s_category}}</td>
                    <td>{{$item->brand}}</td>
                    <td>{{$item->country}}</td>
                    <td>{{$item->quality}}</td>
                    <td>{{$item->warranty}}</td>
                    <td>{{$item->v_model_no}}</td>
                    <td>{{$item->v_model_name}}</td>
                    <td>{{$item->v_class}}</td>
                    <td>{{$item->year}}</td>
                    <td>{{$item->quantity}}</td>
                    <td>{{$item->cost}}</td>
                    <td>{{$item->selling_price}}</td>
                    <td>
                        <a href="{{action('ItemController@edit', $item->id)}}" class="btn btn-primary">Edit</a>
                    </td>
                    <td>

                        <form method="post" class="delete_form" action="{{action('ItemController@destroy', $item->id)}}">
                            {{csrf_field()}}
                            <input type="hidden" name="_method" value="Delete" />
                            <button type="submit " class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach


        </table>


<script>
    $(document).ready(function() {
        $('.delete_form').on('submit', function () {
            if(confirm("Are you sure you want to delete this item?"))
            {
                return  true;
            }
            else
            {
                return false;
            }
        });
    });

</script>


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

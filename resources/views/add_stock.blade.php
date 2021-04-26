<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Stock</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

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
    <div class="col-md-3 float-right">
        <form action="/searchStocks" method="GET">
            {{csrf_field()}}
            <div class="input-group">
                <input type="search" name="searchBar" placeholder="Stock No/Name or Item No/Name" class="form-control">
                <span class="input-group-prepend">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </span>
            </div>
        </form>
    </div>

    <div class="col-md-1 float-right">
        <a href="/signOut" onclick="return confirm('Are you sure you want to sign out?')" class="btn btn-primary">Sign Out</a>
    </div>

</nav>
<br>



<div class="col-md-12">
<h1 align="center">Add Stock</h1>
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
    <form method ="post" action="/saveStock " >
        {{csrf_field()}}

        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
        <label for="stock_des">Stock Description</label>&nbsp;
        <input type="text" id="stock_des" name="stock_des" class="form-control" placeholder="Stock Name" required>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <label for="stock_type">Stock Type</label>&nbsp;
        <select id="stock_type" name="stock_type" class="stockItem form-control" style="width:250px" required>
            <option value="">--- Select Stock Type ---</option>
            <option value="good_stock">Good</option>
            <option value="destroy_stock">Destroy</option>
            <option value="damage_stock">Damage</option>
        </select>
        </div>
        <br/>

        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <label for="stock_quantity" >Stock Quantity</label>&nbsp;
            <input type="number" min="0" name="stock_quantity" class="form-control" size="20" placeholder="Stock Quantity">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <label for="l_stock_quantity" >Last Inserted Stock Quantity</label>&nbsp;
            <input type="number" min="0" id="l_stock_quantity" name="l_stock_quantity" class="form-control" size="20" placeholder="Last Inserted Stock Quantity" readonly>
        </div>
        <br/>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <label for="rol" >Maximum Capacity</label>&nbsp;
            <input type="number" min="0" id="rol" name="rol" class="form-control" size="20" placeholder="Maximum Capacity">
        </div>
        <br/>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <label for="department" >Department</label>&nbsp;
            <input type="text" id="department" name="department" class="form-control" placeholder="Department">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <label for="line_no" >Line No</label>&nbsp;
            <input type="text" id="line_no" name="line_no" class="form-control" placeholder="Line no">
        </div>
        <br/>

        <label for="i_number">Item Number</label>&nbsp;
        <select id="i_number" name="i_number" class="stockItem form-control" required>
            <option value="">--- Select Item Number ---</option>

            @foreach ($item_no as $value)
                <option value="{{ $value->id }}">{{ $value->item_no }}</option>
            @endforeach
        </select>
        <br/>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
        <label for="i_des">Item Description</label>&nbsp;
                <div class="form-control" readonly>
        <input type="text" id="i_des" name="des" class="item_des" value="" placeholder="Item Description" style="border-color: transparent; background-color: #e9ecef" readonly>
                </div>
        </div>
        <br/>

        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
        <label for="main_category">Main Category</label>&nbsp;
            <div class="form-control" readonly>
        <input type="text" id="main_category" name="main_category" class="m_category" value="" placeholder="Main Category" style="border-color: transparent; background-color: #e9ecef" readonly>
            </div>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <label for="sub_category">Sub Category</label>&nbsp;
            <div class="form-control" readonly>
        <input type="text" id="sub_category" name="sub_category" class="s_category" value="" placeholder="Sub Category" style="border-color: transparent; background-color: #e9ecef" readonly>
            </div>
        </div>
        <br/>

        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
        <label for="brand">Brand</label>&nbsp;
            <div class="form-control" readonly>
        <input type="text" id="brand" name="brand" class="brand" value="" placeholder="Brand" style="border-color: transparent; background-color: #e9ecef" readonly>
            </div>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <label for="country">Country</label>&nbsp;
            <div class="form-control" readonly>
        <input type="text" id="country" name="country" class="country" value="" placeholder="Country" style="border-color: transparent; background-color: #e9ecef" readonly>
            </div>
        </div>
        <br/>

        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
        <label for="quality">Quality</label>&nbsp;
            <div class="form-control" readonly>
        <input type="text" id="quality" name="quality" class="quality" value="" placeholder="Quality" style="border-color: transparent; background-color: #e9ecef" readonly>
            </div>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <label for="warranty">Warranty</label>&nbsp;
                <div class="form-control" readonly>
        <input type="text" id="warranty" name="warranty" class="warranty" value="" placeholder="Warranty" style="border-color: transparent; background-color: #e9ecef" readonly>
                </div>
        </div>
        <br/>

        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
        <label for="v_model_no">Vehicle Model No</label>&nbsp;
            <div class="form-control" readonly>
        <input type="text" id="v_model_no" name="v_model_no" class="v_model_no" value="" placeholder="Vehicle Model No" style="border-color: transparent; background-color: #e9ecef" readonly>
            </div>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <label for="v_model">Vehicle Model</label>&nbsp;
            <div class="form-control" readonly>
        <input type="text" id="v_model" name="v_model_name" class="v_model_name" value="" placeholder="Vehicle Model Name" style="border-color: transparent; background-color: #e9ecef" readonly>
            </div>
        </div>
        <br/>

        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
        <label for="v_class">Vehicle Class</label>&nbsp;
            <div class="form-control" readonly>
        <input type="text" id="v_class" name="v_class" class="v_class" value="" placeholder="Vehicle Class" style="border-color: transparent; background-color: #e9ecef" readonly>
            </div>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <label for="year">Year</label>&nbsp;
            <div class="form-control" readonly>
        <input type="text" id="year" name="year" class="year" value="" placeholder="Year" style="border-color: transparent; background-color: #e9ecef" readonly>
            </div>
        </div>
        <br/>

        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
            <label for="cost">Cost</label>&nbsp;
            <div class="form-control" readonly>
            <input type="text" id="cost" name="cost" class="cost" value="" placeholder="Cost" style="border-color: transparent; background-color: #e9ecef" readonly>
            </div>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <label for="selling_price">Item Selling Price</label>&nbsp;
            <div class="form-control" readonly>
            <input type="text" id="selling_price" name="selling_price" class="selling_price" value="" placeholder="Selling Price" style="border-color: transparent; background-color: #e9ecef" readonly>
            </div>
        </div>
        <br/>

        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
        <label for="quantity">Quantity</label>&nbsp;
            <div class="form-control" readonly>
        <input type="text" id="quantity" name="quantity" class="quantity" value="" placeholder="Quantity" style="border-color: transparent; background-color: #e9ecef" readonly>
            </div>
        </div>
        <br/>


        <input type="submit" value="Add" class="btn btn-success btn-lg">
        <input type="button" class="btn btn-warning btn-lg" value="Clear"
               onclick="window.location.reload();">
    </form>
    </div>
</div>
        <br>

    <div class="table-responsive">
        <table class="table table-dark table-striped">
            <tr>
                <th>Stock ID</th>
                <th>Stock Description</th>
                <th>Stock Type</th>
                <th>Stock Quantity</th>
                <th>Last Stock Quantity</th>
                <th>Maximum Capacity</th>
                <th>Department</th>
                <th>Line No</th>
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
                <th>Cost</th>
                <th>Selling Price</th>
                <th>Quantity</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>

            @foreach( $stockItems as $stockItem)
                <tr>
                    <td>{{$stockItem->stock_id}}</td>
                    <td>{{$stockItem->stock_description}}</td>
                    <td>{{$stockItem->stock_type}}</td>
                    <td>{{$stockItem->st_quantity}}</td>
                    <td>{{$stockItem->last_inserted_quantity}}</td>
                    <td>{{$stockItem->rol}}</td>
                    <td>{{$stockItem->department}}</td>
                    <td>{{$stockItem->line_no}}</td>
                    <td>{{$stockItem->item_no}}</td>
                    <td>{{$stockItem->item_description}}</td>
                    <td>{{$stockItem->m_category}}</td>
                    <td>{{$stockItem->s_category}}</td>
                    <td>{{$stockItem->brand}}</td>
                    <td>{{$stockItem->country}}</td>
                    <td>{{$stockItem->quality}}</td>
                    <td>{{$stockItem->warranty}}</td>
                    <td>{{$stockItem->v_model_no}}</td>
                    <td>{{$stockItem->v_model_name}}</td>
                    <td>{{$stockItem->v_class}}</td>
                    <td>{{$stockItem->year}}</td>
                    <td>{{$stockItem->cost}}</td>
                    <td>{{$stockItem->selling_price}}</td>
                    <td>{{$stockItem->quantity}}</td>

                    <td>
                        <a href="{{action('StockItemController@edit', $stockItem->stock_item_id)}}" class="btn btn-primary">Edit</a>
                    </td>
                    <td>

                        <form method="post" class="delete_form" action="{{action('StockItemController@destroy', $stockItem->stock_item_id)}}">
                            {{csrf_field()}}
                            <input type="hidden" name="_method" value="Delete" />
                            <button type="submit " class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach


        </table>
    </div>


<script>
    $(document).ready(function() {
        $('.delete_form').on('submit', function () {
            if(confirm("Are you sure you want to delete this stock?"))
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


<script type="text/javascript">
    $(document).ready(function(){
        //console.log("hmm its change");
        $(document).on('change','.stockItem',function(){
            console.log("hmm its change");

            var id=$(this).val();
            console.log(id);
            var a=$(this).parent();

            var op=" ";

            $.ajax({
                type:'get',
                url:'{!!URL::to('getItemDetails')!!}',
                data:{'id':id},
                success:function(data){


                    // here price is coloumn name in products table data.coln name
                    //console.log(data.item_description);
                    a.find('.item_des').val(data.item_description);
                    a.find('.m_category').val(data.m_category);
                    a.find('.s_category').val(data.s_category);
                    a.find('.brand').val(data.brand);
                    a.find('.country').val(data.country);
                    a.find('.quality').val(data.quality);
                    a.find('.warranty').val(data.warranty);
                    a.find('.v_model_no').val(data.v_model_no);
                    a.find('.v_model_name').val(data.v_model_name);
                    a.find('.v_class').val(data.v_class);
                    a.find('.year').val(data.year);
                    a.find('.quantity').val(data.quantity);
                    a.find('.cost').val(data.cost);
                    a.find('.selling_price').val(data.selling_price);


                },
                error:function(){

                }

            });


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

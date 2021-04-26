<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Goods Return Note</title>
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
    <div class="col-md-3 float-right">
        <form action="/searchGREs" method="GET">
            {{csrf_field()}}
            <div class="input-group">
                <input type="search" name="searchBar" placeholder="GReturn/Item No/Name" class="form-control">
                <span class="input-group-prepend">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </span>
            </div>
        </form>
    </div>
    <br>
    <div class="col-md-1 float-right">
        <a href="/signOut" onclick="return confirm('Are you sure you want to sign out?')" class="btn btn-primary">Sign Out</a>
    </div>

</nav>
<br>

<div class="col-md-12">
    <h1 align="center">Goods Return Note</h1>
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


        <form method ="post" action="/saveReturnGoods" >
            {{csrf_field()}}
            <label for="i_number">Item Number</label>&nbsp;
            <select id="i_number" name="i_number" class="goodsReturn form-control" required>
                <option value="">--- Select Item Number ---</option>
                @foreach ($item_no as $value)
                    <option value="{{ $value->id }}">{{ $value->item_no }}</option>
                @endforeach

            </select>
            &nbsp;&nbsp;
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
                <label for="cost">Cost</label>&nbsp;
                <div class="form-control" readonly>
                    <input type="number" min="0.0" id="cost" name="cost" class="cost" value="" placeholder="Cost" style="border-color: transparent; background-color: #e9ecef" readonly>
                </div>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label for="selling_price">Item Selling Price</label>&nbsp;
                <div class="form-control" readonly>
                    <input type="number" min="0.0" id="selling_price" name="selling_price" class="selling_price" value="" placeholder="Selling Price" style="border-color: transparent; background-color: #e9ecef" readonly>
                </div>
            </div>
            <br/>

            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
                <label for="gre_no">Goods Return Number</label>&nbsp;&nbsp;
                <input type="text" id="gre_no" name="gre_no" class="form-control" placeholder="Goods Return Number" required>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label for="r_date">Return Date</label>&nbsp;
                <input type="date" id="r_date" name="r_date" class="form-control">
            </div>
            <br/>

                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
                <label for="r_quantity">Return Quantity</label>&nbsp;
                    <input type="number" min="1" id="r_quantity" name="r_quantity" class="form-control" placeholder="Return Quantity">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label for="d_status">Damage Status</label>&nbsp;
                <select id="d_status" name="d_status" class=" form-control" >
                    <option value="">--- Select Damage Status ---</option>
                    <option value="Scratched">Scratched</option>
                    <option value="Perforated">Perforated</option>
                    <option value="Faded">Faded</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <br/>


            <input type="submit" value="Return" class="btn btn-success btn-lg">

            <input type="button" class="btn btn-warning btn-lg" value="Clear"
                   onclick="window.location.reload();">
            <input type="button" value="Print" class="btn btn-primary btn-lg">

        </form>
    </div>
</div>
<br>

<table class="table table-dark table-striped">
    <tr>
        <th>GReturn No</th>
        <th>Item No</th>
        <th>Item Description</th>
        <th>Item Cost</th>
        <th>Item Selling Price</th>
        <th>Return Date</th>
        <th>Return Quantity</th>
        <th>Damage Status</th>
        <th>Update</th>
        <th>Delete</th>
    </tr>
    @foreach( $goodsReturns as $goodsReturn)
        <tr>
            <td>{{$goodsReturn->gre_no}}</td>
            <td>{{$goodsReturn->item_no}}</td>
            <td>{{$goodsReturn->item_description}}</td>
            <td>{{$goodsReturn->cost}}</td>
            <td>{{$goodsReturn->selling_price}}</td>
            <td>{{$goodsReturn->gre_date}}</td>
            <td>{{$goodsReturn->return_quantity}}</td>
            <td>{{$goodsReturn->damage_status}}</td>
            <td>
                <a href="{{action('GoodsReturnController@edit', $goodsReturn->id)}}" class="btn btn-primary">Edit</a>
            </td>
            <td>

                <form method="post" class="delete_form" action="{{action('GoodsReturnController@destroy', $goodsReturn->id)}}">
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
            if(confirm("Are you sure you want to delete this record?"))
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
        $(document).on('change','.goodsReturn',function(){
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

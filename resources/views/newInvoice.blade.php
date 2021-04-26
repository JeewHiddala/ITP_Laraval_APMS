<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <title>New Invoice</title>

    <link href="{{ URL::asset('/css/business-casual.min.css') }}" rel="stylesheet" type="text/css" >

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
                  <span class="sr-only">(current)</span>
                </a>
              </li>

              <li class="nav-item px-lg-4">
                <a class="nav-link text-uppercase text-expanded" href="/orderManageMenu">Menu</a>
              </li>

              <li class="nav-item px-lg-4">
                <a class="nav-link text-uppercase text-expanded" href="/about">About</a>
              </li>
              
            </ul>
            
          </div>
        </div>



        <div class="col-md-2.5.loat-right">

            <a href="/signOut" class="btn btn-primary" onclick="return confirm('Are you sure you want to sign out?')">Sign Out</a>
            </div>
            </div>
      </nav><br>





    <div class="container">
    <div class="text-center">
        <br><br>
        <h1>New Invoice :</h1>
         
          <input type="text" class = "form-control" name="invoice_Id" value = "{{$data->id}}" readonly/><br>
          
        <br><br>        

      <!--<form  action="/readyids/{{$data->id}}" method="post">
      {{csrf_field()}}
      <input type="hidden" class = "form-control" name="invoice_Id" value = "{{$data->id}}" readonly/><br>
      <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
             <p style="text-align:left">Sales Person</p>
            <input type="text" class = "form-control" name="semp" placeholder = "employee ID"/><br>
          
           <div class="form-group">
              
                <p style="text-align:left">WholeShale Buyer ID</p>

                <select name="buyer_id">
                  <option>Select WholeShale Buyer ID</option>
                  @foreach($list as $whole_sale_buyer)
                  <option value="{{$whole_sale_buyer->reg_no}}">{{$whole_sale_buyer->buyer_name}}</option>
                  @endforeach
                </select> 
            </div>

            <input  type="submit" a href="/readyids" name="ready" class="btn btn-success" value="Ready To Go"/>  

      </form> -->

        <div class='row'>
        <div class="col-md-11">

         
            @foreach($errors->all() as $error)
            
            <div class ="alert alert-danger" role="alert">
                
                {{$error    }} 
             
            </div>

            @endforeach

            <form  action ="/newInvoive" method="POST">
            {{csrf_field()}}
            
             <input type="hidden" class = "form-control" name="invoice_Id" value = "{{$data->id}}" readonly/><br>
                <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                <div class="form-group">

            <!-- dynamic drop down -->
              
            <p style="text-align:left">Item Name </p>
            <select name="item_description" id="item_description "  class="form-control input-lg dynamic" data-dependent= "v_model">
              <option>Select Item Name</option>
              @foreach($list as $item)
              <option value="{{$item->item_description}}">{{$item->item_description}}</option>
              @endforeach
            </select> 
            </div>

            <div class="form-group">
            <p style="text-align:left">Model</p>
            <select name="v_model" id="v_model" class="form-control input-lg dynamic" data-dependent= "brand">
                <option value="">Select Model</option>
               
            </select>
            </div>

            <div class="form-group">
            <p style="text-align:left">Brand</p>
            <select name="brand" id="brand"  class="form-control input-lg dynamic">
            <option value="">Select Brand</option>
              
            </select>
            </div>
            {{csrf_field()}}

                <!-- dynamic drop down -->
              
                <!-- <p style="text-align:left">Brand</p>
                <select name="brand" id="brand"  class="form-control input-lg dynamic" data-dependent= "v_model">
                  <option>Select Brand</option>
                  @foreach($list as $item)
                  <option value="{{$item->brand}}">{{$item->brand}}</option>
                  @endforeach
                </select> 
                </div>

                <div class="form-group">
                <p style="text-align:left">Model</p>
                <select name="v_model" id="v_model" class="form-control input-lg dynamic" data-dependent= "item_description">
                    <option value="">Select Model</option>
                   
                </select>
                </div>

                <div class="form-group">
                <p style="text-align:left">Item Name</p>
                <select name="item_name" id="item_description"  class="form-control input-lg dynamic">
                <option value="">Select Item Name</option>
                  
                </select>
                </div>
                {{csrf_field()}} -->


                <!-- normal drop down  strat

                <p style="text-align:left">Brand</p>
                <select name="brand">
                  <option>Select Brand</option>
                  @foreach($list as $item)
                  <option value="{{$item->item_no}}">{{$item->brand}}</option>
                  @endforeach
                </select> 
                </div>

                <div class="form-group">
                <p style="text-align:left">Model</p>
                <select name="model">
                    <option>Select Model</option>
                    @foreach($list as $item)
                    <option value="{{$item->item_no}}">{{$item->v_model}}</option>
                    @endforeach
                </select>
                </div>

                <div class="form-group">
                <p style="text-align:left">Item Name</p>
                <select name="item_name">
                <option>Select Item Name</option>
                  @foreach($list as $item)
                  <option value="{{$item->item_no}}">{{$item->item_description}}</option>
                  @endforeach
                </select>
                </div>-->

              <!-- normal drop down  end-->
                
                <div class="row input qty">
                  <div class="col-md-4">
                    <p style="text-align:left">No of Items</p>
                    <input type="text" class = "form-control" id="qty1" name="qty1" placeholder = "Enter Quantity" onclick="return myFunction()" required/><br>
                  </div>
                </div>

                
                <div class="row input qty">    
                  <div class="col-md-4">
                    <p style="text-align:left">Price</p>
                    <input type="text" class = "form-control" id="price" name="price" placeholder = "Price" required/><br>
                  </div>
                </div> 
                <br>
                <input  type="submit" name="Add" class="btn btn-warning" value="Add"/>
            </form>
        <br><br>
        
        
        <table class="table table-dark">
            <tr>
            <th>Item No</th>
            <th>Item Name</th>
            <th>Qty</th>
            <th> Price</th>
            <th>Total</th>
            <th>Edit</th>
            <th>Remove</th>
            </tr>
            @foreach($data2 as $item)
            <tr>
                <td>{{$item->item_no}}</td>
                <td>{{$item->item_description}}</td>
                <td>{{$item->quantity}}</td>
                <td>{{$item->price}}</td>
                <td>{{$item->total}}</td>
                
                <td><a href="/editItem/{{$item->i_List}}"  class="btn btn-success">Edit</a></td>
                <td><a href="/itemdelete/{{$item->i_List}}/{{$data->id}}"  class="btn btn-danger" 
                onclick="return confirm('Are You Sure You want to Delete this Item?');">Remove</a></td>
                
            </tr>
            @endforeach
        </table>


      
        <form action="/addDiscount/{{$data->id}}" method="get">
          <input type="hidden" class = "form-control" name="invoice_Id" value = "{{$data->id}}" readonly/><br>
          <input type="text" class = "form-control" name="discount" placeholder = "Discount"/><br>

          <input type="submit" a href="/addDiscount"  class="btn btn-success" name="dis" value="Add Discount">
          <!--<a href="/addDiscount/"  class="btn btn-success">Add Discount</a>-->
        </form>

        </br>
        <p style="text-align:center">Total</p>
 
      <input type="view" class="form-control" action="read-only" name="total" value="{{$ftot ?? "0"}}"/><br>
      
        <a href="/finishedView/{{$data->id}}" class="btn btn-success">Finish</a>
        <br>
        </br>
        


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



      <script>
          function myFunction() {
            var x;

            // Get the value of the input field with id="numb"
            x = document.getElementById("qty1").value;

            if(!/^[0-9]+$/.test(x)){
              alert("Please only enter numeric characters only here !!");
            }
            
          }
      </script> 

<script type="text/javascript">
  $(document).ready(function(){

    $('.dynamic').change(function(){
      if($(this).val() != ''){

        var select = $(this).attr("id");
        var value = $(this).val();
        var dependent = $(this).data('dependent');
        var _token = $('input[name="_token"]').val();

        $.ajax({
          url :"{{ route('dynamicdependent.fetch')}}",
          method:"POST",
          data:{select:select, value:value,_token:_token,dependent:dependent},
          success:function(result){

            $('#' + dependent).html(result);
          },
          error: function(result) {
          console.log(result);
          }
        })
      }
    });
  });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</body>
</html>

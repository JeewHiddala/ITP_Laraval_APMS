<!DOCTYPE html>
<html>
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Category Graph</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel="icon" type="image/png" href="images/logo.png">

    <link href="{{ URL::asset('/css/Report.css') }}" rel="stylesheet" type="text/css" >
    
    
    <style type="text/css">
    .box{
        width:800px;
        margin:0 auto;
    }
    </style>
    
    <script type="text/javascript">
        var analytics = <?php echo $category; ?>

        google.charts.load('current', {'packages':['corechart']});

        google.charts.setOnLoadCallback(drawChart);

        //    defining the function
        function drawChart()
        {
            var data = google.visualization.arrayToDataTable(analytics);
            var options = {
            title : 'Frequency of Expense Categories'
            };
            var chart = new google.visualization.BarChart(document.getElementById('pie_chart'));
            chart.draw(data, options); //drawing pie chart
        }
    </script>

    
 </head>
 <body>
     <!--header-->
    <img src="images/logo.png" alt="logo" width="110" height="100" style="float:left; margin-top:-2.2% ;padding-left:0.5%">
    <h1 class="site-heading text-center text-white d-none d-lg-block">
        <span class="site-heading-lower" style="color:#e6a756">Ranjith Motors & Auto Parts</span>
      </h1>
<!--</header>-->


  <br />
  <div class="container">   
   <div class="panel panel-default">
    <div class="panel-heading">
     <h3 class="panel-title">Frequency of Expense Categories</h3>
    </div>
    <div class="panel-body" align="center">
     <div id="pie_chart" style="width:750px; height:450px;">

     </div>
    </div>
   </div>
   
  </div>
  <br>
    &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
    &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
     <a href="/fmChartsBar" class="btn btn-success">Back</a>
    <br>
    <br>
 </body>
</html>
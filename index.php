<!DOCTYPE html>
<html>
<head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<title>Google maps MST</title>


<script>
$(function(){
    $(document).on('keydown','.last-city',function(e){
        if($(this).val() != ''){
            $(this).removeClass('last-city');
            $(this).parent().append($('<input/>').attr('type','text').attr('name','cities').attr('placeholder','e.g. Helsinki').addClass('form-control').addClass('last-city') );
        }
    });
});

</script>
</head>


<body>
 <div class="container">

      <div class="jumbotron">
        <h1>Google Maps Minimum Spanning tree</h1>
        <p class="lead">Enter the name of cities, press the go button, and behold the minimum spanning tree between them</p>
      </div>

      <div class="row ">
        <div class="col-lg-6">
        <form action="mst.php">
            <h2>City Names</h2>
            <p>Enter the names of some cities</p>
            <div id="city-holder">
            <input type="text" class="form-control last-city"  name="cities" placeholder="e.g. Helsinki" id="city1"/>
            </div>
            <button class="btn btn-primary">Calculate MST</button>

        </form>
        </div>
        <div class='col-lg-6'>
        Space for the map
        </div>
      </div>
    </div> <!-- /container -->


</body>

</html>

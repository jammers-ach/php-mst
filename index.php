<?php
include 'include/api_key.php';
?>
<!DOCTYPE html>
<html>
<head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?libraries=geometry&key=<?php echo $key;?>"></script>


<script src="js/jquery.form.js"></script>
<script src="js/distance-table.js"></script>
<script src="js/map.js"></script>

<title>Google maps MST</title>


<script>
function process_graph_results(results){

    //Pass the results to the distance table and graph
    results = JSON.parse(results); //TODO find out why I need to parse this, jquery.form errors?
    make_distance_table(results);
    load_graph_to_map(results);
    console.log(results);
}

/**
 * Show's the little loading throbber
 */
function show_throbber(results){
    $('#distance-table').html('Loading.....');
}
$(function(){

    //Expanding city fields,
    //Keep a track of the last one, if we make keypresses add another one make
    //that the lastone
    //TODO add something to remove empty ones
    $(document).on('keydown','.last-city',function(e){
        if($(this).val() != ''){
            $(this).removeClass('last-city');
            $(this).parent().append($('<input/>').attr('type','text').attr('name','cities[]').attr('placeholder','e.g. Helsinki').addClass('form-control').addClass('last-city') );
        }
    });


    //Ajax form submit
    $('#main-form').ajaxForm({
        taType:  'json',
        success:process_graph_results,
        beforeSubmit:show_throbber,
    });

});

</script>
<style type="text/css">
#map { height: 100%; margin: 0; padding: 0; height:500px;}
 </style>


</head>


<body>
 <div class="container">

      <div class="jumbotron">
        <h1>Google Maps Minimum Spanning Tree</h1>
        <p class="lead">Enter the name of cities, press the go button, and behold the minimum spanning tree between them</p>
      </div>

      <div class="row ">
        <div class="col-lg-6">
        <form action="mst.php" id="main-form">
            <h2>City Names</h2>
            <p>Enter the names of some cities</p>
            <div id="city-holder">
            <input type="text" class="form-control last-city"  name="cities[]" placeholder="e.g. Helsinki" id="city1"/>
            </div>
            <button class="btn btn-primary">Calculate MST</button>

        </form>
        </div>
        <div class='col-lg-6'>
            <div id='distance-table'></div>
            <div id='map'></div>

        </div>
      </div>
    </div> <!-- /container -->


</body>

</html>

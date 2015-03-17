<?php
include 'include/api_key.php';
?>
<!DOCTYPE html>
<html>
<head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
<!-- Latest compiled and minified JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?libraries=geometry&key=<?php echo $key;?>"></script>


<script src="js/jquery.form.js"></script>
<script src="js/distance-table.js"></script>
<script src="js/map.js"></script>


<link rel="stylesheet" href="http://msurguy.github.io/ladda-bootstrap/dist/ladda-themeless.min.css"/>
<script src="js/spin.min.js"></script>
<script src="js/ladda.min.js"></script>

<title>Google maps MST</title>


<script>
function process_graph_results(results){

    //Pass the results to the distance table and graph
    results = JSON.parse(results); //TODO find out why I need to parse this, jquery.form errors?
    console.log(results);
    make_distance_table(results);
    load_graph_to_map(results);
    handle_errors(results);
    stop_throbber();
}

function request_failed(results){
    alert('500 error from server :(');
    stop_throbber();
}

function start_throbber(){
    l.start();

}
function stop_throbber(){
    l.stop();
}
var l ;

$(function(){

    //Expanding city fields,
    //Keep a track of the last one, if we make keypresses add another one make
    //that the lastone
    //TODO add something to remove empty ones
    $(document).on('keydown','.last-city',function(e){
        if($(this).val() != ''){
            $(this).removeClass('last-city');
            var formgroup = $('<div class="form-group"></div>');
            formgroup.append($('<input/>').attr('type','text').attr('name','cities[]').attr('placeholder','e.g. Helsinki').addClass('form-control').addClass('last-city') );
            $(this).parent().parent().append(formgroup);
        }
    });


    //Ajax form submit
    $('#main-form').ajaxForm({
        taType:  'json',
        success:process_graph_results,
        error:request_failed,
        beforeSubmit:start_throbber,
    });

    l = Ladda.create($('#main-form button')[0]);
});

</script>
<style type="text/css">
#map { height: 100%; margin: 0; padding: 0; height:500px;margin-bottom:50px;}
.table-high {background-color:#e9e9e9;}
#messages{display:none;}
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
            <div class='form-group'>
                <input type="text" class="form-control last-city"  name="cities[]" placeholder="e.g. Helsinki" id="city1"/>
            </div>
            </div>

            <button class="btn btn-primary ladda-button" data-style="expand-left"><span class="ladda-label">Go</span></button>
        </form>
        </div>
        <div class='col-lg-6'>
            <div id='map'></div>

        </div>
      </div>

    <div class="row">
        <div class="col-lg-12">
            <div id="distance-table"></div>
        </div>
    </div>
    </div> <!-- /container -->


</body>

</html>

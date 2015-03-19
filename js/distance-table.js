/**
 * distance-table.js
 * fills in a distance table for results
 */

/**
 * Makes the text that goes in each distance cell
 */
function make_cell_text(r){
    return r.distance.text + '<br/>' + r.duration.text;
}

/**
 * Makes the table that tells you how far it is from one city to another
 */
function make_distance_table(results){
    $('#distance-table').html('');
    var table = $('<table></table>').addClass('distance-table table table-bordered');

    //Now make a heading row
    var header_row = $('<tr></tr>');
    header_row.append('<td></td>');
    for (city in results.locations){
        header_row.append($('<th></th>').html(city));
    }
    table.append(header_row);

    //Now we go through and make a row for each city matching to the pair
    for (city in results.locations){
        var row = $('<tr></tr>');
        row.append('<th>'+city+'</th>');
        for (city2 in results.locations){
            var r = results.distances[city][city2];
            var cell = $('<td></td>');
            if(r != undefined){
                cell.html(make_cell_text(r));
            }
            cell.attr('id',city + '-' + city2);
            row.append(cell)
        }
        table.append(row);
    }


    $('#distance-table').append(table);
}

/**
 * Highlights boxes if there are any errors
 */
function handle_errors(results){

    //Remove all current highlighted ones
    $('.form-group.has-error').removeClass('has-error');

    //go through each city, try to find the input with that value
    for(city in results.errors){
        //because the val isn't an element attribute we can't use input[val=XX]
        $('input').each(function(e){
            console.log($(this).val(),results.errors[city],city);
            if($(this).val() == results.errors[city]){
                $(this).parent().addClass('has-error');
            }
        });
    }

}


/**
 * Loads the execution times into the table
 */
function load_execution_times(results){
    $('#execution-time').show();
    $('#requests-total').html(results.total_requests);
    $('#mst-time').html(results.graph_time.toFixed(3) + '&micro;s');

    var total = 0.0;
    for (i in results.requests_time){
        total += results.requests_time[i];
    }

    $('#requests-time').html( total.toFixed(3) + '&micro;s / ' + (total/results.requests_time.length).toFixed(3) + '&micro;s');

}

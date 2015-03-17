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
            row.append(cell)
        }
        table.append(row);
    }


    $('#distance-table').append(table);
}

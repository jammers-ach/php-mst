/**
 * distance-table.js
 * fills in a distance table for results
 */

function make_distance_table(results){
    $('#distance-table').html('');
    var table = $('<table></table>').addClass('distance-table table table-bordered');

    console.log(results);
    console.log(results.locations);

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
            console.log(r);
            var cell = $('<td></td>');
            if(r != undefined){
                cell.html(r.distance.text + '<br/>' + r.duration.text);
            }

            row.append(cell)
        }
        table.append(row);
    }


    $('#distance-table').html('').append(table);

}

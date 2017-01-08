<script>

//-------- LINE -------- LINE -------- LINE -------- LINE -------- LINE -------- LINE -------- LINE -------- LINE

    function drawLine(json, json_length) {
// console.log(json);
// console.log(json_length);
        for (var i = 0; i < json_length; i++) {
            var data = google.visualization.arrayToDataTable([
                ['Date', 'Buzz', 'Mood'],
                [json[i][0]['date'], json[i][0]['buzz'], json[i][0]['mood'],],
                [json[i][1]['date'], json[i][1]['buzz'], json[i][1]['mood'],],
                [json[i][2]['date'], json[i][2]['buzz'], json[i][2]['mood'],],
                [json[i][3]['date'], json[i][3]['buzz'], json[i][3]['mood'],],
                [json[i][4]['date'], json[i][4]['buzz'], json[i][4]['mood'],],
                [json[i][5]['date'], json[i][5]['buzz'], json[i][5]['mood'],],
                [json[i][6]['date'], json[i][6]['buzz'], json[i][6]['mood'],],
                [json[i][7]['date'], json[i][7]['buzz'], json[i][7]['mood'],],
                [json[i][8]['date'], json[i][8]['buzz'], json[i][8]['mood'],],
                [json[i][9]['date'], json[i][9]['buzz'], json[i][9]['mood'],],
                [json[i][10]['date'], json[i][10]['buzz'], json[i][10]['mood'],],
                [json[i][11]['date'], json[i][11]['buzz'], json[i][11]['mood'],],
                [json[i][12]['date'], json[i][12]['buzz'], json[i][12]['mood'],],
                [json[i][13]['date'], json[i][13]['buzz'], json[i][13]['mood'],],
                [json[i][14]['date'], json[i][14]['buzz'], json[i][14]['mood'],],
                [json[i][15]['date'], json[i][15]['buzz'], json[i][15]['mood'],],
                [json[i][16]['date'], json[i][16]['buzz'], json[i][16]['mood'],],
                [json[i][17]['date'], json[i][17]['buzz'], json[i][17]['mood'],],
                [json[i][18]['date'], json[i][18]['buzz'], json[i][18]['mood'],],
                [json[i][19]['date'], json[i][19]['buzz'], json[i][19]['mood'],],
                [json[i][20]['date'], json[i][20]['buzz'], json[i][20]['mood'],],
            ]);
        var options = {
            title: json[i][1]['name'] + "'s Buzz & Mood",
            // curveType: 'function',
            legend: { position: 'bottom' }
        };

        var line = new google.visualization.LineChart(document.getElementById('mini_line_div' + i));
        line.draw(data, options); 
        
        };
    };//--------    --------    --------    --------    --------

</script> 

<style>
/*	THE LINE CHARTS	*/


</style>
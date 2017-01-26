<script>

//-------- TREND_LINE -------- TREND_LINE -------- TREND_LINE -------- TREND_LINE -------- TREND_LINE -------- TREND_LINE -------- TREND_LINE -------- TREND_LINE

    function drawTrendLine(json, json_length) {

        var options = {
            hAxis: {title: 'Buzz'},
            vAxis: {title: 'Mood'},
            legend: 'none'
          };

        for (var k = 0; k < json_length; k++) {
            var data = new google.visualization.DataTable();
            data.addColumn('number', 'Buzz');
            
            var name = json[k][1]['name'];
            // name = name.toString();
            options.title = name;
            options.trendlines = { 0: {} };
            data.addColumn('number', name);
            
            mw_comp_values(json[k], data);
            
            var scatter = new google.visualization.ScatterChart(document.getElementById('mini_trend_line_div' + k));
            scatter.draw(data, options); 
        };

    };//--------    --------    --------    --------    --------

    function mw_comp_values(json, data) {

        for (var i = 0; i < 21; i++) {
            var value = hf.moodRanged(json[i]['positives'], json[i]['negatives'], json[i]['neutrals']);
            data.addRows([
                [json[i]['mood'], value]
                ]);
        }; 

        return data;

    };//--------    --------    --------    --------    --------


</script> 
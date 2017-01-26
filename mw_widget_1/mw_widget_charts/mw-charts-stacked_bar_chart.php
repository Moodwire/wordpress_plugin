<script>

//-------- STACKED_BAR_CHART -------- STACKED_BAR_CHART -------- STACKED_BAR_CHART -------- STACKED_BAR_CHART -------- STACKED_BAR_CHART -------- STACKED_BAR_CHART -------- STACKED_BAR_CHART -------- STACKED_BAR_CHART

function drawStackedBar(json, json_length) {
    
    var data = new google.visualization.DataTable();
        data.addColumn('string', 'Name');
        data.addColumn('number', 'Positive');
        data.addColumn('number', 'Neutral');
        data.addColumn('number', 'Negative');
        // data.addColumn('string', {role: 'annotation'});

    
    for (var m = 0; m < json_length; m++) {
        var ent_pos = 0;
        var ent_neu = 0;
        var ent_neg = 0;
        var ent_name = json[m][0]['name'];

        for (var a = 0; a < 21; a++) {
            ent_pos += json[m][a]['positives'];
            ent_neu += json[m][a]['neutrals'];
            ent_neg += json[m][a]['negatives'];
        }//--------

        data.addRows([
            [ent_name, ent_pos, ent_neu, ent_neg]
        ]);
    }//--------
    
    var options_fullStacked = {
        isStacked: 'percent',
        legend: {position: 'top', maxLines: 3},
        hAxis: {
            minValue: 0,
            ticks: [0, .25, .50, .75, 1]
        },
        series: {
            0:{color:'#00ff00'},
            1:{color:'0066ff'},
            2:{color:'ff0000'}
        }
    };
    
    var stacked_bar = new google.visualization.BarChart(document.getElementById('stacked_bar_div'));
    stacked_bar.draw(data, options_fullStacked);

};//--------    --------    --------    --------    --------


</script> 

<style>
    
    #stacked_bar_div div div {
        height: auto;
    }

</style>
<script>

//-------- BAR -------- BAR -------- BAR -------- BAR -------- BAR -------- BAR -------- BAR -------- BAR

    function drawBar(json, json_length) { 

        var mini_bar_div_master = document.createElement('div');                                    //--    append master bar chart
            mini_bar_div_master.id = 'mini_bar_div_master';
            mini_bar_div_master.className = 'mini_bar_div';
            document.getElementById('bar_div').appendChild(mini_bar_div_master);   

        // var mini_bar_div_positive = document.createElement('div');                                  //--    appends three bar charts ( positive, negative, neutral)
        //     mini_bar_div_positive.id = 'mini_bar_div_positive';
        //     mini_bar_div_positive.className = 'mini_bar_div';
        //     document.getElementById('bar_div').appendChild(mini_bar_div_positive);
        
        // var mini_bar_div_negative = document.createElement('div');                                  //--    appends three bar charts ( positive, negative, neutral)
        //     mini_bar_div_negative.id = 'mini_bar_div_negative';
        //     mini_bar_div_negative.className = 'mini_bar_div';
        //     document.getElementById('bar_div').appendChild(mini_bar_div_negative);
        
        // var mini_bar_div_neutral = document.createElement('div');                                   //--    appends three bar charts ( positive, negative, neutral)
        //     mini_bar_div_neutral.id = 'mini_bar_div_neutral';
        //     mini_bar_div_neutral.className = 'mini_bar_div';
        //     document.getElementById('bar_div').appendChild(mini_bar_div_neutral);
        

        // drawBar_positive(json, json_length);
        // drawBar_negative(json, json_length);
        // drawBar_neutral(json, json_length);
        drawBar_master(json, json_length);
    };//--------    --------    --------    --------    --------


    function drawBar_master(json, json_length) {
        var data = new google.visualization.DataTable();
            data.addColumn('string', 'Entity');
            data.addColumn('number', 'Positive');
            data.addColumn('number', 'Negative');
            data.addColumn('number', 'Neutral');
        
        for (var i = 0; i < json_length; i++) {
            var name = json[i]['name'];
                // name = name.toString();
            var pos = json[i]['positives'];
            var neg = json[i]['negatives'];
            var neu = json[i]['neutrals'];
            
            data.addRows([
                [ name, pos, neg, neu],
            ]);

            var options = {
                title: 'Current global feeling',
                colors: ['green', 'red','blue'],
                hAxis: {
                    title: 'Mood',
                    viewWindow: {
                        min: [7, 30, 0],
                        max: [17, 30, 0]
                    }
                // },
                // vAxis: {
                //     title: 'Rating (scale of 1-100)'
                }
            };
        };                                                              
        var chart_bars = new google.visualization.ColumnChart(document.getElementById('mini_bar_div_master'));
        chart_bars.draw(data, options); 
    };//--------    --------    --------    --------    --------


    function drawBar_positive(json, json_length) {
        var data = new google.visualization.DataTable();
            data.addColumn('string', 'Entity');
            data.addColumn('number', 'Positive');
            // data.addColumn('number', 'Negative');
            // data.addColumn('number', 'Neutral');
        
        for (var i = 0; i < json_length; i++) {
            var name = json[i]['name'];
                // name = name.toString();
            var pos = json[i]['positives'];
            
            data.addRows([
                [ name, pos],
            ]);

            var options = {
                // title: 'Current positive feeling',
                colors: ['green'],
                hAxis: {
                    title: 'Positive',
                    viewWindow: {
                        min: [7, 30, 0],
                        max: [17, 30, 0]
                    }
                // },
                // vAxis: {
                //     title: 'Rating (scale of 1-100)'
                }
            };
        };                                                              
        var chart_pos = new google.visualization.ColumnChart(document.getElementById('mini_bar_div_positive'));
        chart_pos.draw(data, options); 
    };//--------    --------    --------    --------    --------


    function drawBar_negative(json, json_length) {
        var data = new google.visualization.DataTable();
            data.addColumn('string', 'Entity');
            // data.addColumn('number', 'Positive');
            data.addColumn('number', 'Negative');
            // data.addColumn('number', 'Neutral');
        
        for (var i = 0; i < json_length; i++) {
            var name = json[i]['name'];
                // name = name.toString();
            var neg = json[i]['negatives'];
            
            data.addRows([
                [ name, neg],
            ]);

            var options = {
                // title: 'Current negative feeling',
                colors: ['red'],
                hAxis: {
                    title: 'Negative',
                    viewWindow: {
                        min: [7, 30, 0],
                        max: [17, 30, 0]
                    }
                // },
                // vAxis: {
                //     title: 'Rating (scale of 1-100)'
                }
            };
        };                                                              
        var chart_neg = new google.visualization.ColumnChart(document.getElementById('mini_bar_div_negative'));
        chart_neg.draw(data, options); 
    };//--------    --------    --------    --------    --------


    function drawBar_neutral(json, json_length) {
        var data = new google.visualization.DataTable();
            data.addColumn('string', 'Entity');
            // data.addColumn('number', 'Positive');
            // data.addColumn('number', 'Negative');
            data.addColumn('number', 'Neutral');
        
        for (var i = 0; i < json_length; i++) {
            var name = json[i]['name'];
                // name = name.toString();
            var neu = json[i]['neutrals'];
            
            data.addRows([
                [ name, neu],
            ]);

            var options = {
                // title: 'Current neutral feeling',
                colors: ['blue'],
                hAxis: {
                    title: 'Neutral',
                    viewWindow: {
                        min: [7, 30, 0],
                        max: [17, 30, 0]
                    }
                // },
                // vAxis: {
                //     title: 'Rating (scale of 1-100)'
                }
            };
        };                                                              
        var chart_neu = new google.visualization.ColumnChart(document.getElementById('mini_bar_div_neutral'));
        chart_neu.draw(data, options); 
    };//--------    --------    --------    --------    --------

</script>

<style>
/*  THE BAR CHARTS  */

    #bar_div {
        /*display: inline-block;*/
        vertical-align: top;
        /*margin: 0 auto;*/
        /*width: 49%;*/
        /*border: 1px solid red;*/
    }
    .mini_bar_div {
        /*width: 200px !important;*/
        /*height: 200px !important;*/
        /*display: inline-block !important;*/
        /*margin: 0px 50px;*/
        vertical-align: top;
    }
    /*.mini_bar_div div div div svg {
        width: 100% !important;
    }*/
    .mini_bar_div div div div svg g g g text[text-anchor=middle] {
        font-weight: bold;
        font-size: 1em;
    }
</style>
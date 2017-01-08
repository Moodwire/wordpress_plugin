<script type="text/javascript">

    // function mw_draw_charts(json) {                                                         //--------      MASTER CALL TO GENERATE CHARTS, ROUTES TO ALL FUNCTIONS FROM HERE(NEXUS)
    function mw_draw_charts(json, word_data, chart_selectors) {  
    // function mw_draw_charts(json, location_data, word_data) {                                         
// console.log(chart_selectors['gauge_charts']);
        var json_length = jsonDataLength(json);  
        var full_chart_data = [];
        for (var i = 0; i < json_length; i++) {
            var json_entry = [];    
            for (var k = 0; k < 21; k++) {
                json_entry.push(JSON.parse(json[i]['entry_' + k]));
            }

            json[i] = JSON.parse(json[i]['entry_20']);
            full_chart_data.push(json_entry);
        }

        document.getElementById('chart_body_div').value = '';
        document.getElementById('gauge_div').innerHTML = '';                                //--    clears the gauges
        document.getElementById('pie_buzz_div').innerHTML = '';
        document.getElementById('pie_div').innerHTML = '';                                  //--    clears the pie charts
        document.getElementById('bar_div').innerHTML = '';                                  //--    clears the bar charts
        document.getElementById('line_div').innerHTML = '';
        document.getElementById('scatter_div').innerHTML = '';
        document.getElementById('treemap_div').innerHTML = '';
        document.getElementById('stacked_bar_div').innerHTML = '';
        document.getElementById('trend_line_div').innerHTML = '';
        // document.getElementById('calendar_div').innerHTML = '';
        document.getElementById('bubble_chart_div').innerHTML = '';
        // document.getElementById('location_div').innerHTML = '';
        var i = 0;
      
        while( i < json_length ) {                                                           //--    iterates through length to append charts
            
            var mini_gauge_div = document.createElement('div');                             //--    appends gauges
            mini_gauge_div.className = 'mini_gauge_div';
            mini_gauge_div.id = 'mini_gauge_div' + i;
            document.getElementById('gauge_div').appendChild(mini_gauge_div);
                                                                  
            var mini_pie_div = document.createElement('div');                               //--    append pie charts
            mini_pie_div.className = 'mini_pie_div';
            mini_pie_div.id = 'mini_pie_div' + i;
            document.getElementById('pie_div').appendChild(mini_pie_div);

            var mini_line_div = document.createElement('div');                              //--    append line charts
            mini_line_div.className = 'mini_line_div';
            mini_line_div.id = 'mini_line_div' + i;
            document.getElementById('line_div').appendChild(mini_line_div);

            var mini_trend_line_div = document.createElement('div');                        //--    append trend charts
            mini_trend_line_div.className = 'mini_trend_line_div';
            mini_trend_line_div.id = 'mini_trend_line_div' + i;
            document.getElementById('trend_line_div').appendChild(mini_trend_line_div);

            // var mini_calendar_div = document.createElement('div');                          //--    append trend charts
            // mini_calendar_div.className = 'mini_calendar_div';
            // mini_calendar_div.id = 'mini_calendar_div' + i;
            // document.getElementById('calendar_div').appendChild(mini_calendar_div);

            // var mini_word_chart_div = document.createElement('div');                          //--    append trend charts
            // mini_word_chart_div.className = 'mini_word_chart_div';
            // mini_word_chart_div.id = 'mini_word_chart_div' + i;
            // document.getElementById('word_chart_div').appendChild(mini_word_chart_div);

            i++;
        };

        if (chart_selectors['gauge_charts'] == 'on')        { drawGauge(json, json_length); };
        if (chart_selectors['buzz_pie_charts'] == 'on')     { drawBuzzPie(json, json_length); };
        if (chart_selectors['pie_charts'] == 'on')          { drawPie(json, json_length); };
        if (chart_selectors['bar_charts'] == 'on')          { drawBar(json, json_length); };
        if (chart_selectors['line_charts'] == 'on')         { drawLine(full_chart_data, json_length); };

        if (chart_selectors['scatter_charts'] == 'on')      { drawScatter(full_chart_data, json_length); };
        if (chart_selectors['treemap_charts'] == 'on')      { drawTreemap(full_chart_data, json_length); };
        if (chart_selectors['stacked_bar_charts'] == 'on')  { drawStackedBar(full_chart_data, json_length); };
        if (chart_selectors['trend_line_charts'] == 'on')   { drawTrendLine(full_chart_data, json_length); };
        // drawCalendar(full_chart_data, json_length);
        if (chart_selectors['bubble_charts'] == 'on')       { drawBubbleChart(full_chart_data, json_length); };
        // drawLocation(location_data);
        if (chart_selectors['word_cloud_charts'] == 'on')   { word_data.forEach(drawWordChart); };
    };//--------    --------    --------    --------    --------

    function jsonDataLength(json) {                                                         //--------      PERFORMS AN ENTITY COUNT
        var count = 0;
        var key;
        for(key in json) {
            count++;
        };

        return count;
    };//--------    --------    --------    --------    --------


    function mwRenderEmptyCharts() {
        document.getElementById('chart_body_div').value = '';
        document.getElementById('gauge_div').innerHTML = '<p>Choose an entity, or disable gauge charts</p>';                              
        document.getElementById('pie_buzz_div').innerHTML = '<p>Choose an entity, or disable pie buzz charts</p>';
        document.getElementById('pie_div').innerHTML = '<p>Choose an entity, or disable pie charts</p>';                                  
        document.getElementById('bar_div').innerHTML = '<p>Choose an entity, or disable bar charts</p>';                                  
        document.getElementById('line_div').innerHTML = '<p>Choose an entity, or disable line charts</p>';
        document.getElementById('scatter_div').innerHTML = '<p>Choose an entity, or disable scatter charts</p>';
        document.getElementById('treemap_div').innerHTML = '<p>Choose an entity, or disable treemap charts</p>';
        document.getElementById('stacked_bar_div').innerHTML = '<p>Choose an entity, or disable stacked bar charts</p>';
        document.getElementById('trend_line_div').innerHTML = '<p>Choose an entity, or disable trend line charts</p>';
        // document.getElementById('calendar_div').innerHTML = '<p>Choose an entity, or disable calendar charts</p>';
        document.getElementById('bubble_chart_div').innerHTML = '<p>Choose an entity, or disable bubble charts</p>';
        // document.getElementById('location_div').innerHTML = '<p>Choose an entity, or disable location charts</p>';
    };//--------    --------    --------    --------    --------

</script>
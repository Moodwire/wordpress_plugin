<script>

//-------- CALENDAR -------- CALENDAR -------- CALENDAR -------- CALENDAR -------- CALENDAR -------- CALENDAR -------- CALENDAR -------- CALENDAR
//------------- this is built using D3.js, visit https://www.crowdanalytix.com/communityBlog/10-steps-to-create-calendar-view-heatmap-in-d3-js
    function drawCalendar(json, json_length) {

    var mw_d3_calendar_chart = c3.generate({
        bindto: '#calendar_div',
        data: {
            columns: [
                ['data1', 30, 200, 100, 400, 150, 250],
                ['data2', 50, 20, 10, 40, 15, 25]
            ]
        }
    });
        // var width = 900,
        // var height = 105;

        // var chart = d3.select('body') 
        //     .append('svg')
        //     .attr('class', 'chart')
        //     .attr('width', width)
        //     .attr('height', height);

        // var cellSize = 17;
        // var percent = d3.format(".1%"),
        // var format = d3.time.format("%Y%m%d");

        // var color = d3.scale.linear().range(["white", '#002b53'])
        //     .domain([0, 1]);

        // // json

        // var data = d3.nest()
        //     .key(function(d) { return d.Date; })
        //     .rollup(function(d) { return  Math.sqrt(d[0].Comparison_Type / Comparison_Type_Max); })
        //     .map(json);

    };//--------    --------    --------    --------    --------


</script> 
<style>
    /*.chart {
        background: #fff;
        margin: 5px;
    }*/

</style>
<script>

//-------- CALENDAR -------- CALENDAR -------- CALENDAR -------- CALENDAR -------- CALENDAR -------- CALENDAR -------- CALENDAR -------- CALENDAR

    function drawCalendar(json, json_length) {

        var dataTable = new google.visualization.DataTable();
        dataTable.addColumn({ type: 'date', id: 'Date' });
        dataTable.addColumn({ type: 'number', id: 'Buzz' });
       
        for (var a = 0; a < 1; a++) {
            for (var i = 0; i < 21; i++) {
                dataTable.addRows([
                    [ new Date(json[a][i][8]), json[a][i][4] ]
                    ])
            };
        };
 
        var chart = new google.visualization.Calendar(document.getElementById('calendar_div'));

        var options = {
            title: "Buzz",
            width: 'auto',
         // height: 350,
            calendar: { 
                // cellSize: 10,
                unusedMonthOutlineColor: {
                    stroke: 'transparent',
                    // strokeOpacity: 0,
                    // strokeWidth: 0,
                    backgroundColor: 'transparent',
                    color: 'transparent',
                    fill: 'none',
                    display: 'none',
                    visibility: 'collapse',
                    overflow: 'hidden',
                    border: 'none',
                    width: 0,
                    height: 0,
                    role: {style: { display: 'none'}}
                }
            },
            noDataPattern: {
                stroke: 'transparent',
                // strokeOpacity: 0,
                // strokeWidth: 0,
                backgroundColor: 'transparent',
                color: 'transparent',
                fill: 'none',
                display: 'none',
                visibility: 'collapse',
                overflow: 'hidden',
                border: 'none',
                width: 0,
                height: 0
            }
            // forcelFrame: true
        };

        chart.draw(dataTable, options);

    };//--------    --------    --------    --------    --------


</script> 

<style>
    #calenddar_div {
        width: auto;
    }
    #calendar_div div div {
        width: auto !important;
    }
    #calendar_div div div div svg g path[fill='none'] {
        stroke: transparent;
        color: transparent;
        fill: none;
        display: none;
        visibility: collapse;
        overflow: hidden;
        border: none;
        width: 0;
        height: 0;
    }
    #calendar_div div div div svg g rect[fill='#ffffff'] {
        /*fill: red !important;*/
        display: none !important;
        width: 0 !important;
        height: 0 !important;
    }
    #calendar_div div div div svg g path {
        width: auto;
    }
    #calendar_div div div {
        width: auto;
    }
    #calendar_div div div div svg g text[font-size='12'] {
        display: none !important;
    }
</style>
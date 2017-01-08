<script>

//-------- BUBBLE -------- BUBBLE -------- BUBBLE -------- BUBBLE -------- BUBBLE -------- BUBBLE -------- BUBBLE -------- BUBBLE

    function drawBubbleChart(json, json_length) {
        var data = new google.visualization.DataTable();
            data.addColumn('string', 'Week Ending');
            data.addColumn('number', 'Positive Buzz');
            data.addColumn('number', "Negative Buzz");
            data.addColumn('string', "ID");
            data.addColumn('number', 'Total Buzz');

        mw_weekly_bubble(json, data, json_length);
        // mw_bubble_entity(json, data, json_length);


        var options = {
            title: "Weekly buzz",
            hAxis: {title: 'Negative buzz'},
            vAxis: {title: 'Positive buzz'},
            bubble: {textStyle: {fontSize: 10}}
        };

        var bubble = new google.visualization.BubbleChart(document.getElementById('bubble_chart_div'));
        bubble.draw(data, options);
    
    };//--------    --------    --------    --------    --------


    function mw_bubble_entity(json, data, json_length) {

        for (var b = 0; b < json_length; b++) {
           var name = json[b][0]['name']; 

            for (var a = 0; a < 21; a++) {
                data.addRows([  [json[b][a]['date'], json[b][a]['positives'], json[b][a]['negatives'], name, json[b][a]['buzz']] ]);
            };
        };

        return data;
    };//--------    --------    --------    --------    --------


    function mw_weekly_bubble(json, data, json_length) {
        for (var b = 0; b < json_length; b++) {
            var name = json[b][0]['name']; 
            var a_pos_1 = 0;
            var a_pos_2 = 0;
            var a_pos_3 = 0;
            var a_neg_1 = 0;
            var a_neg_2 = 0;
            var a_neg_3 = 0;
            var a_buzz_1 = 0;
            var a_buzz_2 = 0;
            var a_buzz_3 = 0;
            var a_date_1 = '';
            var a_date_2 = '';
            var a_date_3 = '';
            
            for (var a = 0; a < 6; a++) {
                a_pos_1 += json[b][a]['positives'];
                a_neg_1 += json[b][a]['negatives'];
                a_buzz_1 += json[b][a]['buzz'];
                a_date_1 = json[b][a]['date'];
            };
            
            for (var a = 7; a < 14; a++) {
                a_pos_2 += json[b][a]['positives'];
                a_neg_2 += json[b][a]['negatives'];
                a_buzz_2 += json[b][a]['buzz'];
                a_date_2 = json[b][a]['date'];
            };
            
            for (var a = 15; a < 21; a++) {
                a_pos_3 += json[b][a]['positives'];
                a_neg_3 += json[b][a]['negatives'];
                a_buzz_3 += json[b][a]['buzz'];
                a_date_3 = json[b][a]['date'];
            };

            data.addRows([  [a_date_1, a_pos_1, a_neg_1, name, a_buzz_1] ]);
            data.addRows([  [a_date_2, a_pos_2, a_neg_2, name, a_buzz_2] ]);
            data.addRows([  [a_date_3, a_pos_3, a_neg_3, name, a_buzz_3] ]);
        };

        return data;
    };//--------    --------    --------    --------    --------


</script> 
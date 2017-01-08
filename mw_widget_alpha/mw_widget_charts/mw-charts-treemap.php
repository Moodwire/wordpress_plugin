<script>

//-------- TREEMAP -------- TREEMAP -------- TREEMAP -------- TREEMAP -------- TREEMAP -------- TREEMAP -------- TREEMAP -------- TREEMAP

    function drawTreemap(json, json_length) {
// console.log(json);
// console.log(json_length);
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Date');
        data.addColumn('string', 'Parent');
        data.addColumn('number', 'Mood size (size)');
        data.addColumn('number', 'Mood increase/decrease (color)');

        for (var b = 0; b < json_length; b++) {
            data.addRows([  ['Mood', null, 0, 0]  ]);
        };

        mw_treemap_entity(json,data,json_length);

        var treemap = new google.visualization.TreeMap(document.getElementById('treemap_div'));
        var options = {
            minColor: '#f00',
            midColor: '#ddd',
            maxColor: '#0d0',
            headerHeight: 15,
            fontColor: 'black',
            showScale: false
        };
// console.log(options);        
        treemap.draw(data, options); 
        
    };//--------    --------    --------    --------    --------


    function mw_treemap_entity(json, data, json_length) {

        var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
            "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
        ];
        // json_length = json_length - 1;
        for (var b = 0; b < json_length; b++) {
// console.log(json[b]);
// console.log(json_length);
            var name = json[b][0]['name'];
           data.addRows([  [name, 'Mood', 0, 0]  ]); 
// console.log(name);
            for (var a = 0; a < 21; a++) {
                var date = new Date(json[b][a]['date']);
// console.log(date);
                var refined_date = date.getDate() + ' ' + monthNames[date.getMonth()];
// console.log(refined_date);                
                var mood = hf.moodRanged(json[b][a]['positives'], json[b][a]['negatives'], json[b][a]['neutrals']);
// console.log(mood);
                // var mood_sizing = mood/2;

                data.addRows([  [refined_date + '-' + 'mood towards ' + name + ' is ' + mood , name, 1, mood] ]);           //      WILL MAKE ALL DATES RENDER WITHOUT SCALING
                // data.addRows([  [refined_date + '-' + 'mood towards ' + name + ' is ' + mood , json[b][a][1], mood_sizing, mood] ]);    //      WILL SCALE, AFFECTS SOME ENTITIES
            };
        };

        return data;
    };//--------    --------    --------    --------    --------

</script> 
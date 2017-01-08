<script>

//-------- SCATTER -------- SCATTER -------- SCATTER -------- SCATTER -------- SCATTER -------- SCATTER -------- SCATTER -------- SCATTER

    function drawScatter(json, json_length) {

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Date');

         var options = {
            legend: 'none',
            chart: {
                title: "Mood tracked daily"
            }
        };
        
        
        for (var k = 0; k < json_length; k++) {                                                     //--        establishes name columns(total columns)
            var name = json[k][1]['name'];
            // name = name.toString();
            data.addColumn('number', name);
            // console.log(name);
        };
            
            for (var i = 0; i < 21; i++) {
                var q = 0;
                var pickles = [];
                pickles.push(json[0][i]['date']);

                while (q < json_length) {
                    var value = hf.moodRanged(json[q][i]['positives'], json[q][i]['negatives'], json[q][i]['neutrals']);
                    pickles.push(value);
                    q++;
                }
                data.addRows([
                    pickles
                    ]);
                
            }; 

        var scatter = new google.visualization.ScatterChart(document.getElementById('scatter_div'));
        scatter.draw(data, options); 

    };//--------    --------    --------    --------    --------


</script> 
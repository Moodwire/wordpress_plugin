<script>

//-------- LOCATION -------- LOCATION -------- LOCATION -------- LOCATION -------- LOCATION -------- LOCATION -------- LOCATION -------- LOCATION

    function drawLocation(json) {

        // for (var a = 0; a < json.length; a++) {
        //     for (var b = 0; b < 50; b++) {
        //         console.log(JSON.parse(json[a]['location_' + b]));
        //     }
            var data = google.visualization.arrayToDataTable([
                ['State', 'Mood'],

                ['Alabama', 300],
                ['Alaska', 100],
                ['Arizona', 300],
                ['Arkansas', 300],
                ['California', 300],

                ['Colorado', 300],
                ['Connecticut', 300],
                ['Delaware', 300],
                ['Florida', 300],
                ['Georgia', 300],

                ['Hawaii', 800],
                ['Idaho', 300],
                ['Illinois', 300],
                ['Indiana', 300],
                ['Iowa', 300],

                ['Kansas', 300],
                ['Kentucky', 300],
                ['Lousianna', 300],
                ['Maine', 300],
                ['Maryland', 300],

                ['Massachusetts', 300],
                ['Michigan', 300],
                ['Minnesota', 300],
                ['Mississippi', 300],
                ['Missouri', 300],

                ['Montana', 300],
                ['Nebraska', 300],
                ['Nevada', 300],
                ['New Hampshire', 300],
                ['New Jersey', 300],

                ['New Mexico', 300],
                ['New York', 300],
                ['North Carolina', 300],
                ['North Dakota', 300],
                ['Ohio', 300],

                ['Oklahoma', 300],
                ['Oregon', 300],
                ['Pennsylvania', 300],
                ['Rhode Island', 300],
                ['South Carolina', 300],

                ['South Dakota', 300],
                ['Tennessee', 300],
                ['Texas', 300],
                ['Utah', 300],
                ['Vermont', 300],

                ['Washington', 300],
                ['West Virginia', 300],
                ['Wisconsin', 300],
                ['Wyoming', 300]
            ]);

            var options = {
                region: 'US'
            };

            var map_chart = new google.visualization.GeoChart(document.getElementById('location_div'));
            map_chart.draw(data, options);
        // }; 
    };//--------    --------    --------    --------    --------

     // ['State', 'Country', 'Mood'],

     //            ['Alabama', 'United States', 300],
     //            ['Alaska', 'United States', 300],
     //            ['Arizona', 'United States', 300],
     //            ['Arkansas', 'United States', 300],
     //            ['California', 'United States', 300],

     //            ['Colorado', 'United States', 300],
     //            ['Connecticut', 'United States', 300],
     //            ['Delaware', 'United States', 300],
     //            ['Florida', 'United States', 300],
     //            ['Georgia', 'United States', 300],

     //            ['Hawaii', 'United States', 300],
     //            ['Idaho', 'United States', 300],
     //            ['Illinois', 'United States', 300],
     //            ['Indiana', 'United States', 300],
     //            ['Iowa', 'United States', 300],

     //            ['Kansas', 'United States', 300],
     //            ['Kentucky', 'United States', 300],
     //            ['Lousianna', 'United States', 300],
     //            ['Maine', 'United States', 300],
     //            ['Maryland', 'United States', 300],

     //            ['Massachusetts', 'United States', 300],
     //            ['Michigan', 'United States', 300],
     //            ['Minnesota', 'United States', 300],
     //            ['Mississippi', 'United States', 300],
     //            ['Missouri', 'United States', 300],

     //            ['Montana', 'United States', 300],
     //            ['Nebraska', 'United States', 300],
     //            ['Nevada', 'United States', 300],
     //            ['New Hampshire', 'United States', 300],
     //            ['New Jersey', 'United States', 300],

     //            ['New Mexico', 'United States', 300],
     //            ['New York', 'United States', 300],
     //            ['North Carolina', 'United States', 300],
     //            ['North Dakota', 'United States', 300],
     //            ['Ohio', 'United States', 300],

     //            ['Oklahoma', 'United States', 300],
     //            ['Oregon', 'United States', 300],
     //            ['Pennsylvania', 'United States', 300],
     //            ['Rhode Island', 'United States', 300],
     //            ['South Carolina', 'United States', 300],

     //            ['South Dakota', 'United States', 300],
     //            ['Tennessee', 'United States', 300],
     //            ['Texas', 'United States', 300],
     //            ['Utah', 'United States', 300],
     //            ['Vermont', 'United States', 300],

     //            ['Washington', 'United States', 300],
     //            ['West Virginia', 'United States', 300],
     //            ['Wisconsin', 'United States', 300],
     //            ['Wyoming', 'United States', 300]


</script> 
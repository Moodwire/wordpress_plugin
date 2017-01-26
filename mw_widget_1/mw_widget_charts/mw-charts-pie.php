<script>

//-------- PIE -------- PIE -------- PIE -------- PIE -------- PIE -------- PIE -------- PIE -------- PIE

    function drawPie(json, json_length) {

        for (var i = 0; i < json_length; i++){
            var name = json[i]['name'];
                // name = name.toString();
            var pos = json[i]['positives'];
            var neg = json[i]['negatives'];
            var neu = json[i]['neutrals'];
            // console.log(i, pos, neg, neu);            
            var mw_sum = pos + neg + neu;

       var data = google.visualization.arrayToDataTable([
            ['Mood', 'Percentage'],
            ['Positive',     Math.round((pos/mw_sum) * 100)],
            ['Negative',      Math.round((neg/mw_sum) * 100)],
            ['Neutral',  Math.round((neu/mw_sum) * 100)]
        ]);

        var options = { title: name,
            slices: {0: {color: 'green'}, 1:{color: 'red'}, 2:{color: 'blue'}} };
        var pie = new google.visualization.PieChart(document.getElementById('mini_pie_div' + i));
        pie.draw(data, options); 
        
        };
    };//--------    --------    --------    --------    --------

</script> 

<style>
/*	THE PIE CHARTS	*/

	#pie_div {
		display: inline-block;
		vertical-align: top;
		margin: 0 auto;
		/*width: 49%;*/
		/*border: 1px solid green;*/
	}
	.mini_pie_div {
		width: 300px !important;
		height: 200px !important;
		display: inline-block !important;
		margin: 0 auto;
		vertical-align: top;
	}
	.mini_pie_div div div div svg rect {																			/*	inner div	*/
		/*fill: black;*/
		margin: 0px 50px;
	}
	.mini_pie_div div div div svg g text {																			/*	pie chart text	*/
		/*fill: red;*/
		font-size: 1em;
	}
</style>
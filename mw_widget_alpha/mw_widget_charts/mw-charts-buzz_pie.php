<script>

//-------- BUZZ PIE -------- BUZZ PIE -------- BUZZ PIE -------- BUZZ PIE -------- BUZZ PIE -------- BUZZ PIE -------- BUZZ PIE -------- BUZZ PIE

    function drawBuzzPie(json, json_length) {

    	var buzz_total = 0;
    	var buzz = 0;
    	
    	var data = new google.visualization.DataTable();
    	data.addColumn('string', 'Name');
    	data.addColumn('number', 'Value');

    	for (var i = 0; i < json_length; i++) { buzz_total += json[i]['buzz']; };

        for (var i = 0; i < json_length; i++){
            var name = json[i]['name'];
                name = name.toString();
            var buzz = json[i]['buzz'];

        	data.addRows([
        		[name, Math.round((buzz/buzz_total) * 100)],
        	]);
		};

		var options = { title: 'BUZZ',
            slices: {0: {color: 'green'}, 1:{color: 'red'}, 2:{color: 'blue'}, 3:{color: 'purple'}} };

		var buzz_pie = new google.visualization.PieChart(document.getElementById('pie_buzz_div'));
        buzz_pie.draw(data, options); 
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
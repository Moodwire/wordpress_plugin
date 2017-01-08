<script>

//-------- GAUGE -------- GAUGE -------- GAUGE -------- GAUGE -------- GAUGE -------- GAUGE -------- GAUGE -------- GAUGE
// google.charts.load('current', {'packages':'gauge'});

    function drawGauge(json, json_length) {

        for (var i = 0; i < json_length; i++) {
            var value = hf.moodRanged(json[i]['positives'], json[i]['negatives'], json[i]['neutrals']);
            var name = json[i]['name'];
            var data = new google.visualization.arrayToDataTable([
                ['Label', 'Value'],
                [name, value]
            ]);

        var gauge_options = {                                                                   //--    sets the gauge options/colors
            max: 100, min: -100,
            redFrom: -100, redTo: -50,
            yellowFrom: -49, yellowTo: 0,
            greenFrom: 1, greenTo: 100,
            minorTicks: 5
        };
        
        var gauge = new google.visualization.Gauge(document.getElementById('mini_gauge_div' + i));
        gauge.draw(data, gauge_options);

        };
    };//--------    --------    --------    --------    --------

</script> 

<style>
/*	THE GAUGE CHARTS	*/

	#gauge_div {
		display: inline-block;
		vertical-align: top;
		margin: 0 auto;
		/*width: 49%;*/
		/*border: 1px solid red;*/
	}
	.mini_gauge_div {
		width: 200px !important;
		height: 200px !important;
		display: inline-block !important;
		margin: 0px 50px;
		vertical-align: top;
	}
	.mini_gauge_div table {
		border: 0px;
		padding: 0px;
	}
	.mini_gauge_div table tbody tr {
		border: 0px;
		padding: 0px;
	}
	.mini_gauge_div table tbody tr td {
		width: 200px !important;
		height: 200px !important;
		overflow: visible !important;
		border: 0px;
		padding: 0px;
		margin: 0px;
	}
	.mini_gauge_div table tbody tr td div {																		/*	OuterMOST of the GAUGE PERIMETER	*/
		position: relative;
		word-break: break-all;
		overflow: visible !important;
	}
	.mini_gauge_div table tbody tr td div div {																	/*	MiddleMOST OF THE GAUGE PERIMETER	*/
		position: relative;
		overflow: visible !important;
	}
	.mini_gauge_div table tbody tr td div div div {																/*	InnerMOST OF THE GAUGE PERIMETER	*/
		position: absolute;
		overflow: visible !important;
		left: 0px;
		top: 0px;
	}
	.mini_gauge_div table tbody tr td div div div svg {															/*	ENCASES THE ENTIRE GAUGE	*/
		overflow: visible !important;
		display: inline-block;
		word-break: break-all;
		white-space: normal;
	}
	.mini_gauge_div table tbody tr td div div div svg g {
		overflow: visible !important;
		word-break: break-all;
	}
	.mini_gauge_div table tbody tr td div div div svg g text {
		width: 40%;
		overflow: visible !important;
	}
	/*.mini_gauge_div table tbody tr td div div div svg g text*/												/*	INNER TEXT(ALL) OF GAUGE	*/
	.mini_gauge_div table tbody tr td div div div svg g text[text-anchor=middle] {								/*	INNER Title and value OF GAUGE	*/
		fill: black;
		z-index: 1;
		overflow: visible !important;
	}
	.mini_gauge_div table tbody tr td div div div svg g text[text-anchor=start] {								/*	INNER -100 OF GAUGE	*/
		fill: red;
	}
	.mini_gauge_div table tbody tr td div div div svg g text[text-anchor=end] {									/*	INNER 100 OF GAUGE	*/
		fill: green;
	}
</style>
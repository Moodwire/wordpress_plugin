<script>

	function mw_call_count(apikey) {
		
		var call_call = "https://api.moodwire.net/v2.0/access-calls-left/" + apikey;
		console.log('api key', call_call);
		$.get(call_call, function(data, status='success') {
			alert("You have " + data['results'][0]['calls_left'] + " calls remaining");
		});
	};//--------	--------	--------	--------	--------

</script>
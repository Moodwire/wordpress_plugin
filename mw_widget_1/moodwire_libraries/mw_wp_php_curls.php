<?php
// phpinfo();

    /** 
    * Send a POST requst using cURL requires PHP5.4+ & PHP curl to be installed
    * @param string $url to request 
    * @param array $post values to send 
    * @param array $options for cURL 
    * @return string 
    */ 

function process_options($options, $api, $x, $apikey) {
	$baseurl = 'https://api.moodwire.net/v2.0';
    $url = '?limit=' . $x;
    $url = $baseurl . $api . $apikey . $url;

 	if (strlen($options[3]) != 0 && strlen($options[5]) == 0) { 
		$url = $url . '&include_text=' . $options[3];
	} else {
		$url = $url . '&include_text=news';
	}

	if (strlen($options[5]) != 0) { 
		$url = $url . '&entities=' . $options[5];		
	}

    if (strlen($options[15]) != 0) { 
		$url = $url . '&source_uuid=' . $options[15];		
	}

	if (strlen($options[24]) != 0) { 
		$url = $url . '&exclude_text=' . $options[24];		
	}

    $url = $url . '&start=' . $options[12] . '&end=' . $options[13];

    return $url;

    };//--------	--------	--------	--------	--------

function default_options($options, $api, $x, $apikey) {
	$baseurl = 'https://api.moodwire.net/v2.0';
    $url = '?limit=' . $x;
    $url = $baseurl . $api . $apikey . $url;
 	
	$url = $url . '&include_text=news';

    $url = $url . '&start=' . $options[12] . '&end=' . $options[13];

    return $url;

};//--------	--------	--------	--------	--------


function curl_articles($options, $x, $apikey) { 
	$api = '/articles/';
	$url = process_options($options, $api, $x, $apikey);

	echo '<script>$(".mw_alert").remove();</script>';

	$result = wp_remote_get($url, array( 'timeout' => 120));
	$result = json_decode($result['body']);
	$test_count = $result->results_count;


	if ($test_count == 0) {																		//--	if no articles are returned, a full default pull is made

		$url = default_options($options, $api, $x, $apikey);
		$result = wp_remote_get($url, array( 'timeout' => 120));

		echo '<div class="mw_alert alert alert-danger alert-dismissible">'
    			. '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
   				. "<p>Your parameters returned <span style='color:red'>no articles.</p>"
				. "<p>A default search has taken place and returned news articles.</p>"
				. "<p>You may want to try revising your searches.</p>"
				. "<p>You can do this in the <strong>'FILTERS'</strong> section.</p>"
    			. '</div>';
    	$result = $result['body'];
    	$result = json_decode($result);
    	$result = $result->results;

		return $result;
	}


	if ($test_count < $x) {																		//--	if < $x is returned, default articles top of the amount of articles

		$diff = $x - $test_count;
		$url = default_options($options, $api, $diff, $apikey);
		$top_off = wp_remote_get($url, array( 'timeout' => 120));
		$top_off = $top_off['body'];
		$top_off = json_decode($top_off);
		$top_off = $top_off->results;
		$result = $result->results;

		echo '<div class="mw_alert alert alert-warning alert-dismissible">'
    			. '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
   				. "<p>Your parameters did not return " . $x . " articles.<br>We have pulled additional articles to top off your api call.</p>"
    			. '</div>';

		$b = 0;
		for ($a = $diff; $a < $x; $a++) {
			$result[$a] = $top_off[$b];
			$b++;
		}

		return $result;
	} 

	$result = $result->results;
	echo '<div class="mw_alert alert alert-success alert-dismissible">'
    			. '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
   				. "<p>Congrats...<br>Your 'FILTERS' parameters returned plenty of articles.</p>"
    			. '</div>';

	return $result;
};//--------	--------	--------	--------	--------


function default_chart_curl($apikey) {

	$url = "https://api.moodwire.net/v2.0/summary/" . $apikey . "?entities=5446b7824f7a47273096f262&return_empty_intervals=true&intervals=21&freq=daily";

	$result = wp_remote_get($url, array( 'timeout' => 120));
	
	$result = $result['body'];
	$result = json_decode($result);
	$result = $result->results;	

	$ccc = array();																														//--	this will create array with ids for later filter functions
	$ccc['entity_cache'] = '5446b7824f7a47273096f262';
	$result = (object) array_merge((array)$result, (array)$ccc);

	return $result;
};//--------	--------	--------	--------	--------


function curl_interval_data($apikey, $chart_builder) {
	$x = define_mw_limiter($chart_builder[5]);
	$mw_end_date = get_current_day_php_format();
	$mw_end_date = '&end=' . $mw_end_date;
	$intervals = '&intervals=21&freq=daily&return_empty_intervals=true';
	$summary_cache = explode(',', $chart_builder[5]);

	if ($chart_builder[5] === '') { 
		$additional = '?&entities=5446b7824f7a47273096f262'; 
		$url = "https://api.moodwire.net/v2.0/summary/" . $apikey . $additional . $intervals;
		$result = wp_remote_get($url, array( 'timeout' => 120));
		$result = $result['body'];
		$result = json_decode($result);
		$result = $result->results;

		$ccc = array();																													//--	this will create array with ids for later filter functions
		$ccc['entity_cache'] = '5446b7824f7a47273096f262';
		$result = (object) array_merge((array)$result, (array)$ccc);

	} else if ($x < 5) { 
		$additional = "?entities=" . $chart_builder[5];
		$url = "https://api.moodwire.net/v2.0/summary/" . $apikey . $additional . $intervals;
		$result = wp_remote_get($url, array( 'timeout' => 120));
		$result = $result['body'];
		$result = json_decode($result);
		$result = $result->results;

		$ccc = array();																													//--	this will create array with ids for later filter functions
		$ccc['entity_cache'] = $summary_cache;
		$result = (object) array_merge((array)$result, (array)$ccc);
		
	} else {
		$k = 0;
		$result = new stdClass();
		while ( $k < $x ) {		
//	----	----	START OF WHILE LOOP 	----	----
			$cache_call = '';
			if ( $k < $x )	 			{ $cache_call = $cache_call . $summary_cache[$k] . ','; }
			if ( ($k + 1) < $x)			{ $cache_call = $cache_call . $summary_cache[$k + 1] . ','; }
			if ( ($k + 2) < $x)			{ $cache_call = $cache_call . $summary_cache[$k + 2] . ','; }
			if ( ($k + 3) < $x)			{ $cache_call = $cache_call . $summary_cache[$k + 3] . ','; }									
			$cache_call = trim($cache_call, ',');
			$cache_call = '?&entities=' . $cache_call;
			$url = "https://api.moodwire.net/v2.0/summary/" . $apikey . $cache_call . $intervals;
// var_dump($url);

			$results_cache = wp_remote_get($url, array( 'timeout' => 120));
			$results_cache = $results_cache['body'];
			$results_cache = json_decode($results_cache);
			$results_cache = $results_cache->results;
			$result = (object) array_merge_recursive((array)$result, (array)$results_cache);											//--	compiles various calls (merges the objects)
			$k += 4;
		}						
//	----	----	END OF WHILE LOOP 	----	----
		$ccc = array();																													//--	this will create array with ids for later filter functions
		$ccc['entity_cache'] = $summary_cache;
		$result = (object) array_merge((array)$result, (array)$ccc);
	}

	if (is_wp_error($result)) {
		$result = default_chart_curl($apikey);
		echo '<script>alert("Sorry, \n there is no data available for this/these entities.");</script>';
	}

	return $result;

};//--------	--------	--------	--------	--------


function curl_location_data($apikey, $results) {
$default_values = '&freq=daily&intervals=1&return_empty_intervals=true';
	if ($results[5] === '') {
	$result = wp_remote_get('https://api.moodwire.net/v2.0/location/' . $apikey . '?by_children=53fb789c451ea02e52b8d6c7&entities=5516321c9b724739f3649835,55166a299b724739f364f02c' . $default_values, array( 'timeout' => 120));
	} else {
		$entities = "&entities=" . $results[5];
		$result = wp_remote_get("https://api.moodwire.net/v2.0/location/" . $apikey . "?by_children=53fb789c451ea02e52b8d6c7" . $entities . $default_values, array( 'timeout' => 120));
	}
	$result = $result['body'];
	$result = json_decode($result);
	$result = $result->results;

	return $result;

};//--------	--------	--------	--------	--------


function curl_word_cloud_data($apikey, $results, $limit_charts) {

	$compiled_word_cloud_array = array();
	$word_uuid_array = explode(',', $results[5]);
	$word_name_array = explode(',', $results[4]);
	$count = 0;
	$top_n = 25;																							//  going to be used to sync and filter out null data in mw_filter_null_to_0();

	if ($results[5] === '') {
		$result = wp_remote_get('https://api.moodwire.net/v2.0/entity-words/' . $apikey . '?entities=5576d41f9b72472aeedac84e&top_n=' . $top_n . '&aggregate=true', array( 'timeout' => 120));
		$result = $result['body'];
		$result = json_decode($result);
		$result = $result->results;
	} else {
		foreach ($word_uuid_array as $word_id) {
			$result = wp_remote_get('https://api.moodwire.net/v2.0/entity-words/' . $apikey . '?entities=' . $word_id . '&top_n=' . $top_n . '&aggregate=true', array( 'timeout' => 120));
			$result = $result['body'];
			
			// if ($result == '[]') { echo 'nope'; die();};
			
			$result = json_decode($result);
			$result = $result->results;
  
			if (empty($result)) 			{$result = mw_filter_null_to_0($result, $top_n, 0); };						//  takes care of an empty/null JSON object
			if (count($result) < $top_n) 	{$result = mw_filter_null_to_0($result, $top_n, count($result)); };			//  fills out the rest of the word cloud object in db

			$result['word_uuid'] = $word_id;
			$result['word_name'] = $word_name_array[$count];
			$count++;
			array_push($compiled_word_cloud_array, json_encode($result));
		}
		
	}
	
	return $compiled_word_cloud_array;

};//--------	--------	--------	--------	--------


?>
<?php

function process_pills($x) {																		//--------		CREATES PILLS FROM DB ON PAGE LOAD
	if ($x == NULL) {return $x;}
	$x = array_unique($x);
	$x = array_filter($x, function($x) {return $x !== "";});
	$string_from_array = implode(',', $x);
	
	return $string_from_array;
};//--------	--------	--------	--------	--------


function mw_date_filter($results) {																	//--------		PREVENTS FUTURE DATES, AND CREATES DATES 30 BACK(if needed)
	$today_date = get_current_day_php_format();
	$date_end = strtotime($results[13]);
	if ($results[13] === '0000-00-00') 	{ $results[13] = $today_date;};								//--	creates an end date (today), if it doesn't exist
	if ($date_end > $today_date) { $results[13] = $today_date;};									//--	prevents end date from searching in the future, doesn't alter db entry
							
	if ($results[12] === '0000-00-00' && isset($results[13])) { 									//--	creates a search for 30 days ago, if no date is specified
		$the_end = date_create($results[13]);
		$results[12] = date_modify($the_end, "-30 days");
		$results[12] = date_format($results[12], "Y-m-d");
	};

	return $results;
};//--------	--------	--------	--------	--------


function convert_mqsql_data_to_json_for_javascript($articles) {
	$articles = json_decode($articles);

	return $articles;
};//--------	--------	--------	--------	--------


function refine_mw_data_object($object) {															//--------		TAKES ALL DATA AND CREATES A 'CLEAN' OBJECT FOR LATER USE
	$m = strtotime($object->article_date);
	$formatted_date = date("Y-m-d", $m);

	$refined_object = new stdClass();
	$refined_object->article_body = $object->article_body;
	$refined_object->article_date = $formatted_date;
	$refined_object->article_title = $object->article_title;
	$refined_object->uuid = $object->id;
	$refined_object->images = $object->images;
	$refined_object->scores = $object->scores;
	$refined_object->source = $object->source;
	$refined_object->url = $object->url;

	return $refined_object;
};//--------	--------	--------	--------	--------


// function mw_plugin_deactivated_and_daily_db_update_cleared() {
// 	wp_clear_scheduled_hook('mw_daily_event');

// 	return;
// };//--------	--------	--------	--------	--------


function define_mw_limiter($limiter) {																//--------		CREATES A COUNT TO LIMIT NUMBER OF ENTITIES
	$limiter = explode(',', $limiter);
	$limiter = count($limiter);

	return $limiter;
};//--------	--------	--------	--------	--------


function get_current_day_php_format() {																//--------		GETS TODAYS DATE
	$today_date = date('Y-m-d');																	
	$today_date_string = strtotime($today_date);

	return $today_date;
};//--------	--------	--------	--------	--------


function moodwire_refine_location_data($location_data, $limit_locations, $uuid) {					//--------		TAKES LOCATION DATA AND PROCESSES IT FOR USE

	$uuid = explode(',', $uuid);
	$count = $limit_locations * 50;

	if ($limit_locations == 1) { 																	//--	compiles array if only one entity is listed
		$k = 0;
		$new_array = array();
		while ($k < $count) {
			array_push($new_array, $location_data[$b]); 
			$k++;
		};
		return $new_array;
	};

	for ($a = 0; $a < $limit_locations; $a++) {														//--	sorts and compiles multiple entities
		$new_array[$a] = array();
	
		for ($b = 0; $b < $count; $b++) {
				if (strnatcmp($location_data[$b]->entity_id, $uuid[$a])) {
					array_push($new_array[$a], $location_data[$b]);
				}
		}
	}

	return $new_array;
};//--------	--------	--------	--------	--------


function mw_run_filter_and_sort($chart_data) {

	$new_array = array();
	for ($a = 0; $a < $chart_data['limiter']; $a++) {												//--	NEED TO DO -1 BECAUSE IT COUNTS ['LIMITER'] IN THE OVERALL NUMBER, THROWS ERROR
		array_push($new_array, array($chart_data[$a]->entity_id));
	}

	$m = count($new_array);

	foreach($chart_data as $data) {
		for ($k = 0; $k < $m; $k++) {
			if (is_object($data)) {
				if (strcmp($data->entity_id, $new_array[$k][0]) == 0) {
					array_push($new_array[$k], $data);
				}
			};
		}
	}

	return $new_array;
};//--------	--------	--------	--------	--------


function mw_process_post_data($data) {																//--------		TAKES THE DATA AND CREATES PILLS/CONVERTS DATA									

	if (isset($data['filter_params'])) {
		$data['filter_params'] = 	process_pills($data['filter_params']);
		$data['filter_params'] = 	preg_replace('/\s+/', '%20', $data['filter_params']);			//--	NECESSARY FOR PROPER UPDATE OF DB
	}

	if (isset($data['chart_names'])) {
		$data['chart_names'] = 		str_replace('"', '%22', $data['chart_names']);
		$data['chart_names'] = 		str_replace("'", '%27', $data['chart_names']);
		$data['chart_names'] = 		process_pills($data['chart_names']);
	} else {
		$data['chart_names'] = '';
	}

	if (isset($data['chart_params'])) {
		$data['chart_params'] = 	process_pills($data['chart_params']);
	} else {
		$data['chart_params'] = '';
	}
		
	if (isset($data['source_names'])) {
		$data['source_names'] =	 	process_pills($data['source_names']);
	} else {
		$data['source_names'] = '';	
	}

	if (isset($data['source_params'])) {
		$data['source_params'] = 	process_pills($data['source_params']);
	} else {
		$data['source_params'] = '';
	}

	if (isset($data['exclude_params'])) {
		$data['exclude_params'] = 	process_pills($data['exclude_params']);
		$data['exclude_params'] = 	preg_replace('/\s+/', '%20', $data['exclude_params']);			//--	NECESSARY FOR PROPER UPDATE OF DB
	}
//-----------------------------------------------------------------------------------
	if(!isset($data['mw_images'])) 			{ $data['mw_images'] = 'off';}
	if(!isset($data['mw_assoc'])) 			{ $data['mw_assoc'] = 'off';}
	if(!isset($data['mw_border'])) 			{ $data['mw_border'] = 'off';}
	
	$data['options'] = mw_create_options( $data['mw_images'], $data['mw_assoc'], $data['mw_border'] );
	
	// var_dump($data['options']);
	// die();
//-----------------------------------------------------------------------------------
	if(!isset($data['gauge_charts'])) 		{ $data['gauge_charts'] = 'off';}
		$data['gauge_charts'] = mw_process_chart($data['gauge_charts'], $data['mw_gauge_size'], $data['mw_gauge_colors']);

	if(!isset($data['buzz_pie_charts'])) 	{ $data['buzz_pie_charts'] = 'off';}
		$data['buzz_pie_charts'] = mw_process_chart($data['buzz_pie_charts'], $data['mw_buzz_pie_size'], $data['mw_buzz_pie_colors']);

	if(!isset($data['pie_charts'])) 		{ $data['pie_charts'] = 'off';}
		$data['pie_charts'] = mw_process_chart($data['pie_charts'], $data['mw_pie_charts_size'], $data['mw_pie_charts_colors']);
	
	if(!isset($data['bar_charts'])) 		{ $data['bar_charts'] = 'off';}
		$data['bar_charts'] = mw_process_chart($data['bar_charts'], $data['mw_bar_size'], $data['mw_bar_colors']);
	
	if(!isset($data['line_charts'])) 		{ $data['line_charts'] = 'off';}
		$data['line_charts'] = mw_process_chart($data['line_charts'], $data['mw_line_size'], $data['mw_line_colors']);

	if(!isset($data['scatter_charts'])) 	{ $data['scatter_charts'] = 'off';}
		$data['scatter_charts'] = mw_process_chart($data['scatter_charts'], $data['mw_scatter_size'], $data['mw_scatter_colors']);

	if(!isset($data['treemap_charts'])) 	{ $data['treemap_charts'] = 'off';}
		$data['treemap_charts'] = mw_process_chart($data['treemap_charts'], $data['mw_treemap_size'], $data['mw_treemap_colors']);

	if(!isset($data['stacked_bar_charts'])) { $data['stacked_bar_charts'] = 'off';}
		$data['stacked_bar_charts'] = mw_process_chart($data['stacked_bar_charts'], $data['mw_stacked_size'], $data['mw_stacked_colors']);

	if(!isset($data['trend_line_charts'])) 	{ $data['trend_line_charts'] = 'off';}
		$data['trend_line_charts'] = mw_process_chart($data['trend_line_charts'], $data['mw_trend_size'], $data['mw_trend_colors']);

	// if(!isset($data['calendar_charts'])) 	{ $data['calendar_charts'] = 'off';}
	// 	$data['calendar_charts'] = mw_process_chart($data['calendar_charts'], $data['mw_calendar_size'], $data['mw_calendar_colors']);

	if(!isset($data['bubble_charts'])) 		{ $data['bubble_charts'] = 'off';}
		$data['bubble_charts'] = mw_process_chart($data['bubble_charts'], $data['mw_bubble_size'], $data['mw_bubble_colors']);

	// if(!isset($data['location_charts'])) 	{ $data['location_charts'] = 'off';}
	// 	$data['location_charts'] = mw_process_chart($data['location_charts'], $data['mw_location_size'], $data['mw_location_colors']);

	if(!isset($data['word_cloud_charts'])) 	{ $data['word_cloud_charts'] = 'off';}
		$data['word_cloud_charts'] = mw_process_chart($data['word_cloud_charts'], $data['mw_word_size'], $data['mw_word_colors']);


	return $data;
};//--------	--------	--------	--------	--------


function mw_process_chart($status, $size, $colors) {										//--------		CREATE A NEW OBJECT AND CONVER IT TO A STRING
	$processed_chart_data = new stdClass();
	$processed_chart_data->status = $status;
	$processed_chart_data->size = $size;
	$processed_chart_data->colors = $colors;
	$processed_chart_data = json_encode($processed_chart_data);

	return $processed_chart_data;
};//--------	--------	--------	--------	--------


function mw_create_options($images, $assoc, $border) {
	$mw_obj = new stdClass();
	$mw_obj->mw_images = $images;
	$mw_obj->mw_assoc = $assoc;
	$mw_obj->mw_border = $border;
	$mw_obj = json_encode($mw_obj);
	
	return $mw_obj;
};//--------	--------	--------	--------	--------


function mw_string_to_object_results($data) {												//--------		MAKES DATA STRING INTO MULTIPLE OBJECTS
// var_dump($data);
	$data[6] = json_decode($data[6]);
	$data[7] = json_decode($data[7]);
	$data[8] = json_decode($data[8]);
	$data[9] = json_decode($data[9]);
	$data[10] = json_decode($data[10]);
	$data[11] = json_decode($data[11]);

	$data[16] = json_decode($data[16]);
	$data[17] = json_decode($data[17]);
	$data[18] = json_decode($data[18]);
	$data[19] = json_decode($data[19]);
	// $data[20] = json_decode($data[20]);
	$data[21] = json_decode($data[21]);
	// $data[22] = json_decode($data[22]);
	$data[23] = json_decode($data[23]);

// var_dump($data);

	return $data;
};//--------	--------	--------	--------	--------


function mw_filter_null_to_0($data, $size, $count) {										//--------		IF ANY DATA IS NULL IT WILL BE REPLACED WITH 0 FOR THE WORD COUNT CHART TO WORK
	$diff = $size - $count;
	
	if ($count == 0) { $diff = 0;};															//--  this ensures that count will start at 0 with an empty array
	
	$empty_obj = new stdClass();
		$empty_obj->count = 0;
		$empty_obj->word = ' ';

	for ($diff = $diff; $diff < $size; $diff++) {
		$data[$diff] = $empty_obj;
	}

	return $data;
};//--------	--------	--------	--------	--------


function mw_select_charts($data) {															//--------		MAKES AN OBJECT WITH ON/OFF CHART SELECTORS
	
	$data = (object) [
		'gauge_charts' => 		json_decode($data[6])->status,
		'buzz_pie_charts' => 	json_decode($data[7])->status,
		'pie_charts' => 		json_decode($data[8])->status,
		'bar_charts' => 		json_decode($data[9])->status,
		'line_charts' => 		json_decode($data[10])->status,

		'scatter_charts' => 	json_decode($data[16])->status,
		'treemap_charts' => 	json_decode($data[17])->status,
		'stacked_bar_charts' => json_decode($data[18])->status,
		'trend_line_charts' => 	json_decode($data[19])->status,

		'bubble_charts' => 		json_decode($data[21])->status,
		'word_cloud_charts' => 	json_decode($data[23])->status
	];

	return $data;
};//--------	--------	--------	--------	--------


?>
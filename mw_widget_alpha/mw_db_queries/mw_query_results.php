<?php

global $wpdb;

global $table_name;
$table_name = $wpdb->prefix . 'mw_news_sentiment_db_table_v_1_0';


function moodwire_database_table_install() {														//--------		THIS WILL CREATE THE DATABASE TABLE									
	global $wpdb;
	global $table_name;

	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		-- time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		total int(3) NOT NULL,
		title_name VARCHAR(255) NOT NULL,
		filter_params text NOT NULL,
		chart_names text NOT NULL,
		chart_params text NOT NULL,
		gauge_charts VARCHAR(255) NOT NULL,
		buzz_pie_charts VARCHAR(255) NOT NULL,
		pie_charts VARCHAR(255) NOT NULL,
		bar_charts VARCHAR(255) NOT NULL,
		line_charts VARCHAR(255) NOT NULL,
		options VARCHAR(255) NOT NULL,
		mw_date_start  date NOT NULL default '0000-00-00',
		mw_date_end  date NOT NULL default '0000-00-00',
		source_names text NOT NULL,
		source_params text NOT NULL,
		scatter_charts VARCHAR(255) NOT NULL,
		treemap_charts VARCHAR(255) NOT NULL,
		stacked_bar_charts VARCHAR(255) NOT NULL,
		trend_line_charts VARCHAR(255) NOT NULL,
		calendar_charts VARCHAR(255) NOT NULL,
		bubble_charts VARCHAR(255) NOT NULL,
		location_charts VARCHAR(255) NOT NULL,
		word_cloud_charts VARCHAR(255) NOT NULL,
		exclude_params text NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	return $table_name;
};//--------	--------	--------	--------	--------					


function pull_from_mw_db_table() {																	//--------		PULL FROM TABLE ON PAGE LOAD
	global $wpdb;
	global $table_name;
	// $find_mw = 1;
	// $sql_query = $wpdb->get_results("SELECT id FROM $table_name ORDER BY id DESC LIMIT 1", ARRAY_N );
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
		moodwire_database_table_install();
		$default_data = array(
			// 'time' => date('Y-m-d H:i:s'),
			'total' => 5,
			// 'time' => date('Y-m-d H:i:s'),
			'title_name' => "Moody news",
			'filter_params' => "",
			'gauge_charts' => '{"status":"off","size":"small","colors":"default"}',
			'buzz_pie_charts' => '{"status":"off","size":"small","colors":"default"}',
			'pie_charts' => '{"status":"off","size":"small","colors":"default"}',
			'bar_charts' => '{"status":"off","size":"small","colors":"default"}',
			'line_charts' => '{"status":"off","size":"small","colors":"default"}',
			'options' => '{"mw_images":"on","mw_assoc":"off","mw_border":"on"}',
			'mw_date_start' => '',
			'mw_date_end' => '',
			'chart_names' => '',
			'chart_params' => '',
			'scatter_charts' => '{"status":"off","size":"small","colors":"default"}',
			'treemap_charts' => '{"status":"off","size":"small","colors":"default"}',
			'stacked_bar_charts' => '{"status":"off","size":"small","colors":"default"}',
			'trend_line_charts' => '{"status":"off","size":"small","colors":"default"}',
			'calendar_charts' => 'off',
			'bubble_charts' => '{"status":"off","size":"small","colors":"default"}',
			'location_charts' => 'off',
			'word_cloud_charts' => '{"status":"off","size":"small","colors":"default"}',
			'exclude_params' => ''
			);
		$wpdb->insert( $table_name, $default_data );
	}
	// if ( $sql_query == FALSE ) {																	//--	if table does not exist, it will create the table in the wp DB
	// 	moodwire_database_table_install();
	// 	$default_data = array(
	// 		// 'time' => date('Y-m-d H:i:s'),
	// 		'total' => 5,
	// 		// 'time' => date('Y-m-d H:i:s'),
	// 		'title_name' => "Moody news",
	// 		'filter_params' => "news",
	// 		'gauge_charts' => 'on',
	// 		'buzz_pie_charts' => 'on',
	// 		'pie_charts' => 'on',
	// 		'bar_charts' => 'on',
	// 		'line_charts' => 'on',
	// 		'tile_view' => 'on',
	// 		'mw_date_start' => '',
	// 		'mw_date_end' => '',
	// 		'chart_names' => 'United States of America',
	// 		'chart_params' => '539210135f260eaca93b3870',
	// 		'scatter_charts' => 'on',
	// 		'treemap_charts' => 'on',
	// 		'stacked_bar_charts' => 'on',
	// 		'trend_line_charts' => 'on',
	// 		'calendar_charts' => 'on',
	// 		'bubble_charts' => 'on',
	// 		'location_charts' => 'on'
	// 		);
	// 	$wpdb->insert( $table_name, $default_data );
		
	// 	// $sql_query = $wpdb->get_results("SELECT id FROM $table_name ORDER BY id DESC LIMIT 1", ARRAY_N );
	// }
	// $sql_query = $wpdb->get_results($wpdb->prepare( "SELECT id FROM $table_name ORDER BY id DESC LIMIT %d", $find_mw), ARRAY_N );
	$sql_query = $wpdb->get_results("SELECT id FROM $table_name ORDER BY id DESC LIMIT 1", ARRAY_N );
	if ( $sql_query === 0 ) {
		$default_data = array(
			// 'time' => date('Y-m-d H:i:s'),
			'total' => 5,
			// 'time' => date('Y-m-d H:i:s'),
			'title_name' => "Moody news",
			'filter_params' => "",
			'gauge_charts' => '{"status":"off","size":"small","colors":"default"}',
			'buzz_pie_charts' => '{"status":"off","size":"small","colors":"default"}',
			'pie_charts' => '{"status":"off","size":"small","colors":"default"}',
			'bar_charts' => '{"status":"off","size":"small","colors":"default"}',
			'line_charts' => '{"status":"off","size":"small","colors":"default"}',
			'options' => '{"mw_images":"on","mw_assoc":"off","mw_border":"on"}',
			'mw_date_start' => '',
			'mw_date_end' => '',
			'chart_names' => '',
			'chart_params' => '',
			'scatter_charts' => '{"status":"off","size":"small","colors":"default"}',
			'treemap_charts' => '{"status":"off","size":"small","colors":"default"}',
			'stacked_bar_charts' => '{"status":"off","size":"small","colors":"default"}',
			'trend_line_charts' => '{"status":"off","size":"small","colors":"default"}',
			'calendar_charts' => 'off',
			'bubble_charts' => '{"status":"off","size":"small","colors":"default"}',
			'location_charts' => 'off',
			'word_cloud_charts' => '{"status":"off","size":"small","colors":"default"}',
			'exclude_params' => ''
			);
		$wpdb->insert( $table_name, $default_data );
	}	
	$sql_query = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id DESC LIMIT 1", ARRAY_N );
	// $sql_query = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY id DESC", ARRAY_N );
	// $sql_query = $wpdb->query("SELECT * FROM $table_name ORDER BY id DESC", ARRAY_N );
	// $sql_query = $sql_query[0];
	return $sql_query[0];
};//--------	--------	--------	--------	--------


function insert_into_wp_mw_db_table($mw) {															//--------		INSERTS DATA INTO DB
	global $wpdb;
	global $table_name;

	$total = $mw['total'];
	$title_name = $mw['title_name'];
	$filter_params = $mw['filter_params'];
	$source_names = $mw['source_names'];
	$source_params = $mw['source_params'];

	$gauge_charts = $mw['gauge_charts'];
	$buzz_pie_charts = $mw['buzz_pie_charts'];
	$pie_charts = $mw['pie_charts'];
	$bar_charts = $mw['bar_charts'];
	$line_charts = $mw['line_charts'];
	$options = $mw['options'];

	$mw_date_start = $mw['mw_date_start'];
	$mw_date_end = $mw['mw_date_end'];

	$chart_names = $mw['chart_names'];
	$chart_params = $mw['chart_params'];

	$scatter_charts = $mw['scatter_charts'];
	$treemap_charts = $mw['treemap_charts'];
	$stacked_bar_charts = $mw['stacked_bar_charts'];
	$trend_line_charts = $mw['trend_line_charts'];
	// $calendar_charts = $mw['calendar_charts'];
	$bubble_charts = $mw['bubble_charts'];
	// $location_charts = $mw['location_charts'];
	$word_cloud_charts = $mw['word_cloud_charts'];

	$exclude_params = $mw['exclude_params'];

// var_dump($mw['chart_params']);
// var_dump($mw['chart_names']);

	// if(!isset($gauge_charts)) 		{ $gauge_charts = 'off';}
	// if(!isset($buzz_pie_charts)) 	{ $buzz_pie_charts = 'off';}
	// if(!isset($pie_charts)) 		{ $pie_charts = 'off';}
	// if(!isset($bar_charts)) 		{ $bar_charts = 'off';}
	// if(!isset($line_charts)) 		{ $line_charts = 'off';}
	// if(!isset($tile_view)) 			{ $tile_view = 'off';}
	// if(!isset($scatter_charts)) 	{ $scatter_charts = 'off';}
	// if(!isset($treemap_charts)) 	{ $treemap_charts = 'off';}
	// if(!isset($stacked_bar_charts)) { $stacked_bar_charts = 'off';}
	// if(!isset($trend_line_charts)) 	{ $trend_line_charts = 'off';}
	if(!isset($calendar_charts)) 	{ $calendar_charts = 'off';}
	// if(!isset($bubble_charts)) 		{ $bubble_charts = 'off';}
	if(!isset($location_charts)) 	{ $location_charts = 'off';}
	// if(!isset($word_cloud_charts)) 	{ $word_cloud_charts = 'off';}
	// if(!isset($exclude_params)) 	{ $exclude_params = 'off';}

	$mw_updated_data = array(
		// 'time' => date('Y-m-d H:i:s'),
		'total' => $total,
		'title_name' => $title_name,
		'filter_params' => $filter_params,
		'chart_names' => $chart_names,
		'chart_params' => $chart_params,

		'gauge_charts' => $gauge_charts,
		'buzz_pie_charts' => $buzz_pie_charts,
		'pie_charts' => $pie_charts,
		'bar_charts' => $bar_charts,
		'line_charts' => $line_charts,

		'options' => $options,
		'mw_date_start' => $mw_date_start,
		'mw_date_end' => $mw_date_end,
		// 'api_key' => $api_key,
		'source_names' => $source_names,
		'source_params' => $source_params,

		'scatter_charts' => $scatter_charts,
		'treemap_charts' => $treemap_charts,
		'stacked_bar_charts' => $stacked_bar_charts,
		'trend_line_charts' => $trend_line_charts,
		'calendar_charts' => $calendar_charts,

		'bubble_charts' => $bubble_charts,
		'location_charts' => $location_charts,
		'word_cloud_charts' => $word_cloud_charts,
		'exclude_params' => $exclude_params
		);

	$mw_format = array(
		// '%s',
		'%d',
		'%s',
		'%s',
		'%s',
		'%s',

		'%s',
		'%s',
		'%s',
		'%s',
		'%s',

		'%s',
		'%s',
		'%s',
		// '%s',
		'%s',
		'%s',

		'%s',
		'%s',
		'%s',
		'%s',
		'%s',

		'%s',
		'%s',
		'%s',
		'%s'
		);

	$wpdb->insert( $table_name, $mw_updated_data, $mw_format );

	return $table_name;
};//--------	--------	--------	--------	--------

//++++++++++     ++++++++++     ++++++++++     ++++++++++     ++++++++++
//++++++++++     ++++++++++     ++++++++++     ++++++++++     ++++++++++
//	END OF SEARCH PARAMETERS TABLE 		END OF SEARCH PARAMETERS TABLE
//++++++++++     ++++++++++     ++++++++++     ++++++++++     ++++++++++
//++++++++++     ++++++++++     ++++++++++     ++++++++++     ++++++++++


?>
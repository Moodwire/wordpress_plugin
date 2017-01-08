<?php

global $wpdb;

global $chart_table;
$chart_table = $wpdb->prefix . 'mw_news_sentiment_db_summary_table_v_1_0';


function moodwire_chart_table_install() {														//--------		THIS WILL CREATE THE DATABASE TABLE									
	global $wpdb;
	global $chart_table;

	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $chart_table (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		entity_name VARCHAR(255) NOT NULL,
		entity_type VARCHAR(255) NOT NULL,
		entity_uuid VARCHAR(255) NOT NULL,
		entry_0 VARCHAR(255) NOT NULL,
		entry_1 VARCHAR(255) NOT NULL,
		entry_2 VARCHAR(255) NOT NULL,
		entry_3 VARCHAR(255) NOT NULL,
		entry_4 VARCHAR(255) NOT NULL,
		entry_5 VARCHAR(255) NOT NULL,
		entry_6 VARCHAR(255) NOT NULL,
		entry_7 VARCHAR(255) NOT NULL,
		entry_8 VARCHAR(255) NOT NULL,
		entry_9 VARCHAR(255) NOT NULL,
		entry_10 VARCHAR(255) NOT NULL,
		entry_11 VARCHAR(255) NOT NULL,
		entry_12 VARCHAR(255) NOT NULL,
		entry_13 VARCHAR(255) NOT NULL,
		entry_14 VARCHAR(255) NOT NULL,
		entry_15 VARCHAR(255) NOT NULL,
		entry_16 VARCHAR(255) NOT NULL,
		entry_17 VARCHAR(255) NOT NULL,
		entry_18 VARCHAR(255) NOT NULL,
		entry_19 VARCHAR(255) NOT NULL,
		entry_20 VARCHAR(255) NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
// print_r('moodwire chart table install');
	return $chart_table;
};//--------	--------	--------	--------	--------


function pull_chart_table($apikey, $results) {																//--------		PULL FROM TABLE ON PAGE LOAD
	global $wpdb;
	global $chart_table;

if($wpdb->get_var("SHOW TABLES LIKE '$chart_table'") != $chart_table) {
		moodwire_chart_table_install();
		insert_into_summary_table($apikey, $results);
	}

	$sql_query = $wpdb->get_row( "SELECT id FROM $chart_table ORDER BY id DESC" );
	$sql_query = $sql_query->id;

	if ($results[5] === '') {
		$limit_charts = 2;
	} else {
		$limit_charts = explode(',', $results[5]);
		$limit_charts = count($limit_charts);
		$limit_charts = (int)$limit_charts;
	}

	if ( $sql_query == FALSE ) {
		moodwire_chart_table_install();
		$default_chart_data = default_chart_curl($apikey);
		insert_into_summary_table($apikey, $default_chart_data);
		$results =  pull_from_mw_db_table();
		pull_chart_table($apikey, $results);
	}

	if ( $sql_query === 0 ) {
		$default_chart_data = default_chart_curl($apikey);
		insert_into_summary_table($apikey, $default_chart_data);
		$results =  pull_from_mw_db_table();
		pull_chart_table($apikey, $results);
	} 

	if ( $sql_query > 500 ) {
		mw_summary_trash_collection_and_database_sweep();
		$results =  pull_from_mw_db_table();
		pull_chart_table($apikey, $results);
	} 

	$sql_query = $wpdb->get_results("SELECT * FROM $chart_table ORDER BY id DESC LIMIT $limit_charts", OBJECT );

	return $sql_query;
};//--------	--------	--------	--------	--------


function insert_into_summary_table($apikey, $results) {
	global $wpdb;
	global $chart_table;
// print_r('insert');
	if($wpdb->get_var("SHOW TABLES LIKE '$chart_table'") != $chart_table) {
		moodwire_chart_table_install();
		insert_into_summary_table($apikey, $results);
	}
	
	$chart_data = curl_interval_data($apikey, $results);
// var_dump($chart_data);
	$data = mw_run_filter_and_sort($chart_data);
// var_dump($data);
// for ($i = 0; $i < $chart_data['limiter']; $i++ ) {
// 	$m = $i * $chart_data['limiter'];
// 	// $m = $m + $i;
// print_r(' into');
// 	//	first iteration 0,38,76,114,152
// 	//	second 			1,39,77,115,153
// 	//	third			2,40,78,116,154
// 	//	fourth			3,41,79,117,155

// 	//	1				0,1,2,3,4,5,6,7,8,9,10
// var_dump($m);
// 		$wpdb->insert(
// 			$chart_table, array(
// 				'entity_name' => $chart_data[$i][0],
// 				'entity_type' => $chart_data[$i][1],
// 				'entity_uuid' => $chart_data[$i][2],
// 				'entry_0' => json_encode($chart_data[$i]),
// 				'entry_1' => json_encode($chart_data[($i + (1 * $chart_data['limiter']))]),
// 				'entry_2' => json_encode($chart_data[($i + (2 * $chart_data['limiter']))]),
// 				'entry_3' => json_encode($chart_data[($i + (3 * $chart_data['limiter']))]),
// 				'entry_4' => json_encode($chart_data[($i + (4 * $chart_data['limiter']))]),
// 				'entry_5' => json_encode($chart_data[($i + (5 * $chart_data['limiter']))]),
// 				'entry_6' => json_encode($chart_data[($i + (6 * $chart_data['limiter']))]),
// 				'entry_7' => json_encode($chart_data[($i + (7 * $chart_data['limiter']))]),
// 				'entry_8' => json_encode($chart_data[($i + (8 * $chart_data['limiter']))]),
// 				'entry_9' => json_encode($chart_data[($i + (9 * $chart_data['limiter']))]),
// 				'entry_10' => json_encode($chart_data[($i + (11 * $chart_data['limiter']))]),
// 				'entry_11' => json_encode($chart_data[($i + (11 * $chart_data['limiter']))]),
// 				'entry_12' => json_encode($chart_data[($i + (12 * $chart_data['limiter']))]),
// 				'entry_13' => json_encode($chart_data[($i + (13 * $chart_data['limiter']))]),
// 				'entry_14' => json_encode($chart_data[($i + (14 * $chart_data['limiter']))]),
// 				'entry_15' => json_encode($chart_data[($i + (15 * $chart_data['limiter']))]),
// 				'entry_16' => json_encode($chart_data[($i + (16 * $chart_data['limiter']))]),
// 				'entry_17' => json_encode($chart_data[($i + (17 * $chart_data['limiter']))]),
// 				'entry_18' => json_encode($chart_data[($i + (18 * $chart_data['limiter']))]),
// 				'entry_19' => json_encode($chart_data[($i + (19 * $chart_data['limiter']))]),
// 				'entry_20' => json_encode($chart_data[($i + (20 * $chart_data['limiter']))])
// 				),
// 			array(
// 				'%s',
// 				'%s',
// 				'%s',
// 				'%s',
// 				'%s',
// 				'%s',
// 				'%s',
// 				'%s',
// 				'%s',
// 				'%s',
// 				'%s',
// 				'%s',
// 				'%s',
// 				'%s',
// 				'%s',
// 				'%s',
// 				'%s',
// 				'%s',
// 				'%s',
// 				'%s',
// 				'%s',
// 				'%s',
// 				'%s',
// 				'%s'
// 				)
// 			);
// 	};
// print_r('charts');
	foreach ($data as $chart_data) {
// var_dump(json_encode($chart_data[2]));
		$wpdb->insert(
			$chart_table, array(
				'entity_name' => $chart_data[1]->name,
				'entity_type' => $chart_data[1]->type,
				'entity_uuid' => json_encode($chart_data[0]),
				'entry_0' => json_encode($chart_data[1]),
				'entry_1' => json_encode($chart_data[2]),
				'entry_2' => json_encode($chart_data[3]),
				'entry_3' => json_encode($chart_data[4]),
				'entry_4' => json_encode($chart_data[5]),
				'entry_5' => json_encode($chart_data[6]),
				'entry_6' => json_encode($chart_data[7]),
				'entry_7' => json_encode($chart_data[8]),
				'entry_8' => json_encode($chart_data[9]),
				'entry_9' => json_encode($chart_data[10]),
				'entry_10' => json_encode($chart_data[11]),
				'entry_11' => json_encode($chart_data[12]),
				'entry_12' => json_encode($chart_data[13]),
				'entry_13' => json_encode($chart_data[14]),
				'entry_14' => json_encode($chart_data[15]),
				'entry_15' => json_encode($chart_data[16]),
				'entry_16' => json_encode($chart_data[17]),
				'entry_17' => json_encode($chart_data[18]),
				'entry_18' => json_encode($chart_data[19]),
				'entry_19' => json_encode($chart_data[20]),
				'entry_20' => json_encode($chart_data[21])
				),
			array(
				// '%s',
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
				'%s'
				)
			);
	};
// print_r('finished inserting into summary table');
	return $chart_table;
};//--------	--------	--------	--------	--------


function mw_summary_trash_collection_and_database_sweep() {
	global $wpdb;
	global $chart_table;

	$wpdb->query("DROP TABLE IF EXISTS $chart_table");
	return $wpdb;

};//--------	--------	--------	--------	--------

//++++++++++     ++++++++++     ++++++++++     ++++++++++     ++++++++++
//++++++++++     ++++++++++     ++++++++++     ++++++++++     ++++++++++
//			END OF SUMMARY TABLE 			END OF SUMMARY TABLE 	
//++++++++++     ++++++++++     ++++++++++     ++++++++++     ++++++++++
//++++++++++     ++++++++++     ++++++++++     ++++++++++     ++++++++++


?>
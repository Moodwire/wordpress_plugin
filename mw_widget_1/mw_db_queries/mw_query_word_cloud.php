<?php

global $wpdb;

global $word_table;
$word_table = $wpdb->prefix . 'mw_word_cloud_table_v_1_0';


function moodwire_word_cloud_table_install() {														//--------		THIS WILL CREATE THE DATABASE TABLE									
	global $wpdb;
	global $word_table;

	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $word_table (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		entity_name VARCHAR(255) NOT NULL,
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
		entry_21 VARCHAR(255) NOT NULL,
		entry_22 VARCHAR(255) NOT NULL,
		entry_23 VARCHAR(255) NOT NULL,
		entry_24 VARCHAR(255) NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
// print_r('moodwire chart table install');
	return $word_table;
};//--------	--------	--------	--------	--------


function pull_word_table($apikey, $results) {																//--------		PULL FROM TABLE ON PAGE LOAD
	global $wpdb;
	global $word_table;

	if ($results[5] === '') {
		$limit_charts = 2;
	} else {
		$limit_charts = explode(',', $results[5]);
		$limit_charts = count($limit_charts);
		$limit_charts = (int)$limit_charts;
	}

if($wpdb->get_var("SHOW TABLES LIKE '$word_table'") != $word_table) {
		moodwire_word_cloud_table_install();
		insert_into_word_cloud_table($apikey, $results);
	}

	$sql_query = $wpdb->get_row( "SELECT id FROM $word_table ORDER BY id DESC" );
	$sql_query = $sql_query->id;

	if ( $sql_query == FALSE ) {
		moodwire_word_cloud_table_install();
		// $default_chart_data = curl_word_cloud_data($apikey, $results, $limit_charts);
// var_dump('false', $default_chart_data);
		insert_into_word_cloud_table($apikey, $results);
		// pull_word_table($apikey, $results);
	}

	if ( $sql_query === 0 ) {
		// $default_chart_data = curl_word_cloud_data($apikey, $results, $limit_charts);
// var_dump('-0-', $default_chart_data);
		insert_into_word_cloud_table($apikey, $results);
		// pull_word_table($apikey, $results);
	} 

	if ( $sql_query > 500 ) {
		mw_word_cloud_trash_collection_and_database_sweep();
		pull_word_table($apikey, $results);
	} 

	$sql_query = $wpdb->get_results("SELECT * FROM $word_table ORDER BY id DESC LIMIT $limit_charts", OBJECT );
// return;
	return $sql_query;
};//--------	--------	--------	--------	--------


function insert_into_word_cloud_table($apikey, $results) {
	global $wpdb;
	global $word_table;

	if ($results[5] === '') {
		$limit_charts = 2;
	} else {
		$limit_charts = explode(',', $results[5]);
		$limit_charts = count($limit_charts);
		$limit_charts = (int)$limit_charts;
	}
// print_r('insert');
	if($wpdb->get_var("SHOW TABLES LIKE '$word_table'") != $word_table) {
		moodwire_word_cloud_table_install();
		insert_into_word_cloud_table($apikey, $results);
	}
	
	$word_data = curl_word_cloud_data($apikey, $results, $limit_charts);

// var_dump('------------------------', $word_data);
	//---------------------------------------------------------run sort here to input data for this---------------------------------------------------------------------------
	// $data = mw_run_filter_and_sort($word_data);
// $p = 0;
	// while ($p < $limit_charts) {
// var_dump(json_decode($word_data[$p][0]));
	foreach ($word_data as $data) {
// var_dump('-----------------------------------------------------', $data['word_name']);
// var_dump('-----------------------------------------------------', json_decode($data));
		$data = json_decode($data);
// var_dump(json_encode($data->{'0'}));
// var_dump(json_encode($data->{'word_name'}));
		$wpdb->insert(
			$word_table, array(
				'entity_name' => json_encode($data->{'word_name'}),
				'entity_uuid' => json_encode($data->{'word_uuid'}),
				'entry_0' => json_encode($data->{'0'}),
				'entry_1' => json_encode($data->{'1'}),
				'entry_2' => json_encode($data->{'2'}),
				'entry_3' => json_encode($data->{'3'}),
				'entry_4' => json_encode($data->{'4'}),
				'entry_5' => json_encode($data->{'5'}),
				'entry_6' => json_encode($data->{'6'}),
				'entry_7' => json_encode($data->{'7'}),
				'entry_8' => json_encode($data->{'8'}),
				'entry_9' => json_encode($data->{'9'}),
				'entry_10' => json_encode($data->{'10'}),
				'entry_11' => json_encode($data->{'11'}),
				'entry_12' => json_encode($data->{'12'}),
				'entry_13' => json_encode($data->{'13'}),
				'entry_14' => json_encode($data->{'14'}),
				'entry_15' => json_encode($data->{'15'}),
				'entry_16' => json_encode($data->{'16'}),
				'entry_17' => json_encode($data->{'17'}),
				'entry_18' => json_encode($data->{'18'}),
				'entry_19' => json_encode($data->{'19'}),
				'entry_20' => json_encode($data->{'20'}),
				'entry_21' => json_encode($data->{'21'}),
				'entry_22' => json_encode($data->{'22'}),
				'entry_23' => json_encode($data->{'23'}),
				'entry_24' => json_encode($data->{'24'})
				),
			array(
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
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s'
				)
			);
	// $p++;
	};
// print_r('finished inserting into summary table');
	return $word_table;
};//--------	--------	--------	--------	--------


function mw_word_cloud_trash_collection_and_database_sweep() {
	global $wpdb;
	global $word_table;

	$wpdb->query("DROP TABLE IF EXISTS $word_table");
	return $wpdb;

};//--------	--------	--------	--------	--------

//++++++++++     ++++++++++     ++++++++++     ++++++++++     ++++++++++
//++++++++++     ++++++++++     ++++++++++     ++++++++++     ++++++++++
//			END OF WORD CLOUD TABLE 			END OF WORD CLOUD TABLE 	
//++++++++++     ++++++++++     ++++++++++     ++++++++++     ++++++++++
//++++++++++     ++++++++++     ++++++++++     ++++++++++     ++++++++++


?>
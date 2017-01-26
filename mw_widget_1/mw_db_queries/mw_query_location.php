<?php

global $location_table;
$location_table = $wpdb->prefix . 'mw_news_sentiment_db_location_table_v_1_0';


function moodwire_location_table_install() {														//--------		THIS WILL CREATE THE DATABASE TABLE									
	global $wpdb;
	global $location_table;

	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $location_table (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		entity VARCHAR(255) NOT NULL,location_type VARCHAR(255) NOT NULL,uuid VARCHAR(255) NOT NULL,
		loc_0 VARCHAR(255) NOT NULL,loc_1 VARCHAR(255) NOT NULL,loc_2 VARCHAR(255) NOT NULL,loc_3 VARCHAR(255) NOT NULL,loc_4 VARCHAR(255) NOT NULL,
		loc_5 VARCHAR(255) NOT NULL,loc_6 VARCHAR(255) NOT NULL,loc_7 VARCHAR(255) NOT NULL,loc_8 VARCHAR(255) NOT NULL,loc_9 VARCHAR(255) NOT NULL,
		loc_10 VARCHAR(255) NOT NULL,loc_11 VARCHAR(255) NOT NULL,loc_12 VARCHAR(255) NOT NULL,loc_13 VARCHAR(255) NOT NULL,loc_14 VARCHAR(255) NOT NULL,
		loc_15 VARCHAR(255) NOT NULL,loc_16 VARCHAR(255) NOT NULL,loc_17 VARCHAR(255) NOT NULL,loc_18 VARCHAR(255) NOT NULL,loc_19 VARCHAR(255) NOT NULL,
		loc_20 VARCHAR(255) NOT NULL,loc_21 VARCHAR(255) NOT NULL,loc_22 VARCHAR(255) NOT NULL,loc_23 VARCHAR(255) NOT NULL,loc_24 VARCHAR(255) NOT NULL,
		loc_25 VARCHAR(255) NOT NULL,loc_26 VARCHAR(255) NOT NULL,loc_27 VARCHAR(255) NOT NULL,loc_28 VARCHAR(255) NOT NULL,loc_29 VARCHAR(255) NOT NULL,
		loc_30 VARCHAR(255) NOT NULL,loc_31 VARCHAR(255) NOT NULL,loc_32 VARCHAR(255) NOT NULL,loc_33 VARCHAR(255) NOT NULL,loc_34 VARCHAR(255) NOT NULL,
		loc_35 VARCHAR(255) NOT NULL,loc_36 VARCHAR(255) NOT NULL,loc_37 VARCHAR(255) NOT NULL,loc_38 VARCHAR(255) NOT NULL,loc_39 VARCHAR(255) NOT NULL,
		loc_40 VARCHAR(255) NOT NULL,loc_41 VARCHAR(255) NOT NULL,loc_42 VARCHAR(255) NOT NULL,loc_43 VARCHAR(255) NOT NULL,loc_44 VARCHAR(255) NOT NULL,
		loc_45 VARCHAR(255) NOT NULL,loc_46 VARCHAR(255) NOT NULL,loc_47 VARCHAR(255) NOT NULL,loc_48 VARCHAR(255) NOT NULL,loc_49 VARCHAR(255) NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	return $location_table;
};//--------	--------	--------	--------	--------


function pull_location_table($apikey, $results) {																//--------		PULL FROM TABLE ON PAGE LOAD
	global $wpdb;
	global $location_table;

	$place_holder = False;
	
	if($wpdb->get_var("SHOW TABLES LIKE '$location_table'") != $location_table) {
		moodwire_location_table_install();
		insert_into_location_table($apikey, $results);
	}

	$sql_query = $wpdb->get_row( "SELECT id FROM $location_table ORDER BY id DESC" );
	$sql_query = $sql_query->id;

	if ( $sql_query === 0 ) {
		$place_holder = True;
		insert_into_location_table($apikey, $results);

	}
	if ( $sql_query > 100 ) {
		$place_holder = True;
		mw_location_trash_collection_and_database_sweep();

	}
	if ( $place_holder == TRUE ) {
		pull_location_table($apikey, $results);

	} else {
		if ($results[5] === '') {
			$limit_locations = 2;
			$sql_query = $wpdb->get_results("SELECT * FROM $location_table ORDER BY id DESC LIMIT $limit_locations", OBJECT );
		} else {
			$limit_locations = define_mw_limiter($results[5]);
			$sql_query = $wpdb->get_results("SELECT * FROM $location_table ORDER BY id DESC LIMIT $limit_locations", OBJECT );
		}
	}
	return $sql_query;
};//--------	--------	--------	--------	--------


function insert_into_location_table($apikey, $results) {
	global $wpdb;
	global $location_table;

	$limit_locations = define_mw_limiter($results[5]);
	$location_data = curl_location_data($apikey, $results);
// var_dump($location_data);
	$location_data = moodwire_refine_location_data($location_data, $limit_locations, $results[5]);
// var_dump($location_data);
	$processed_data = array();

	for ($a = 0; $a < $limit_locations; $a++) {
		$processed_data[$a] = array();
		for ($b = 0; $b < 50; $b++) {
			$processed_data[$a][$b] = array();
			$processed_data[$a][$b]['ent'] = $location_data[$a][0]->name;
			$processed_data[$a][$b]['loc'] = $location_data[$a][$b]->location_name; 
			// $processed_data[$a][$b]['location_id'] = $location_data[$a][$b]->location_id;
			$processed_data[$a][$b]['buzz'] = $location_data[$a][$b]->buzz;
			$processed_data[$a][$b]['pos'] = $location_data[$a][$b]->positives;
			$processed_data[$a][$b]['neu'] = $location_data[$a][$b]->neutrals;
			$processed_data[$a][$b]['neg'] = $location_data[$a][$b]->negatives;
			$processed_data[$a][$b]['mood'] = $location_data[$a][$b]->mood;
		}
// var_dump($processed_data[$a]);
		$wpdb->insert(
			$location_table, array(
				'entity' => $location_data[$a][0]->name,
				'location_type' => $location_data[$a][0]->location_type,
				'uuid' => $location_data[$a][0]->entity_id,
				'loc_0' => json_encode($processed_data[$a][0]),
				'loc_1' => json_encode($processed_data[$a][1]),
				'loc_2' => json_encode($processed_data[$a][2]),
				'loc_3' => json_encode($processed_data[$a][3]),
				'loc_4' => json_encode($processed_data[$a][4]),
				'loc_5' => json_encode($processed_data[$a][5]),
				'loc_6' => json_encode($processed_data[$a][6]),
				'loc_7' => json_encode($processed_data[$a][7]),
				'loc_8' => json_encode($processed_data[$a][8]),
				'loc_9' => json_encode($processed_data[$a][9]),
				'loc_10' => json_encode($processed_data[$a][10]),
				'loc_11' => json_encode($processed_data[$a][11]),
				'loc_12' => json_encode($processed_data[$a][12]),
				'loc_13' => json_encode($processed_data[$a][13]),
				'loc_14' => json_encode($processed_data[$a][14]),
				'loc_15' => json_encode($processed_data[$a][15]),
				'loc_16' => json_encode($processed_data[$a][16]),
				'loc_17' => json_encode($processed_data[$a][17]),
				'loc_18' => json_encode($processed_data[$a][18]),
				'loc_19' => json_encode($processed_data[$a][19]),
				'loc_20' => json_encode($processed_data[$a][20]),
				'loc_21' => json_encode($processed_data[$a][21]),
				'loc_22' => json_encode($processed_data[$a][22]),
				'loc_23' => json_encode($processed_data[$a][23]),
				'loc_24' => json_encode($processed_data[$a][24]),
				'loc_25' => json_encode($processed_data[$a][25]),
				'loc_26' => json_encode($processed_data[$a][26]),
				'loc_27' => json_encode($processed_data[$a][27]),
				'loc_28' => json_encode($processed_data[$a][28]),
				'loc_29' => json_encode($processed_data[$a][29]),
				'loc_30' => json_encode($processed_data[$a][30]),
				'loc_31' => json_encode($processed_data[$a][31]),
				'loc_32' => json_encode($processed_data[$a][32]),
				'loc_33' => json_encode($processed_data[$a][33]),
				'loc_34' => json_encode($processed_data[$a][34]),
				'loc_35' => json_encode($processed_data[$a][35]),
				'loc_36' => json_encode($processed_data[$a][36]),
				'loc_37' => json_encode($processed_data[$a][37]),
				'loc_38' => json_encode($processed_data[$a][38]),
				'loc_39' => json_encode($processed_data[$a][39]),
				'loc_40' => json_encode($processed_data[$a][40]),
				'loc_41' => json_encode($processed_data[$a][41]),
				'loc_42' => json_encode($processed_data[$a][42]),
				'loc_43' => json_encode($processed_data[$a][43]),
				'loc_44' => json_encode($processed_data[$a][44]),
				'loc_45' => json_encode($processed_data[$a][45]),
				'loc_46' => json_encode($processed_data[$a][46]),
				'loc_47' => json_encode($processed_data[$a][47]),
				'loc_48' => json_encode($processed_data[$a][48]),
				'loc_49' => json_encode($processed_data[$a][49])
				),
			array(
				'%s','%s','%s','%s','%s','%s','%s','%s','%s','%s',
				'%s','%s','%s','%s','%s','%s','%s','%s','%s','%s',
				'%s','%s','%s','%s','%s','%s','%s','%s','%s','%s',
				'%s','%s','%s','%s','%s','%s','%s','%s','%s','%s',
				'%s','%s','%s','%s','%s','%s','%s','%s','%s','%s',
				'%s','%s','%s'
				)
			);
	};

	return $location_table;
};//--------	--------	--------	--------	--------


function mw_location_trash_collection_and_database_sweep() {
	global $wpdb;
	global $location_table;

	$wpdb->query("DROP TABLE IF EXISTS $location_table");
};//--------	--------	--------	--------	--------

//++++++++++     ++++++++++     ++++++++++     ++++++++++     ++++++++++
//++++++++++     ++++++++++     ++++++++++     ++++++++++     ++++++++++
//			END OF LOCATION TABLE 			END OF LOCATION TABLE 	
//++++++++++     ++++++++++     ++++++++++     ++++++++++     ++++++++++
//++++++++++     ++++++++++     ++++++++++     ++++++++++     ++++++++++

// 'entity_name' => $location_data[$i][6],
				// 'entity_type' => $location_data[$i][10],
				// 'entity_uuid' => $location_data[$i][1],
				// 'location_0' => json_encode($location_data[$i]),
				// 'location_1' => json_encode($location_data[$i + ($limit_locations * 1)]),
				// 'location_2' => json_encode($location_data[$i + ($limit_locations * 2)]),
				// 'location_3' => json_encode($location_data[$i + ($limit_locations * 3)]),
				// 'location_4' => json_encode($location_data[$i + ($limit_locations * 4)]),
				// 'location_5' => json_encode($location_data[$i + ($limit_locations * 5)]),
				// 'location_6' => json_encode($location_data[$i + ($limit_locations * 6)]),
				// 'location_7' => json_encode($location_data[$i + ($limit_locations * 7)]),
				// 'location_8' => json_encode($location_data[$i + ($limit_locations * 8)]),
				// 'location_9' => json_encode($location_data[$i + ($limit_locations * 9)]),
				// 'location_10' => json_encode($location_data[$i + ($limit_locations * 10)]),
				// 'location_11' => json_encode($location_data[$i + ($limit_locations * 11)]),
				// 'location_12' => json_encode($location_data[$i + ($limit_locations * 12)]),
				// 'location_13' => json_encode($location_data[$i + ($limit_locations * 13)]),
				// 'location_14' => json_encode($location_data[$i + ($limit_locations * 14)]),
				// 'location_15' => json_encode($location_data[$i + ($limit_locations * 15)]),
				// 'location_16' => json_encode($location_data[$i + ($limit_locations * 16)]),
				// 'location_17' => json_encode($location_data[$i + ($limit_locations * 17)]),
				// 'location_18' => json_encode($location_data[$i + ($limit_locations * 18)]),
				// 'location_19' => json_encode($location_data[$i + ($limit_locations * 19)]),
				// 'location_20' => json_encode($location_data[$i + ($limit_locations * 20)]),
				// 'location_21' => json_encode($location_data[$i + ($limit_locations * 21)]),
				// 'location_22' => json_encode($location_data[$i + ($limit_locations * 22)]),
				// 'location_23' => json_encode($location_data[$i + ($limit_locations * 23)]),
				// 'location_24' => json_encode($location_data[$i + ($limit_locations * 24)]),
				// 'location_25' => json_encode($location_data[$i + ($limit_locations * 25)]),
				// 'location_26' => json_encode($location_data[$i + ($limit_locations * 26)]),
				// 'location_27' => json_encode($location_data[$i + ($limit_locations * 27)]),
				// 'location_28' => json_encode($location_data[$i + ($limit_locations * 28)]),
				// 'location_29' => json_encode($location_data[$i + ($limit_locations * 29)]),
				// 'location_30' => json_encode($location_data[$i + ($limit_locations * 30)]),
				// 'location_31' => json_encode($location_data[$i + ($limit_locations * 31)]),
				// 'location_32' => json_encode($location_data[$i + ($limit_locations * 32)]),
				// 'location_33' => json_encode($location_data[$i + ($limit_locations * 33)]),
				// 'location_34' => json_encode($location_data[$i + ($limit_locations * 34)]),
				// 'location_35' => json_encode($location_data[$i + ($limit_locations * 35)]),
				// 'location_36' => json_encode($location_data[$i + ($limit_locations * 36)]),
				// 'location_37' => json_encode($location_data[$i + ($limit_locations * 37)]),
				// 'location_38' => json_encode($location_data[$i + ($limit_locations * 38)]),
				// 'location_39' => json_encode($location_data[$i + ($limit_locations * 39)]),
				// 'location_40' => json_encode($location_data[$i + ($limit_locations * 40)]),
				// 'location_41' => json_encode($location_data[$i + ($limit_locations * 41)]),
				// 'location_42' => json_encode($location_data[$i + ($limit_locations * 42)]),
				// 'location_43' => json_encode($location_data[$i + ($limit_locations * 43)]),
				// 'location_44' => json_encode($location_data[$i + ($limit_locations * 44)]),
				// 'location_45' => json_encode($location_data[$i + ($limit_locations * 45)]),
				// 'location_46' => json_encode($location_data[$i + ($limit_locations * 46)]),
				// 'location_47' => json_encode($location_data[$i + ($limit_locations * 47)]),
				// 'location_48' => json_encode($location_data[$i + ($limit_locations * 48)]),
				// 'location_49' => json_encode($location_data[$i + ($limit_locations * 49)])
?>
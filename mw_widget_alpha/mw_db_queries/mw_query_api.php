<?php

global $wpdb;

global $table_key;
$table_key = $wpdb->prefix . 'mw_key';


function moodwire_api_key_table_install() {														//--------		THIS WILL CREATE THE DATABASE TABLE									
	global $wpdb;
	global $table_key;

	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_key (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		api_key VARCHAR(255) NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	return $table_key;
};//--------	--------	--------	--------	--------	


function pull_mw_key_table() {																	//--------		PULL FROM TABLE ON PAGE LOAD
	global $wpdb;
	global $table_key;
	
	if($wpdb->get_var("SHOW TABLES LIKE '$table_key'") != $table_key) {
		moodwire_api_key_table_install();
		insert_into_api_key_table('XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX');
	}

	$mw_limit = 1;
	$sql_query = $wpdb->get_results( $wpdb->prepare("SELECT api_key FROM $table_key ORDER BY id DESC LIMIT %d", $mw_limit), ARRAY_N );

	if ( $sql_query === 0 ) {
		$default_data = array(
			'api_key' => 'XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX'
			);
		$wpdb->insert( $table_key, $default_data );
		$sql_query = $wpdb->get_results( $wpdb->prepare("SELECT api_key FROM $table_key ORDER BY id DESC LIMIT %d", $mw_limit), ARRAY_N );
	}	

	return $sql_query[0][0];
};//--------	--------	--------	--------	--------


function insert_into_api_key_table($new_key) {													//--------		INSERT NEW API FROM MODAL WINDOW
	global $wpdb;
	global $table_key;
		
		$new_data = array(
			'api_key' => $new_key
			);

		$wpdb->insert( $table_key, $new_data );

	return $table_key;
};

//++++++++++     ++++++++++     ++++++++++     ++++++++++     ++++++++++
//++++++++++     ++++++++++     ++++++++++     ++++++++++     ++++++++++
//		END OF API TABLE 	END OF API TABLE 	END OF API TABLE
//++++++++++     ++++++++++     ++++++++++     ++++++++++     ++++++++++
//++++++++++     ++++++++++     ++++++++++     ++++++++++     ++++++++++


?>
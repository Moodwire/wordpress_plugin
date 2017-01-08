<?php

global $wpdb;

global $table_cache;
$table_cache = $wpdb->prefix . 'mw_news_sentiment_db_article_cache_v_1_0';


function moodwire_database_cache_table_install() {														//--------		THIS WILL CREATE THE DATABASE TABLE							
	global $wpdb;
	global $table_cache;

	$charset_collate = $wpdb->get_charset_collate();
	
	$sql = "CREATE TABLE $table_cache (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		article_body TEXT NOT NULL,
		article_date VARCHAR(255) NOT NULL,
		article_title VARCHAR(255) NOT NULL,
		uuid VARCHAR(255) NOT NULL,
		images TEXT NOT NULL,
		scores TEXT NOT NULL,
		source TEXT NOT NULL,
		url TEXT NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";
	
	$wpdb->query($sql);
	return $table_cache;
};//--------	--------	--------	--------	--------


function pull_from_mw_cache_table($apikey) {																	//--------		PULL FROM TABLE ON PAGE LOAD
	global $wpdb;
	global $table_cache;

	if($wpdb->get_var("SHOW TABLES LIKE '$table_cache'") != $table_cache) {
		moodwire_database_cache_table_install();
		insert_dummy_data_into_mw_table_cache();
	}

	$sql_query = $wpdb->get_results("SELECT id FROM $table_cache ORDER BY id DESC LIMIT 1", OBJECT );
	if ( $sql_query === 0 ) {																	//--	if table does not exist, it will create the table in the wp DB
		insert_into_mw_table_cache($apikey);
	} 
	$sql_query = $wpdb->get_results("SELECT * FROM $table_cache LIMIT 10", OBJECT );
	return $sql_query;
};//--------	--------	--------	--------	--------


function insert_dummy_data_into_mw_table_cache() {
	global $wpdb;
	global $table_cache;

	$moodwire = new stdClass(); 
	$moodwire->article_body = "Please go to moodwire.com and request an API key.";
	$moodwire->article_date = "2017-01-01";
	$moodwire->article_title = "Moodwire gets it right!!!!";
	$moodwire->uuid = "x0x0x0x0x0x0x0x0x0x0x0x0x0x0x0x0";
	$moodwire->images = json_decode('[{"type":"image\/jpeg","height":333,"url":"https://www.moodwire.com/assets/images/default.png","width":500}]');
	$moodwire->scores = explode("," , "5446b7824f7a47273096f262,Moodwire,organization,100000,100000,0,null,[],10");
	$moodwire->source = explode("," , "5446b7824f7a47273096f262,https://www.moodwire.com/item/5446b7824f7a47273096f262,news");
	$moodwire->url = "http://www.moodwire.com";

	for ($i = 0; $i < 10; $i++ ) {
		$wpdb->insert(
			$table_cache, array(
				'article_body' => $moodwire->article_body,
				'article_date' => $moodwire->article_date,
				'article_title' => $moodwire->article_title,
				'uuid' => $moodwire->uuid,						//-------------------------find the right traversal for this one
				'images' => json_encode($moodwire->images),
				'scores' => json_encode($moodwire->scores),
				'source' => json_encode($moodwire->source),
				'url' => $moodwire->url
				),
			array(
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

	return $table_cache;
}

// MAY NEED TO PULL 50 ARTICLES AND INSERT THEM ONE BY ONE WITH A LOOP.  THEN EXIT.  LOOK TO OVERWRITE EVERY ENTRY TO KEEP DATAUSAGE LOW
function insert_into_mw_table_cache($apikey) {
	global $wpdb;
	global $table_cache;

	if($wpdb->get_var("SHOW TABLES LIKE '$table_cache'") != $table_cache) {
		moodwire_database_cache_table_install();
		insert_into_mw_table_cache($apikey);
	}
	
	$results = pull_from_mw_db_table();
	$results = mw_date_filter($results);
	$result = curl_articles($results, '10', $apikey);
// var_dump('get article data',$result);
	for ($i = 0; $i < count($result); $i++ ) {
		$refined_object = refine_mw_data_object($result[$i]);

		$wpdb->insert(
			$table_cache, array(
				'article_body' => $refined_object->article_body,
				'article_date' => $refined_object->article_date,
				'article_title' => $refined_object->article_title,
				'uuid' => $refined_object->uuid,						//-------------------------find the right traversal for this one
				'images' => json_encode($refined_object->images),
				'scores' => json_encode($refined_object->scores),
				'source' => json_encode($refined_object->source),
				'url' => $refined_object->url
				),
			array(
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
	return $table_cache;
};//--------	--------	--------	--------	--------


function update_mw_table_cache($apikey, $results) {
	global $wpdb;
	global $table_cache;

	if($wpdb->get_var("SHOW TABLES LIKE '$table_cache'") != $table_cache) {
		moodwire_database_cache_table_install();
		insert_into_mw_table_cache($apikey);
	}
	$results = mw_date_filter($results);
	$result = curl_articles($results, '10', $apikey);
// var_dump('updating article data',$result);
// var_dump($result);
// var_dump(count($result));
// die();
	for ($i = 0; $i < count($result); $i++ ) {
		$refined_object = refine_mw_data_object($result[$i]);
		$m = $i + 1;
		
		$wpdb->update(
			$table_cache, array(
				'article_body' => $refined_object->article_body,
				'article_date' => $refined_object->article_date,
				'article_title' => $refined_object->article_title,
				'uuid' => $refined_object->uuid,
				'images' => json_encode($refined_object->images),
				'scores' => json_encode($refined_object->scores),
				'source' => json_encode($refined_object->source),
				'url' => $refined_object->url
				),
			array('ID' => $m),
			array(
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

	return $table_cache;
};//--------	--------	--------	--------	--------


function mw_articles_trash_collection_and_database_sweep() {
	global $wpdb;
	global $table_cache;

	$wpdb->query("DROP TABLE IF EXISTS $table_cache");
	// return $table_cache;
};//--------	--------	--------	--------	--------

//++++++++++     ++++++++++     ++++++++++     ++++++++++     ++++++++++
//++++++++++     ++++++++++     ++++++++++     ++++++++++     ++++++++++
//			END OF ARTICLES TABLE 			END OF ARTICLES TABLE 	
//++++++++++     ++++++++++     ++++++++++     ++++++++++     ++++++++++
//++++++++++     ++++++++++     ++++++++++     ++++++++++     ++++++++++


?>
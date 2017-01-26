<?php


global $wpdb;

global $table_key;
$table_key = $wpdb->prefix . 'mw_key';

global $table_name;
$table_name = $wpdb->prefix . 'mw_news_sentiment_db_table_v_1_0';

global $table_cache;
$table_cache = $wpdb->prefix . 'mw_news_sentiment_db_article_cache_v_1_0';

global $chart_table;
$chart_table = $wpdb->prefix . 'mw_news_sentiment_db_summary_table_v_1_0';

global $location_table;
$location_table = $wpdb->prefix . 'mw_news_sentiment_db_location_table_v_1_0';

global $word_table;
$word_table = $wpdb->prefix . 'mw_word_cloud_table_v_1_0';


function remove_old_moodwire_wp_table_and_perform_a_fresh_table_install() {
	global $wpdb;
	
	global $table_name;
	global $table_cache;
	global $chart_table;
	global $location_table;
	global $word_table;

	$wpdb->query("DROP TABLE IF EXISTS $table_name");
	$wpdb->query("DROP TABLE IF EXISTS $table_cache");
	$wpdb->query("DROP TABLE IF EXISTS $chart_table");
	$wpdb->query("DROP TABLE IF EXISTS $location_table");
	$wpdb->query("DROP TABLE IF EXISTS $word_table");

};//--------	--------	--------	--------	--------


?>
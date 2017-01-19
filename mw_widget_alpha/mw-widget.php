<?php
/*

	Plugin Name: Moodwire Widget (alpha)
	Plugin URI: http://moodwire.com
	Description: Get the latest news and sentimentality
	Version: 1.0
	Author: W_Morgan
	Author URI: http://moodwire.com
	License: none

*/

include ( plugin_dir_path(__FILE__) . "mw_admin_settings.php" );										//		CREATES THE ADMIN ICON ON DASHBOARD

// get_template_part('mw_widget_create_settings');
class MW_Widget extends WP_Widget {

	public function __construct() {
// register_deactivation_hook(__FILE__, 'delete_tables' );
		$name = __('Moodwire plugin','moodwire_widget');

		$widget_ops = array(
			'description' => __( 'This is the Alpha version widget for Moodwire.com.  This plugin will utilize the auto complete feature from the moodwire.com website.' ),
			'customize_selective_refresh' => true  //PERMITS A PARTIAL REFRESH, e.g. THE WIDGET ITSELF, AS OPPOSED TO THE ENTIRE PAGE(a combination of PHP Obj and JS)
			//Source docs -- https://make.wordpress.org/core/2016/03/22/implementing-selective-refresh-support-for-widgets/
		);
		
		$control_ops = array (
			'width' => 400,
			'height' => 200
			// 'id_base' => 'moodwire_widget_4'
		);

		parent::__construct(false, $name, $widget_ops, $control_ops);

		// register_deactivation_hook(__FILE__, 'deactivate_mw_plugin' );									//		REGISTERS THE DEACTIVATION OF PLUGIN, WILL DELETE TABLE TO PREVENT ISSUES
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */

	function widget($args, $instance) {	

		include ( plugin_dir_path(__FILE__) . "moodwire_libraries/mw_wp_full_scripts.php" );			//		LINK TO SCRIPT TAGS FOR ADMIN PAGE
		mw_wp_load_scripts();
		include ( plugin_dir_path(__FILE__) . "mw_db_queries/mw_query_api.php" );						//		LOADS API PAGE
		include ( plugin_dir_path(__FILE__) . "mw_db_queries/mw_query_articles.php" );					//		LOADS ARTICLES PAGE
		include ( plugin_dir_path(__FILE__) . "mw_db_queries/mw_query_drop.php" );						//		LOADS DROP PAGE
		// include ( plugin_dir_path(__FILE__) . "mw_db_queries/mw_query_location.php" );					//		LOADS LOCATION PAGE
		include ( plugin_dir_path(__FILE__) . "mw_db_queries/mw_query_results.php" );					//		LOADS RESULTS PAGE
		include ( plugin_dir_path(__FILE__) . "mw_db_queries/mw_query_summary.php" );					//		LOADS SUMMARY PAGE
		include ( plugin_dir_path(__FILE__) . "mw_db_queries/mw_query_word_cloud.php" );				//		LOADS WORD CLOUD PAGE

		include	( plugin_dir_path(__FILE__) . "mw_php_functions.php");									//		LINK TO PHP FUNCTIONS
		include	( plugin_dir_path(__FILE__) . "moodwire_libraries/mw_wp_php_curls.php" );				//		LINK TO PHP FUNCTIONS
		
		include ( plugin_dir_path(__FILE__) . "moodwire_libraries/moodwire_js_helper.php" );			//		LINK TO HELPER FUNCTIONS (MOODWIRE)
		include ( plugin_dir_path(__FILE__) . "moodwire_libraries/moodwire_api_js.php" );				//		LINK TO MOODWIRE API CALL FUNCTIONS
		include ( plugin_dir_path(__FILE__) . "mw-widget_js.php" );										//		LINK TO JS FILE FOR WIDGET

		include	( plugin_dir_path(__FILE__) . "mw_widget_charts/mw-widget_charts.php" );				//		LINK TO Master Chart file FOR WIDGET
		include	( plugin_dir_path(__FILE__) . "mw_widget_charts/mw-charts-gauge.php" );					//		LINK TO gauge chart FOR WIDGET 		----	single page format
		include	( plugin_dir_path(__FILE__) . "mw_widget_charts/mw-charts-buzz_pie.php" );				//		LINK TO pie chart FOR WIDGET 		----	single page format
		include	( plugin_dir_path(__FILE__) . "mw_widget_charts/mw-charts-pie.php" );					//		LINK TO pie chart FOR WIDGET 		----	single page format
		include	( plugin_dir_path(__FILE__) . "mw_widget_charts/mw-charts-bar.php" );					//		LINK TO bar chart FOR WIDGET 		----	single page format
		include	( plugin_dir_path(__FILE__) . "mw_widget_charts/mw-charts-line.php" );					//		LINK TO bar chart FOR WIDGET 		----	single page format
		include	( plugin_dir_path(__FILE__) . "mw_widget_charts/mw-charts-scatter.php" );				//		LINK TO scatter chart FOR WIDGET	----	single page format
		include	( plugin_dir_path(__FILE__) . "mw_widget_charts/mw-charts-treemap.php" );				//		LINK TO treemap chart FOR WIDGET	----	single page format
		include	( plugin_dir_path(__FILE__) . "mw_widget_charts/mw-charts-stacked_bar_chart.php" );		//		LINK TO stacked chart FOR WIDGET	----	single page format
		// include	( plugin_dir_path(__FILE__) . "mw_widget_charts/mw-charts-trend_line.php" );			//		LINK TO trend chart FOR WIDGET		----	single page format
		// include	( plugin_dir_path(__FILE__) . "mw_widget_charts/mw-charts-calendar.php" );				//		LINK TO trend chart FOR WIDGET		----	single page format
		// include	( plugin_dir_path(__FILE__) . "mw_widget_charts/mw-d3-calendar.php" );				//		LINK TO trend chart FOR WIDGET		----	single page format
		// include	( plugin_dir_path(__FILE__) . "mw_widget_charts/mw_d3_calendar_w-o_c3.php" );			//		LINK TO calendar chart FOR WIDGET	----	single page format
		// include	( plugin_dir_path(__FILE__) . "mw_widget_charts/mw-d3-calendar_json.php" );				//		LINK TO calendar chart FOR WIDGET	----	single page format
		include ( plugin_dir_path(__FILE__) . "mw_widget_charts/mw-charts-bubble.php" );				// 		LINK to bubble chart for WIDGET 	----	single page format
		// include ( plugin_dir_path(__FILE__) . "mw_widget_charts/mw-charts-location.php" );				// 		LINK to location chart for WIDGET 	----	single page format
		// include ( plugin_dir_path(__FILE__) . "mw_widget_charts/mw-amcharts_location.php");
		include ( plugin_dir_path(__FILE__) . "mw_widget_charts/mw-d3_word_charts.php");
		include	( plugin_dir_path(__FILE__) . "moodwire_libraries/d3_layout_cloud_js.php");
																				
		$apikey = pull_mw_key_table();
    	$results =  pull_from_mw_db_table(); 															//		CHECKS FOR TABLE, INSTANTIATES, DOES A CRUD READ OPERATION	
    	$articles = pull_from_mw_cache_table($apikey);
    	$results = mw_date_filter($results);															//		CREATES/MODIFIES DATAS FOR API CALL														
	
		if ( !empty($results[5]) ) {																	//		RENDERS CHARTS, IF ENTITIES WERE SELECTED IN ADMIN
			$chart_builder = pull_chart_table($apikey, $results); 			
		// $location = pull_location_table($apikey, $results);
		// $location = json_encode($location);
			$word_cloud = pull_word_table($apikey, $results);
			$mw_select_charts = mw_select_charts($results);
// $pickles = microtime(true);
			echo '<script>widget_on_load(' . json_encode($chart_builder) . ',' . json_encode($word_cloud) . ',' . json_encode($mw_select_charts) . ');</script>';
// $hummus = microtime(true);
// echo "It took " . ( $hummus - $pickles ) . ' seconds';
		};

		$results = mw_string_to_object_results($results);
		?>

<div class='mw_wd_container'>
		
	<div id="moodwire_generic" <?php if($results[11]->mw_border === 'on') { echo "style='border:2px solid black;' "; } else { echo "style='border:2px solid transparent;' "; }	?>>
			
		<div id='myMwWid'></div>
		
		<div class='switch_div'>
			<h3 class='mw_in_the_news'><?php echo( str_replace("\'", "'", $results[2]) ); ?></h3>
		</div>
<!--		RETURNED ARTICLES HERE - as lists	-->
		<div id="mwtest_list"<?php if($results[11]->mw_images === 'off') 	{ echo "style='display:block;' "; } else { echo "style='display:none;' "; }  	?>></div>		
<!--		RETURNED ARTICLES HERE - as tiles	-->
		<div id="mwtest_tile"<?php if($results[11]->mw_images === 'off') 	{ echo "style='display:none;' "; } else { echo "style='display:block;' "; }		?>></div>		

		<div id="chart_body_div">
			<div id="gauge_div" 		<?php if($results[6]->status === 'off') 	{ echo "style='display:none;' "; } ?>></div>
			<div id="pie_buzz_div" 		<?php if($results[7]->status === 'off') 	{ echo "style='display:none;' "; } ?>></div>
			<div id="pie_div" 			<?php if($results[8]->status === 'off') 	{ echo "style='display:none;' "; } ?>></div>
			<div id="bar_div" 			<?php if($results[9]->status === 'off') 	{ echo "style='display:none;' "; } ?>></div>
			<div id="line_div" 			<?php if($results[10]->status === 'off') 	{ echo "style='display:none;' "; } ?>></div>
			<div id="scatter_div"		<?php if($results[16]->status === 'off') 	{ echo "style='display:none;' "; } ?>></div>
			<div id="treemap_div"		<?php if($results[17]->status === 'off') 	{ echo "style='display:none;' "; } ?>></div>
			<div id="stacked_bar_div"	<?php if($results[18]->status === 'off') 	{ echo "style='display:none;' "; } ?>></div>
			<!--<div id="trend_line_div"	<php if($results[19]->status === 'off') 	{ echo "style='display:none;' "; } ?>></div>-->
			<!--<div id="calendar_div"		<php if($results[20]->status === 'off') { echo "style='display:none;' "; } ?>></div>-->
			<div id="bubble_chart_div"	<?php if($results[21]->status === 'off') 	{ echo "style='display:none;' "; } ?>></div>
			<!--<div id="location_div"		<php if($results[22]->status === 'off') { echo "style='display:none;' "; } ?>></div>-->
			<div id="word_chart_div"	<?php if($results[23]->status === 'off') 	{ echo "style='display:none;' "; } ?>></div>
		</div>

		<div class='poweredByDiv'>
			<a class='poweredBy' href='http://www.moodwire.com' target='_blank'>Powered by Moodwire</a>
		</div>
	
	</div>

</div>

<!--<script>widget_on_load(< echo( $chart_builder );?>, < echo($word_cloud); ?>);</script>-->

<!--<script>widget_on_load(< echo($chart_builder); ?>,< echo($location); ?>, < echo($word_cloud); ?>);</script>-->

<script>logResults(<?php echo( json_encode($articles) ); ?>, <?php echo ( $results[1] ); ?>);</script>
<script>newsResults(<?php echo( json_encode($articles) ); ?>);</script>
<?php if($results[11]->mw_assoc === 'on') { echo "<script>$('.fixed_dpd_size').css({'display':'inline'});</script>"; }?>

<!--<script>drawLocation( echo( $location ); ?>);</script>-->


<?php

		include ( plugin_dir_path(__FILE__) . "mw_css/mw-widget_default.css" );							//		LINK TO WIDGET CSS
	   	if ( empty($results[5]) ) {																		//		CREATES CHART WARNING MESSAGES
			echo '<script>mwRenderEmptyCharts();</script>';
		};
	}
}
//The widget can then be registered using the widgets_init hook: (for PHP v5.3+)
add_action('widgets_init', function() {
	register_widget('MW_Widget');
});


function deactivate_mw_plugin() {									//		ADMIN CHECK, THEN DROPS THE TABLE UPON DEACTIVATION OF THE PLUGIN (TRASH COLLECTION)
	include 	( plugin_dir_path(__FILE__) . "mw_db_queries/mw_query_drop.php" );
	remove_old_moodwire_wp_table_and_perform_a_fresh_table_install();
	
	// include ( plugin_dir_path(__FILE__) . "mw_php_functions.php" );
	// mw_plugin_deactivated_and_daily_db_update_cleared();
};

register_deactivation_hook(__FILE__, 'deactivate_mw_plugin' );									//		REGISTERS THE DEACTIVATION OF PLUGIN, WILL DELETE TABLE TO PREVENT ISSUES

?>
<?php
/** Step 2 (from text above). */
add_action( 'admin_menu', 'my_menu' );

/** Step 1. */
function my_menu() {
    add_menu_page(
        'Refine Moodwire Search parameters',															//		The text to be displayed in the title tags of the page when the menu is selected.
        'Moodwire',																						//		The text to be used for the menu.
        'manage_options',																				//		The capability required for this menu to be displayed to the user.
        'my-unique-identifier',																			//		The slug name to refer to this menu by (should be unique for this menu).
        'moodwire_admin',																				//		The function to be called to output the content for this page.
        'dashicons-admin-site'				 															//		The URL to the icon to be used for this menu.   
    //  'position'																						//		The position in the menu order this one should appear. 
    );
}
 
/** Step 3. */
function moodwire_admin() {

    if ( !current_user_can( 'manage_options' ) ) {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    } 

		include 	( plugin_dir_path(__FILE__) . "moodwire_libraries/mw_wp_partial_scripts.php" );		//		LINK TO SCRIPT TAGS FOR ADMIN PAGE	
		mw_wp_load_partial_scripts();																	//		LOADS SCRIPTS NECESSARY FOR PERFORMING OPERATIONS
		include 	( plugin_dir_path(__FILE__) . "mw_db_queries/mw_query_api.php" );					//		LOADS API PAGE
		include 	( plugin_dir_path(__FILE__) . "mw_db_queries/mw_query_articles.php" );				//		LOADS ARTICLES PAGE
		include 	( plugin_dir_path(__FILE__) . "mw_db_queries/mw_query_drop.php" );					//		LOADS DROP PAGE
		
		// include 	( plugin_dir_path(__FILE__) . "mw_db_queries/mw_query_location.php" );				//		LOADS LOCATION PAGE

		include 	( plugin_dir_path(__FILE__) . "mw_db_queries/mw_query_results.php" );				//		LOADS RESULTS PAGE
		include 	( plugin_dir_path(__FILE__) . "mw_db_queries/mw_query_summary.php" );				//		LOADS SUMMARY PAGE
		include 	( plugin_dir_path(__FILE__) . "mw_db_queries/mw_query_word_cloud.php" );			//		LOADS WORD CLOUD PAGE
		include		( plugin_dir_path(__FILE__) . "mw_php_functions.php");								//		LINK TO PHP FUNCTIONS
		include 	( plugin_dir_path(__FILE__) . "moodwire_libraries/moodwire_js_helper.php" );		//		LINK TO HELPER FUNCTIONS (MOODWIRE)
		include 	( plugin_dir_path(__FILE__) . "moodwire_libraries/moodwire_api_js.php" );			//		LINK TO MOODWIRE API CALL FUNCTIONS
		include 	( plugin_dir_path(__FILE__) . "mw-widget_js.php" );									//		LINK TO JS FILE FOR WIDGET
		include		( plugin_dir_path(__FILE__) . "moodwire_libraries/mw_wp_php_curls.php" );			//		LINK TO PERFORM CALLS LEFT API CALL
		include 	( plugin_dir_path(__FILE__) . "mw_ajax_call.php");
	
		$apikey = pull_mw_key_table();																	//		OBTAINS MOODWIRE APIKEY FROM DATABASE	
    	$results =  pull_from_mw_db_table();															//		PULLS PARAMETERS FROM DATABASE
    	$results = mw_date_filter($results);															//		CREATES/MODIFIES DATES FOR API CALL			
		$results = mw_string_to_object_results($results);	
		$articles = pull_from_mw_cache_table($apikey);				

		if ($_POST) {																					//		ON UPDATE, RUNS THE FORM DATA TO mw_db_querries.php
			if ($_POST['mw_update_api_key'] != NULL) {
				$new_key = $_POST['mw_update_api_key'];
				insert_into_api_key_table($new_key);
				$apikey = pull_mw_key_table();	
			}

			$_POST = mw_process_post_data($_POST);														//		PROCESS POST DATA FOR DB SAVE
						
			insert_into_wp_mw_db_table($_POST);															//		UPDATES SEARCH PARAMETERS IN DATABASE	
			$results = pull_from_mw_db_table();															//		PULLS NEW PARAMETERS			
			$results[3] = str_replace('%20', ' ', $results[3]);											//		DISPLAYS EXCLUDE PILL WITH A SPACE INSTEAD OF %20
			$results[24] = str_replace('%20', ' ', $results[24]);										//		DISPLAYS FILTER PILL WITH A SPACE INSTEAD OF %20
			$results[2] = str_replace("\'", "'", $results[2]);

			update_mw_table_cache($apikey, $results);													//		UPDATES CACHE ARTICLES IN DATABASE
			if( strlen($results[5]) != 0 ) {
				insert_into_summary_table($apikey, $results);											//		UPDATES CHART SUMMARY DATA			
				// insert_into_location_table($apikey, $results);											//		INSERTS NEW LOCATION DATA
				insert_into_word_cloud_table($apikey, $results);										//		INSERTS NEW WORD DATA DATA
			};
			
			$results = mw_string_to_object_results($results);											//		CONVERTS CHART DATA STRING TO OBJECT FOR USE
		}
?>

<script> 
	$(document).ready(function() { 
		mw_load_all_and_populate(filter_pill_to_be,source_uuid,source_name,chart_uuid,chart_name,exclude_pill_to_be);		//		ROUTES DATA FOR PILL RENDERING
		$('[data-toggle="mw_options_selected"]').popover();
    	$('[data-toggle="mw_options_not_selected"]').popover();
    	$('[data-toggle="mw_title_name"]').popover();
    	$('[data-toggle="mw_total_display"]').popover();
    	$('[data-toggle="mw_filter_params"]').popover();
    	$('[data-toggle="mw_chart_params"]').popover();
    	$('[data-toggle="mw_source_params"]').popover();
    	$('#mw_options_div').show();
	}); 
</script>

<script>var filter_pill_to_be = "<?php echo $results[3] ?>";</script>
<script>var source_uuid 	= "<?php echo $results[15] ?>";</script>
<script>var source_name 	= "<?php echo $results[14] ?>";</script>
<script>var chart_uuid 		= "<?php echo $results[5] ?>";</script>
<script>var chart_name 		= "<?php echo $results[4] ?>";</script>
<script>var exclude_pill_to_be = "<?php echo $results[24] ?>";</script>

<script>
		filter_pill_to_be = filter_pill_to_be.trim();
		source_uuid = source_uuid.trim();
		source_name = source_name.trim();
		chart_uuid = chart_uuid.trim();
		chart_name = chart_name.trim();
		exclude_pill_to_be = exclude_pill_to_be.trim();
</script>

<div id='mw_admin'>
	<div id='mw_admin_header'>
		<h3>MOODWIRE WIDGET SETTINGS</h3>
	</div>

	

<form method='post' action='#' id='moodwire_form'>	
	<div id='mw_admin_sections'>
			<!--<p>WIDGET SETTINGS: <span class='mw_more_data glyphicon glyphicon-question-sign' data-toggle="mw_options_selected" title="Selected options" data-content="These will choose to display articles with or without images.  You may also choose which charts to render."></span></p>-->
			<div id='mw_left_column_header'>	
				<div class='mw_selectors'>
					<!--<p data-toggle='modal' data-target='#mw_options_div' data-backdrop="static">Options</p></div>-->
					<p onclick='mw_ch_p_s_h("#mw_options_div")'>WIDGET SETTINGS</p></div>

				<div class='mw_selectors'>
					<p onclick='mw_ch_p_s_h("#mw_filter_div")'>FILTERS</p></div>
			</div>		

			<div id='mw_admin_selected'>
				<p>included charts:</p>
					<?php if ($results[6]->status === 'on')	{ 
						echo "<div class='mw_selectors' id='mw_gauge_sel'>
								<p onclick='mw_ch_p_s_h(\"#mw_gauge_div\")'>GAUGE CHARTS</p>
									<span class='glyphicon glyphicon-remove-sign' onclick='mw_charts_div_sel(\"#mw_gauge_div\", \"gauge_charts\", \"mw_gauge_sel\", \"on\", \"GAUGE CHARTS\")'></span>
									<input type='checkbox' name='gauge_charts' value='on' checked style='display:none'>
							</div>"; }; ?>

					<?php if ($results[7]->status === 'on')	{ 
						echo "<div class='mw_selectors' id='mw_buzz_pie_sel'>
								<p onclick='mw_ch_p_s_h(\"#mw_buzz_pie_div\")'>BUZZ PIE CHARTS</p>
									<span class='glyphicon glyphicon-remove-sign' onclick='mw_charts_div_sel(\"#mw_buzz_pie_div\", \"buzz_pie_charts\", \"mw_buzz_pie_sel\", \"on\", \"BUZZ PIE CHARTS\")'></span>
									<input type='checkbox' name='buzz_pie_charts' value='on' checked style='display:none'>
							</div>"; }; ?>

					<?php if ($results[8]->status === 'on')	{ 
						echo "<div class='mw_selectors' id='mw_pie_sel'>
								<p onclick='mw_ch_p_s_h(\"#mw_pie_div\")'>PIE CHARTS</p>
									<span class='glyphicon glyphicon-remove-sign' onclick='mw_charts_div_sel(\"#mw_pie_div\", \"pie_charts\", \"mw_pie_sel\", \"on\", \"PIE CHARTS\")'></span>
									<input type='checkbox' name='pie_charts' value='on' checked style='display:none'>
							</div>"; }; ?>

					<?php if ($results[9]->status === 'on')	{ 
						echo "<div class='mw_selectors' id='mw_bar_sel'>
								<p onclick='mw_ch_p_s_h(\"#mw_bar_div\")'>BAR CHARTS</p>
									<span class='glyphicon glyphicon-remove-sign' onclick='mw_charts_div_sel(\"#mw_bar_div\", \"bar_charts\", \"mw_bar_sel\", \"on\", \"BAR CHARTS\")'></span>
									<input type='checkbox' name='bar_charts' value='on' checked style='display:none'>
							</div>"; }; ?>

					<?php if ($results[10]->status === 'on'){ 
						echo "<div class='mw_selectors' id='mw_line_sel'>
								<p onclick='mw_ch_p_s_h(\"#mw_line_div\")'>LINE CHARTS</p>
									<span class='glyphicon glyphicon-remove-sign' onclick='mw_charts_div_sel(\"#mw_line_div\", \"line_charts\", \"mw_line_sel\", \"on\", \"LINE CHARTS\")'></span>
									<input type='checkbox' name='line_charts' value='on' checked style='display:none'>
							</div>"; }; ?>

					<?php if ($results[16]->status === 'on'){ 
						echo "<div class='mw_selectors' id='mw_scatter_sel'>
								<p onclick='mw_ch_p_s_h(\"#mw_scatter_div\")'>SCATTER CHARTS</p>
									<span class='glyphicon glyphicon-remove-sign' onclick='mw_charts_div_sel(\"#mw_scatter_div\", \"scatter_charts\", \"mw_scatter_sel\", \"on\", \"SCATTER CHARTS\")'></span>
									<input type='checkbox' name='scatter_charts' value='on' checked style='display:none'>
							</div>"; }; ?>

					<?php if ($results[17]->status === 'on'){ 
						echo "<div class='mw_selectors' id='mw_treemap_sel'>
								<p onclick='mw_ch_p_s_h(\"#mw_treemap_div\")'>TREEMAP CHARTS</p>
									<span class='glyphicon glyphicon-remove-sign' onclick='mw_charts_div_sel(\"#mw_treemap_div\", \"treemap_charts\", \"mw_treemap_sel\", \"on\", \"TREEMAP CHARTS\")'></span>
									<input type='checkbox' name='treemap_charts' value='on' checked style='display:none'>
							</div>"; }; ?>

					<?php if ($results[18]->status === 'on'){ 
						echo "<div class='mw_selectors' id='mw_stacked_bar_sel'>
								<p onclick='mw_ch_p_s_h(\"#mw_stacked_div\")'>STACKED BAR CHARTS</p>
									<span class='glyphicon glyphicon-remove-sign' onclick='mw_charts_div_sel(\"#mw_stacked_div\", \"stacked_bar_charts\", \"mw_stacked_bar_sel\", \"on\", \"STACKED BAR CHARTS\")'></span>
									<input type='checkbox' name='stacked_bar_charts' value='on' checked style='display:none'>
							</div>"; }; ?>

					<!--<php if ($results[19]->status === 'on'){ 
						echo "<div class='mw_selectors' id='mw_trend_line_sel'>
								<p onclick='mw_ch_p_s_h(\"#mw_trend_div\")'>TREND LINE CHARTS</p>
									<span class='glyphicon glyphicon-remove-sign' onclick='mw_charts_div_sel(\"#mw_trend_div\", \"trend_line_charts\", \"mw_trend_line_sel\", \"on\", \"TREND LINE CHARTS\")'></span>
									<input type='checkbox' name='trend_line_charts' value='on' checked style='display:none'>
							</div>"; }; ?>-->

					<?php if ($results[21]->status === 'on'){ 
						echo "<div class='mw_selectors' id='mw_bubble_sel'>
								<p onclick='mw_ch_p_s_h(\"#mw_bubble_div\")'>BUBBLE CHARTS</p>
									<span class='glyphicon glyphicon-remove-sign' onclick='mw_charts_div_sel(\"#mw_bubble_div\", \"bubble_charts\", \"mw_bubble_sel\", \"on\", \"BUBBLE CHARTS\")'></span>
									<input type='checkbox' name='bubble_charts' value='on' checked style='display:none'>
							</div>"; }; ?>

					<?php if ($results[23]->status === 'on'){ 
						echo "<div class='mw_selectors' id='mw_word_cloud_sel'>
								<p onclick='mw_ch_p_s_h(\"#mw_word_div\")'>WORD CLOUD CHARTS</p>
									<span class='glyphicon glyphicon-remove-sign' onclick='mw_charts_div_sel(\"#mw_word_div\", \"word_cloud_charts\", \"mw_word_cloud_sel\", \"on\", \"WORD CLOUD CHARTS\")'></span>
									<input type='checkbox' name='word_cloud_charts' value='on' checked style='display:none'>
							</div>"; }; ?>
		</div>

		<div id='mw_admin_not_selected'>
			<p>click to include</p>
				<?php if ($results[6]->status === 'off') { 
					echo "<div class='mw_selectors' id='mw_gauge_sel' onclick='mw_charts_div_sel(\"#mw_gauge_div\", \"gauge_charts\", \"mw_gauge_sel\", \"off\", \"GAUGE CHARTS\")'>
							<p>GAUGE CHARTS</p>
							<input type='checkbox' name='gauge_charts' value='on' style='display:none'>
						</div>"; }; ?>

				<?php if ($results[7]->status === 'off') { 
					echo "<div class='mw_selectors' id='mw_buzz_pie_sel' onclick='mw_charts_div_sel(\"#mw_buzz_pie_div\", \"buzz_pie_charts\", \"mw_buzz_pie_sel\", \"off\", \"BUZZ PIE CHARTS\")'>
							<p>BUZZ PIE CHARTS</p>
							<input type='checkbox' name='buzz_pie_charts' value='on' style='display:none'>
						</div>"; }; ?>

				<?php if ($results[8]->status === 'off') { 
					echo "<div class='mw_selectors' id='mw_pie_sel' onclick='mw_charts_div_sel(\"#mw_pie_div\", \"pie_charts\", \"mw_pie_sel\", \"off\", \"PIE CHARTS\")'>
							<p>PIE CHARTS</p>
							<input type='checkbox' name='pie_charts' value='on' style='display:none'>
						</div>"; }; ?>

				<?php if ($results[9]->status === 'off') { 
					echo "<div class='mw_selectors' id='mw_bar_sel' onclick='mw_charts_div_sel(\"#mw_bar_div\", \"bar_charts\", \"mw_bar_sel\", \"off\", \"BAR CHARTS\")'>
							<p>BAR CHARTS</p>
							<input type='checkbox' name='bar_charts' value='on' style='display:none'>
						</div>"; }; ?>

				<?php if ($results[10]->status === 'off'){ 
					echo "<div class='mw_selectors' id='mw_line_sel' onclick='mw_charts_div_sel(\"#mw_line_div\", \"line_charts\", \"mw_line_sel\", \"off\", \"LINE CHARTS\")'>
							<p>LINE CHARTS</p>
							<input type='checkbox' name='line_charts' value='on' style='display:none'>
						</div>"; }; ?>

				<?php if ($results[16]->status === 'off'){ 
					echo "<div class='mw_selectors' id='mw_scatter_sel' onclick='mw_charts_div_sel(\"#mw_scatter_div\", \"scatter_charts\", \"mw_scatter_sel\", \"off\", \"SCATTER CHARTS\")'>
							<p>SCATTER CHARTS</p>
							<input type='checkbox' name='scatter_charts' value='on' style='display:none'>
						</div>"; }; ?>

				<?php if ($results[17]->status === 'off'){ 
					echo "<div class='mw_selectors' id='mw_treemap_sel' onclick='mw_charts_div_sel(\"#mw_treemap_div\", \"treemap_charts\", \"mw_treemap_sel\", \"off\", \"TREEMAP CHARTS\")'>
							<p>TREEMAP CHARTS</p>
							<input type='checkbox' name='treemap_charts' value='on' style='display:none'>
						</div>"; }; ?>

				<?php if ($results[18]->status === 'off'){ 
					echo "<div class='mw_selectors' id='mw_stacked_bar_sel' onclick='mw_charts_div_sel(\"#mw_stacked_div\", \"stacked_bar_charts\", \"mw_stacked_bar_sel\", \"off\", \"STACKED BAR CHARTS\")'>
							<p>STACKED BAR CHARTS</p>
							<input type='checkbox' name='stacked_bar_charts' value='on' style='display:none'>
						</div>"; }; ?>

				<!--<php if ($results[19]->status === 'off'){ 
					echo "<div class='mw_selectors' id='mw_trend_line_sel' onclick='mw_charts_div_sel(\"#mw_trend_div\", \"trend_line_charts\", \"mw_trend_line_sel\", \"off\", \"TREND LINE CHARTS\")'>
							<p>TREND LINE CHARTS</p>
							<input type='checkbox' name='trend_line_charts' value='on' style='display:none'>
						</div>"; }; ?>-->

				<?php if ($results[21]->status === 'off'){ 
					echo "<div class='mw_selectors' id='mw_bubble_sel' onclick='mw_charts_div_sel(\"#mw_bubble_div\", \"bubble_charts\", \"mw_bubble_sel\", \"off\", \"BUBBLE CHARTS\")'>
							<p>BUBBLE CHARTS</p>
							<input type='checkbox' name='bubble_charts' value='on' style='display:none'>
						</div>"; }; ?>

				<?php if ($results[23]->status === 'off'){ 
					echo "<div class='mw_selectors' id='mw_word_cloud_sel' onclick='mw_charts_div_sel(\"#mw_word_div\", \"word_cloud_charts\", \"mw_word_cloud_sel\", \"off\", \"WORD CLOUD CHARTS\")'>
							<p>WORD CLOUD CHARTS</p>
							<input type='checkbox' name='word_cloud_charts' value='on' style='display:none'>
						</div>"; }; ?>

		</div>

		<div class="modal fade" id="mw_apikey_admin" role="dialog">
    		<div class="modal-dialog">
	      		<div class="modal-content">
	        		<div class="modal-header">
	          			<h4 class="modal-title">Moodwire API Key</h4>
	        		</div>
	        	
	        		<div class="modal-body">
	          			<p>This is your current API key is <?php echo( $apikey); ?><br><br>This key permits your interaction with the Moodwire APIs.  Changing or altering this key can result in a loss of functionality and/or rendering the plugin inert.  You should only change this key if you understand what you are doing, AND HAVE A REASON TO ALTER THE API KEY.<br><br>Your key will not be lost.  It will be stored in the database under the MySQL table '{wp db prefix}_mw_key'.<br><br>If you uninstall the plugin all Wordpress DB tables pertaining to this plugin will be removed, EXCEPT FOR THE API KEY TABLE.<br><br><br>This will facilitate easy recovery if need be.</p>

	          				<input type='text' name='mw_update_api_key' id='mw_update_api_key_modal'>
	          				<input class='btn btn-danger' type='submit' value='Update'>
	          			
	        		</div>
	        
	        		<div class="modal-footer">
	          			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	        		</div>
	      		</div>
      
    		</div>
  		</div>
	</div>

	<div id='mw_admin_settings'>
			<div class='mw_ad_ch_div' id="mw_options_div">
				
				<div id='mw_api_buttons'>
					<button id='mw_call_sign' class='btn btn-md btn-info' type='button' onclick="mw_call_count('<?php echo ($apikey); ?>')" <?php if ( $apikey === 'XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX' ) { echo 'disabled'; };?>>Calls left</button>
					<button type='button' class='btn btn-md btn-danger' data-toggle='modal' data-target='#mw_apikey_admin'>Update API Key</button>
				</div>
				
				<label for="title_name" id='title_input'>TITLE</label>										<!--		NAME YOUR WIDGET 	-->
					<input class='spacing_mw_input' type="text" id="title_name" name='title_name' value="<?php echo( $results[2]); ?>">
					<span class='mw_more_data glyphicon glyphicon-question-sign' data-toggle="mw_title_name" title="Your title" data-content="This will set your title to display within the plugin."></span>

				<label for='select_total' id='mw_select'>NUMBER OF ARTICLES</label>							<!--		LIMIT # OF ARTICLES 	-->	
					<select class='spacing_mw_input mw-select' name='total' id='select_total'>						
						<option value="1"		<?php if ($results[1] == 1)		{ echo "selected"; } ?>>1</option>
						<option value="2"		<?php if ($results[1] == 2)		{ echo "selected"; } ?>>2</option>
						<option value="3"		<?php if ($results[1] == 3)		{ echo "selected"; } ?>>3</option>
						<option value="4"		<?php if ($results[1] == 4)		{ echo "selected"; } ?>>4</option>
						<option value="5"		<?php if ($results[1] == 5)		{ echo "selected"; } ?>>5</option>
						<option value="6"		<?php if ($results[1] == 6)		{ echo "selected"; } ?>>6</option>
						<option value="7"		<?php if ($results[1] == 7)		{ echo "selected"; } ?>>7</option>
						<option value="8"		<?php if ($results[1] == 8)		{ echo "selected"; } ?>>8</option>
						<option value="9"		<?php if ($results[1] == 9)		{ echo "selected"; } ?>>9</option>
						<option value="10"		<?php if ($results[1] == 10)	{ echo "selected"; } ?>>10</option>
					</select>
					<span class='mw_more_data glyphicon glyphicon-question-sign' data-toggle="mw_total_display" title="# articles to display" data-content="This will set the amount of articles to display within the plugin.  It defaults to 5 articles."></span></br>

				<div class="form-group has-feedback mw_date ">
					<label for='mw_date_start' id='mw_date' class='control-label'>DATE RANGE</label>
					</br>
					<input class='form-control' type='date' name='mw_date_start'>
					<span class='glyphicon glyphicon-calendar form-control-feedback mw_cal_span_ow'></span>
				</div>

				<p class='mw_date mw_date_to'>TO</p>

				<div class="form-group has-feedback mw_date ">
					<label for='mw_date_end' class='control-label'></label>
					<input class='form-control' type='date' name='mw_date_end'>
					<span class='glyphicon glyphicon-calendar form-control-feedback mw_cal_span_ow'></span>
				</div>	

				
					<div class='mw_no_hover'>
						<p>IMAGES</p>
							<label class='switch'>
								<input type='checkbox' name='mw_images' value='on' 						<?php if ($results[11]->mw_images === 'on')		{ echo "checked"; } ?>>
									<div class='slider round'></div>
							</label>
					</div>

					<div class='mw_no_hover'>
						<p>ASSOCIATION DROPDOWNS</p>
							<label class='switch'>
								<input type='checkbox' name='mw_assoc' value='on' 						<?php if ($results[11]->mw_assoc === 'on')		{ echo "checked"; } ?>>
									<div class='slider round'></div>
							</label>
					</div>

					<div class='mw_no_hover'>
						<p>BORDER</p>
							<label class='switch'>
								<input type='checkbox' name='mw_border' value='on' 						<?php if ($results[11]->mw_border === 'on')		{ echo "checked"; } ?>>
									<div class='slider round'></div>
							</label>
					</div>
			</div>

			<div id='mw_filter_div' class='mw_ad_ch_div'>
				<h3>FILTERS</h3>
																										
				<!--<button class="mw_icon_add" type='button' onclick='create_filter_param_input();'><span class="glyphicon glyphicon-plus-sign"></span></button>-->

				<div id='filter_params_div'></div>
				
				<div id="pill_lot">																			<!--		UPDATE FILTER PARAMETERS 	-->
					<div class='lot_pill'>
						<input class='filt_par spacing_mw_input' type="text" id="filter_parameters" onkeypress='updateFilterParams(event);' placeholder='Enter keywords' name="filter_params[]">
							<span class='mw_more_data glyphicon glyphicon-question-sign' data-toggle="mw_filter_params" title="filter options" data-content="These parameters will update your search to include these keywords in both the article and the article title.  If you want to cover a generic topic, e.g. 'disc golf', you can search for articles related to this topic.  You can also search for specific individuals, e.g. 'Donald Trump' and 'Hillary Clinton', and get recent articles relating to these entities."></span>
					</div>
				</div>		

				<div id="exclude_lot">																		<!--		UPDATE EXCLUDE PARAMETERS 	-->
					<div class='lot_pill'>
						<input class='filt_par spacing_mw_input' type="text" id="exclude_parameters" onkeypress='updateExcludeParams(event);' placeholder='Exclude keywords' name="exclude_params[]">
							<span class='mw_more_data glyphicon glyphicon-question-sign' data-toggle="mw_exclude_params" title="exclude filter" data-content="These parameters will update your search to exclude these keywords in both the article and the article title.  If you want to cover a generic topic, e.g. 'disc golf', you can search for articles unrelated to this topic.  You can also exclude specific entities, e.g. 'Donald Trump' and 'Hillary Clinton', and get recent articles not relating to these entities."></span>
					</div>
				</div>																					
				
				<div id="chart_lot">																		<!--		UPDATE CHART PARAMETERS 	-->
					<div class='lot_pill'>
						<input class='spacing_mw_input' type="text" id="chart_parameters" placeholder='Check specific entity' onkeyup="chartSearch('<?php echo( $apikey); ?>');">
							<span class='mw_more_data glyphicon glyphicon-question-sign' data-toggle="mw_chart_params" title="Chart data" data-content="These entities will return data from the Moodwire summary API.  The data will be rendered into charts that have been selected to be displayed."></span>
					</div>
				</div>

						<ul class='chart_results'></ul>
			</div>
																										<!--		UPDATE SOURCE PARAMETERS 	-->
			<!--<input class='spacing_mw_input' type="text" id="source_parameters" placeholder='Source Data' onkeyup="doSearch('< echo( $apikey); ?>');">
			<span class='mw_more_data glyphicon glyphicon-question-sign' data-toggle="mw_source_params" title="Selected sources" data-content="These parameters will give priority to finding articles written/hosted by the entities selected."></span>-->

				<!--<div id="source_lot"></div>
					<ul class='search_results'></ul>-->
			<div id="mw_all_ch_div">

				<div class='mw_ad_ch_div' id="mw_gauge_div">
					<h3>GAUGE CHARTS</h3>
						<h5>CHART SIZE:</h5>
							<label>Small</label>	<input type="radio" name="mw_gauge_size" value="small" 				<?php if ($results[6]->size === "small")		{ echo "checked"; } ?>>
							<label>Medium</label>	<input type="radio" name="mw_gauge_size" value="medium"				<?php if ($results[6]->size === "medium")		{ echo "checked"; } ?>>
							<label>Large</label>	<input type="radio" name="mw_gauge_size" value="large"				<?php if ($results[6]->size === "large")		{ echo "checked"; } ?>><br>

						<h5>CHART COLOR:</h5>
							<label>Default</label>	<input type="radio" name="mw_gauge_colors" value="default" 			<?php if ($results[6]->colors === "default")	{ echo "checked"; } ?>>
							<label>Light</label>	<input type="radio" name="mw_gauge_colors" value="light"			<?php if ($results[6]->colors === "light")		{ echo "checked"; } ?>>
							<label>Dark</label>		<input type="radio" name="mw_gauge_colors" value="dark"				<?php if ($results[6]->colors === "dark")		{ echo "checked"; } ?>>
				</div>

				<div class='mw_ad_ch_div' id="mw_buzz_pie_div">
					<h3>BUZZ PIE CHARTS</h3>
						<h5>CHART SIZE:</h5>
							<label>Small</label>	<input type="radio" name="mw_buzz_pie_size" value="small" 			<?php if ($results[7]->size === "small")		{ echo "checked"; } ?>>
							<label>Medium</label>	<input type="radio" name="mw_buzz_pie_size" value="medium"			<?php if ($results[7]->size === "medium")		{ echo "checked"; } ?>>
							<label>Large</label>	<input type="radio" name="mw_buzz_pie_size" value="large"			<?php if ($results[7]->size === "large")		{ echo "checked"; } ?>><br>

						<h5>CHART COLOR:</h5>
							<label>Default</label>	<input type="radio" name="mw_buzz_pie_colors" value="default" 		<?php if ($results[7]->colors === "default")	{ echo "checked"; } ?>>
							<label>Light</label>	<input type="radio" name="mw_buzz_pie_colors" value="light"			<?php if ($results[7]->colors === "light")		{ echo "checked"; } ?>>
							<label>Dark</label>		<input type="radio" name="mw_buzz_pie_colors" value="dark"			<?php if ($results[7]->colors === "dark")		{ echo "checked"; } ?>>
				</div>

				<div class='mw_ad_ch_div' id="mw_pie_div">
					<h3>PIE CHARTS</h3>
						<h5>CHART SIZE:</h5>
							<label>Small</label>	<input type="radio" name="mw_pie_charts_size" value="small" 		<?php if ($results[8]->size === "small")		{ echo "checked"; } ?>>
							<label>Medium</label>	<input type="radio" name="mw_pie_charts_size" value="medium"		<?php if ($results[8]->size === "medium")		{ echo "checked"; } ?>>
							<label>Large</label>	<input type="radio" name="mw_pie_charts_size" value="large"			<?php if ($results[8]->size === "large")		{ echo "checked"; } ?>><br>

						<h5>CHART COLOR:</h5>
							<label>Default</label>	<input type="radio" name="mw_pie_charts_colors" value="default" 	<?php if ($results[8]->colors === "default")	{ echo "checked"; } ?>>
							<label>Light</label>	<input type="radio" name="mw_pie_charts_colors" value="light"		<?php if ($results[8]->colors === "light")		{ echo "checked"; } ?>>
							<label>Dark</label>		<input type="radio" name="mw_pie_charts_colors" value="dark"		<?php if ($results[8]->colors === "dark")		{ echo "checked"; } ?>>
				</div>

				<div class='mw_ad_ch_div' id="mw_bar_div">
					<h3>BAR CHARTS</h3>
						<h5>CHART SIZE:</h5>
							<label>Small</label>	<input type="radio" name="mw_bar_size" value="small" 				<?php if ($results[9]->size === "small")		{ echo "checked"; } ?>>
							<label>Medium</label>	<input type="radio" name="mw_bar_size" value="medium"				<?php if ($results[9]->size === "medium")		{ echo "checked"; } ?>>
							<label>Large</label>	<input type="radio" name="mw_bar_size" value="large"				<?php if ($results[9]->size === "large")		{ echo "checked"; } ?>><br>

						<h5>CHART COLOR:</h5>
							<label>Default</label>	<input type="radio" name="mw_bar_colors" value="default" 			<?php if ($results[9]->colors === "default")	{ echo "checked"; } ?>>
							<label>Light</label>	<input type="radio" name="mw_bar_colors" value="light"				<?php if ($results[9]->colors === "light")		{ echo "checked"; } ?>>
							<label>Dark</label>		<input type="radio" name="mw_bar_colors" value="dark"				<?php if ($results[9]->colors === "dark")		{ echo "checked"; } ?>>
				</div>

				<div class='mw_ad_ch_div' id="mw_line_div">
					<h3>LINE CHARTS</h3>
						<h5>CHART SIZE:</h5>
							<label>Small</label>	<input type="radio" name="mw_line_size" value="small" 				<?php if ($results[10]->size === "small")		{ echo "checked"; } ?>>
							<label>Medium</label>	<input type="radio" name="mw_line_size" value="medium"				<?php if ($results[10]->size === "medium")		{ echo "checked"; } ?>>
							<label>Large</label>	<input type="radio" name="mw_line_size" value="large"				<?php if ($results[10]->size === "large")		{ echo "checked"; } ?>><br>

						<h5>CHART COLOR:</h5>
							<label>Default</label>	<input type="radio" name="mw_line_colors" value="default" 			<?php if ($results[10]->colors === "default")	{ echo "checked"; } ?>>
							<label>Light</label>	<input type="radio" name="mw_line_colors" value="light"				<?php if ($results[10]->colors === "light")		{ echo "checked"; } ?>>
							<label>Dark</label>		<input type="radio" name="mw_line_colors" value="dark"				<?php if ($results[10]->colors === "dark")		{ echo "checked"; } ?>>
				</div>

				<div class='mw_ad_ch_div' id="mw_scatter_div">
					<h3>SCATTER CHARTS</h3>
						<h5>CHART SIZE:</h5>
							<label>Small</label>	<input type="radio" name="mw_scatter_size" value="small" 			<?php if ($results[16]->size === "small")		{ echo "checked"; } ?>>
							<label>Medium</label>	<input type="radio" name="mw_scatter_size" value="medium"			<?php if ($results[16]->size === "medium")		{ echo "checked"; } ?>>
							<label>Large</label>	<input type="radio" name="mw_scatter_size" value="large"			<?php if ($results[16]->size === "large")		{ echo "checked"; } ?>><br>

						<h5>CHART COLOR:</h5>
							<label>Default</label>	<input type="radio" name="mw_scatter_colors" value="default" 		<?php if ($results[16]->colors === "default")	{ echo "checked"; } ?>>
							<label>Light</label>	<input type="radio" name="mw_scatter_colors" value="light"			<?php if ($results[16]->colors === "light")		{ echo "checked"; } ?>>
							<label>Dark</label>		<input type="radio" name="mw_scatter_colors" value="dark"			<?php if ($results[16]->colors === "dark")		{ echo "checked"; } ?>>
				</div>
					
				<div class='mw_ad_ch_div' id="mw_treemap_div">
					<h3>TREEMAP CHARTS</h3>
						<h5>CHART SIZE:</h5>
							<label>Small</label>	<input type="radio" name="mw_treemap_size" value="small" 			<?php if ($results[17]->size === "small")		{ echo "checked"; } ?>>
							<label>Medium</label>	<input type="radio" name="mw_treemap_size" value="medium"			<?php if ($results[17]->size === "medium")		{ echo "checked"; } ?>>
							<label>Large</label>	<input type="radio" name="mw_treemap_size" value="large"			<?php if ($results[17]->size === "large")		{ echo "checked"; } ?>><br>

						<h5>CHART COLOR:</h5>
							<label>Default</label>	<input type="radio" name="mw_treemap_colors" value="default" 		<?php if ($results[17]->colors === "default")	{ echo "checked"; } ?>>
							<label>Light</label>	<input type="radio" name="mw_treemap_colors" value="light"			<?php if ($results[17]->colors === "light")		{ echo "checked"; } ?>>
							<label>Dark</label>		<input type="radio" name="mw_treemap_colors" value="dark"			<?php if ($results[17]->colors === "dark")		{ echo "checked"; } ?>>
				</div>
					
				<div class='mw_ad_ch_div' id="mw_stacked_div">
					<h3>STACKED BAR CHARTS</h3>
						<h5>CHART SIZE:</h5>
							<label>Small</label>	<input type="radio" name="mw_stacked_size" value="small" 			<?php if ($results[18]->size === "small")		{ echo "checked"; } ?>>
							<label>Medium</label>	<input type="radio" name="mw_stacked_size" value="medium"			<?php if ($results[18]->size === "medium")		{ echo "checked"; } ?>>
							<label>Large</label>	<input type="radio" name="mw_stacked_size" value="large"			<?php if ($results[18]->size === "large")		{ echo "checked"; } ?>><br>

						<h5>CHART COLOR:</h5>
							<label>Default</label>	<input type="radio" name="mw_stacked_colors" value="default" 		<?php if ($results[18]->colors === "default")	{ echo "checked"; } ?>>
							<label>Light</label>	<input type="radio" name="mw_stacked_colors" value="light"			<?php if ($results[18]->colors === "light")		{ echo "checked"; } ?>>
							<label>Dark</label>		<input type="radio" name="mw_stacked_colors" value="dark"			<?php if ($results[18]->colors === "dark")		{ echo "checked"; } ?>>
				</div>
					
				<!--<div class='mw_ad_ch_div' id="mw_trend_div">
					<h3>TREND LINE CHARTS</h3>
						<h5>CHART SIZE:</h5>
							<label>Small</label>	<input type="radio" name="mw_trend_size" value="small" 				<php if ($results[19]->size === "small")		{ echo "checked"; } ?>>
							<label>Medium</label>	<input type="radio" name="mw_trend_size" value="medium"				<php if ($results[19]->size === "medium")		{ echo "checked"; } ?>>
							<label>Large</label>	<input type="radio" name="mw_trend_size" value="large"				<php if ($results[19]->size === "large")		{ echo "checked"; } ?>><br>

						<h5>CHART COLOR:</h5>
							<label>Default</label>	<input type="radio" name="mw_trend_colors" value="default" 			<php if ($results[19]->colors === "default")	{ echo "checked"; } ?>>
							<label>Light</label>	<input type="radio" name="mw_trend_colors" value="light"			<php if ($results[19]->colors === "light")		{ echo "checked"; } ?>>
							<label>Dark</label>		<input type="radio" name="mw_trend_colors" value="dark"				<php if ($results[19]->colors === "dark")		{ echo "checked"; } ?>>
				</div>-->
					
				<!--<div class='mw_ad_ch_div' id="mw_calendar_div">
					<h5>CHART SIZE:</h5>
						<label>Small</label>	<input type="radio" name="mw_calendar_size" value="small" 			<php if ($results[20]->size === "small")		{ echo "checked"; } ?>>
							<label>Medium</label>	<input type="radio" name="mw_calendar_size" value="medium"			<php if ($results[20]->size === "medium")		{ echo "checked"; } ?>>
							<label>Large</label>	<input type="radio" name="mw_calendar_size" value="large"				<php if ($results[20]->size === "large")		{ echo "checked"; } ?>><br>

					<h5>CHART COLOR:</h5>
							<label>Default</label>	<input type="radio" name="mw_calendar_colors" value="default" 		<php if ($results[20]->colors === "default")	{ echo "checked"; } ?>>
							<label>Light</label>	<input type="radio" name="mw_calendar_colors" value="light"			<php if ($results[20]->colors === "light")		{ echo "checked"; } ?>>
							<label>Dark</label>		<input type="radio" name="mw_calendar_colors" value="dark"				<php if ($results[20]->colors === "dark")		{ echo "checked"; } ?>>
				</div>-->
					
				<div class='mw_ad_ch_div' id="mw_bubble_div">
					<h3>BUBBLE CHARTS</h3>
						<h5>CHART SIZE:</h5>
							<label>Small</label>	<input type="radio" name="mw_bubble_size" value="small" 			<?php if ($results[21]->size === "small")		{ echo "checked"; } ?>>
							<label>Medium</label>	<input type="radio" name="mw_bubble_size" value="medium"			<?php if ($results[21]->size === "medium")		{ echo "checked"; } ?>>
							<label>Large</label>	<input type="radio" name="mw_bubble_size" value="large"				<?php if ($results[21]->size === "large")		{ echo "checked"; } ?>><br>

						<h5>CHART COLOR:</h5>
							<label>Default</label>	<input type="radio" name="mw_bubble_colors" value="default" 		<?php if ($results[21]->colors === "default")	{ echo "checked"; } ?>>
							<label>Light</label>	<input type="radio" name="mw_bubble_colors" value="light"			<?php if ($results[21]->colors === "light")		{ echo "checked"; } ?>>
							<label>Dark</label>		<input type="radio" name="mw_bubble_colors" value="dark"			<?php if ($results[21]->colors === "dark")		{ echo "checked"; } ?>>
				</div>
					
				<!--<div class='mw_ad_ch_div' id="mw_location_div">
					<h5>CHART SIZE:</h5>
						<label>Small</label>	<input type="radio" name="mw_location_size" value="small" 			<php if ($results[22]->size === "small")		{ echo "checked"; } ?>>
							<label>Medium</label>	<input type="radio" name="mw_location_size" value="medium"			<php if ($results[22]->size === "medium")		{ echo "checked"; } ?>>
							<label>Large</label>	<input type="radio" name="mw_location_size" value="large"				<php if ($results[22]->size === "large")		{ echo "checked"; } ?>><br>

					<h5>CHART COLOR:</h5>
							<label>Default</label>	<input type="radio" name="mw_location_colors" value="default" 		<php if ($results[22]->colors === "default")	{ echo "checked"; } ?>>
							<label>Light</label>	<input type="radio" name="mw_location_colors" value="light"			<php if ($results[22]->colors === "light")		{ echo "checked"; } ?>>
							<label>Dark</label>		<input type="radio" name="mw_location_colors" value="dark"				<php if ($results[22]->colors === "dark")		{ echo "checked"; } ?>>
				</div>-->
					
				<div class='mw_ad_ch_div' id="mw_word_div">
					<h3>WORD CLOUD CHARTS</h3>
						<h5>CHART SIZE:</h5>
							<label>Small</label>	<input type="radio" name="mw_word_size" value="small" 				<?php if ($results[23]->size === "small")		{ echo "checked"; } ?>>
							<label>Medium</label>	<input type="radio" name="mw_word_size" value="medium"				<?php if ($results[23]->size === "medium")		{ echo "checked"; } ?>>
							<label>Large</label>	<input type="radio" name="mw_word_size" value="large"				<?php if ($results[23]->size === "large")		{ echo "checked"; } ?>><br>

						<h5>CHART COLOR:</h5>
							<label>Default</label>	<input type="radio" name="mw_word_colors" value="default" 			<?php if ($results[23]->colors === "default")	{ echo "checked"; } ?>>
							<label>Light</label>	<input type="radio" name="mw_word_colors" value="light"				<?php if ($results[23]->colors === "light")		{ echo "checked"; } ?>>
							<label>Dark</label>		<input type="radio" name="mw_word_colors" value="dark"				<?php if ($results[23]->colors === "dark")		{ echo "checked"; } ?>>
				</div>
			</div>
	</div>	
					<?php if ( $apikey === 'XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX' ) { echo "<div id='mw_admin_sub_can'><a class='btn btn-md btn-info' href='http://www.moodwire.com/developer' target='_blank'>Request your new key here</a></div>";
					} else { echo "<div id='mw_admin_sub_can'><input class='btn btn-md btn-primary' type='submit' value='Update'>&nbsp<a href='javascript:history.go(0)' class='btn btn-md btn-default' id='mw_default_refresh'>Undo Changes</a></div>"; }; ?>

		</form>
										

</div>

<?php
    	include 	( plugin_dir_path(__FILE__) . "mw_css/mw_admin.css" );					//		LINK TO WIDGET CSS
		}

?>
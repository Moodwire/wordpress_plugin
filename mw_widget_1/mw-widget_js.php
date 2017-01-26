<script>

	var filter_params_array = [];
	var exclude_params_array = [];
	var filter_source = [];
	var filter_chart = [];
	
	var entity = hf.getURLParam("entities","none");
    var gData = {};         
	var gModeActive  = entity== "none" ? "search" : "entity";
	var uuid = "";

	var filter_params_sterile = '';
	var scored_here = [];
	var count = 1;


	$(document).on('keypress','input', function(event) {									//--------		PREVENTS A USER PRESSING ENTER AND SUBMITTING THE FORM
			if (event.keyCode == 13) {return false;}
		});//--------	--------	--------	--------	--------

			
	function updateFilterParams() {															//--------		STORES FILTER PARAMETERS FOR API CALL AND GENERATES A 'PILL'
		if (event.keyCode === 13) {
			var pill_params = document.getElementById('filter_parameters').value;			//--	PULLS THE INPUT VALUE
			pill_params = pill_params.trim();
			pill_params = recursive_filter_cleaning(pill_params);
			pill_params = pill_params.trim();

			filterParamCreateFilterPill('filter', pill_params);								//--	creates the PILL
			document.getElementById('filter_parameters').value = '';						//-- 	CLEARS THE INPUT
		
			return filter_params_array;
		} 
	};//--------	--------	--------	--------	--------


	function updateExcludeParams() {														//--------		STORES EXCLUDE PARAMETERS FOR API CALL AND GENERATES A 'PILL'
		if (event.keyCode === 13) {
			var pill_params = document.getElementById('exclude_parameters').value;			//--	PULLS THE INPUT VALUE
			pill_params = pill_params.trim();
			pill_params = recursive_filter_cleaning(pill_params);
			pill_params = pill_params.trim();

			filterParamCreateFilterPill('exclude', pill_params);							//--	creates the PILL
			document.getElementById('exclude_parameters').value = '';						//-- 	CLEARS THE INPUT
		
			return exclude_params_array;
		} 
	};//--------	--------	--------	--------	--------


	function filterParamCreateFilterPill(destination, pill_params) {										//--------		CREATES THE FILTER PILL
	
		if (destination == 'filter') {
			var id_pill_params = "";
			var change_pill_params = [];
			var pill_pre = 'pill_';

			if (pill_params === "") { 															//--	PREVENTS EMPTY STRING ENTRY
					return;
				} 									
		
			for(var i = 0; i < filter_params_array.length; i++) {
				if (filter_params_array[i] === pill_params) { 									//--	PREVENTS DUPLICATES
					document.getElementById('filter_parameters').value = '';
					return;
				}
			}

			if (pill_params.search(" ")) {														//--	PREVENTS A SPACE IN THE ID NAME
				change_pill_params = pill_params.split(" ");

				var i = 0;																		//--	WHILE LOOP TO CONVERT ARRAY TO ONE LONG STRING FOR ID'S
				while (i < change_pill_params.length) {
					change_pill_params[i] = change_pill_params[i].trim();						//--	REMOVES THE WHITESPACE
					change_pill_params[i] = fix_apostrophes_moody(change_pill_params[i]);
					id_pill_params = id_pill_params.concat(change_pill_params[i]);
					i++;
				}

				id_pill_params = pill_pre + id_pill_params;
			} else {
				id_pill_params = pill_pre + pill_params;
			}				
	//-- mw_count is used solely for failed entity search in the api calls (prevents losing these parameters)
			
			$('#pill_lot').prepend(
				"<div class='mw_div_spacing' id='" + id_pill_params + "' onclick='removeFilterParams(\"" + id_pill_params + "\",\"" + fix_apostrophes_moody(pill_params) + "\") '>"
					+ "<p class='filter_pill btn mw_count' >" + pill_params + "</p>"
					+ "<input id=\"" + id_pill_params + "\" type='hidden' value='" + pill_params + "' name='filter_params[]'>"
					+ "</div>");

			// $('#pill_lot').prepend("<input class='filter_pill btn mw_count' id=\"" + id_pill_params + "\" onclick='removeFilterParams(\"" + id_pill_params + "\",\"" + fix_apostrophes_moody(pill_params) + "\")' value=\"" + pill_params + "\"  name='filter_params[]' />");

			filter_params_array.push(pill_params);
			return filter_params_array;
		}

		if (destination == 'exclude') {
			var id_pill_params = "";
			var change_pill_params = [];
			var pill_pre = 'exclude_';

			if (pill_params === "") { 															//--	PREVENTS EMPTY STRING ENTRY
					return;
				} 									
		
			for(var i = 0; i < exclude_params_array.length; i++) {
				if (exclude_params_array[i] === pill_params) { 									//--	PREVENTS DUPLICATES
					document.getElementById('exclude_parameters').value = '';
					return;
				}
			}

			if (pill_params.search(" ")) {														//--	PREVENTS A SPACE IN THE ID NAME
				change_pill_params = pill_params.split(" ");

				var i = 0;																		//--	WHILE LOOP TO CONVERT ARRAY TO ONE LONG STRING FOR ID'S
				while (i < change_pill_params.length) {
					change_pill_params[i] = change_pill_params[i].trim();						//--	REMOVES THE WHITESPACE
					change_pill_params[i] = fix_apostrophes_moody(change_pill_params[i]);
					id_pill_params = id_pill_params.concat(change_pill_params[i]);
					i++;
				}

				id_pill_params = pill_pre + id_pill_params;
			} else {
				id_pill_params = pill_pre + pill_params;
			}				
	//-- mw_count is used solely for failed entity search in the api calls (prevents losing these parameters)
			
			$('#exclude_lot').prepend(
				"<div class='mw_div_spacing' id='" + id_pill_params + "' onclick='removeFilterParams(\"" + id_pill_params + "\",\"" + fix_apostrophes_moody(pill_params) + "\") '>"
					+ "<p class='filter_pill btn mw_count' >" + pill_params + "</p>"
					+ "<input id=\"" + id_pill_params + "\" type='hidden' value='" + pill_params + "' name='exclude_params[]'>"
					+ "</div>");

			// $('#pill_lot').prepend("<input class='filter_pill btn mw_count' id=\"" + id_pill_params + "\" onclick='removeFilterParams(\"" + id_pill_params + "\",\"" + fix_apostrophes_moody(pill_params) + "\")' value=\"" + pill_params + "\"  name='filter_params[]' />");

			exclude_params_array.push(pill_params);
			return exclude_params_array;
		}
	};//--------	--------	--------	--------	--------

	
	function fix_apostrophes_moody(id_pill_params) {										//--------		PERMITS PILL REMOVAL WHEN APOSTOPHES ARE PRESENT
			id_pill_params = id_pill_params.replace(/'/g, "_");
			id_pill_params = id_pill_params.replace(/"/g, '_');
		return id_pill_params;
	};//--------	--------	--------	--------	--------


	function removeFilterParams(id_pill_params, pill_params) {								//--------		THIS WILL REMOVE THE FILTER 'PILL' THAT WAS DYNAMICALLY GENERATED
		var pill = document.getElementById(id_pill_params);
		var bad_pill = pill_params;

		if (pill) {
			for (var i = 0; i < filter_params_array.length; i++) {
				if (bad_pill === filter_params_array[i]) {
					filter_params_array.splice(i,1);
				}
			}
	
			var delete_param = pill;
			$(delete_param).remove();
			return filter_params_array;
		}
	};//--------	--------	--------	--------	--------


	function updateSourceParams(destination, name, uuid) {									//--------		STORES SOURCE UUID FOR API CALL AND GENERATES A 'PILL'
		var id_source_params = "";
		var change_source_params = [];
		var id_chart_params = "";
		var change_chart_params = [];
		
		name_1 = name.replace(/%27/g, "'");
		name_1 = name_1.replace(/%22/g, '"');
// console.log('name', name);
// console.log('name_1',name_1);

		if (destination == 'source') {
			if (name === "") { 																//--	PREVENTS EMPTY STRING ENTRY
				return;
			} 			

			for(var i = 0; i < filter_source.length; i++) {
				if (filter_source[i] === uuid) { 											//--	PREVENTS DUPLICATES
					document.getElementById('source_parameters').value = '';
					return;
				}
			}

			if (name.search(" ")) {															//--	PREVENTS A SPACE IN THE ID NAME
				change_source_params = name.split(" ");
				var c = 0;

				while (c < change_source_params.length) {
					change_source_params[c] = change_source_params[c].trim();
					id_source_params = id_source_params.concat(change_source_params[c]);
					c++;
				}

				id_source_params = "source_" + id_source_params;

			} else {
				id_source_params = "source_" + name;
			}

			name_1 = name.replace(/%27/g, "'");
			name_1 = name.replace(/%22/g, '"');
			
			$('#source_lot').prepend("<div class='mw_div_spacing' id='" + id_source_params + "' onclick='removeSourceParams(\"" + id_source_params + "\",\"" + uuid + "\") '>" 
				+ "<p class='filter_pill btn' >" + name_1 + "</p>"
				+ "<input class='" + id_source_params + "' type='hidden' value='" + name + "' name='source_names[]'>"
				+ "<input class='" + id_source_params + "' type='hidden' value='" + uuid + "' name='source_params[]'>"
				+ "</div>");

			filter_source.push(uuid);
			if (document.getElementById('source_parameters')) {
				document.getElementById('source_parameters').value = '';
			}
			
			return filter_source;
		}

		if (destination == 'chart') {
			if (name === "") { 																//--	PREVENTS EMPTY STRING ENTRY
				return;
			} 			

			for(var i = 0; i < filter_chart.length; i++) {
				if (filter_chart[i] === uuid) { 											//--	PREVENTS DUPLICATES
					document.getElementById('chart_parameters').value = '';
					return;
				}
			}

			if (name.search(" ")) {															//--	PREVENTS A SPACE IN THE ID NAME
				change_chart_params = name.split(" ");
				var c = 0;

				while (c < change_chart_params.length) {
					change_chart_params[c] = change_chart_params[c].trim();
					id_chart_params = id_chart_params.concat(change_chart_params[c]);
					c++;
				}

				id_chart_params = "chart_" + id_chart_params;

			} else {
				id_chart_params = "chart_" + name;
			}

			$('#chart_lot').prepend("<div class='mw_div_spacing' id='" + id_chart_params + "' onclick='removeChartParams(\"" + id_chart_params + "\",\"" + uuid + "\") '>" 
				+ "<p class='filter_pill btn' >" + name_1 + "</p>"
				+ "<input class='" + id_chart_params + "' type='hidden' value='" + name + "' name='chart_names[]'>"
				+ "<input class='" + id_chart_params + "' type='hidden' value='" + uuid + "' name='chart_params[]'>"
				+ "</div>");

			filter_chart.push(uuid);
			if (document.getElementById('chart_parameters')) {
				document.getElementById('chart_parameters').value = '';
			}

			return filter_chart;
		}
	};//--------	--------	--------	--------	--------


	function removeSourceParams(id_source_params,uuid) {									//--------		REMOVES THE SOURCE PILL AND UUID BEFORE THE API CALL	
		var source_pill = document.getElementById(id_source_params);
		var bad_pill = uuid;

		if (source_pill) {
			for (var i = 0; i < filter_source.length; i++) {
				if (bad_pill === filter_source[i]) {
					filter_source.splice(i,1);
				}
			}

			$(source_pill).remove();
			return filter_source;
		}
	};//--------	--------	--------	--------	--------

	function removeChartParams(id_chart_params,uuid) {										//--------		REMOVES THE CHART PILL AND UUID BEFORE THE API CALL		
		var chart_pill = document.getElementById(id_chart_params);
		var bad_pill = uuid;

		if (chart_pill) {
			for (var i = 0; i < filter_chart.length; i++) {
				if (bad_pill === filter_chart[i]) {
					filter_chart.splice(i,1);
				}
			}

			$(chart_pill).remove();
			return filter_chart;
		}
	};//--------	--------	--------	--------	--------


	function mw_load_all_and_populate(filter_pill_to_be,source_uuid,source_name,chart_uuid,chart_name,exclude_pill_to_be) {	//--------		CONVERTS DATA TO PILLS ON PAGE LOAD
		if ( filter_pill_to_be != '' ) {
			mw_db_conversion_for_pill_and_display_filter_params('filter', filter_pill_to_be);
		}
		if ( exclude_pill_to_be != '' ) {
			mw_db_conversion_for_pill_and_display_filter_params('exclude', exclude_pill_to_be);
		}
		if ( source_uuid != '' ) {
			mw_db_conversion_for_pill_and_display_source_params('source', source_name, source_uuid);
		}
		if (chart_uuid != '') {
			mw_db_conversion_for_pill_and_display_source_params('chart', chart_name, chart_uuid);
		}
	};//--------	--------	--------	--------	--------

	function widget_on_load(chart_builder, word_data, chart_selectors) {								//--------		THIS HAPPENS ON THE MW-WIDGET.PHP PAGE (not admin page)
	// function widget_on_load(chart_builder, location_data, word_data) {						//--------		THIS HAPPENS ON THE MW-WIDGET.PHP PAGE (not admin page)
		// function widget_on_load(chart_builder) {									//--------		THIS HAPPENS ON THE MW-WIDGET.PHP PAGE (not admin page)
		google.charts.load('current', {'packages':['gauge', 'corechart', 'bar', 'treemap', 'calendar']});
		// google.charts.load('upcoming',{'packages': ['geochart']});						//--------		heat map by states, needs apikey
		google.charts.setOnLoadCallback(function new_attempt(){mw_draw_charts(chart_builder, word_data, chart_selectors);});	//--	waits to perform call on libraries until loaded	
		// google.charts.setOnLoadCallback(function new_attempt(){mw_draw_charts(chart_builder, location_data, word_data);});	//--	waits to perform call on libraries until loaded				
		// google.charts.setOnLoadCallback(function new_attempt(){mw_draw_charts(chart_builder);});	//--	waits to perform call on libraries until loaded				
	};//--------	--------	--------	--------	--------


	function mw_db_conversion_for_pill_and_display_filter_params(destination, pill_to_be) {				//--------	PULLS STRING FROM DB, FRACTURES IT, AND SENDS IT TO RENDER 'PILLS'
		pill_to_be = pill_to_be.replace(/%20/g, ' ');
		pill_to_be = pill_to_be.split(',');
		for (var i = 0; i < pill_to_be.length; i++) {
			filterParamCreateFilterPill(destination, pill_to_be[i]);
		}
	};//--------	--------	--------	--------	--------


	function mw_db_conversion_for_pill_and_display_source_params(destination, name, uuid) {	//--------	PULLS STRING FROM DB, FRACTURES IT, SYNCS AND SENDS IT TO RENDER 'PILLS'
		var name_pickles = [];
		var uuid_pickles = [];

		name = name.split(',');																//--	push names into an array for iteration
		for (var i = 0; i < name.length; i++) {												
			name_pickles.push(name[i]);
		}

		uuid = uuid.split(',');																//--	push uuids into an array for iteration
		for (var i = 0; i < uuid.length; i++) {
			uuid_pickles.push(uuid[i]);
		}

		for (var i = 0; i < name_pickles.length; i++) {										//--	syncronize data for processing
			updateSourceParams(destination, name_pickles[i],uuid_pickles[i]);
		}
	};//--------	--------	--------	--------	--------


	function cleanFilterParams(filter_params) {												//--------		CONVERTS ARRAY TO STRING FOR DB STORAGE/API CALL
		filter_params_sterile = '';
		for (var i = 0; i < filter_params.length; i++) {
			filter_params[i] = recursive_filter_cleaning(filter_params[i]);
			filter_params_sterile += filter_params[i].toString();
			filter_params_sterile = filter_params_sterile.concat(',');
		}
		
		filter_params_sterile = filter_params_sterile.slice(0, filter_params_sterile.length - 1);
		return filter_params_sterile;

    };//--------	--------	--------	--------	--------


	function recursive_filter_cleaning(filter_param) {										//--------		REMOVES TRAILING AND LEADING COMMAS, incorporates trim() to prevent 'spaced' commas
		if (filter_param.startsWith(',')) {
				filter_param = filter_param.substr(1, filter_param.length);
				filter_param = filter_param.trim();
				filter_param = recursive_filter_cleaning(filter_param);
			}
		if (filter_param.endsWith(',')) {
				filter_param = filter_param.substr(0, filter_param.length - 1);
				filter_param = filter_param.trim();
				filter_param = recursive_filter_cleaning(filter_param);
			}
		return filter_param;
	};//--------	--------	--------	--------	--------


	function create_scored_here(json) {														//--------		COMPILES DATA FOR THE RELATIONAL DROPDOWN								
		var article_scores = [];
		var h = 0;

		if (json.scores.length > 20) {														//--	limits the score length for dropdown menu
			json.scores.length = 20;
		}
																							
		while (h < json.scores.length) {													//--	makes a source object with name and uuid
			var mw_a_s = {
				uuid : json.scores[h][0],
				name : json.scores[h][1],
				decal : json.scores[h][2]
			};
			article_scores.push(mw_a_s);
			h++;
		};

		for (var j = 0; j < article_scores.length; j++) {									//--	compiles drop down links
			decal = mw_decal_sorter(article_scores[j].decal);								//--	chooses a bootstrap glyphicon for each dropdown item		
			scored_here += "<li><a href='http://www.moodwire.com/item/" + article_scores[j].uuid + "' target='_blank'>"
				+ decal + article_scores[j].name + "</a></li>";
		};
		articleTrunc = mw_shortener(article_scores[0].name, 21, 16);
		
		scored_here_div = 																	//--	creates the relational dropdown	
			"<div class='dropdown fixed_dpd_size'>"										
				+ "<a class ='mw_news_dropdown_btn' href='http://www.moodwire.com/item/" + article_scores[0].uuid + "' target='_blank'>" + articleTrunc + "</a>"
				+ "<button class='btn btn-primary dropdown-toggle mw_no_mgn' type='button' data-toggle='dropdown'>" + "<span class='caret'></span></button>"
					+ "<ul class='dropdown-menu mw_dp_menu'>"
			 			+ scored_here 
			 		+ "</ul>"
			+ "</div>";
		scored_here = [];

		return scored_here_div;
	};//--------	--------	--------	--------	--------


	function mw_decal_sorter(decal) {														//--------		CHOOSES THE DECAL TO BE APPLIED in dropdown
		if 		(decal === 'organization') 	{decal = "<span class='glyphicon glyphicon-folder-close'>"	 + '&nbsp;' + "</span>"} 
		else if (decal === 'person') 		{decal = "<span class='glyphicon glyphicon-user'>"			 + '&nbsp;' + "</span>"}
		else if (decal === 'location') 		{decal = "<span class='glyphicon glyphicon-map-marker'>"	 + '&nbsp;' + "</span>"}
		else if (decal === 'product') 		{decal = "<span class='glyphicon glyphicon-barcode'>"		 + '&nbsp;' + "</span>"}
		else if (decal === 'event') 		{decal = "<span class='glyphicon glyphicon-bell'>"			 + '&nbsp;' + "</span>"}
		else 								{decal = "<span class='glyphicon glyphicon-question-sign'>"	 + '&nbsp;' + "</span>"};
		return decal;
	};//--------	--------	--------	--------	--------


	function mw_shortener(string_to_snip, x, y) {											//--------		SHORTENS THE STRING AND APPENDS ' ... '
		if (string_to_snip.length > x) {
			string_to_snip = string_to_snip.substr(0, y);
			string_to_snip = string_to_snip.concat(' ... ');
		}; 
		return string_to_snip;
	};//--------	--------	--------	--------	--------


	function mw_url_trimmer(source_to_parse) {												//--------		Cleans the URL strings
		source_to_parse = source_to_parse.replace('www.','');
		source_to_parse = source_to_parse.replace('m.','');
		source_to_parse = source_to_parse.replace(/.com[^>]*/, '');
		source_to_parse = source_to_parse.replace(/.org[^>]*/, '');
		source_to_parse = source_to_parse.replace(/.net[^>]*/, '');
		source_to_parse = source_to_parse.replace(/.int[^>]*/, '');
		source_to_parse = source_to_parse.replace(/.edu[^>]*/, '');
		source_to_parse = source_to_parse.replace(/.gov[^>]*/, '');
		source_to_parse = source_to_parse.replace(/.mil[^>]*/, '');
		source_to_parse = source_to_parse.replace(/.io[^>]*/, '');
		source_to_parse = source_to_parse.replace(/.co[^>]*/, '');
		source_to_parse = source_to_parse.replace(/.mt[^>]*/,'');
		source_to_parse = source_to_parse.replace(/.ca[^>]*/,'');
		return source_to_parse;
	};//--------	--------	--------	--------	--------


	function mw_article_body_trimmer(article_body) {										//--------		REMOVES TAGS, IMAGES, AND BREAKS FROM ARTICLE_BODY
		article_body = article_body.replace(/<br[^>]*>/g,'');								//--	removes all breaks
		article_body = article_body.replace(/<img[^>]*>/g,'');								//--	removes all images
		article_body = $("<p>" + article_body + "</p>").text();								//-- 	removes all remaining html markup tags
		return article_body;
	};//--------	--------	--------	--------	--------


	function logResults(json, no_of_articles) {												//--------		RESPONDS TO AJAX API CALL TO GENERATE DATA TO POPULATE DIV, ALSO INCLUDES LINKS TO ARTICLE AND SITE
		for (var i = 0; i < no_of_articles; i++) {											//--	permits parsing of the object in 'INSPECT ELEMENT'
			json[i].images = JSON.parse(json[i].images);
			json[i].source = JSON.parse(json[i].source);
			json[i].scores = JSON.parse(json[i].scores);

			var jsonDate = new Date(json[i].article_date);
			var articleDate = (jsonDate.getMonth() + 1) + "/" + jsonDate.getDate() + "/" + jsonDate.getFullYear();
			var jsonTitle = json[i].article_title;
				jsonTitle = jsonTitle.toString();
			var source_link = json[i].source[1];
				source_link = source_link.toString();
				source_link = mw_url_trimmer(source_link);

			source_link_list = mw_shortener(source_link, 35, 30);
			create_scored_here(json[i]);													//--	creates dropdowns
			var back_image_builder = '"' + json[i].images[0].url + '"';

			$('#mwtest_list').append(														//--	returns list view
				"<div class='mw_list_div'>"
					// + "<div class='mw_after_list'>"
						+ "<a class='mwtest_h4_a' href ='" + json[i].url + "' target='_blank'>" + jsonTitle + "</a>"
						+ "<div class='mwtest_a_div'>"
							+ "<a href ='http://" + json[i].source[1] + "' target='_blank'>" + source_link_list + "</a>"
							+ "<p class='articleDate'>" + articleDate + "</p>"
						+ "</div>"
						+ "<div class='mw_after_list'>"
						+ scored_here_div
					+ "</div>"
				+ "</div>"
				);

			jsonTitleTrunc = mw_shortener(jsonTitle, 58, 53);
			source_link_tile = mw_shortener(source_link, 22, 17);
			
			$('#mwtest_tile').append(														//--	returns tile view
				"<div class='mw_tile_div'>"

					+ "<div class='mw_image'>"
						+ "<div class='backgroundImage' style='background-image: url("  + back_image_builder + ");'></div>"
					+ "</div>"
					
					+ "<div class='mw_after_image'>"
						+ "<a class='mwtest_h6_a' href ='" + json[i].url + "' target='_blank'>" + jsonTitleTrunc + "</a>"
						+ "<div class='tile_article_a_and_date'>"
							+ "<a href ='http://" + json[i].source[1] + "' target='_blank'>" + source_link_tile + "</a>"
							+ "<p>" + articleDate + "</p>"
						+ "</div>"
						+ scored_here_div
					+ "</div>"
				+ "</div>" 
			);
		};
	};//--------	--------	--------	--------	--------


	function newsResults(json) {															//--------		RESPONDS TO AJAX API CALL TO GENERATE DATA TO POPULATE DIV, ALSO INCLUDES LINKS TO ARTICLE AND SITE
		var pickles = Object.keys(json).length;
		for (var i = 0; i < pickles; i++) {													//--	permits parsing of the object in 'INSPECT ELEMENT'
			json[i].images = JSON.parse(json[i].images);
			json[i].source = JSON.parse(json[i].source);
			json[i].scores = JSON.parse(json[i].scores);

			var jsonDate = new Date(json[i].article_date);
			var articleDate = (jsonDate.getMonth() + 1 ) + "/" + jsonDate.getDate() + "/" + jsonDate.getFullYear();
			
			var jsonTitle = json[i].article_title;
				jsonTitle = jsonTitle.toString();
			
			var source_link = json[i].source[1];
				source_link = source_link.toString();
				source_link = mw_url_trimmer(source_link);
			
			var jsonBody = json[i].article_body;
				jsonBody = jsonBody.toString();
				jsonBody = mw_article_body_trimmer(jsonBody);

			create_scored_here(json[i]);
			source_link_tile = mw_shortener(source_link, 16, 12);
			jsonTitleTrunc = mw_shortener(jsonTitle, 50, 45);
			
			jsonBodyTrunc = mw_shortener(jsonBody, 230, 225);
			var back_image_builder = '"' + json[i].images[0].url + '"';

			$('#mw_show_me_the_news').append(												//--	returns tile view
				"<div class='mw_news_div'>"
					+ "<a href='" + json[i].url + "' target='_blank'><div class='mw_image_news'>"
						+ "<div class='backgroundImage' style='background-image: url("  + back_image_builder + ");'></div>"
					// <img src='" + json[i].images[0].url + "'>
					+ "</div></a>"
					+ "<a class='mwtest_news_title' href ='" + json[i].url + "' target='_blank'>" + jsonTitleTrunc + "</a>"

					// + "<div class='mw_news_dropdown_div'>" + scored_here_div + "</div>"
					
					+ "<div class='mw_news_tile_article_a_and_date'>"
						+ "<a href ='http://" + json[i].source[1] + "' target='_blank'>" + source_link_tile + "</a>"
						+ "<p>" + articleDate + "</p>"
					+ "</div>"

					+ "<div class='mwtest_news_body'><p>" + jsonBodyTrunc + "</p></div>"
					+ "<div class='mw_news_dropdown_div'>" + scored_here_div + "</div>"
				+ "</div>"
			);
		};
	};//--------	--------	--------	--------	--------


    function makeEntity(destination, name, uuid) {											//---------		RETURNS API CALLED ENTITIES WITH DATA TO BE SENT TO updateSourceParams(), IF SELECTED								
    	name_1 = name.replace(/'/g, '%27');
		name_1 = name_1.replace(/"/g, '%22');

    	if (destination == 'source') {
    		return "<li class='search_results' onclick='updateSourceParams(\"" + destination + "\",\"" + name_1 + "\",\"" + uuid + "\")'>" + name + "</li>";
    	};
    	if (destination == 'chart') {
    		return "<li class='chart_results' onclick='updateSourceParams(\"" + destination + "\",\"" + name_1 + "\",\"" + uuid + "\")'>" + name + "</li>";
    	};
    };//--------	--------	--------	--------	--------


	function setActiveArea(mode) {															//--------		SHOW/HIDE SEARCH RESULTS
       gModeActive = mode;
       if (gModeActive == "search") {
           $(".search_results").show();
        } else {
           $(".search_results").hide();
        }
    };//--------	--------	--------	--------	--------


    function setChartArea(mode) {															//--------		SHOW/HIDE CHART RESULTS
       gModeActive = mode;
       if (gModeActive == "search") {
           $(".chart_results").show();
        } else {
           $(".chart_results").hide();
        }
    };//--------	--------	--------	--------	--------


    setActiveArea(gModeActive);
    setChartArea(gModeActive);

    //begin search box logic   
    function cblist(d) { 																	//--------		CALLBACK FOR LIST DATA 
        // console.log('callback: rows='+d.length+' : time=' + hf.readTimer());	     
        gData["search"]=d;
		var s="", n=0; // limit on number of links to return
		var p = "";

		if (typeof gData["search"] !== "undefined") {
			
	        //when doing search, hide the other stuff
            for (var r in gData["search"]) {
            	var entity = {
            		uuid : gData['search'][r][0],
            		name : gData['search'][r][1]
            		};
             
                p += makeEntity('source', entity.name,entity.uuid);
                n++;
                if (n==10)
                    break;
            }
            setActiveArea("search");
        }        
		$(".search_results").html(p);
		
	};//--------	--------	--------	--------	--------


	function chartlist(d) { 																//--------		CALLBACK FOR LIST DATA 	 
        // console.log('callback: rows='+d.length+' : time=' + hf.readTimer());	     
        gData["search"]=d;
		var s="", n=0; // limit on number of links to return
		var p = "";

		if (typeof gData["search"] !== "undefined") {
			
	        //when doing search, hide the other stuff
            for (var r in gData["search"]) {
            	var entity = {
            		uuid : gData['search'][r][0],
            		name : gData['search'][r][1]
            		};
             
                p += makeEntity('chart', entity.name,entity.uuid);
                n++;
                if (n==10)
                    break;
            }
            setChartArea("search");
        }        
		$(".chart_results").html(p);
		
	};//--------	--------	--------	--------	--------
	

    function doSearch(apikey) {																//--------		SEARCHES MOODWIRE.COM FOR ENTITY NAME AND ID
        searchText = $("#source_parameters").val();         
        // console.log(searchText);
        if (searchText.length < 1) {//if there is nothing there, clear the field
        	print("please search....");
            cblist([]);
        } else {
            var p={"prefix":searchText,"limit":30,"description":"true","type":"true"};
            mwAPI.fetchData(mwAPI.urls["search"],apikey,p,cblist);
        }        
    };//--------	--------	--------	--------	--------


    function chartSearch(apikey) {															//--------		SEARCHES MOODWIRE.COM FOR ENTITY NAME AND ID
        chartText = $("#chart_parameters").val();         
        // console.log(chartText);
        if (chartText.length < 1) {//if there is nothing there, clear the field
        	print("please search....");
            chartlist([]);
        } else {
            var p={"prefix":chartText,"limit":30,"description":"true","type":"true"};
            mwAPI.fetchData(mwAPI.urls["search"],apikey,p,chartlist);
        }        
    };//--------	--------	--------	--------	--------


    function create_filter_param_input() {													//--------		CREATES ADDTIONAL HTML INPUTS ON MW_WIDGET_CREATE_SETTINGS.PHP
    	$('#filter_params_div').append(
    		'<div id="filter_div' + count + '">'
    			+ '<input class="filt_par spacing_mw_input" type="text" placeholder="Refine your search" name="filter_params[]">' 
    							+ '<button class="mw_icon_remove" type="button" onclick="remove_filter_param_input(' + count + ')"><span class="glyphicon glyphicon-remove-sign"></span></button>'
    							+ '</div>'
    		);
    	count = count + 1;
    };//--------	--------	--------	--------	--------


    function remove_filter_param_input(x) {													//--------		REMOVES HTML INPUT from create_filter_param_input
    	$('#filter_div' + x).remove();
    };//--------	--------	--------	--------	--------


    function mw_charts_div_sel(x, name, sel, status, p) {									//--------		REMOVES OLD ITEM, DECIDES WHICH TO BUILD AND APPENDS IT TO APPROPRIATE DIV

		b = "#" + sel;

		$(b).remove();
    	if (status === 'off') {

	    	mw_new_sel = "<div class='mw_selectors' id='" + sel + "'>"
							+ "<p onclick='mw_ch_p_s_h(\"" + x + "\")'>" + p + "</p>"
							+ "<span class='glyphicon glyphicon-remove-sign' onclick='mw_charts_div_sel(\"" + x + "\", \"" + name + "\", \"" + sel + "\", \"on\", \"" + p + "\")'></span>"
							+ "<input type='checkbox' name='" + name + "' value='on' checked style='display:none'>"
						+ "</div>";

			$('#mw_admin_selected').append(mw_new_sel);
    	}

    	if (status === 'on') {

	    	mw_new_sel = "<div class='mw_selectors' id='" + sel + "' onclick='mw_charts_div_sel(\"" + x + "\", \"" + name + "\", \"" + sel + "\", \"off\", \"" + p + "\")'>"
							+ "<p>" + p + "</p>"
							+ "<input type='checkbox' name='" + name + "' value='on' style='display:none'>"
						+ "</div>";

			$('#mw_admin_not_selected').append(mw_new_sel);
			$('.mw_ad_ch_div').hide();
			$('#mw_options_div').show();
    		$('.mw_start').addClass('mw_chosen');

    	}
    };//--------	--------	--------	--------	--------


    function mw_ch_p_s_h(x) {																//--------		WHEN CHOSEN, THE CHART/SECTION ATTRIBUTES ARE DISPLAYED
    	$('.mw_ad_ch_div').hide();
    	$('.mw_selectors').removeClass('mw_chosen');
    	$(x).show();
    	// $(y).css('border', '2px solid red');
    };//--------	--------	--------	--------	--------


 </script>
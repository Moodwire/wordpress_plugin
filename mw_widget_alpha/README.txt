=== Moodwire News and Sentiment plugin for Wordpress ===

Contributors: Manu Chatterjee, Erick Watson, Adam Morgan
Donate link: http://moodwire.com
Tags: comments, blogs, news, sentiment
Requires at least: 1.0
Tested up to: 1.0
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html



== Description ==

The internet is a complex and vast entity that requires the most adept programmers to develop a means to scour, scrape, and crawl sites for their data.  Moodwire's plugin allows non-technical users to perform these complex actions.  The plugin is as simple as "plug-and-play".  The plugin returns news, sentiments, and other desired aspects to your site.  You can display the vast amounts of data in various ways.  If you don't want to tailor your responses simply use designated tags and the data will automatically format for you.  The plugin works in a straight forward manner.  

1.  It makes an API call to Moodwire.com.  
2.  The data returned will be in JSON format.  

The data can be crafted to display various charts, graphs, etc.  These calls can be manipulated for your desired results.  We do not choose what data to display, supress news, alter results, or manipulate your results.  Our data is pulled from numerous sources without bias.  We scrape news sites, data sites, social media, and pretty much anything that is on the web.  If it is out there, we will find it and incorporate it into our 'buzz'.  

Please feel free to visit the developer's portal and read the API documentation at Moodwire.com to see what possiblities await.  You can also visit api-docs.moodwire.com.  You may need to register for a different API_Key, for greater/tailored search results.



== Installation ==

1.	Upload the plugin files to '/wp-content/plugins/' directory, or install the plugin through the Wordpress plugins screen directly.
2.	Login to '<yourdomain>/wp-admin'.
3.	Click on the 'Plugins' icon located on the Dashboard.
4.	Find the Moodwire plugin version selected and activate it.
5.	Hover over the 'Appearance' icon and click on the 'Widgets' option.
6.	Find the Moodwire plugin and drag it to the chosen widget location.
		--	Your theme will denote if the widget can be utilized	--
7.  Look on the left side of your dashboard.  You should see 'Moodwire' towards the bottom, click on it.
8.  See == Usage == below for details.
9.	Visit your site, via the Nav Bar (located on the top, under the URL bar).
10.	You should see the Widget now, if not.  Validate steps 3-8.



== Usage ==

Upon loading the widget it will create a table called 'wp_mw_news_sentiment_db_table' in your wpdb.  The widget has preset defaults.  
YOU DO NOT CHANGE THESE via DATABASE MANAGEMENT e.g. phpmyadmin or control panel.  Simply follow these steps.

8a. You will see a screen with multiple fields and 'pills' displayed.
8b. Choose your name
8c. Choose the quantity of results to return.  These results will be displayed in the main widget portion.  

8d. Refine your search.  This will look for these keywords.  You can click 'update' to incorporate a single entity, or press enter.  Either choice will create a 'pill'.
	A 'pill' is merely a visual representation of what is in your Database.  If you click on the 'pill' it will disappear, and be removed from your search parameters.  If you want to add multiple parameters, simply click the 'add input field' button.  You may click 'delete' to remove excess fields or leave them blank if you don't need/want them.  An empty field will be removed from your search.

8e. Finding an entity requires a specific match.  For instance, type "F" and you'll see a list of possible candidates.  Continue typing to refine the list, e.g. "F", "i", "r", 		"e", "f", "l", "y" and you'll see multiple candidates.  Find yours, in this case it is "Firefly (Tv Series)".  This will screen the search for articles written by this 			entity.  So it will not return any articles written by "Firefly (Tv Series)".  Using "Fox news", "CNN", "Huffington Post", etc will return articles.  So Why use "FireFly (Tv 		Series)" as an example.  This will incorporate this entity in your charts.  Charts are used to display 'buzz', 'mood', etc.  This will be discussed later.

8f. There are multiple check boxes, such as: Tile view, Gauges, Pie, Buzz Pie, Bar, Line.  These are options.  'Tile view' relates to the quantity of articles returned in 8c.  		These will format the data return in the main plugin body.  'Tile view' has images, while 'List view' does not have images.  

8g. Charts selection is done via the checkboxes at the bottom.  If you want you display the chart make sure it is checked.  By default, all charts are chosen upon db table 			instantiation.  You can chose to add or remove them later by simply revisiting the dashboard and repeating these steps. 

8h. Click 'Update' to save you changes.
8i. Click 'test' to see sample results.
8j. Visit your site.


8k.	Click on a link, image, or 'pill' and a new tab opens up.  This prevents people from navigating away from your page.
8l. You can hover over a 'pill' arrow(>) and when it rotates to point down, click on the carot/arrow
8m. You will see a list of related entities, e.g. 'Major', 'Ownership', 'Theory', 'Americans'.  Click on one and you will open a new tab to learn more.
8n. Every Icon to the left of the dropdown entities is a visual representation of its designation/association.  Organization, Person, Location, Product, and Event are the 				designations.  If an entity falls outside of this it will be represented by a 'question mark'. 


== Changing settings ==

1.  Login to <site_url>/wp-admin
2.  Find Moodwire on your dashboard
3.  See == Usage ==


== Frequently Asked Questions ==

Q1.		Where does the data come from?
A1.			Social media sites(tweets, facebook, etc) and news sites - BASICALLY THE WHOLE INTERNET.

Q2.		Is this widget complicated to use?
A2.			No.

Q3.		What is Moodwire?
A3.			Moodwire is a 'Sentimental' and News search engine for feeling the 'Pulse' of the Web.

Q4.		Can I change my search settings?
A4.			Yes.  Use this README file, and follow the instructions.  You may also visit the Moodwire.com/developer/examples/Moodwire_API.pdf for further details.

Q5.		What languages are used?
A5.			PHP, JavaScript, and jQuery.

Q6.		What is the widget file structure?
A6.			'~/wp-content/plugins/<plugin_directory>' - in the directory are several files:
					
					moodwire_libraries
						jquery_library_3_10.php 		-	jquery library 
						moodwire_api_js.php 			-	list of moodwire functions
						moodwire_js_helper.php 			-	list of moodwire custom functions

					mw_css
						mw-widget.css 					-	incorporates CSS3 in compilation with mw-widget_root.css <inactive>
						mw-widget_bar_chart.css 		-	google bar charts css <non-compartmentalized version> <inactive>
						mw-widget_charts_default.css 	-	MASTER CSS FILE FOR CHARTS <inactive>
						* mw-widget_default.css 		- 	MASTER CSS FILE FOR PLUGIN
						mw-widget_gauge_chart.css 		-	google gauge charts css <non-compartmentalized version> <inactive>
						mw-widget_pie_chart.css 		-	google pie charts css <non-compartmentalized version> <inactive>
						mw-widget_root.css 				-	for use with CSS3, pre-plumbing <inactive>

					mw_widget_charts
						mw-charts-bar.php 				-	google bar charts
						mw-charts-buzz_pie.php 			-	google pie charts
						mw-charts-gauge.php 			-	google gauge charts
						mw-charts-line.php 				-	google line charts
						mw-charts-pie.php 				-	google pie charts
						mw-widget_charts.php 			-	master charts file, contains function that is called to pass json data to all charts (NEXUS point)

					mw-widget.php 						-	actual widget PHP file that is displayed on your site
					mw-widget_admin_panel.php 			-	test button on the admin panel
					mw-widget_api_calls.php 			- 	performs api calls to moodwire via Ajax
					mw-widget_js.php 					-	main file containing js functions and helper functions
					mw_db_querries.php 					-	wpdb database interaction
					mw_widget_create_settings.php 		-	admin panel display on user dashboard
					mw_wp_scripts.php 					-	contains function that loads necessary scripts to perform essential actions
					README.txt							-	this file


Q7.		Why is it modularized?
A7.			This permits easy manipulation and targeting of particular code.

Q8.		Why is my CSS acting up/not listening?
A8.			This is using your CSS, Wordpress inherited CSS, Bootstrap CSS, and your chosen Theme CSS.  

Q9. 	How can I bypass this CSS issues?
A9a.		Go to W3Schools.com and review.
A9b.		Go to the '/<plugin_directory>/mw_css/<widget>.css' and overwrite the id and/or class directly.
A9c.		Utilize !important	-	e.g. 'color: maroon !important;'
A9d.		Go to your sites Dashboard, hover over Appearance, then hover over Editor.  
				Click on Editor.  
				Go to the templates portion (right side of page), and click on 'style.css'.
				Find your id and/or class to modify.

		-- 	Advice: Take note of where you made your changes.  I recommend a CSS changes in A9d be made at the bottom of 'style.css'.  -- 
				==  This way when you change themes you may easily find your changes, and modify your settings as needed.  ==
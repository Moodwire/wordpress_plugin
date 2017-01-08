# Moodwire News and Sentiment plugin for Wordpress #

This is a respository that houses the various versions packaged in a zip file.  
Each file will be accompanied by its own README file that will outline the installation steps, and important information.
A General overview is provided below.

** Please note that some features you have may not be listed below.  In that case, please review your specific version for answers **

## You can visit [Moodwire](http://api-docs.moodwire.com/API_Docs.html) to obtain the latest API documentation. ##
```
Contributors: Manu Chatterjee, Erick Watson, Adam Morgan
Tags: comments, blogs, news, sentiment
Requires at least version: 1.0
Tested up to: 1.0
Stable tag: 1.0
License: GPLv2 or later
```
Donate link: [Moodwire](http://moodwire.com)

License URI: [GPLv2](http://www.gnu.org/licenses/gpl-2.0.html)


## Description ##

The internet is a complex and vast entity that requires the most adept programmers to develop a means to scour, scrape, and crawl sites for their data.  Moodwire's plugin allows non-technical users to perform these complex actions.  The plugin is as simple as "plug-and-play".  The plugin returns news, sentiments, and other desired aspects to your site.  You can display the vast amounts of data in various ways.  If you don't want to tailor your responses simply use designated tags and the data will automatically format for you.

1.  It makes API calls to Moodwire.com.  
2.  The data returned will be in JSON format.
3.  The data is inserted into Wordpress database tables.
4.  When the main page is 'viewed', the data is pulled and rendered via javascript/JQuery.

The data can be crafted to display various charts, graphs, etc.  You can incorporate keywords, exclude keywords, or feature specific entities in you searches.  We do not supress or alter results your results.  Our data is pulled from numerous sources without bias.  We scrape news sites, data sites, social media, and pretty much anything that is available on the web.  If it is out there, we will find it and incorporate it into our 'buzz'.  

Please feel free to visit the developer's portal and read the API documentation at Moodwire.com to see what possiblities await.  You can also visit api-docs.moodwire.com.  You may need to register for a different API_Key, for greater/tailored search results.



## Installation ##

1.	Upload the plugin files to '/wp-content/plugins/' directory, or install the plugin through the Wordpress plugins screen directly.
2.	Login to '<yourdomain>/wp-admin'.
3.	Click on the 'Plugins' icon located on the Dashboard.
4.	Find the Moodwire plugin and activate it.
5.	Hover over the 'Appearance' icon and click on the 'Widgets' option.
6.	Find the Moodwire plugin and drag it to the chosen widget location (sidebar locations work best).
		--	Your theme will denote if the widget can be utilized	--
7.      Look on the left side of your dashboard.  You should see 'Moodwire' towards the bottom.  Click on the icon.
8.      See == Usage == below for details.
9.	Visit your site, via the Nav Bar (located on the top, under the URL bar).
10.	You should see the Widget now, if not.  Validate steps 3-8.

--     For more data, include:

<div id='mw_show_me_the_news'></div>

<style> 
     #mwtest_list { display: none !important; }
     #mwtest_tile { display: none !important; }
</style>

--     on a dedicated wordpress page.  This will render larger articles on your site.



## Usage ##

Upon loading the widget it will create a table called 'wp_mw_news_sentiment_db_table' in your wpdb.  The widget has preset defaults.  
**YOU DO NOT CHANGE THESE via DATABASE MANAGEMENT, e.g. phpmyadmin or control panel.  Simply follow these steps.**

8a. You have two columns, left and right.  "Widget settings" is loaded by default.  This houses the options for the plugin.

8b. Choose your plugin title, article/data date range, article quantity, and plugin options.
    
8c. If this is a fresh plugin install, you will need to click on the "Request new key here" button.
     i.
       a.      A new page will open.  
       b.      Follow the steps to request your apikey.
       c.      Click on 'Update API Key'.
       d.      Insert your key into the input field.
       e.      Click 'Update'.
       -You can click on the CALLS LEFT BUTTON.  This will tell you how many calls are left with your apikey.  If you can't click on this button, go through the steps above.

8d. Refine your search by clicking on "FILTERS". 
     i.    ENTER KEYWORDS
         a.  Type in a keyword to INCLUDE in your search
         b.  Press ENTER on your keyboard
         c.  Repeat as needed
        
     ii.   EXCLUDE KEYWORDS
         a.  Type in a keyword to EXCLUDE from your search
         b.  Press ENTER on your keyboard
         c.  Repeat as needed
         
     iii.  CHECK SPECIFIC ENTITY
         a.  Begin typing in a name of an ENTITY (person, place, thing, idea)
         b.  Below a list of possible entities will display
         c.  Continue typing if you don't see your entity
         d.  Once found, click on you entity to include it in your search
    
    - Any completed KEYWORD or ENTITY will create a 'pill'.  A 'pill' is merely a visual representation of what is in your Database.
    - If you click on the 'pill' it will disappear, and be removed from your search parameters.

8e. If your search parameters do not return any/enough articles, a default parameter search will compliment your search.

8f. Under the "FILTERS" option, there are two sections: 'INCLUDED CHARTS' and 'CLICK TO INCLUDE'.

8g. Click on a chart listed to add it to INCLUDED CHARTS.  
    i.    Click on the chart to select chart options.
    ii.   Make you selections.
    iii.  Click on the 'X' to remove the chart, if desired. 

8h. Click 'Update' to save you changes.  This will preform your API calls and obtain your data.

8i. Clicking 'undo changes' will refresh the page.

8j. Visit your site.
    i.	  Click on a link, image, or 'pill' and a new tab opens up.  This prevents people from navigating away from your page.
    ii.   You can hover over a 'pill' arrow(>) and when it rotates to point down, click on the carot/arrow
    iii.  You will see a list of related entities, e.g. 'Major', 'Ownership', 'Theory', 'Americans'.  Click on one and you will open a new tab to learn more.
    iv.   Every Icon to the left of the dropdown entities is a visual representation of its designation/association.  Organization, Person, Location, Product, and Event are the 				designations.  If an entity falls outside of this it will be represented by a 'question mark'. 

--  Optional --
Create a new page.  Copy and paste the code below on your page.

-div id='mw_show_me_the_news'--/div-

-style- 
     #mwtest_list { display: none !important; }
     #mwtest_tile { display: none !important; }
-/style-
(Replace '-' with the appropriate carot)
This will create articles for a person to read.  You will see an image, title, link, date, dropdown, and article body.



## Changing settings ##

1.  Login to <site_url>/wp-admin
2.  Find Moodwire on your dashboard
    1.  This should be located on the left of your browser window.
    2.  Scroll towards the bottom of your options.
    3.  You should see an icon infront of Moodwire.
    4.  Click on Moodwire.
3.  See == Usage ==


## Frequently Asked Questions ##

Q1.  Where does the data come from?

    A1.  Social media sites(tweets, facebook, etc) and news sites - BASICALLY THE WHOLE INTERNET.

Q2.  Is this widget complicated to use?

    A2.  No.

Q3.  What is Moodwire?

    A3.  Moodwire is a 'Sentimental' and News search engine for feeling the 'Pulse' of the Web.

Q4.  Can I change my search settings?

    A4.  Yes.  Use this README file, and follow the instructions.  You may also visit the Moodwire.com/developer/examples/Moodwire_API.pdf for further details.

Q5.  What languages are used?

    A5.  PHP, JavaScript, and jQuery.

Q6.  What is the plugin file structure?

    A6.  '~/wp-content/plugins/<plugin_directory>' - in the directory are several files:

        moodwire_libraries
                d3_layout_cloud_js.php             ----                d3 charts library
                jquery_library_3_10.php            ----                jquery library 
                moodwire_api_js.php                ----                list of moodwire functions 
                moodwire_js_helper.php             ----                list of moodwire custom functions 
                mw_wp_full_scripts.php             ----                loads all the scripts
                mw_wp_partial_scripts.php          ----                loads some of the scripts
                mw_wp_php_curls.php                ----                performs the PHP curls to Moodwire API
        
        mw_css 
                mw_admin.css                       ----                loads the CSS for the admin window
                mw-widget_default.css              ----                loads the CSS for the displayed plugin
                
        mw_db_queries
                mw_query_api.php                   ----                api table queries
                mw_query_articles.php              ----                articles table queries
                mw_query_drop.php                  ----                drops the db tables on deactivation
                mw_query_location.php              ----                location table queries
                mw_query_results.php               ----                plugin settings table queries
                mw_query_summary.php               ----                chart table queries
                mw_query_word_cloud.php            ----                word cloud table queries

        mw_widget_charts
                mw-amcharts_location.php           ----                loads js needed for rendering location chart
                mw-charts-bar.php                  ----                google bar charts
                mw-charts-bubble.php               ----                google bubble charts
                mw-charts-buzz_pie.php             ----                google pie charts
                mw-charts-gauge.php                ----                google gauge charts
                mw-charts-line.php                 ----                google line charts
                mw-charts-location.php             ----                processes location data
                mw-charts-pie.php                  ----                google pie charts
                mw-charts-scatter.php              ----                google scatter charts
                mw-charts-stacked_bar_chart.php    ----                google stacked bar chart
                mw-charts-treemap.php              ----                google treemap chart
                mw-charts-trend_line.php           ----                google trendline chart
                mw-d3_word_charts.php              ----                d3 word chart processing
                mw-widget_charts.php               ----                master charts file, contains function that is called to pass json data to all charts (NEXUS point)

        moodwire_wordpress_plugin_summary.txt      ----                Summary of the plugin
        mw_admin_settings.php                      ----                Contains the admin protion of the plugin in <your site>/wp-admin
        mw_ajax_call.php                           ----                Contains functions for 'Calls left' button
        mw_php_functions.php                       ----                Contains all php functions for the plugin
        mw-widget.php                              ----                actual widget PHP file that is displayed on your site
        mw-widget_js.php                           ----                main file containing js functions and helper functions
        README.txt                                 ----                a must read


Q7.  Why is it modularized?
    
    A7.  This permits easy manipulation and targeting of particular code.

Q8.  Why is my CSS acting up/not listening?

    A8.  This is using your CSS, Wordpress's inherited CSS, Bootstrap's CSS, and your chosen Theme's CSS.  Things are always changing, including how your browser renders something.  

Q9.  How can I bypass this CSS issues?
    
    A9a.  Go to W3Schools.com and review.
    A9b.  Go to the '/<plugin_directory>/mw_css/<widget>.css' and overwrite the id and/or class directly.
    A9c.  Utilize !important	-	e.g. 'color: maroon !important;' (But really study and understand the implications of this)
    A9d.  Go to your sites Dashboard, hover over Appearance, then hover over Editor.  
				Click on Editor.  
				Go to the templates portion (right side of page), and click on 'style.css'.
				Find your id and/or class to modify.

		-- 	Advice: Take note of where you made your changes.  I recommend a CSS changes in A9d be made at the bottom of 'style.css'.  -- 
				==  This way when you change themes you may easily find your changes, and modify/revert your settings as needed.  ==

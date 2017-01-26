<script>

/*
moodwire-api.js

Moodwire API example functions implemented in browser compatible Javascript.

@copy(c) 2015 Moodwire Inc.

@author: M A Chatterjee 2014-02-15 updated

See MoodwireAPI documentation for details
Simple wrapper for Moodwire API demo

This file provides simple access for browser based implementations of moodwire API data.
Included here are url endpoints for getting access to entity, buzz, sentiment and relationship data.


Moodwire API is wrapped in the mwAPI object via namespace via javascript anonymous function().  
For more details on this method see this post: http://appendto.com/2010/10/how-good-c-habits-can-encourage-bad-javascript-habits-part-1     

Note that all function calls require a developer key to work. See moodwire documentation for info about acquiring developer keys.

You may use this line in your code, or host on your own server:	    
<script type="text/javascript"src="http://moodwire.com/developer/libs/moodwire-api.js">
    

Dependancies:
    The code here does not require any external libraries and should work across all modern browsers
    (Internet Explorer 8+), Chrome / Firefox / Safari / Opera 2009 or later.  
    
    Data can be obtained via the mwAPI.dataFetch() function which uses jsonp and for cross domain
    data acquisitions using "vanilla" javascript.  See notes by mwAPI.dataFetch() below.
    
    For those who prefer JQuery, the function mwAPI.jQueryFetch() uses JQuery to fetch API URLs.  with identical functionality.

*/

(function( mwAPI, undefined ){
    mwAPI.mwBaseURL = "http://api.moodwire.net";  //moodwire base url for all API endpoints
    //mwAPI.mwBaseURL = "http://localhost:6543";  //moodwire base url for all API endpoints
     
     //Moodwire API URL endpoints, use these as base URLs to obtain specific information 
     mwAPI.urls = {
        //entity metadata, Including about, links[], name, etc
        "entity_info"       : mwAPI.mwBaseURL+'/entities/', 
        
        //aggregated data (can use filters) such as buzz over a timeperiod, also intervaled data
        "summary_data"      : mwAPI.mwBaseURL+'/summary/',
        
        //get related entities, use &direction=both for parent and child links
        "relationships"     : mwAPI.mwBaseURL+'/relations/',
        
        //find entities
        "entity_list"       : mwAPI.mwBaseURL+'/list_entities/', 
        
        //get tweets, news articles, etc given about an entity, with optional filters
        "quotes"            : mwAPI.mwBaseURL+'/quotes/', 
        
        //get word frequency terms for a given entity over time -- ### deprecated
        "terms_freqs_d"       : mwAPI.mwBaseURL+'/terms_and_frequency/',
        
        //get word frequency terms for a given entity over time
        "terms_freqs"       : mwAPI.mwBaseURL+'/entity_words/', 
        
        //look up matching entity ids via string search
        "search"            : mwAPI.mwBaseURL+'/entity_lookup/',
        
        //get a full snapshot of last 30days data for an entity or facet
        "entity_details"    : mwAPI.mwBaseURL+'/entity_details/',
         
        //articles 
        "articles"          : mwAPI.mwBaseURL+'/articles/'
    }

    
    //mwAPI.fetchData() returns data from the server.
    //This fetches data using JSONP explicitly for cross domain data GET. 
    //No JQuery or other library support is required.
    //
    //api_url   //a valid data url such above (e.g. http://api.moodwire.com/quotes)
    //api_key   //developer key for access to data.  see moodwire API docs
    //params    //a JSON dict of params (e.g. {entity:"539210145f260eaca93b3898", limit:10}
    //callback_fn  // a function to be called with the data
    //opt_key       // an optional item which can also be passed to the callback function.  
    //                 if opt_key is ommitted callback_fn invoked as such: callback_fn(data)
    //                 if opt_key is present  callback_fn invoked as such: callback_fn(data,opt_key)
    //
    // for server side access http:POST is also allowed (see docs and curl examples)
    
    mwAPI.fetchData = function(api_url,api_key,params,callback_fn,opt_key) {
       
        mwAPI.fetchData["inc"] = typeof mwAPI.fetchData["inc"] == "undefined" ? 1 : mwAPI.fetchData["inc"]; //callback fn name closure incrementer; 
        
        function jsonp (url, callback) {            
            mwAPI.fetchData["inc"] = mwAPI.fetchData["inc"] +1;    
            var callbackName = 'mwAPI_jsonp_callback_' +mwAPI.fetchData["inc"];
            
            window[callbackName] = function(data) {
                delete window[callbackName];
                document.body.removeChild(script);
                callback(data);
            };
            
        
            var script = document.createElement('script');
            script.src = url + (url.indexOf('?') >= 0 ? '&' : '?') + 'callback=' + callbackName;
            document.body.appendChild(script);
        }
      
        jsonp(mwAPI.makeURL(api_url,api_key,params),
            function(d){
                if (typeof opt_key == "undefined") 
                    {callback_fn(d);} 
               else 
                    {callback_fn(d,opt_key);}
            });
        
    };
    
    //mwAPI.makeURL creates a fully parameterized moodwire API url given 
    //a URL endpoint, api_key, calling params and optional callback
	mwAPI.makeURL = function(api_url,api_key,params,opt_jsonp_callback) {
	    var serialize = function(obj) {
           var str = [];
           for(var p in obj){
               if (obj.hasOwnProperty(p)) {
                   str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
               }
           }
           return str.join("&");
        }
	    var url = api_url+api_key;
	    var sparams = serialize(params);
	    url += (sparams == "") ? "" : "?"+sparams; 
	    if (typeof opt_jsonp_callback == "string")
	        url += (url.indexOf('?') >= 0 ? '&' : '?') + 'callback=' + opt_jsonp_callback;
	    return url;
	}
    
    //Functionality is identical to mwAPI.jsonpFetch() except requires JQuery 1.9 or later.
    //include  
    //<script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.min.js">
    mwAPI.jQueryFetch = function (api_url,api_key,params,callback_fn,optkey) {
        console.log(params);
        $.ajax({
          url: api_url+'/'+api_key,
          dataType: 'JSONP',  //use jsonp data type in order to perform cross domain ajax
          crossDomain: true,
          data: ((typeof params == "undefined") ? {}: params),
          type: 'POST',
          cache: false,
          async: true,
          success: function fn(d){
            if (typeof optkey == "undefined")
                callback_fn(d);
            else
                callback_fn(d,optkey);
          },
          error: function(s){console.log("mwAPI.fetchData() error:"+api_url+' key:'+optkey); console.log(s);}
        });
    }

    //lastNDaysFromToday(num)
    //returns a date string in the format "YYYY-MM-DD" UTC for api quueries 
    //as the last N days from today (
    //Note: returns UTC universal coordinated time see: http://en.wikipedia.org/wiki/Coordinated_Universal_Time    
    mwAPI.lastNDaysFromToday=function(num){
        var d =  new Date();
        t = d.getTime()-num*3600*1000*24;
        d.setTime(t);
        s= d.getUTCFullYear()+'-';
        x = d.getUTCMonth()+1;
        if (x<10)
            s+= '0';
        s+= x+'-';
        x= d.getUTCDate();
        if (x<10)
            s+= '0';
        s+= x;
        return s;
    };
    
    //make a moodwire API friendly date
    mwAPI.makeDate = function(year,month,day) {
        return parseInt(year)+'-'+parseInt(month)+'-'+parseInt(day);            
    }
    
        
})(window.mwAPI = window.mwAPI || {});

/*
//ga analytics for when this lib is loaded only
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-62757906-3', 'auto');
ga('send', 'pageview');
*/
</script>
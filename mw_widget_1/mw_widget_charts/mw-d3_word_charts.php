<script>

//-------- WORD CHART -------- WORD CHART -------- WORD CHART -------- WORD CHART -------- WORD CHART -------- WORD CHART -------- WORD CHART -------- WORD CHART


    function drawWordChart(json) {
// console.log( JSON.parse(json['entity_name']));
// do a function that computes the size value
        var frequency_list = [
            
            { "text" : JSON.parse(json['entity_name']), "size" : 30 },              //      name can not max on the spectrum or else it will not render

            { "text" : word_chart_word_process(json['entry_0']), "size" : word_chart_count_process(json['entry_0']) },
            { "text" : word_chart_word_process(json['entry_1']), "size" : word_chart_count_process(json['entry_1']) },
            { "text" : word_chart_word_process(json['entry_2']), "size" : word_chart_count_process(json['entry_2']) },
            { "text" : word_chart_word_process(json['entry_3']), "size" : word_chart_count_process(json['entry_3']) },
            { "text" : word_chart_word_process(json['entry_4']), "size" : word_chart_count_process(json['entry_4']) },

            { "text" : word_chart_word_process(json['entry_5']), "size" : word_chart_count_process(json['entry_5']) },
            { "text" : word_chart_word_process(json['entry_6']), "size" : word_chart_count_process(json['entry_6']) },
            { "text" : word_chart_word_process(json['entry_7']), "size" : word_chart_count_process(json['entry_7']) },
            { "text" : word_chart_word_process(json['entry_8']), "size" : word_chart_count_process(json['entry_8']) },
            { "text" : word_chart_word_process(json['entry_9']), "size" : word_chart_count_process(json['entry_9']) },

            { "text" : word_chart_word_process(json['entry_10']), "size" : word_chart_count_process(json['entry_10']) },
            { "text" : word_chart_word_process(json['entry_11']), "size" : word_chart_count_process(json['entry_11']) },
            { "text" : word_chart_word_process(json['entry_12']), "size" : word_chart_count_process(json['entry_12']) },
            { "text" : word_chart_word_process(json['entry_13']), "size" : word_chart_count_process(json['entry_13']) },
            { "text" : word_chart_word_process(json['entry_14']), "size" : word_chart_count_process(json['entry_14']) },

            { "text" : word_chart_word_process(json['entry_15']), "size" : word_chart_count_process(json['entry_15']) },
            { "text" : word_chart_word_process(json['entry_16']), "size" : word_chart_count_process(json['entry_16']) },
            { "text" : word_chart_word_process(json['entry_17']), "size" : word_chart_count_process(json['entry_17']) },
            { "text" : word_chart_word_process(json['entry_18']), "size" : word_chart_count_process(json['entry_18']) },
            { "text" : word_chart_word_process(json['entry_19']), "size" : word_chart_count_process(json['entry_19']) },

            { "text" : word_chart_word_process(json['entry_20']), "size" : word_chart_count_process(json['entry_20']) },
            { "text" : word_chart_word_process(json['entry_21']), "size" : word_chart_count_process(json['entry_21']) },
            { "text" : word_chart_word_process(json['entry_22']), "size" : word_chart_count_process(json['entry_22']) },
            { "text" : word_chart_word_process(json['entry_23']), "size" : word_chart_count_process(json['entry_23']) },
            { "text" : word_chart_word_process(json['entry_24']), "size" : word_chart_count_process(json['entry_24']) }

            ];

// for ( var k = 0; k < frequency_list.length; k++ ) {                                 //      this will remove any object.sprite values permitting the entity_name to render
//     if ( "sprite" in frequency_list[k] ) {
//         delete frequency_list[k].sprite;
//     };
// };

            var color = d3.scale.linear()
                    // .domain([0,5,7.5,10,12.5,15,17.5,20,22.5,25,27.5,30,32.5,35,37.5,40,100])
                    .domain([15,17.5,20,40])
                    // .range(["#cccccc", "#bfbfbf", "#b3b3b3", "#a6a6a6", "#999999", "#8c8c8c", "#808080", "#737373", "#666666", "#595959", "#4d4d4d",'#404040','#333333','#262626','#1a1a1a','#0b0b0d', "#000000"]);
                    .range(['#262626','#1a1a1a','#0b0b0d', "#000000"]);

            d3.layout.cloud()
                // .size([450, 250])
                .words(frequency_list)                                              //      runs as a foreach on the words?
                .rotate(0)
                .fontSize(function(d) { return d.size; })                           //      pulls the size from the frequency list
                .on("end", draw)
                .start();

                        // translate: Where the element is moved by a relative value in the x,y direction.
                        // scale: Where the element’s attributes are increased or reduced by a specified factor.
                        // rotate: Where the element is rotated about its reference point by an angular value.


        function draw(words) {
// console.log(words);
 // if (words.sprite) {console.log('true');};
            d3.select("#word_chart_div").append("svg")
                .attr("width", d3.select(".sidebar").node().getBoundingClientRect().width)
                .attr("height", '275')
                .attr("class", "wordcloud")
                .append("g")
                // without the transform, words words would get cutoff to the left and top, they would
                // appear outside of the SVG area
                .attr("transform", "translate(150,150)")              //the transform-translate attribute will take an elements position and adjust it based on a specified value(s) in the x,y directions.
                // .attr("style", "center")
                // .attr("transform", "translate(100,40)")
                .selectAll("text")
                .data(words)                                        
                .enter().append("text")
                .style("font-size", function(d) { return d.size + "px"; })          //      sets the font-size of text
                // .style("font-size", function(d) { return (d.size/3) + "px"; })   //      "d.size/3" is an assumption use your appropriate relative width or height
                // .attr("class", word_chart_div)
                .style("fill", function(d, i) { return color(i); })                 //      sets the color(fill) of the text
                .attr("transform", function(d) {                                    //      sets the spacing of the words on the x,y grid
                    return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
                })
                .attr("text-anchor", "middle")                                      //      set anchor y justification
                .text(function(d) { return d.text; });
       
// console.log(words);
        }
// console.log(json);
    };//--------    --------    --------    --------    --------


    function word_chart_word_process(x) {
        x = JSON.parse(x);
        x = x['word'];

        return x;
    };//--------    --------    --------    --------    --------


    function word_chart_count_process(x) {
        x = JSON.parse(x);
        x = x['count'];
// console.log( x );
//         if ( x < 1000)                  {   x = 2.5;    };
//         if ( x > 1001 && x < 2000)      {   x = 5;      };
//         if ( x > 2001 && x < 3000)      {   x = 7.5;    };
//         if ( x > 3001 && x < 5000)      {   x = 10;     };
//         if ( x > 5001 && x < 8000)      {   x = 12.5;   };
//         if ( x > 8001 && x < 13000)     {   x = 15;     };
        if ( x < 13000 )                {   x = 15;     };
        if ( x > 13001 && x < 55000)    {   x = 17.5;   };
        // if ( x > 21001 && x < 34000)    {   x = 20;     };
        // if ( x > 34001 && x < 55000)    {   x = 22.5;   };
        if ( x > 55001)    {   x = 20;     };
        // if ( x > 89001 && x < 144000)   {   x = 27.5;   };
        // if ( x > 144001)                {   x = 30;     };
        // if ( x > 144001 && x < 233000)  {   x = 30;     };
        // if ( x > 233001 && x < 377000)  {   x = 32.5;   };
        // if ( x > 377001 && x < 610000)  {   x = 35;     };
        // if ( x > 610001 && x < 987000)  {   x = 37.5;   };
        // if ( x > 987001 )               {   x = 40;     };

        return x;
    };//--------    --------    --------    --------    --------


</script>

<style>
    .legend {
        border: 1px solid #555555;
        border-radius: 5px 5px 5px 5px;
        font-size: 0.8em;
        margin: 10px;
        padding: 8px;
    }
    .bld {
        font-weight: bold;
    }
</style>


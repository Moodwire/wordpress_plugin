 <script>


    function drawCalendar(json, json_length) {
        var data = [4, 8, 15, 16, 23, 42];  
//--------------------------------------------------------------------------------------------------------
        var body = d3.select("#calendar_div");
        var div_d3 = body.append("div");
            div_d3.html("Hello, world!"); 

        // d3.select("#calendar_div")      //  selects container and sets styles
        //     .style("color", "black")
        //     .style("background-color", "gray"); 

        d3.selectAll("#calendar_div")     //  selection.append returns a new selection containing the new elements. This conveniently allows you to chain operations into the new elements.
        //         .attr("class", "special")
            .append("div")
                .attr('class', 'chart');
        //         .html("Hello, world!");
//--------
        // var section = d3.selectAll("#calendar_div");  //  Since method chaining can only be used to descend into the document hierarchy, use var to keep references to selections and go back up.

        //     section.append("div")
        //         .html("First!");

        //     section.append("div")
        //         .html("Second.");
//--------
        // d3.select(".chart")
        //         .selectAll("div")
        //         .data(data)
        //     .enter().append("div")
        //         .style("width", function(d) { return d * 10 + "px"; })
        //         .text(function(d) { return d; });
//--------
//--------------------------------------------------------------------------------------------------------
        // var chart = d3.select(".chart");        //  First, we select the chart container using a class selector.
        // var bar = chart.selectAll("div");       //  Next we initiate the data join by defining the selection to which we will join data.
                                                //  Think of the initial selection as declaring the elements you want to exist.

        // var barUpdate = bar.data(data);         //  Next we join the data (defined previously) to the selection using selection.data.

        // var barEnter = barUpdate.enter().append("div");     //  Since we know the selection is empty, the returned update and exit selections are also empty, 
                                                            //  and we need only handle the enter selection which represents new data for which there was no existing element. 
                                                            //  We instantiate these missing elements by appending to the enter selection.

            //--------------- barEnter.style("width", function(d) { return d * 10 + "px"; });     //  Now we set the width of each new bar as a multiple of the associated data value, d.

        //  Because these elements were created with the data join, each bar is already bound to data. 
        //  We set the dimensions of each bar based on its data by passing a function to compute the width style property.

        // barEnter.text(function(d) { return d; });       //  Lastly, we use a function to set the text content of each bar, and produce a label.
                                                        //  When formatting numbers for text labels, you may want to use d3.format 
                                                            //  for rounding and grouping to improve readability.

    //  D3’s selection operators such as attr, style and property, allow you to specify the value either as a constant (the same for all selected elements) or a function (computed separately for each element). If the value of a particular attribute should be based on the element’s associated data, then use a function to compute it; otherwise, if it’s the same for all elements, then a string or number suffices.
//--------------------------------------------------------------------------------------------------------
        var x = d3.scaleLinear()               //  Although x here looks like an object, it is also a function that returns the scaled display value 
            .domain([0, d3.max(data)])          //  in the range for a given data value in the domain. For example, an input value of 4 returns 40, and an input value of 16 returns 160. 
            .range([0, 420]);                   //  To use the new scale, simply replace the hard-coded multiplication by calling the scale function:

        // barEnter.style("width", function(d) { return x(d) + "px"; }); 
        d3.select(".chart")
  .selectAll("div")
    .data(data)
  .enter().append("div")
    .style("width", function(d) { return x(d) + "px"; })
    .text(function(d) { return d; });

    };//--------    --------    --------    --------    --------


</script>

<style>

.chart rect {
  fill: steelblue;
}

.chart text {
  fill: white;
  font: 10px sans-serif;
  text-anchor: end;
}

.chart div {
  font: 10px sans-serif;
  background-color: steelblue;
  text-align: right;
  padding: 3px;
  margin: 1px;
  color: white;
}

</style>
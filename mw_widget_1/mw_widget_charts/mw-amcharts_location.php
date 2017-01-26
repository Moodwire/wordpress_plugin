<script src="https://www.amcharts.com/lib/3/ammap.js"></script>
<script src="https://www.amcharts.com/lib/3/maps/js/usaLow.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<!-- <script src="https://www.amcharts.com/lib/3/themes/light.js"></script> -->
<!-- <script src="https://www.amcharts.com/lib/3/themes/chalk.js"></script> -->
<script src="https://www.amcharts.com/lib/3/themes/none.js"></script>

<script>

//-------- LOCATION -------- LOCATION -------- LOCATION -------- LOCATION -------- LOCATION -------- LOCATION -------- LOCATION -------- LOCATION


    function drawLocation(json) {
        var count = json.length;
// console.log('pre work', json);
        var compare_name_values_for_map = compare_mw_map_names(json); 
// console.log(compare_name_values_for_map);
        json = process_and_input_json_data_from_mw_db(json);
        var map = AmCharts.makeChart( "location_div", {
            "type": "map",
            "theme": "none",
            "colorSteps": count,        //  determines one color per entity
// color is determined automatically, consider using a function the assign a specific color.
            "dataProvider": {
                "map": "usaLow",
                    "areas": [ {    "id": "US-AL", "value": cal_val_mw(compare_name_values_for_map, json[0]['ent']), "balloonText": "[[title]] likes <strong>" + json[0]['ent'] + "</strong>"
                            }, {    "id": "US-AK", "value": cal_val_mw(compare_name_values_for_map, json[1]['ent']), "balloonText": "[[title]] likes <strong>" + json[1]['ent'] + "</strong>"
                            }, {    "id": "US-AZ", "value": cal_val_mw(compare_name_values_for_map, json[2]['ent']), "balloonText": "[[title]] likes <strong>" + json[2]['ent'] + "</strong>"
                            }, {    "id": "US-AR", "value": cal_val_mw(compare_name_values_for_map, json[3]['ent']), "balloonText": "[[title]] likes <strong>" + json[3]['ent'] + "</strong>"
                            }, {    "id": "US-CA", "value": cal_val_mw(compare_name_values_for_map, json[4]['ent']), "balloonText": "[[title]] likes <strong>" + json[4]['ent'] + "</strong>"
                            }, {    "id": "US-CO", "value": cal_val_mw(compare_name_values_for_map, json[5]['ent']), "balloonText": "[[title]] likes <strong>" + json[5]['ent'] + "</strong>"
                            }, {    "id": "US-CT", "value": cal_val_mw(compare_name_values_for_map, json[6]['ent']), "balloonText": "[[title]] likes <strong>" + json[6]['ent'] + "</strong>"
                            }, {    "id": "US-DE", "value": cal_val_mw(compare_name_values_for_map, json[7]['ent']), "balloonText": "[[title]] likes <strong>" + json[7]['ent'] + "</strong>"
                            }, {    "id": "US-FL", "value": cal_val_mw(compare_name_values_for_map, json[8]['ent']), "balloonText": "[[title]] likes <strong>" + json[8]['ent'] + "</strong>"
                            }, {    "id": "US-GA", "value": cal_val_mw(compare_name_values_for_map, json[9]['ent']), "balloonText": "[[title]] likes <strong>" + json[9]['ent'] + "</strong>"
                            }, {    "id": "US-HI", "value": cal_val_mw(compare_name_values_for_map, json[10]['ent']), "balloonText": "[[title]] likes <strong>" + json[10]['ent'] + "</strong>"
                            }, {    "id": "US-ID", "value": cal_val_mw(compare_name_values_for_map, json[11]['ent']), "balloonText": "[[title]] likes <strong>" + json[11]['ent'] + "</strong>"
                            }, {    "id": "US-IL", "value": cal_val_mw(compare_name_values_for_map, json[12]['ent']), "balloonText": "[[title]] likes <strong>" + json[12]['ent'] + "</strong>"
                            }, {    "id": "US-IN", "value": cal_val_mw(compare_name_values_for_map, json[13]['ent']), "balloonText": "[[title]] likes <strong>" + json[13]['ent'] + "</strong>"
                            }, {    "id": "US-IA", "value": cal_val_mw(compare_name_values_for_map, json[14]['ent']), "balloonText": "[[title]] likes <strong>" + json[14]['ent'] + "</strong>"
                            }, {    "id": "US-KS", "value": cal_val_mw(compare_name_values_for_map, json[15]['ent']), "balloonText": "[[title]] likes <strong>" + json[15]['ent'] + "</strong>"
                            }, {    "id": "US-KY", "value": cal_val_mw(compare_name_values_for_map, json[16]['ent']), "balloonText": "[[title]] likes <strong>" + json[16]['ent'] + "</strong>"
                            }, {    "id": "US-LA", "value": cal_val_mw(compare_name_values_for_map, json[17]['ent']), "balloonText": "[[title]] likes <strong>" + json[17]['ent'] + "</strong>"
                            }, {    "id": "US-ME", "value": cal_val_mw(compare_name_values_for_map, json[18]['ent']), "balloonText": "[[title]] likes <strong>" + json[18]['ent'] + "</strong>"
                            }, {    "id": "US-MD", "value": cal_val_mw(compare_name_values_for_map, json[19]['ent']), "balloonText": "[[title]] likes <strong>" + json[19]['ent'] + "</strong>"
                            }, {    "id": "US-MA", "value": cal_val_mw(compare_name_values_for_map, json[20]['ent']), "balloonText": "[[title]] likes <strong>" + json[20]['ent'] + "</strong>"
                            }, {    "id": "US-MI", "value": cal_val_mw(compare_name_values_for_map, json[21]['ent']), "balloonText": "[[title]] likes <strong>" + json[21]['ent'] + "</strong>"
                            }, {    "id": "US-MN", "value": cal_val_mw(compare_name_values_for_map, json[22]['ent']), "balloonText": "[[title]] likes <strong>" + json[22]['ent'] + "</strong>"
                            }, {    "id": "US-MS", "value": cal_val_mw(compare_name_values_for_map, json[23]['ent']), "balloonText": "[[title]] likes <strong>" + json[23]['ent'] + "</strong>"
                            }, {    "id": "US-MO", "value": cal_val_mw(compare_name_values_for_map, json[24]['ent']), "balloonText": "[[title]] likes <strong>" + json[24]['ent'] + "</strong>"
                            }, {    "id": "US-MT", "value": cal_val_mw(compare_name_values_for_map, json[25]['ent']), "balloonText": "[[title]] likes <strong>" + json[25]['ent'] + "</strong>"
                            }, {    "id": "US-NE", "value": cal_val_mw(compare_name_values_for_map, json[26]['ent']), "balloonText": "[[title]] likes <strong>" + json[26]['ent'] + "</strong>"
                            }, {    "id": "US-NV", "value": cal_val_mw(compare_name_values_for_map, json[27]['ent']), "balloonText": "[[title]] likes <strong>" + json[27]['ent'] + "</strong>"
                            }, {    "id": "US-NH", "value": cal_val_mw(compare_name_values_for_map, json[28]['ent']), "balloonText": "[[title]] likes <strong>" + json[28]['ent'] + "</strong>"
                            }, {    "id": "US-NJ", "value": cal_val_mw(compare_name_values_for_map, json[29]['ent']), "balloonText": "[[title]] likes <strong>" + json[29]['ent'] + "</strong>"
                            }, {    "id": "US-NM", "value": cal_val_mw(compare_name_values_for_map, json[30]['ent']), "balloonText": "[[title]] likes <strong>" + json[30]['ent'] + "</strong>"
                            }, {    "id": "US-NY", "value": cal_val_mw(compare_name_values_for_map, json[31]['ent']), "balloonText": "[[title]] likes <strong>" + json[31]['ent'] + "</strong>"
                            }, {    "id": "US-NC", "value": cal_val_mw(compare_name_values_for_map, json[32]['ent']), "balloonText": "[[title]] likes <strong>" + json[32]['ent'] + "</strong>"
                            }, {    "id": "US-ND", "value": cal_val_mw(compare_name_values_for_map, json[33]['ent']), "balloonText": "[[title]] likes <strong>" + json[33]['ent'] + "</strong>"
                            }, {    "id": "US-OH", "value": cal_val_mw(compare_name_values_for_map, json[34]['ent']), "balloonText": "[[title]] likes <strong>" + json[34]['ent'] + "</strong>"
                            }, {    "id": "US-OK", "value": cal_val_mw(compare_name_values_for_map, json[35]['ent']), "balloonText": "[[title]] likes <strong>" + json[35]['ent'] + "</strong>"
                            }, {    "id": "US-OR", "value": cal_val_mw(compare_name_values_for_map, json[36]['ent']), "balloonText": "[[title]] likes <strong>" + json[36]['ent'] + "</strong>"
                            }, {    "id": "US-PA", "value": cal_val_mw(compare_name_values_for_map, json[37]['ent']), "balloonText": "[[title]] likes <strong>" + json[37]['ent'] + "</strong>"
                            }, {    "id": "US-RI", "value": cal_val_mw(compare_name_values_for_map, json[38]['ent']), "balloonText": "[[title]] likes <strong>" + json[38]['ent'] + "</strong>"
                            }, {    "id": "US-SC", "value": cal_val_mw(compare_name_values_for_map, json[39]['ent']), "balloonText": "[[title]] likes <strong>" + json[39]['ent'] + "</strong>"
                            }, {    "id": "US-SD", "value": cal_val_mw(compare_name_values_for_map, json[40]['ent']), "balloonText": "[[title]] likes <strong>" + json[40]['ent'] + "</strong>"
                            }, {    "id": "US-TN", "value": cal_val_mw(compare_name_values_for_map, json[41]['ent']), "balloonText": "[[title]] likes <strong>" + json[41]['ent'] + "</strong>"
                            }, {    "id": "US-TX", "value": cal_val_mw(compare_name_values_for_map, json[42]['ent']), "balloonText": "[[title]] likes <strong>" + json[42]['ent'] + "</strong>"
                            }, {    "id": "US-UT", "value": cal_val_mw(compare_name_values_for_map, json[43]['ent']), "balloonText": "[[title]] likes <strong>" + json[43]['ent'] + "</strong>"
                            }, {    "id": "US-VT", "value": cal_val_mw(compare_name_values_for_map, json[44]['ent']), "balloonText": "[[title]] likes <strong>" + json[44]['ent'] + "</strong>"
                            }, {    "id": "US-VA", "value": cal_val_mw(compare_name_values_for_map, json[45]['ent']), "balloonText": "[[title]] likes <strong>" + json[45]['ent'] + "</strong>"
                            }, {    "id": "US-WA", "value": cal_val_mw(compare_name_values_for_map, json[46]['ent']), "balloonText": "[[title]] likes <strong>" + json[46]['ent'] + "</strong>"
                            }, {    "id": "US-WV", "value": cal_val_mw(compare_name_values_for_map, json[47]['ent']), "balloonText": "[[title]] likes <strong>" + json[47]['ent'] + "</strong>"
                            }, {    "id": "US-WI", "value": cal_val_mw(compare_name_values_for_map, json[48]['ent']), "balloonText": "[[title]] likes <strong>" + json[48]['ent'] + "</strong>"
                            }, {    "id": "US-WY", "value": cal_val_mw(compare_name_values_for_map, json[49]['ent']), "balloonText": "[[title]] likes <strong>" + json[49]['ent'] + "</strong>"
                        } ]
            },
                "areasSettings": {
                    "autoZoom": true
                },
                // "valueLegend": {
                    // "right": 10
                    // "minValue": "little",
                    // "maxValue": "a lot!"
                // },
                "export": {
                    "enabled": false
                }
        } );

   };//--------    --------    --------    --------    --------  
 

    function process_and_input_json_data_from_mw_db(json) {                                                 //      COMPARES EACH ENTITIES 50 STATES
        var count = json.length;
        var state_data = [];
        
        for (var a = 0; a < 50; a++) {                                                                      //      new array is made with first entity
            state_data.push(JSON.parse(json[0]['loc_' + a]));

        };//--  --  END OF FOR LOOP --  --

        for (var p = 1; p < count; p++) {                                                                   //      count starts with comparing entity 1 to new array
            var k = 0;
            
            while (k < 50) {                                                                                //      iterate each state and compare values
                var comparing_data = JSON.parse(json[p]['loc_' + k]);
                var comparing_data_value = hf.moodRanged(comparing_data['pos'], comparing_data['neg'], comparing_data['neu']);
                var state_data_value = hf.moodRanged(state_data[k]['pos'], state_data[k]['neg'], state_data[k]['neu']);

                if (state_data_value < comparing_data_value) {                                              //      conditional to compare values
                    state_data[k] = comparing_data;                                                         //      overwrite value with more positive mood
                };//--  --  END OF CONDITIONAL --  --   
                k++;
            };//--  --  END OF WHILE LOOP --  --  
        
        };//--  --  END OF FOR LOOP --  --

        return state_data;
    };//--------    --------    --------    --------    --------


    function compare_mw_map_names(json) {                                                                   //      CREATES OBJECTS WITH ENTITY NAMES AND VALUES
        var compared_and_verified = [];
        var new_array_here = {'name': json[0]['entity'], 'value': 0};       
            compared_and_verified.push(new_array_here);                                                     //      create object 1 and insert into array
        
        for (var k = 1; k < json.length; k++) {                                                             //      this will compare and prevent duplicates
            var count = 0;
            if (json[k]['entity'] != json[count]['entity']) {
                var new_object_here = {'name': json[k]['entity'], 'value': k};
                compared_and_verified.push(new_object_here);
                count++;
            };//--  --  END OF CONDITIONAL --  --
        };//--  --  END OF FOR LOOP --  --

        return compared_and_verified;
    };//--------    --------    --------    --------    --------


    function cal_val_mw(compare_this, with_that) {                                                          //      FOR THIS TYPE OF MAP, THIS FUNCTION WILL RETURN A VALUE THAT WILL DETERMINE STATE COLOR
        for (var k = 0; k < compare_this.length; k++) {
            if (compare_this[k]['name'] == with_that) {
                return compare_this[k].value;
            };//--  --  END OF CONDITIONAL --  --
        };//--  --  END OF FOR LOOP --  --
        return;
    };//--------    --------    --------    --------    --------


</script>

<style>
#location_div {
  width: 100%;
  height: 500px;
}
</style>
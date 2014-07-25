google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart);

var ajaxData = null;
var category = $('#js-category').text();
var URL = '../../progresses/ajax';

// get chart data from ajax call
$.ajax({
    type: 'POST',
    url : URL,
    async : false,
    data: {
        'chartType' : 'ggChart',
        'category'  : category
    },
    success : function (msg) {
        if(msg != ''){
            ajaxData = JSON.parse(msg);
        }
        else {
            ajaxData = [];
        }
    }
});

// draw the data
function drawChart(id){
    var data = google.visualization.arrayToDataTable(ajaxData);

    var options = {
        format: "MM/dd/yy",
        title: 'latest 10 tests performace on ' + category.charAt(0).toUpperCase() + category.slice(1),
        vAxis:{
            curveType: 'function',
            format: '##%',
            maxValue: 1,
            minValue: 0
        }
    };
    data.addColumn({type: 'string', role: 'annotation'});

    var chart = new google.visualization.LineChart(document.getElementById('chart'));
    chart.draw(data, options);
}

$.ajax({
    type: 'POST',
    url : URL,
    data: {
        'chartType' : 'overall'
    },
    success : function (msg) {
        if(isNaN(msg)){
            msg = 0;
        }
        
        $('#performance_value').text(msg+'%');
    }
});
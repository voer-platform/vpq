google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart);

var ajaxData = null;

// get chart data from ajax call
$.ajax({
    type: 'POST',
    url : '../progresses/ajax',
    async : false,
    data: {
        'chartType' : 'ggChart'
    },
    success : function (msg) {
        ajaxData = JSON.parse(msg);
    }
});

// draw the data
function drawChart(id){
    var data = google.visualization.arrayToDataTable(ajaxData);

    var options = {
        title: 'Overal performances',
        // curveType : 'function',
        vAxis:{
            format: '#,##%'
        }
    };

    var chart = new google.visualization.LineChart(document.getElementById('chart'));
    chart.draw(data, options);
}

$.ajax({
    type: 'POST',
    url : '../progresses/ajax',
    data: {
        'chartType' : 'overall'
    },
    success : function (msg) {
        $('#performance_value').text(msg+'%');
    }
});
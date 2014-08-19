google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart);

var ajaxData = null;
var subject = $('#js-subject').text();
// var URL = '../Progresses/ajax';
var URL = "<?php echo Router::url(array('controller'=>'Progresses','action'=>'ajax'));?>";

// get chart data from ajax call
$.ajax({
    type: 'POST',
    url : URL,
    async : false,
    data: {
        'chartType' : 'ggChart',
        'subject'  : subject
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
        title: 'Latest performace on ' + subject.charAt(0).toUpperCase() + subject.slice(1),
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
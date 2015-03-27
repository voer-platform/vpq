<?php echo $this->Html->css('choose_test.css'); ?>

<<<<<<< HEAD
<!--<ol class="breadcrumb">
  <li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'People', 'action' => 'dashboard')); ?></li>
  <li class="active"><?php echo __('Choose Test'); ?></li>
</ol>-->
=======
<!-- <ol class="breadcrumb">
  <li><?php # echo $this->Html->link(__('Dashboard'), array('controller' => 'People', 'action' => 'dashboard')); ?></li>
  <li class="active"><?php echo __('Choose Test'); ?></li>
</ol> -->
>>>>>>> origin/master

<div class="chooseTest">
    <h2><?php echo __('Choose test')?></h2>
    <hr />
    <?php echo __('Test').': '.$this->Name->subjectToName($subject); ?>
    <form role="form" class="form-horizontal" id="preDoTest" method="POST">
        <div class="form-group">
            <label for="" class="col-sm-3 control-label"><?php echo __('Grade'); ?></label>
            <div class="col-sm-7">
                <div class="btn-group" data-toggle="buttons">
                    <?php foreach ($grades as $index => $grade): ?>
                    <label class="btn btn-default <?php echo ($gradeUser == $grade['Grade']['name'] ? "active" : ""); ?> ">
                        <input type="radio" name="selectGrade" value="<?php echo $grade['Grade']['id']; ?>" autocomplete="off" tag='<?php echo $grade['Grade']['name']; ?>' <?php echo ($grade['Grade']['name']==10 ? "checked" : ""); ?> > <?php echo __('Grade'); ?> <?php echo $grade['Grade']['name']; ?>
                    </label>
                    <?php endforeach; ?>
                </div>   
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-3 control-label">Chủ đề</label>
            <div class="col-sm-7">
                <select class="form-control" id="selectCategory" multiple="multiple">
                </select>								
                <div id="selectedCategories" style="text-align: left;">
                    <ul>
						<?php foreach($tracking as $trk): ?>
						<li id='<?php echo $trk['Subcategory']['id']; ?>' rel='<?php echo $trk['Tracking']['grade']; ?>-<?php echo $trk['Subcategory']['id']; ?>'><span class='glyphicon glyphicon-remove remove' aria-hidden='true'></span><span class='label label-primary class<?php echo $trk['Tracking']['grade']; ?>'>Lớp&nbsp;<?php echo $trk['Tracking']['grade'];?>&nbsp/&nbsp<?php echo $trk['Subcategory']['name']; ?></span>
						</li>
						<?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class='form-group'>
            <label for="" class="col-sm-3 control-label"></label>
            <div class="col-sm-7">
                <?php
                    $times = array(5, 10, 15, 30, 60);
                    foreach($times as $time){
                        echo '<button class="btn btn-primary btn-lg1 btn-test" type="button" onclick="javascript:doTest(' . $time . ')">' . $time . ' ' . __('mins') . '</button>';
                    }
                ?>
                <!--<input type="hidden" name="level" id="level" />-->
                <input type="hidden" name="categories" id="categories" />
				<!--<input type="hidden" name="subcategory" id="subcategory"  value="<?php echo $subcategory ?>"/>-->
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">

var preSubs = '<?php echo $preSubs; ?>';

//var preSubs = '';
var arraySubs = preSubs.split(",");
var t=0;
var cl;
function preSelectCategories(){
	//$("#selectedCategories ul").empty();
	//t=t+1;
    var $s = $('#selectCategory');
    for (i=0;i<arraySubs.length;i++){
		if(arraySubs[i]!=''){
			var $selectedCategories = $('#selectedCategories>ul');
			var item = $s.find('option[value='+arraySubs[i]+']');
			var grade = $("input:radio[name=selectGrade]:checked").attr('tag');
			var s = "Lớp " +  grade + " / " + item.text();
			var v = arraySubs[i];
			//if(t==1){
			//	cl=grade;
			//}		
			//if(s!='' && grade==cl){	
			if(s!=''){	
			$selectedCategories.append("<li rel='" + v + "'><span class='glyphicon glyphicon-remove remove' aria-hidden='true'></span><span class='label label-primary class" + grade + "'>" + s + "</span></li>");
			}
		}
    }
};

function doTest(t){
    $subject = <?php echo $subject; ?>;
    $str = $('#selectedCategories>ul')
                .find('li')
                .map(function() {
                    return $(this).attr('rel');
                }).get().join(',');
    $('#categories').val($str);
    //var grade = $("input:radio[name=selectGrade]:checked").attr('tag');
    //$('#level').val(grade);
	var url = '<?php echo Router::url(array('controller'=>'tests','action'=>'byQuestion'));?>/' + t + '/'+$str;
	//alert(url);
	$.getJSON(url, function( data ) {
		 if(data<t){			
			showMessage('Không thể làm bài kiểm tra', 'Dữ liệu hiện tại không đủ để thực hiện bài kiểm tra này', 'error', 'glyphicon-remove-sign');
		 }else{
			$("#preDoTest").attr("action", "/Tests/doTest/" + t + "/" + $subject + "/");
			$('#preDoTest').submit();
		 }
	});
    
};

function choice(e){
    var $selectedCategories = $('#selectedCategories>ul');
    var grade = $("input:radio[name=selectGrade]:checked").attr('tag');
    var s = "Lớp " +  grade + " / " + e.text.trim();
    var v = e.value;
    if (e.checked){
        $selectedCategories.append("<li id='"+ v +"' rel='" + grade +"-" + v + "'><span class='glyphicon glyphicon-remove remove' aria-hidden='true'></span><span class='label label-primary class" + grade + "'>" + s + "</span></li>");
    }else{
        $selectedCategories.find('li[id="' + v + '"]').remove();
    }    
}

$(document).ready(function() {
    var $selectedCategories = $('#selectedCategories>ul');
    $('#selectCategory').multiselect({
        header: false,
        noneSelectedText: 'Chọn chủ đề',
        selectedText: '# được chọn',
        click: function(e, ui){
            choice(ui);
        },
        optgrouptoggle: function(event, ui){
            var values = $.map(ui.inputs, function(checkbox){
                // $(checkbox).trigger('click');
                choice($(checkbox));
            }).join(", ");

            // $callback.html("Checkboxes " + (ui.checked ? "checked" : "unchecked") + ": " + values);
        }

    });

	$(document).on('click', '#selectedCategories span.remove', function(){
        var val = $(this).parent().attr('id');
        $(this).parent().remove();
        $('#selectCategory').find('option[value="' + val + '"]').prop('selected', false);
        $('#selectCategory').multiselect('refresh');
    });

	$("input:radio[name='selectGrade']").change(function(e, sign){
        var url = '<?php echo Router::url(array('controller'=>'categories','action'=>'byGrade'));?>/' + $(this).val() + '/' + <?php echo $subject; ?>;		
        //if (sign != 'pre-select'){
        //    arraySubs = array();
        //}
		
        $.getJSON(url, function( data ) {
		
            var optgroups = [];
            $.each( data, function( key, val ) {
                var category = val['Category'];
                var subcategories = val['Subcategory'];
                var items = [];
                $.each(subcategories, function(k, v){
                    var tmp = $selectedCategories.find('li[rel="' + v['id'] + '"]');
                    if (tmp.length > 0 || jQuery.inArray(v['id'], arraySubs) != -1){
                        items.push( "<option value='" + v['id'] + "' selected>" + v['name'] + "</option>" );
                    }else{
                        items.push( "<option value='" + v['id'] + "'>" + v['name'] + "</option>" );
                    }
                });
                optgroups.push("<optgroup label='" + category['name'] + "'>" + items.join("") + "</optgroup>");
            });
            $("#selectCategory").empty();
            $("#selectCategory").append(optgroups.join(""));
            $('#selectCategory').multiselect('refresh');
        });
    });
	
    //$('#selectGrade').trigger("change");
    $("input:radio[name='selectGrade']:checked").trigger('change',"pre-select");

});
function showMessage(title, text, type, icon) {
    var notice = new PNotify({
        title: title,
        text: text,
        type: type,
        icon: 'glyphicon ' + icon,
        addclass: 'snotify',
        pnotify_closer: true,
        pnotify_delay: 800
    });
}
</script>

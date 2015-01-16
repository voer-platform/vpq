<?php echo $this->Html->css('choose_test.css'); ?>

<ol class="breadcrumb">
  <li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'People', 'action' => 'dashboard')); ?></li>
  <li class="active"><?php echo __('Choose Test'); ?></li>
</ol>

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
                        <input type="radio" name="selectGrade" value="<?php echo $grade['Grade']['id']; ?>" autocomplete="off" tag='<?php echo $grade['Grade']['name']; ?>' <?php echo ($gradeUser == $grade['Grade']['name'] ? "checked" : ""); ?> > <?php echo __('Grade'); ?> <?php echo $grade['Grade']['name']; ?>
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
                <input type="hidden" name="level" id="level" />
                <input type="hidden" name="categories" id="categories" />
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
function doTest(t){
    $subject = <?php echo $subject; ?>;
    $str = $('#selectedCategories>ul')
                .find('li')
                .map(function() {
                    return $(this).attr('rel');
                }).get().join(',');
    $('#categories').val($str);
    $("#preDoTest").attr("action", "/Tests/doTest/" + t + "/" + $subject + "/");
    // alert($str);
    $('#preDoTest').submit();
};

function choice(e){
    var $selectedCategories = $('#selectedCategories>ul');
    var grade = $("input:radio[name=selectGrade]:checked").attr('tag');
    var s = "Lớp " +  grade + " / " + e.text.trim();
    var v = e.value;
    if (e.checked){
        $selectedCategories.append("<li rel='" + v + "'><span class='glyphicon glyphicon-remove remove' aria-hidden='true'></span><span class='label label-primary class" + grade + "'>" + s + "</span></li>");
    }else{
        $selectedCategories.find('li[rel="' + v + '"]').remove();
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
        var val = $(this).parent().attr('rel');
        $(this).parent().remove();
        $('#selectCategory').find('option[value="' + val + '"]').prop('selected', false);
        $('#selectCategory').multiselect('refresh');
    });

    $("input:radio[name='selectGrade']").change(function(e){
        var url = '<?php echo Router::url(array('controller'=>'categories','action'=>'byGrade'));?>/' + $(this).val() + '/' + <?php echo $subject; ?>;

        $.getJSON(url, function( data ) {
            var optgroups = [];
            $.each( data, function( key, val ) {
                var category = val['Category'];
                var subcategories = val['Subcategory'];
                var items = [];
                $.each(subcategories, function(k, v){
                    var tmp = $selectedCategories.find('li[rel="' + v['id'] + '"]');
                    if (tmp.length > 0){
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

    // $('#selectGrade').trigger("change");
    $("input:radio[name='selectGrade']:checked").trigger('change');


});
</script>

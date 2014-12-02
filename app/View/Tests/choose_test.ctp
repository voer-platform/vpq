<?php echo $this->Html->css('choose_test.css'); ?>

<ol class="breadcrumb">
  <li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'People', 'action' => 'dashboard')); ?></li>
  <li class="active"><?php echo __('Choose Test'); ?></li>
</ol>

<div class="chooseTest">
    <h2>CHUẨN BỊ KIỂM TRA<?php //echo __('Choose time for the test')?></h2>
    <hr />
    <?php echo __('Test').': '.$this->Name->subjectToName($subject); ?>
    <form role="form" class="form-horizontal" id="preDoTest" method="POST">
        <div class="form-group">
            <label for="" class="col-sm-3 control-label"><?php echo __('Grade'); ?></label>
            <div class="col-sm-7">
                <select class="form-control" id="selectGrade">
                    <?php foreach ($grades as $index => $grade): ?>
                    <option value="<?php echo $grade['Grade']['id']; ?>"><?php echo $grade['Grade']['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-3 control-label"><?php echo __('Category'); ?></label>
            <div class="col-sm-7">
                <select class="form-control" id="selectCategory" multiple="multiple">
                </select>
                <div id="selectedCategories" style="text-align: left;">
                    <ul>
                    </ul>
                </div>
            </div>
        </div>
        <div class='btn-groups'>
            <?php
                $times = array(5, 10, 15, 30, 60);
                foreach($times as $time){
                    echo '<button class="btn btn-primary btn-lg" type="button" onclick="javascript:doTest(' . $time . ')">' . $time . ' ' . __('mins') . '</button>';
                }
            ?>
            <input type="hidden" name="level" id="level" />
            <input type="hidden" name="categories" id="categories" />
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

$(document).ready(function() {
    var $selectedCategories = $('#selectedCategories>ul');
    var $selectGrade = $('#selectGrade');
    $('#selectCategory').multiselect({
        click: function(e, ui){
            var s = "Class " +  $selectGrade.find(':selected').text() + " / " + ui.text.trim();
            var v = ui.value;
            if (ui.checked){
                $selectedCategories.append("<li rel='" + v + "'><span class='glyphicon glyphicon-remove remove' aria-hidden='true'></span><span class='label label-primary class" + $selectGrade.find(':selected').text() + "'>" + s + "</span></li>");
            }else{
                $selectedCategories.find('li[rel="' + v + '"]').remove();
            }
        },
        optgrouptoggle: function(event, ui){
            var values = $.map(ui.inputs, function(checkbox){
             return checkbox.value;
            }).join(", ");

            $callback.html("Checkboxes " + (ui.checked ? "checked" : "unchecked") + ": " + values);
        }

    });

    $(document).on('click', '#selectedCategories span.remove', function(){
        var val = $(this).parent().attr('rel');
        $(this).parent().remove();
        $('#selectCategory').find('option[value="' + val + '"]').prop('selected', false);
        $('#selectCategory').multiselect('refresh');
    });

    $('#selectGrade').change(function(e){
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

    $('#selectGrade').trigger("change");

});
</script>

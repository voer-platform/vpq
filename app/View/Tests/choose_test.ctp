<?php echo $this->Html->css('choose_test.css'); ?>

<ol class="breadcrumb">
  <li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'People', 'action' => 'dashboard')); ?></li>
  <li class="active"><?php echo __('Choose Test'); ?></li>
</ol>

<div class="chooseTest">
    <h2><?php echo __('Choose time for the test')?></h2>
    <?php echo __('Test').': '.$this->Name->subjectToName($subject); ?>
    <form role="form" class="form-horizontal">
        <div class="form-group">
            <label for="" class="col-sm-3 control-label"><?php echo __('Grade'); ?></label>
            <div class="col-sm-7">
                <select class="form-control" id="selectGrade">
                    <?php foreach ($grades as $index => $grade): ?>
                    <option value="<?php echo $grade['Grade']['id']; ?>"><?php echo __('Class') . ' ' . $grade['Grade']['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-3 control-label"><?php echo __('Category'); ?></label>
            <div class="col-sm-7">
                <select class="form-control" id="selectCategory">
                </select>
            </div>
        </div>
    </form>
    <div class='btn-groups'>
        <?php
            $times = array(5, 10, 15, 30, 60);
            foreach($times as $time){
                echo $this->Html->link($time . ' '. __('mins'), array('controller' => 'Tests', 'action' => 'doTest', $time, $subject), array('class' => 'btn btn btn-primary btn-lg'));
            }
        ?>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#selectGrade').change(function(e){
        var url = '<?php echo Router::url(array('controller'=>'categories','action'=>'byGrade'));?>/' + $(this).val() + '/' + <?php echo $subject; ?>;

        $.getJSON(url, function( data ) {
            var optgroups = [];
            $.each( data, function( key, val ) {
                var category = val['Category'];
                var subcategories = val['Subcategory'];
                var items = [];
                $.each(subcategories, function(k, v){
                    items.push( "<option value='" + v['id'] + "'>" + v['name'] + "</option>" );
                });
                optgroups.push("<optgroup label='" + category['name'] + "'>" + items.join("") + "</optgroup>");
            });
            $("#selectCategory").empty();
            $("#selectCategory").append(optgroups.join(""));
        });
    });

    $('#selectGrade').trigger("change");
});
</script>

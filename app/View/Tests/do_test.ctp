<ol class="breadcrumb">
  <li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'People', 'action' => 'dashboard')); ?></li>
  <li class="active"><?php echo __('Do test'); ?></li>
</ol>

<p id='clock-time' style='display:none;'><?php echo $duration; ?></p>

<?php echo $this->element('clock'); ?>
<?php echo $this->element('do_test');?>
<script>
$(document).ready(function(){
    $('ul#questions').simplePaging({pageSize: "1"});

    $('ul#questions').find('input[type="radio"]').on('click', function(){
        setTimeout(function() {
            $('ul#questions').data('simplePaging').nextPage();      
        }, 500);
    });

})
</script>

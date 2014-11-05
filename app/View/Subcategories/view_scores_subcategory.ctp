<div class='container'>
	<h2><?php echo __('Your scores on ').'"'. $this->Name->subcategoryToName($subcategory_id).'"'; ?></h2>
	<?php echo $this->element('table_score'); ?>
</div>
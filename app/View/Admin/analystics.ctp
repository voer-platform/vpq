<div class="analystic container">
    <h1><?php echo __("Anaystics page"); ?></h1>
    <p><?php echo __("Number of questions for each subcategory in database."); ?></p>
    <table class="table table-striped table-condensed table-hover table-bordered">
        <?php echo $this->Html->tableHeaders(array( __('ID'), __('Name'),__('Number of questions'))); ?>
        <?php foreach($data as $id => $d): ?>
            <?php echo $this->Html->tableCells(array(
                $d['Subcategory']['id'],
                $this->Html->link($d['Subcategory']['name'], array('controller' => 'subcategories', 'action' => 'view', $d['Subcategory']['id'])),
                $d[0]['number'])); ?>
        <?php endforeach; ?>
    </table>
</div>
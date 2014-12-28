<div class='manual-categorize'>
    <h1><?php echo __("Categorize"); ?></h1>

    <div class="paging">
    <p>
        <?php
        echo $this->Paginator->counter(array(
        'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
        ));
        ?>  </p>
    <?php
        echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
        echo $this->Paginator->numbers(array('separator' => ''));
        echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
    ?>
    </div>

    <!-- table -->
    <table>
        <?php echo $this->Html->tableHeaders(array(
            __('id'),
            __('Content'),
            __('Subcategory'),
            __('Action')
        )); ?>
        <?php foreach($questions as $question): ?>
            <?php echo $this->Form->create('Question', array(
                'id' => 'QuestionEditForm',
                'url' => array (
                    'controllers' => 'questions',
                    'action' => 'edit', 
                    $question['Question']['id']
                )
            )); ?>
            <?php echo $this->Form->input('id', array(
                'name' => 'id',
                'value' => $question['Question']['id'],
                'type' => 'hidden'
            )); ?>
            <?php echo $this->Html->tableCells(array(
                $question['Question']['id'],
                $question['Question']['content'],
                $this->Form->input('', array(
                    'name' => 'Subcategory.id',
                    'value' => $question['Subcategory'][0]['id'],
                    'type' => 'text')),
                $this->Form->end('Submit')
            )); ?>
        <?php endforeach; ?>
    </table>

    <hr>

    <div class="paging">
    <p>
        <?php
        echo $this->Paginator->counter(array(
        'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
        ));
        ?>  </p>
    <?php
        echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
        echo $this->Paginator->numbers(array('separator' => ''));
        echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
    ?>
    </div>
    
    </div>
</div>

<style type="text/css">
    .paging a{
        padding: 1px;
    }
</style>
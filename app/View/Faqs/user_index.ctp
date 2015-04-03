<div class="faqs index">
    <h2><?php echo __('Faq'); ?></h2>
    <p class="description"><?php echo __('Here are frequently asked questions sent to PLS by users.'); ?></p>
    <table cellpadding="0" cellspacing="0" class="table table-striped table-condensed table-hover table-bordered">
    <thead>
    <tr>
            <th><?php echo __("FAQ content") ?></th>
            <th><?php echo __("FAQ answer") ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($faqs as $faq): ?>
        <?php if($faq['Faq']['status'] === 'answered'): ?>
            <tr>
                <td><?php echo h($faq['Faq']['content']); ?>&nbsp;</td>
                <td><?php echo h($faq['Faq']['answer']); ?>&nbsp;</td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>
    </tbody>
    </table>
    
    <div class="paging">
    <?php
        echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
        echo $this->Paginator->numbers(array('separator' => ' '));
        echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
    ?>
    </div>
</div>
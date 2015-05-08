<div class="faqs index">
    <h2><?php echo __('Faq'); ?></h2>
    <p class="description"><?php echo __('Here are frequently asked questions sent to PLS by users.'); ?></p>
	<hr/>
    
    <?php foreach ($faqs as $faq): ?>
        <?php if($faq['Faq']['status'] === 'answered'): ?>
            <h4><font color="green"><b>Q?</b></font> <?php echo h($faq['Faq']['content']); ?></h4>
			<p class="pdl-30"><?php echo $faq['Faq']['answer']; ?></p>
			<br/>
        <?php endif; ?>
    <?php endforeach; ?>
   
	<!--
   
    <div class="paging">
    <?php
        echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
        echo $this->Paginator->numbers(array('separator' => ' '));
        echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
    ?>
    </div>
	-->
</div>
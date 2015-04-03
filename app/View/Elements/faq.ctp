<?php echo $this->Html->css('faq.css'); ?>
<div class="faq-container">
    <button class="faq-toggle-btn btn btn-sm btn-primary" type="button" data-toggle="collapse" data-target="#faq-popup" aria-expanded="false" aria-control="faq-popup"><?php echo __("Ask us a question"); ?></button>
    <div id="faq-popup" class="collapse">
        <div class="title"><?php echo __("Have a question for us? Wanna give some comments? Type here!"); ?></div>
        <textarea class='faq-content'></textarea>
        <div class='faq-response'></div>
        <button class="faq-submit-btn btn btn-sm btn-primary"><?php echo __("Submit"); ?></button>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        var state = false;
        $('.faq-submit-btn').click(function(){
            $.ajax({
                type : 'post',
                url : "<?php echo Router::url(array('controller' => 'Faqs', 'action' => 'userAdd'), true);?>",
                data : {
                    'person_id' : "<?php echo $user['id']; ?>",
                    'content' : $('.faq-content').val()
                },
                success : function(msg){
                    $('.faq-response').text(msg);
                    $('.faq-content').fadeToggle("slow", "linear");
                    $('.faq-response').fadeToggle("slow", "linear");
                    $('.faq-response').text('');
                    $('.faq-content').val('');
                    
                }
            })
        });
    });
</script>
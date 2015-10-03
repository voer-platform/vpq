<?php echo $this->Html->css('faq.css'); ?>
<div class="faq-container">
    <button class="faq-toggle-btn btn btn-lg btn-info" type="button" data-toggle="modal" data-target="#faq-modal" title="<?php echo __("Ask us a question"); ?>">
		<span class="glyphicon glyphicon-question-sign"></span>
	</button>
</div>
<div class="modal" id="faq-modal">
	<div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title"><?php echo __("Have a question for us? Wanna give some comments? Type here!"); ?></h4>
		  </div>
		  <div class="modal-body">
			<!--<div class="alert alert-warning" id="faq-response" style="display:none;"></div>
			<textarea id="faq-content" class="form-control" rows="5" placeholder="<?php echo __('Write your question...'); ?>"></textarea>-->
			<iframe style="overflow-y:scroll !important; overflow-x:hidden !important; overflow:hidden;height:400px;width:550px;" src="http://localhost/qa"  frameborder="none" scrolling="yes"></iframe>
		  </div>
		  <div class="modal-footer">
			<!--<button type="button" id="faq-submit-btn" class="btn btn-primary"><span class="glyphicon glyphicon-send"></span> &nbsp;<?php echo __("Send PLS"); ?></button>-->
			<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close'); ?></button>
		  </div>
		</div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
    $(document).ready(function(){
        $('.faq-toggle-btn').click(function(){
			mixpanel.track("FAQ Form", {"user_id": "<?php echo $user['id']; ?>"});
		});
        $('#faq-submit-btn').click(function(){
			content = $('#faq-content').val();
            if(content != ''){
                $.ajax({
                    type : 'post',
                    url : "<?php echo Router::url(array('controller' => 'Faqs', 'action' => 'userAdd'), true);?>",
                    data : {
                        'person_id' : "<?php echo $user['id']; ?>",
                        'content' : content
                    },
                    success : function(msg){
                        $('#faq-response').text(msg).show();
                        $('#faq-content').val('');
                        setTimeout(function(){
                            $('#faq-response').text('').hide();
                        }, 3000);
                    }
                });
            }
            else{
                $('#faq-response').text("<?php echo __('Blank content'); ?>");
                $('#faq-response').show();
            }
        });
    });
</script>
	
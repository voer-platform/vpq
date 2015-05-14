<?php 
	if(!empty($notifications)){
		$count = count($notifications);
		foreach($notifications AS $notify){ 
			$count--;
?>
		<li>
			<?php
				$notifyContent = $notify['NotificationType']['content'];
				
				if($notify['Person2']['id']){ 
					echo '<img src="'.$notify['Person2']['image'].'" class="notify-img" />';
					
					$objectUrl = $this->Html->url(array('controller'=>'People', 'action'=>'view', $notify['Person2']['id']));
					$object = '<b><a href="'.$objectUrl.'">'.$notify['Person2']['fullname'].'</a></b>';
					$notifyContent = str_replace('{1}', $object, $notifyContent);
					
				} else {
					echo $this->Html->image('avatars/no_avatar.png', array('class' => 'notify-img')); 
					
					$personUrl = $this->Html->url(array('controller'=>'People', 'action'=>'view', $notify['Person']['id']));
					$person = '<b><a href="'.$personUrl.'">'.$notify['Person']['fullname'].'</a></b>';
					$notifyContent = str_replace('{0}', $person, $notifyContent);
				}
				echo $notifyContent;
			?>
		</li>	
		<?php if($count>0){ ?>
			<li class="divider"></li>
		<?php } ?>	
<?php
		}
	}
	else
	{
?>	
		<li class="center pd10"><?php echo __('You have no new notifications'); ?></li>
<?php		
	}
?>
<?php echo $this->Html->css('profile.css'); ?>
<div class="profile-view container">
    <div class="profile-view header row">
        <div class="avatar col-md-2">
            <?php echo $this->Html->image($person['Person']['image']); ?>
        </div>
        <div class="info col-md-10">
            <h1><?php echo $person['Person']['first_name'].' '.$person['Person']['last_name']; ?></h1>
            <p><?php echo '<b>'.__('Member since').'</b>'.': '.date('d-m-Y', strtotime($person['Person']['date_created'])); ?></p>
            <p><?php echo '<b>'.'Facebook'.' '.__('account').'</b>'.': '.$this->Html->link($person['Person']['first_name'].' '.$person['Person']['last_name'], 'http://facebook.com/'.$person['Person']['facebook']) ?></p>
        </div>
    </div>
</div>
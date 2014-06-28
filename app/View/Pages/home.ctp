<?php echo $this->Html->css('home.css');?>

<div class='container'>
    <div class="jumbotron">
        <h1>Check it!</h1>
        <p class="lead">Join us to access Open, Free, Huge pool of questions in many categories</p>
        <p><!-- <a class="btn btn-lg btn-success" href="#" role="button">Get started today</a> -->
        <?php 
        	if(empty($this->Session->read('Auth.User'))){
        		echo $this->Html->link('Join us', 
                        array('controller' => 'people', 'action' => 'register'),
                        array('class' => "btn btn-lg btn-success")
                        );
            }
            else {
            	echo $this->Html->link('Start', 
                        array('controller' => 'tests', 'action' => 'chooseTest'),
                        array('class' => "btn btn-lg btn-success")
                        );
            }            ?></p>
    </div>
</div>
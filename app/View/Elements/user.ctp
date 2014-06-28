<div id = 'user'>
    <?php
        $user = $this->Session->read('Auth.User');
        if(!empty($user)) {
            echo "Logged in as: ".$user['username'].' ';
            echo $this->Html->link('logout',
                    array(
                        'controller' => 'people',
                        'action' => 'logout',
                        1,));
        }
        else {
            echo $this->Html->link('logout',
                array(
                        'controller' => 'people',
                        'action' => 'login',
                        1,));
        }

    ?>
</div>
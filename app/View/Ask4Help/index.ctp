<?php $this->start('meta'); ?>
<meta property="og:url" content="<?php echo Router::url( $this->here, true ); ?>" /> 
<meta property="og:title" content="Chocolate Pecan Pie" />
<meta property="og:description" content="This pie is delicious!" /> 
<meta property="og:image" content="https://fbcdn-dragon-a.akamaihd.net/hphotos-ak-prn1/851565_496755187057665_544240989_n.jpg" />
<?php $this->end(); ?>

<h2 class="page-heading heading">Ask for help</h2>

<div class='score-view'>
  <?php echo $questionData['Question']['content']; ?>
  <div class='input radio'>
    <?php foreach($questionData['Answer'] as $answerId => $answer): ?>
      <!-- correct answer -->
      <?php if( $answer['correctness'] == 1): ?>
        <div class='score-answer-correct'>
      <!-- else -->
      <?php else: ?>
	<div class='score-answer-normal'>
      <?php endif; ?>

        <!-- correct answer -->
        <?php if( $answer['correctness'] == '1'): ?>
          <input type='radio' id='<?php echo "TestAnswer".$answerId; ?>' checked='checked' disabled >
        <!-- normal answer -->
        <?php else: ?>
          <input type='radio' id='<?php echo "TestAnswer".$answerId; ?>' disabled >
        <?php endif; ?>
        <!-- label -->
        <label for='<?php echo "TestAnswer".$answerId; ?>'> <?php echo $answer['content']; ?></label>
      </div>
    <?php endforeach;?>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    var FBShare = function () {
      FB.ui({
        method: 'share',
        //href: 'http://pls.edu.vn/',
        href: '<?php echo Router::url( $this->here, true ); ?>',
      }, function(response){});
    };
    <?php if ( count($explanationsData) < 1 ): ?>
      setTimeout(FBShare, 1000);
    <?php endif; ?>
    $('.fb-share').click(function() {
        FBShare();
    });
  });
</script>

<div id="explanation-listing">
<?php foreach($explanationsData as $eid => $explanation): ?>
  <div class="expanation clearfix">
    <div class="content">
      <?php echo $explanation['Explanation']['content']; ?>
    </div>
    <div class="user-info dashboard-header clearfix pull-right">
      <?php $person = $this->Person->getById($explanation['Explanation']['person_id']); ?>
      <div class="avatar pull-left">
        <a class="profile-img" href="/people/dashboard">
          <img width="60px" height="60px" class="profile-img" src="<?php echo $person['image']; ?>" />
        </a>
      </div>
      <div class="user-name pull-left">
        <a href="/people/dashboard">
          <h4><?php echo $person['first_name'].' '.$person['last_name']; ?></h4>
        </a>
        <div class="user-action-time">
          answered
          <span class="relativetime">
            <?php echo $explanation['Explanation']['created']; ?>
          </span>
        </div>
      </div>
    </div>
  </div>
<?php endforeach;?>
<?php if ( count($explanationsData) < 1 ): ?>
  <p>No explanations found!</p>
<?php endif; ?>
</div>

<div id="ask-for-help">
  <a class="fb-share" style="cursor: pointer;">Still not find your answer? Share this on Facebook to get help from your friends.</a>
</div>

<h3>Your Answer</h3>
<?php
echo $this->Form->create('Explanation', array(
    'url' => array(
        'controller' => 'ask4Help',
        'action' => 'index/'.$questionData['Question']['id']
    )
));
echo $this->Form->input('content', array(
    'rows' => '3',
    'label' => false
));
echo $this->Form->input('question_id', array(
    'type' => 'hidden',
    'value' => $questionData['Question']['id']
));
echo $this->Form->input('person_id', array(
    'type' => 'hidden',
    'value' => $user['id']
));
echo $this->Form->end('Post Your Answer');
?>

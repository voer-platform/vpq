<ol class="breadcrumb">
  <li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'People', 'action' => 'dashboard')); ?></li>
  <li class="active"><?php echo __('Covered'); ?></li>
</ol>
<div class='cover'>

  <center>
    <h2><?php echo __('Your coverage for').' '.$this->Name->subjectToName($subject); ?></h2>
  </center>

  <div class = 'row'>
    <!-- first -->
    <div class='col-lg-4 col-lg-offset-2'>
      <div class="list-group">
        <?php foreach($grades as $grade): ?>
            <a class='list-group-item' href='#' id='grade-btn-<?php echo $grade['Grade']['id']?>'>
              <?php echo __('Grade').' '.$grade['Grade']['name']; ?>
              <span class="badge">14</span>
            </a>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- second -->
    <div class='col-lg-4'>
      <div class='row'>
        <div class="panel-group" id="accordion">
          <?php foreach($categories as $key => $category): ?>
            <div class="panel panel-default grade-<?php echo $category['Category']['grade_id'];?>">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $key;?>">
                    <?php echo $category['Category']['name']; ?>
                  </a>
                </h4>
              </div>
              <div id="collapse<?php echo $key;?>" class="panel-collapse collapse in">
                <?php foreach($category['Subcategory'] as $subcategory): ?>
                  <div class="panel-body">
                    <?php echo $subcategory['name']; ?>
                    <span class="badge">14</span>    
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
  // collapse all 
  $(".collapse").collapse();
  $('.grade-1').css({'display' : 'block'});$('#grade-btn-1').addClass('active');
  $('.grade-2').css({'display' : 'none'});
  $('.grade-3').css({'display' : 'none'});

  function btn1(){
    $('.grade-1').css({'display' : 'block'});$('#grade-btn-1').addClass('active');
    $('.grade-2').css({'display' : 'none'});$('#grade-btn-2').removeClass('active');
    $('.grade-3').css({'display' : 'none'});$('#grade-btn-3').removeClass('active');
  }

  function btn2(){
    $('.grade-1').css({'display' : 'none'});$('#grade-btn-1').removeClass('active');
    $('.grade-2').css({'display' : 'block'});$('#grade-btn-2').addClass('active');
    $('.grade-3').css({'display' : 'none'});$('#grade-btn-3').removeClass('active');
  }
  function btn3(){
    $('.grade-1').css({'display' : 'none'});$('#grade-btn-1').removeClass('active');
    $('.grade-2').css({'display' : 'none'});$('#grade-btn-2').removeClass('active');
    $('.grade-3').css({'display' : 'block'});$('#grade-btn-3').addClass('active');
  }

  $('#grade-btn-1').click(btn1);
  $('#grade-btn-2').click(btn2);
  $('#grade-btn-3').click(btn3);
</script>
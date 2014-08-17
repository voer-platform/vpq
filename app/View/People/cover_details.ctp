<div class='cover'>

  <div class = 'row'>
    <!-- first -->
    <!-- <div class='col-lg-4'> -->
      <div class="panel-group" id="accordion">
        <?php foreach($categories as $key => $category): ?>
          <div class="panel panel-default">
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
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <!-- </div> -->

  </div>
</div>

<script type="text/javascript">
  $(".collapse").collapse();
</script>
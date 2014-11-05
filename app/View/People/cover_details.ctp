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
    <div class='col-lg-4'>
      <div class="list-group" id='first-col'>
        <?php foreach($grades as $grade): ?>
            <a class='list-group-item btn-grade' href='#' id='grade-btn-<?php echo $grade['Grade']['id']?>'>
              <?php echo __('Grade').' '.$grade['Grade']['name']; ?>
              <span class="badge">14</span>
            </a>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- second -->
    <div class='col-lg-4'>
      <div class="list-group" id='second-col'>
        <?php foreach($categories as $key => $category): ?>
          <a class='list-group-item btn-category grade-<?php echo $category['Category']['grade_id'];?>' href='#' id='category-btn-<?php echo $category['Category']['id']?>'>
            <?php echo $category['Category']['name']; ?>
            <span class="badge">14</span>
          </a>
        <?php endforeach; ?>
      </div>  
    </div>

    <!-- third -->
    <div class='col-lg-4'>
      <ul class="list-group" id='third-col'>
        <?php foreach($categories as $key => $category): ?>
          <?php foreach($category['Subcategory'] as $subcategory): ?>
            <li class="list-group-item subcategory subcategory-<?php echo $category['Category']['id']?>" id="subcategory-<?php echo $subcategory['id'] ?>">
              <?php echo $this->Html->link($subcategory['name'], array('controller' => 'Subcategories', 'action' => 'viewScoresSubcategory', $subcategory['id'])); ?>
            </li>
          <?php endforeach; ?>
        <?php endforeach; ?>
      </div>
    </div>

  </div>
</div>

<?php echo $this->Html->script('cover_details'); ?>
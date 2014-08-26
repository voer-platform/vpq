$('#grade-btn-1').addClass('active');
$('#category-btn-1').addClass('active');
$('.btn-category').css({'display' : 'none'});
$('.btn-category.grade-1').css({'display' : 'block'});
$('.subcategory').css({'display' : 'none'});
$('.subcategory.subcategory-1').css({'display' : 'block'});

function clickGrade(){
  $('.btn-grade').removeClass('active');
  $('.btn-category').removeClass('active');

  $(this).addClass('active');
  var id = ($(this).attr('id')).split('-')[2];

  $('.btn-category').css({'display' : 'none'});
  $('.btn-category.grade-' + id).css({'display' : 'block'});
  var firstBtnCategory = $('#second-col a.btn-category.grade-'+id+':first');
  firstBtnCategory.addClass('active');

  id = firstBtnCategory.attr('id').split('-')[2];

  $('.subcategory').css({'display' : 'none'});
  $('.subcategory.subcategory-'+id).css({'display' : 'block'});
}

function clickCategory(){
  $('.btn-category').removeClass('active');
  $(this).addClass('active');

  var id = ($(this).attr('id')).split('-')[2];
  $('.subcategory').css({'display' : 'none'});
  $('.subcategory.subcategory-'+id).css({'display' : 'block'});
}

$('.btn-category').click(clickCategory);
$('.btn-grade').click(clickGrade);
<?php echo $this->Html->css('choose_test.css'); ?>
<!--<ol class="breadcrumb">
  <li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'People', 'action' => 'dashboard')); ?></li>
  <li class="active"><?php echo __('Choose Test'); ?></li>
</ol>-->

<div class="chooseTest">
    <h2><?php echo __('Choose test')?></h2>
    <hr />
    <?php echo __('Test').': '.$this->Name->subjectToName($subject); ?>
    <form role="form" class="form-horizontal" id="preDoTest" method="POST">
	<br/>
		
		<div class="col-sm-6 col-sm-offset-3">
			<div class="row">
				<div class="col-sm-12" style="padding:0px">
					<div class="nav-tabs-custom" style="margin-bottom: 0px; box-shadow:none;">
						<ul class="nav nav-tabs">
							<li class="active" >
								<a href="#tab1" data-toggle='tab'>Lớp 10</a>
							</li>
							<li>
								<a href="#tab2" data-toggle='tab'>Lớp 11</a>
							</li>
							<li>
								<a href="#tab3" data-toggle='tab'>Lớp 12</a>
							</li>
						</ul>
					</div>
				</div>				
			</div>
			<div class='row'>
				<table class="table table-condensed" style="border-collapse:collapse;border:0px;margin:0px">
					<tbody>
						<tr>
							<td style="padding-left:5px;border-left: solid 1px #ddd; border-top:0px; width:10px;">
								<input type="checkbox" id="checkfull"'/>
							</td>
							<td style="border-top:0px;">
								<a>Check All</a>
							</td>
							<td style="border-right: solid 1px #ddd;border-top:0px;">
								<a style='float:right'>Số bài bạn đã chọn: <span id="sl"><?php echo $count ?></span></a>	
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="row">
				<div class="tab-content col-sm-12	" style="padding:0px;">
				<?php for($i=1;$i<=3;$i++): ?>
					<div class="tab-pane <?php echo($i==1)?"active":""; ?> " id="tab<?php echo $i;?>">
						<table class="table table-condensed" id="grade<?php echo $i;?>" style="border-collapse:collapse;border:0px">
							<tbody>						
								<?php foreach($allcat as $item=>$ac): ?>
								<?php if($ac['Grade']['id']==$i): ?>
								<tr>
									<td class="td_cat" style="padding-left:5px; width:10px;border: solid 1px #ddd;border-right:0px;">
										<input type="checkbox" class="checkall chk_box" data-id='<?php echo $ac['Category']['id'] ?>'/>
									</td>
									<td colspan='2' class="cat" data-id='<?php echo $ac['Category']['id'] ?>' style="padding-left:5px;border: solid 1px #ddd;border-left:0px;">&nbsp<a><?php echo $ac['Category']['name'];?><i style="float:right;margin-top:2px" class="glyphicon glyphicon-plus-sign"></i><span id='spcat-<?php echo $ac['Category']['id'] ?>' style="float:right; margin-right:10px;" id="sl_incat"></span></a>
									</td>
								</tr>				
								<?php foreach($ac['Subcategory'] as $item=>$asc): ?>
									<tr class="subcat cat-<?php echo $ac['Category']['id'] ?> sub-<?php echo $asc['id'] ?>" data-id='<?php echo $ac['Category']['id'] ?>' data-sub='<?php echo $asc['id'] ?>'>
										<td style='border: solid 1px #ddd;border-right:0px;'>
										</td>
										<td style="width:23px;">
											<input type="checkbox" name="sub" class='chk_box chksub chk-<?php echo $ac['Category']['id'] ?> ' id='sub-<?php echo $asc['id'] ?>' value="<?php echo $asc['id']?>" <?php echo (in_array($asc['id'],$pretracking) ? "checked" : ""); ?> />
										</td>
										<td style='border: solid 1px #ddd;border-left:0px;' class="td-subcat" data-id='<?php echo $asc['id'] ?>'><?php echo $asc['name'] ?></td>
									</tr>
								<?php endforeach; ?>									
								<?php endif; ?>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				<?php endfor; ?>					
				</div>	
			</div>
			
			<div class="row">
				<div class="tab-content col-sm-12" style="padding:0px; padding-top:10px">
					<div class='form-group'>
						<label for="" class="col-sm-3 control-label"></label>
						<div class="col-sm-12 ">
							<?php
								$times = array(5, 10, 15, 30, 60);
								foreach($times as $time){
									echo '<button class="btn btn-primary btn-lg1 btn-test" type="button" onclick="javascript:doTest(' . $time . ')">' . $time . ' ' . __('mins') . '</button>';
								}
							?>
							<input type="hidden" name="categories" id="categories" />
						</div>
					</div>
				</div>
			</div>
		</div>			
    </form>	
</div>

<!--<div class="modal fade" id="modal_ds" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
	 aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content" style="width: 450px">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span
						aria-hidden="true">&times;</span><span
						class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Danh sách các bài đã chọn</h4>
			</div>
			<div class="modal-body" style="padding:0px">
				<form class="form-horizontal" role="form" id="frmtab10">
					<table class="table table-condensed" id="table_modal" style="border-collapse:collapse;border:0px">
						
					</table>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" id="{$btn_qtdt}" name="{$btn_qtdt}"><span class="glyphicon glyphicon-ok-sign"></span></button>
				<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>-->

<script type="text/javascript">
var totalsubcat=<?php echo $totalsubcat ?>;
var sl=<?php echo $count ?>;
var pretracking='<?php echo $strtracking ?>';
var arraySubs = pretracking.split(",");
function preSelectCategories(){
	for (i=0;i<arraySubs.length;i++){
		if(arraySubs[i]!=''){
			var s = $('.sub-'+arraySubs[i]).attr('data-id');
			var countpre = $('#spcat-'+s).text();
			if(countpre==''){
				countpre=0;
				countpre=countpre+1;
			}else{
				countpre=parseInt(countpre);
				countpre=countpre+1;
			}
			document.getElementById('spcat-'+s).innerHTML=countpre;
		}
	}
}

function doTest(t){
    $subject = <?php echo $subject; ?>;
	var $str='';
	for(i=1;i<=3;i++){
		$str = 	$str+$('#grade'+i)
                .find("input:checkbox[name=sub]:checked")
                .map(function() {
                    return $(this).attr('value');
                }).get().join(',');
		$str=$str+',';
	}
    $('#categories').val($str);
	var url = '<?php echo Router::url(array('controller'=>'tests','action'=>'byQuestion'));?>/' + t + '/'+$str;
	$.getJSON(url, function( data ) {
		 if(data<t){			
			showMessage('Không thể làm bài kiểm tra', 'Dữ liệu hiện tại không đủ để thực hiện bài kiểm tra này', 'error', 'glyphicon-remove-sign');
		 }else{
			$("#preDoTest").attr("action", "/Tests/doTest/" + t + "/" + $subject + "/");
			$('#preDoTest').submit();
		 }
	});
    
};

$(document).ready(function(){	
	preSelectCategories();
	$(document).on('click','.cat',function(){
		var catId = $(this).attr('data-id');
		$('.subcat').not('.cat-'+catId).hide();
		$('.cat-'+catId).toggle();		
		var s = $('.cat-'+catId).attr('style');
		if(s=='display: table-row;'){		
			$(this).find("i").attr('class','glyphicon glyphicon-minus-sign');
		}else{
			$(this).find("i").attr('class','glyphicon glyphicon-plus-sign');
		}		
	});
	$(document).on('click','#checkfull',function(){
		if(this.checked){
			$('.chk_box').each(function(){
				this.checked=true;
				document.getElementById("sl").innerHTML=totalsubcat;
			});
		}else{
			$('.chk_box').each(function(){
				this.checked=false;
				document.getElementById("sl").innerHTML=0;
			});
		}
	});
	$(document).on('click','.checkall',function(){
		var chkall=$(this).attr('data-id');
		if(this.checked){
			$('.chk-'+chkall).each(function(){				
				if(this.checked==false){
					sl=sl+1;				
					document.getElementById("sl").innerHTML=sl;
					var SubID = $(this).attr('id');
					var CatID = $('.'+SubID).attr('data-id');
					count=$('#spcat-'+CatID).text();
					if(count==''){
						count=0;
					}else{
						count=parseInt(count);
					}
					count=count+1;
					document.getElementById("spcat-"+CatID).innerHTML=count;
					this.checked=true;
				}								
			});
		}else{
			$('.chk-'+chkall).each(function(){
				if(this.checked==true){					
					sl=sl-1;
					document.getElementById("sl").innerHTML=sl;
					var subid = $(this).attr('data-id');
					var SubID = $(this).attr('id');
					var CatID = $('.'+SubID).attr('data-id');
					count=$('#spcat-'+CatID).text();
					if(count==''){
						count=0;
					}else{
						count=parseInt(count);
					}
					count=count-1;
					if(count==0){
						count='';
					}
					document.getElementById("spcat-"+CatID).innerHTML=count;
					this.checked=false;
				}				
			});
		}
	});
	$(document).on('click','.td-subcat',function(){
		
		var lb_id = $(this).attr('data-id');
		if($('#sub-'+lb_id).is(':checked')==true){
			$('#sub-'+lb_id).each(function(){
				this.checked=false;
				sl=sl-1;
				document.getElementById("sl").innerHTML=sl;
			});
		}else{
			$('#sub-'+lb_id).each(function(){
				this.checked=true;
				sl=sl+1;		
				document.getElementById("sl").innerHTML=sl;
			});

		}
			/*var name=$(this).text();
			var tr="";
			tr+="<tr><td>"+name+"</td></tr>";
			$('#table_modal').html(tr);*/
			
			//Đang làm đoạn này
	});
	
	$(document).on('click','.chksub',function(){
		if($(this).is(':checked')==true){
				sl=sl+1;		
				document.getElementById("sl").innerHTML=sl;
		}else{
				sl=sl-1;
				document.getElementById("sl").innerHTML=sl;
		}
	});
	
	$(document).on('click','.subcat',function(){
		var idsub = $(this).attr('data-sub');
		var id = $(this).attr('data-id');
		var s = $('#spcat-'+id).text();
		if(s==''){
			s=0;
		}else{
			s=parseInt(s);
		}
		if($('#sub-'+idsub).is(':checked')==true){			
			s=s+1;			
		}else{
			s=s-1;
			if(s==0){
				s='';
			}
		}
		document.getElementById('spcat-'+id).innerHTML=s;
	});
});



function showMessage(title, text, type, icon) {
    var notice = new PNotify({
        title: title,
        text: text,
        type: type,
        icon: 'glyphicon ' + icon,
        addclass: 'snotify',
        pnotify_closer: true,
        pnotify_delay: 800
    });
}
</script>

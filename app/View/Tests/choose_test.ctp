<?php echo $this->Html->css('choose_test.css'); ?>
<!--<ol class="breadcrumb">
  <li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'People', 'action' => 'dashboard')); ?></li>
  <li class="active"><?php echo __('Choose Test'); ?></li>
</ol>-->

<div class="chooseTest">
    <h2><?php echo __('Choose test')?> môn <?php echo $this->Name->subjectToName($subject);?></h2>
    <hr />
	<!--<?php echo __('Test').': '.$this->Name->subjectToName($subject); ?>-->
    <form role="form" class="form-horizontal" id="preDoTest" method="POST">
	<input type='hidden' value='<?php echo $user_id; ?>' id='user_id' />
	<br/>
		
		<div class="col-sm-6 col-sm-offset-3">
			<div class="row">
				<div class="col-sm-12" style="padding:0px">
					<div class="nav-tabs-custom" style="margin-bottom: 0px; box-shadow:none;">
						<ul class="nav nav-tabs">
							<li <?php echo($grade_id==1)?"class='active'":""; ?>>
								<a href="#tab1" data-toggle='tab'>Lớp 10</a>
							</li>
							<li <?php echo($grade_id==2)?"class='active'":""; ?>>
								<a href="#tab2" data-toggle='tab'>Lớp 11</a>
							</li>
							<li <?php echo($grade_id==3)?"class='active'":""; ?>>
								<a href="#tab3" data-toggle='tab'>Lớp 12</a>
							</li>
							<li style="float:right">
								<a style='padding-right:0px;'>Số bài bạn đã chọn: <span id="sl"><?php echo $count ?></span></a>
							</li>
						</ul>
					</div>
				</div>				
			</div>

			<div class="row">
				<div class="tab-content col-sm-12" style="padding:0px;">
				<?php for($i=1;$i<=3;$i++): ?>
					<div class="tab-pane <?php echo($i==$grade_id)?"active":""; ?> " id="tab<?php echo $i;?>">
						<table class="table table-condensed" id="grade<?php echo $i;?>" style="border-collapse:collapse;border:0px">							
							<tbody>			
								<tr>
									<td style="padding-left:5px;border-left: solid 1px #ddd; border-top:0px; width:10px;">
										<input type="checkbox" class="checkfull" data-id="<?php echo $i;?>"/>
									</td>
									<td colspan='2' style="border-top:0px;border-right: solid 1px #ddd;">
										<a><?php echo __('Check All'); ?></a>
									</td>
								</tr>
								<?php foreach($allcat as $item=>$ac): ?>
								<?php if($ac['Grade']['id']==$i): ?>
								<tr>
									<td class="td_cat" style="padding-left:5px; width:10px;border: solid 1px #ddd;border-right:0px;">
										<input type="checkbox" class="checkall chkall-<?php echo $i;?>" data-id='<?php echo $ac['Category']['id'] ?>'/>
									</td>
									<td colspan='2' class="cat" data-id='<?php echo $ac['Category']['id'] ?>' style="padding-left:5px;border: solid 1px #ddd;border-left:0px;">&nbsp<a>Chương: <?php echo $ac['Category']['name'];?><i style="float:right;margin-top:2px" class="glyphicon glyphicon-plus-sign"></i><span id='spcat-<?php echo $ac['Category']['id'] ?>' style="float:right; margin-right:10px;" id="sl_incat"></span></a>
									</td>
								</tr>				
								<?php foreach($ac['Subcategory'] as $item=>$asc): ?>
									<tr class="subcat cat-<?php echo $ac['Category']['id'] ?> sub-<?php echo $asc['id'] ?> <?php echo ($ac['Category']['id']==$categories_id ? "pre" : ""); ?>" data-id='<?php echo $ac['Category']['id'] ?>' data-sub='<?php echo $asc['id'] ?>'>
										<td style='border: solid 1px #ddd;border-right:0px;' class="td-subcat" data-id='<?php echo $asc['id'] ?>'>
										</td>
										<td style="width:12px;padding-left:0px;padding-right:0px;">
											<input type="checkbox" name="sub" class='chkbox-<?php echo $i;?> chksub chk-<?php echo $ac['Category']['id'] ?> ' id='sub-<?php echo $asc['id'] ?>' value="<?php echo $asc['id']?>" <?php echo (in_array($asc['id'],$pretracking) ? "checked" : ""); ?> />
										</td>
										<td style='border: solid 1px #ddd;border-left:0px;' class="td-subcat" data-id='<?php echo $asc['id'] ?>'>Bài: <?php echo $asc['name'] ?></td>
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

<div id="msgNotice" class="modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-sm" style="width:400px;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Thông báo</h4>
            </div>
            <div class="modal-body" style='text-align:center'>
                <p id='tb' style='font-size:16px;'>Bạn chưa chọn bài nào.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="modal_message" class="modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Thông báo</h4>
            </div>
            <div class="modal-body" style='text-align:center'>
                <p id='tb' style='font-size:16px;'>Số lượng câu hỏi không đủ để thực hiện bài kiểm tra này.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="rechargecard" class="modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style='margin-top:100px;'>
            <div class="modal-body" style='text-align:center;padding-top: 0px;'>				
				<div class='row'>
					<div class='row' style='margin:0px;padding-left:10px;padding-right:10px;padding-top:15px;'>
					<?php echo $this->Html->image('Xu.png',array('style'=>'width:100px;height:100px;')) ?>						
					<span style='color:#428bca;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:18pt;'>Trời ơi hết xu rồi</span>
					<hr style='margin-top:7px;margin-bottom:5px;'/>
					</div>
					<div  class='row' style='margin:0px;padding:10px;'>	
						<p style='font-size:12pt;'>Đừng lo lắng, bạn hãy chọn 1 trong 2 hình thức dưới để tăng xu ngay nhé.</p>
					</div>
					<div  class='row' style='margin:0px;'>						
						<div class='col-sm-12' style='padding-left:10px;padding-right:10px;'>								
							<div class='col-sm-6' style='padding-left:0px;padding-right:5px;'>
							<a class='btn btn-danger bl fw' href="<?php echo $this->Html->url(array('controller'=> 'rechargecard')); ?>"><span class='glyphicon glyphicon-usd'></span> Nạp thẻ</a>
							</div>
							<div class='col-sm-6' style='padding-left:5px;padding-right:0px;'>
							<a class='btn btn-success bl fw' href="javascript:void(0);" onclick="FBInvite()"><span class='glyphicon glyphicon-send'></span>&nbsp;&nbsp;Invite</a>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
var over=<?php echo $over ?>;
var coin= <?php echo $coin ?>;
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
	var n=0;
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
	var data = $str.split(",");
	console.log(data);
	for(i=0;i<data.length;i++){
		if(data[i]!=''){
			n=data[i];
		}
	}
	if(coin!=0){
		if(n!=0){
			$('#categories').val($str);	
			var url = '<?php echo Router::url(array('controller'=>'tests','action'=>'byQuestion'));?>/' + t + '/'+$str;
			$.getJSON(url, function( data ) {
				 if(data<t){			
					$('#modal_message').modal({
							backdrop: true
					});
				 }else{
					var id = $('#user_id').attr('value');
					mixpanel.track("Do Test", {
						"test_time": t,
						"user_id":id,
					});
					$("#preDoTest").attr("action", "/Tests/doTest/" + t + "/" + $subject + "/");
					$('#preDoTest').submit();
				 }
			});
		}else{
			$('#msgNotice').modal({
					backdrop: true
				});
		}
	}else{
		$('#rechargecard').modal({
				backdrop: true
			});	
	}
};

$(document).ready(function(){	
	$('.pre').css('display', 'table-row');
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
	$(document).on('click','.checkfull',function(){
		$id = $(this).attr('data-id');	
		if(this.checked){
			$('.chkall-'+$id).each(function(){
				this.checked=false;
				this.click();
			});
		}else{
			$('.chkall-'+$id).each(function(){
				this.checked=true;
				this.click();
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

function FBInvite(){
		FB.ui({
			method: 'apprequests',
			title: 'Mời bạn bè tham gia PLS',
			message: 'Mời bạn bè tham gia PLS',
			new_style_message: true
		},function(response){
			$.ajax({
				type: 'POST',
				url: '<?php echo $this->Html->url(
							array(
								'controller' => 'People', 
								'action' => 'invite'
							)
						); ?>',
				data: {'frs': response.to},
				success: function(){
					//No handler
				}
			});
		});
	}
</script>

</script>

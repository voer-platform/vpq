<div class='admin-insert-questions'>
	<!-- left nav -->
	<?php echo $this->element('admin-left-nav'); ?>

	<!-- right nav -->
	<div class='col-lg-10'>
		<!-- visible form -->
		<div class='row'>
			<h2>Import questions to excel</h2>
			<hr/>
		</div>
		<div class='row'>
			<form action="" method="POST" name="frmimportexcel" role="form"  enctype="multipart/form-data" class="form-horizontal">
				<div class='col-lg-6'>
					<div class='row'>
						<input type='file' name='file_import' class='form-control'/>
					</div>
					<br/>
					<div class='row'>
						<input type='submit' name='import_excel' value='Import Excel' class='btn btn-primary'/>
					</div>
				</div>
			</form>
		</div>
	</div>	
</div>
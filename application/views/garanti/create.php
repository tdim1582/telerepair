<?php $garanti_uri_id	=	$this->uri->segment(3); ?>
<h1 class="page-header">
	Garanti
</h1>

<div class="row">
<div class="col-md-7">
<div class="table-responsive">
<?= form_open('garanti/create/'.$garanti_uri_id)?>

<table class="table table-striped">
  <tbody>
  	<tr>
  		<td style="padding-top: 15px" width="200px">Name</td>
  		<td>
		  <?php
		  	if($GarantiDataAll){
				$name_value	=	$GarantiDataAll[0]['name'];
			}else{
				$name_value	=	set_value('name');
			}
		   ?>
		  <input type="text" name="name" class="form-control" value="<?=$name_value;?>" />
		  <span class="error"><?php echo form_error('name'); ?></span>
		</td>
		  
  	</tr>
  
  	<tr>
  		<td style="padding-top: 15px" width="200px">garanti Text</td>
  		<td>
		  <?php
		  	if($GarantiDataAll){
				$garanti_text	=	$GarantiDataAll[0]['text'];
			}else{
				$garanti_text	=	set_value('garanti_text');
			}
		   ?>
		  <textarea class="form-control" name="garanti_text" rows="6"><?=$garanti_text;?></textarea>
		  
		</td>
  	</tr>
  	<tr>
  		<td style="padding-top: 15px" width="200px"></td>
  		<td><input type="submit" class="btn btn-success" name="create" value="Garanti" /></td>
  	</tr>
  </tbody>
</table>
<?=form_close();?>
</div>
</div>

</div>

<style>
.error{
	color: red;
}
</style>


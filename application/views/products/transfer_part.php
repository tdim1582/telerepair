
<div class="row">
	<div class="col-md-12">
		<form action="" method="post" id="getAmount">
		<h1 style="margin-top: 0px; margin-bottom: 20px; font-size: 16px">Vælg hvilken butik du vil overføre <?=strtolower($parts[0]->name);?> fra og til</h1>
		
		<label style="float: left; padding-top: 6px; padding-right: 10px">Overfør fra:</label>
		
		<select class="form-control fromTransfer" name="from" style="width: 150px; float: left">
			<option value="">-</option>
			<?php
			foreach($boutique_info as $boutique):
			?>
			<option value="<?=$boutique->id;?>"><?=$boutique->name;?></option>
			<?php
			endforeach;
			?>
		</select>
		
		<label style="float: left; padding-top: 6px; padding-right: 10px; padding-left: 10px">Til</label>
		
		<select class="form-control toTransfer" name="to" style="width: 150px; float: left; margin-right: 10px">
			<option value="">-</option>
			<?php
			foreach($boutique_info as $boutique):
			?>
			<option value="<?=$boutique->id;?>"><?=$boutique->name;?></option>
			<?php
			endforeach;
			?>
		</select>
		
		<input type="hidden" class="hiddenProductId" value="<?=$this->uri->segment(3);?>" />
		<input type="hidden" class="hiddenUniqueString" value="<?=$this->input->post('id');?>" />
		
		<input type="submit" class="btn btn-default" style=" width: 120px; padding-left: 10px float: left" value="Vælg antal" />
		</form>
		
		<center class="pleasewait_wrap" style="display: none">
			<img src="<?=base_url();?>/assets/images/loader.gif" style="margin-top: 15px; margin-bottom: 15px" /><br />
			Vent venligst...
		</center>
		
		<div class="transferAmountContent"></div>
		
	</div>
</div>

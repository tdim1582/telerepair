<?=form_open(current_url());?>
<div class="row">
	
	<div class="col-md-12">
		<hr />
	</div>
	
	<?php
	if($inventory == 0):
	?>
	<div class="col-md-12">
		<div class="alert alert-danger">Ingen reservedele på lager fra valgt butik. Vælg en anden</div>
	</div>
	<?php
	elseif($this->input->post('to') == false):
	?>
	<div class="col-md-12">
		<div class="alert alert-danger">Vælg en butik du vil overføre til</div>
	</div>
	<?php
	elseif($this->input->post('from') == false):
	?>
	<div class="col-md-12">
		<div class="alert alert-danger">Vælg en butik du vil overføre fra</div>
	</div>
	<?php
	elseif($this->input->post('to') == $this->input->post('from')):
	?>
	<div class="col-md-12">
		<div class="alert alert-danger">Du kan ikke overføre til samme butik</div>
	</div>
	<?php
	else:
	?>
	
	<div class="col-md-6">
		<label>Vælg antal du vil rykke</label>
		<select class="form-control" name="amount">
			<?php
			for ($x = 1; $x <= $inventory; $x++) {
			?>
			<option><?=$x;?></option>
			<?php
			}
			?>
		</select>
		
		<br />
		
		<input type="hidden" value="<?=$this->input->post('from');?>" name="from" />
		<input type="hidden" value="<?=$this->input->post('to');?>" name="to" />
		<input type="hidden" value="<?=$this->input->post('id');?>" name="unique_string" />
		<input type="hidden" value="<?=$this->uri->segment(3);?>" name="product_id" />
		
		<input type="submit" class="btn btn-success" name="move_inventory" value="Opdater" />
	</div>
	<?php
	endif;
	?>
</div>
</form>
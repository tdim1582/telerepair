<h1 class="page-header">
	Overfør enhed

</h1>

<div class="row">
	<div class="col-md-6">
		
		<?php
		if($this->session->flashdata('success')){
		?>
		<div class="alert alert-success"><?=$this->session->flashdata('success');?></div>
		<?php
		}
		?>
		
		<?=form_open();?>
		
		<label>ID</label><br />
		<input type="text" name="id" required="true" class="form-control" />
		
		<br />
		
		<label>Overfør til</label><br />
		<select class="form-control" name="boutique" required="true">
			<option value="">Vælg</option>
			<?php
			foreach($boutiques as $boutique):
			?>
			<option value="<?=$boutique->id;?>"><?=$boutique->name;?></option>
			<?php
			endforeach;
			?>
			<option value="fraud">Svind lager</option>
			<option value="defect">Defekt lager</option>
		</select>
		
		<br />
		
		<input type="submit" class="btn btn-success" name="submit" value="Overfør" />
		
		<?=form_close();?>
	</div>
</div>
<h1 class="page-header">
	Eksport
</h1>

<div class="row">
	<div class="col-md-6">
		
		<?=form_open(current_url());?>
		
		<label>Vælg butik</label>
		
		<select class="form-control" name="boutique">
      	<?php
      	$boutiques_access = explode(",",$me[0]->boutiques);
      	
      	foreach($boutiques_access as $boutique_info){
      		$this->db->where('id',$boutique_info);
      		$this->db->where('active',1);
      		$this->db->order_by('name','asc');
      		$single_boutique = $this->db->get('boutiques')->result();
          	if($single_boutique){
          		if($single_boutique[0]->id == $this->session->userdata('active_boutique')){
	          		$selected = 'selected="true"';
          		}else{
	          		$selected = '';
          		}
          		echo '<option value="'.$single_boutique[0]->id.'" '.$selected.'>'.$single_boutique[0]->name.'</option>';
          	}
      	}
      	?>
      </select>
		
		<br />
		
		<label>Vælg type</label>
		
		<select class="form-control" name="type">
			<option value="csv_phones">Telefoner</option>
			<option value="csv_access_export">Tilbehør</option>
		</select>
		
		<br />
		
		<label>Interval</label>
		
		<div class="row">
			<div class="col-md-5">
			<input type="date" name="from" value="<?=date("Y-m-d",strtotime("-4 weeks"));?>" class="form-control" />
			</div>
			<div class="col-md-5">
			<input type="date" name="to" value="<?=date("Y-m-d");?>" class="form-control" />
			</div>
		</div>
		
		<br />
		
		<label>Type</label>
		
		<div class="checkbox">
		  <label>
		    <input type="radio" name="type_choose" value="all" style="margin-left: -20px" checked="true"> Alle (salg og køb)
		  </label>
		</div>
		
		<div class="checkbox">
		  <label>
		    <input type="radio" name="type_choose" value="sale" style="margin-left: -20px"> Kun salg
		  </label>
		</div>
		
		<div class="checkbox">
		  <label>
		    <input type="radio" name="type_choose" value="buy" style="margin-left: -20px"> Kun køb
		  </label>
		</div>
		
		<div class="checkbox">
		  <label>
		    <input type="radio" name="type_choose" value="phones_on_inventory" style="margin-left: -20px"> Telefoner på lager
		  </label>
		</div>
		
		<?php
		if (strpos($rank_permissions,'all') !== false) {
		?>
		<div class="checkbox">
		  <label>
		    <input type="radio" name="type_choose" value="fraud" style="margin-left: -20px"> Svind lager
		  </label>
		</div>
		
		<div class="checkbox">
		  <label>
		    <input type="radio" name="type_choose" value="defect" style="margin-left: -20px"> Defekt lager
		  </label>
		</div>
		<?php
		}
		?>
		<div class="clearfix"></div>
		
		<input type="submit" class="btn btn-success" name="submit" value="Eksporter" style="margin-top: 10px" />
		
		</form>
		
	</div>
</div>
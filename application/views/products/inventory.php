<div class="modal fade" id="create_part">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Opret reservedel</h4>
      </div>
      <div class="modal-body">
      	
      	<?=form_open(current_url());?>
      	
      	<input type="text" class="form-control" name="name" style="margin-bottom: 10px" placeholder="Navn" value="" />
      	<input type="text" class="form-control" name="price" style="margin-bottom: 10px" placeholder="Indkøbspris" value="" />
      	
      	<div class="checkbox">
		<label>
		  <input type="checkbox" name="part_of_inventory" value="1" checked="true"> En del af lagerstyring?
		</label>
		</div>
      	
		<input type="hidden" value="<?=$this->uri->segment(4);?>" name="part_id" />
		<input type="submit" class="btn btn-success" name="add_part" value="Gem" />
        <?php
        echo form_close();
        ?>
      	
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="edit_part">
  <div class="modal-dialog" style="width: 900px">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Rediger reservedel</h4>
      </div>
      <div class="modal-body">
      	
      	
      	
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<div class="modal fade" id="transfer_part">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Overfør reservedel</h4>
      </div>
      <div class="modal-body">
      	
      	
      	
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="create_broke">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Opret defekt</h4>
      </div>
      <div class="modal-body">
      	
      	<?=form_open(current_url());?>
      	
      	<label>Vælg defekt</label>
      	<select class="form-control checkIfNewAccess" required="true" name="access" required style="margin-bottom: 10px">
        	<option value="">-</option>
        	<?php
        	foreach($access as $access):
        	?>
        	<option value="<?=$access->id;?>"><?=$access->name;?></option>
        	<?php
        	endforeach;
			?>
        </select>
        
        <label>Vælg butik</label>
        <select class="form-control checkIfNewAccess" required="true" name="boutique" required style="margin-bottom: 10px">
        	<option value="">-</option>
        	<?php
        	foreach($boutiques as $boutique):
        	?>
        	<option value="<?=$boutique->id;?>"><?=$boutique->name;?></option>
        	<?php
        	endforeach;
			?>
        </select>
        
      	<textarea class="form-control" rows="5" name="description" required="true"></textarea>
      	
		<input type="hidden" value="<?=$this->uri->segment(3);?>" name="part_id" />
		<input type="submit" class="btn btn-success" name="add_defect" value="Gem" style="margin-top: 10px" />
        <?php
        echo form_close();
        ?>
      	
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<h1 class="page-header">
	Lagerstyring
</h1>

<div class="clearfix"></div>

<div class="table-responsive">

<ul class="nav nav-tabs">
	<li class="<?php if($this->uri->segment(3) == 'devices'): echo 'active'; endif; ?>"><a href="<?=site_url('products/inventory/devices');?>" >Enheder</a></li>
	<li class="<?php if($this->uri->segment(3) == 'parts'): echo 'active'; endif; ?>"><a href="<?=site_url('products/inventory/parts');?>">Reservedele</a></li>
</ul>
<div class="tab-content" style="margin-top: 15px;">
	<div class="tab-pane fade <?php if($this->uri->segment(3) == 'devices'): echo 'active in'; endif; ?>" id="default-tab-1">
		<ul class="nav nav-pills" style="margin-bottom: 15px">
			<?php
			foreach($products as $product):
			?>
			<li class="<?php if($product->id == $this->uri->segment(4)): echo 'active'; endif; ?>"><a href="<?=site_url('products/inventory/'.$this->uri->segment(3).'/'.$product->id);?>"><?=$product->name;?></a></li>
			<?php
			endforeach;
			?>
		</ul>
		
		<?php
		$color_array = array();
		foreach($colors as $color){
			$color_array[] = $color->name.'|'.$color->id;
		}
		
		
		$gb_array = array();
		foreach($gbs as $gb){
			$gb_array[] = $gb->name.'|'.$gb->id;
		}
		
		$condition_array = array();
		foreach($conditions as $condition){
			$condition_array[] = $this->global_model->convert_condition_to_name($condition->name).'|'.$condition->id;
		}
						
		//$data[]=$color_array;
		$data[]=$gb_array;
		//$data[]=$condition_array;
		
		$combos=possible_combos($data);
		
		//calculate all the possible comobos creatable from a given choices array
		function possible_combos($groups, $prefix='') {
		    $result = array();
		    $group = array_shift($groups);
		    foreach($group as $selected) {
		        if($groups) {
		            $result = array_merge($result, possible_combos($groups, $prefix . $selected. '_'));
		        } else {
		            $result[] = $prefix . $selected;
		        }
		    }
		    return $result;
		}
		?>
		
		<h1>Enheder</h1>
		
		<table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Butik</th>
                    <?php
                    foreach($combos as $combo){
            	
			    	$explode = explode("_",$combo);
			    	
			    	//////////////
			    	
			    	$gb_id_explode = explode("|",$explode[0]);
			    	
			    	if(isset($gb_id_explode[1])){
			        	$gb_id = $gb_id_explode[1];
			        	$gb = $gb_id_explode[0];
			    	}else{
			        	$gb_id = 0;
			        	$gb = $gb_id_explode[0];
			    	}
			    	
			    	echo '<th>'.$gb.'GB</th>';
			    	
			    	}
			    	?>
                </tr>
            </thead>
            <tbody>
            	<?php
            	$eight_gb_total = 0;
            	$sixteen_gb_total = 0;
            	$thirdytwo_gb_total = 0;
            	$sixfour_gb_total = 0;
            	$hundeight_gb_total = 0;
            	
            	$this->db->where('active',1);
            	$boutique_info = $this->db->get('boutiques')->result();
            	
            	foreach($boutique_info as $boutique):


            	// check inventory number
            	//$inventory_number = $this->inventory_model->get_number($gb,$this->uri->segment(4));
				            	
            	?>
				<tr class="odd gradeX" style="font-size: 14px; <?php if($this->session->userdata('active_boutique') == $boutique->id): echo 'background: #f5efd9;'; endif; ?>">
                    <td width="20%"><?=$boutique->name;?></td>
                    
                    <?php
                    foreach($combos as $combo){
            	
			    	$explode = explode("_",$combo);
			    	
			    	//////////////
			    	
			    	$gb_id_explode = explode("|",$explode[0]);
			    	
			    	if(isset($gb_id_explode[1])){
			        	$gb_id = $gb_id_explode[1];
			        	$gb = $gb_id_explode[0];
			    	}else{
			        	$gb_id = 0;
			        	$gb = $gb_id_explode[0];
			    	}
			    	
			    	$this->db->where('boutique_id',$boutique->id);
			    	$this->db->where('gb',$gb);
			    	$this->db->where('product_id',$this->uri->segment(4));
			    	$this->db->where('sold',0);
			    	$this->db->where('fraud',0);
			    	$this->db->where('defect',0);
			    	$this->db->where('type','bought');
			    	$inventory_number = $this->db->get('orders')->num_rows();
			    	
			    	if($gb == 8){
			    		$eight_gb_total += $inventory_number;
			    	}elseif($gb == 16){
			    		$sixteen_gb_total += $inventory_number;
			    	}elseif($gb == 32){
			    		$thirdytwo_gb_total += $inventory_number;
			    	}elseif($gb == 64){
			    		$sixfour_gb_total += $inventory_number;
			    	}elseif($gb == 128){
			    		$hundeight_gb_total += $inventory_number;
			    	}
			    	
			    	//$inventory_number = $this->inventory_model->get_number($gb,$this->uri->segment(4),$boutique->id);
			    	?>
                    <td width="10%"><?=$inventory_number;?></td>
                    <?php
                    }
                    ?>
                </tr>
                <?php
                endforeach;
                ?>
                
                <tr class="odd gradeX" style="font-size: 14px;">
                    <td width="20%"><b>Total</b></td>
                    <?php
                    foreach($combos as $combo){
                    
                    $explode = explode("_",$combo);
			    	
			    	//////////////
			    	
			    	$gb_id_explode = explode("|",$explode[0]);
			    	
			    	if(isset($gb_id_explode[1])){
			        	$gb_id = $gb_id_explode[1];
			        	$gb = $gb_id_explode[0];
			    	}else{
			        	$gb_id = 0;
			        	$gb = $gb_id_explode[0];
			    	}
			    	
			    	if($gb == 8){
			    		$total_inventory = $eight_gb_total;
			    	}elseif($gb == 16){
			    		$total_inventory = $sixteen_gb_total;
			    	}elseif($gb == 32){
			    		$total_inventory = $thirdytwo_gb_total;
			    	}elseif($gb == 64){
			    		$total_inventory = $sixfour_gb_total;
			    	}elseif($gb == 128){
			    		$total_inventory = $hundeight_gb_total;
			    	}
                    
                    ?>
                    <td width="10%"><?=$total_inventory;?></td>
                    <?php
                    }
                    ?>
                </tr>
            </tbody>
        </table>
        
        <?php
        if (strpos($rank_permissions,'all') !== false) {
        ?>
        
        <h1>Svind</h1>
		
		<table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Butik</th>
                    <?php
                    foreach($combos as $combo){
            	
			    	$explode = explode("_",$combo);
			    	
			    	//////////////
			    	
			    	$gb_id_explode = explode("|",$explode[0]);
			    	
			    	if(isset($gb_id_explode[1])){
			        	$gb_id = $gb_id_explode[1];
			        	$gb = $gb_id_explode[0];
			    	}else{
			        	$gb_id = 0;
			        	$gb = $gb_id_explode[0];
			    	}
			    	
			    	echo '<th>'.$gb.'GB</th>';
			    	
			    	}
			    	?>
                </tr>
            </thead>
            <tbody>
            	<?php
            	$eight_gb_total = 0;
            	$sixteen_gb_total = 0;
            	$thirdytwo_gb_total = 0;
            	$sixfour_gb_total = 0;
            	$hundeight_gb_total = 0;
            	
            	$this->db->where('active',1);
            	$boutique_info = $this->db->get('boutiques')->result();
            	
            	foreach($boutique_info as $boutique):


            	// check inventory number
            	//$inventory_number = $this->inventory_model->get_number($gb,$this->uri->segment(4));
				            	
            	?>
				<tr class="odd gradeX" style="font-size: 14px; <?php if($this->session->userdata('active_boutique') == $boutique->id): echo 'background: #f5efd9;'; endif; ?>">
                    <td width="20%"><?=$boutique->name;?></td>
                    
                    <?php
                    foreach($combos as $combo){
            	
			    	$explode = explode("_",$combo);
			    	
			    	//////////////
			    	
			    	$gb_id_explode = explode("|",$explode[0]);
			    	
			    	if(isset($gb_id_explode[1])){
			        	$gb_id = $gb_id_explode[1];
			        	$gb = $gb_id_explode[0];
			    	}else{
			        	$gb_id = 0;
			        	$gb = $gb_id_explode[0];
			    	}
			    	
			    	$this->db->where('boutique_id',$boutique->id);
			    	$this->db->where('gb',$gb);
			    	$this->db->where('product_id',$this->uri->segment(4));
			    	$this->db->where('sold',0);
			    	$this->db->where('fraud',1);
			    	$this->db->where('type','bought');
			    	$inventory_number = $this->db->get('orders')->num_rows();
			    	
			    	if($gb == 8){
			    		$eight_gb_total += $inventory_number;
			    	}elseif($gb == 16){
			    		$sixteen_gb_total += $inventory_number;
			    	}elseif($gb == 32){
			    		$thirdytwo_gb_total += $inventory_number;
			    	}elseif($gb == 64){
			    		$sixfour_gb_total += $inventory_number;
			    	}elseif($gb == 128){
			    		$hundeight_gb_total += $inventory_number;
			    	}
			    	
			    	//$inventory_number = $this->inventory_model->get_number($gb,$this->uri->segment(4),$boutique->id);
			    	?>
                    <td width="10%" style="cursor: pointer;" onclick="javascript: top.location.href = '<?=site_url('products/inventory/devices/'.$this->uri->segment(4).'/fraud/'.$boutique->id.'/'.$gb);?>';"><?=$inventory_number;?></td>
                    <?php
                    }
                    ?>
                </tr>
                <?php
                endforeach;
                ?>
                
                <tr class="odd gradeX" style="font-size: 14px;">
                    <td width="20%"><b>Total</b></td>
                    <?php
                    foreach($combos as $combo){
                    
                    $explode = explode("_",$combo);
			    	
			    	//////////////
			    	
			    	$gb_id_explode = explode("|",$explode[0]);
			    	
			    	if(isset($gb_id_explode[1])){
			        	$gb_id = $gb_id_explode[1];
			        	$gb = $gb_id_explode[0];
			    	}else{
			        	$gb_id = 0;
			        	$gb = $gb_id_explode[0];
			    	}
			    	
			    	if($gb == 8){
			    		$total_inventory = $eight_gb_total;
			    	}elseif($gb == 16){
			    		$total_inventory = $sixteen_gb_total;
			    	}elseif($gb == 32){
			    		$total_inventory = $thirdytwo_gb_total;
			    	}elseif($gb == 64){
			    		$total_inventory = $sixfour_gb_total;
			    	}elseif($gb == 128){
			    		$total_inventory = $hundeight_gb_total;
			    	}
                    
                    ?>
                    <td width="10%"><?=$total_inventory;?></td>
                    <?php
                    }
                    ?>
                </tr>
            </tbody>
        </table>
        
        
        <h1>Defekt</h1>
		
		<table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Butik</th>
                    <?php
                    foreach($combos as $combo){
            	
			    	$explode = explode("_",$combo);
			    	
			    	//////////////
			    	
			    	$gb_id_explode = explode("|",$explode[0]);
			    	
			    	if(isset($gb_id_explode[1])){
			        	$gb_id = $gb_id_explode[1];
			        	$gb = $gb_id_explode[0];
			    	}else{
			        	$gb_id = 0;
			        	$gb = $gb_id_explode[0];
			    	}
			    	
			    	echo '<th>'.$gb.'GB</th>';
			    	
			    	}
			    	?>
                </tr>
            </thead>
            <tbody>
            	<?php
            	$eight_gb_total = 0;
            	$sixteen_gb_total = 0;
            	$thirdytwo_gb_total = 0;
            	$sixfour_gb_total = 0;
            	$hundeight_gb_total = 0;
            	
            	$this->db->where('active',1);
            	$boutique_info = $this->db->get('boutiques')->result();
            	
            	foreach($boutique_info as $boutique):


            	// check inventory number
            	//$inventory_number = $this->inventory_model->get_number($gb,$this->uri->segment(4));
				            	
            	?>
				<tr class="odd gradeX" style="font-size: 14px; <?php if($this->session->userdata('active_boutique') == $boutique->id): echo 'background: #f5efd9;'; endif; ?>">
                    <td width="20%"><?=$boutique->name;?></td>
                    
                    <?php
                    foreach($combos as $combo){
            	
			    	$explode = explode("_",$combo);
			    	
			    	//////////////
			    	
			    	$gb_id_explode = explode("|",$explode[0]);
			    	
			    	if(isset($gb_id_explode[1])){
			        	$gb_id = $gb_id_explode[1];
			        	$gb = $gb_id_explode[0];
			    	}else{
			        	$gb_id = 0;
			        	$gb = $gb_id_explode[0];
			    	}
			    	
			    	$this->db->where('boutique_id',$boutique->id);
			    	$this->db->where('gb',$gb);
			    	$this->db->where('product_id',$this->uri->segment(4));
			    	$this->db->where('sold',0);
			    	$this->db->where('defect',1);
			    	$this->db->where('type','bought');
			    	$inventory_number = $this->db->get('orders')->num_rows();
			    	
			    	if($gb == 8){
			    		$eight_gb_total += $inventory_number;
			    	}elseif($gb == 16){
			    		$sixteen_gb_total += $inventory_number;
			    	}elseif($gb == 32){
			    		$thirdytwo_gb_total += $inventory_number;
			    	}elseif($gb == 64){
			    		$sixfour_gb_total += $inventory_number;
			    	}elseif($gb == 128){
			    		$hundeight_gb_total += $inventory_number;
			    	}
			    	
			    	//$inventory_number = $this->inventory_model->get_number($gb,$this->uri->segment(4),$boutique->id);
			    	?>
                    <td width="10%"><?=$inventory_number;?></td>
                    <?php
                    }
                    ?>
                </tr>
                <?php
                endforeach;
                ?>
                
                <tr class="odd gradeX" style="font-size: 14px;">
                    <td width="20%"><b>Total</b></td>
                    <?php
                    foreach($combos as $combo){
                    
                    $explode = explode("_",$combo);
			    	
			    	//////////////
			    	
			    	$gb_id_explode = explode("|",$explode[0]);
			    	
			    	if(isset($gb_id_explode[1])){
			        	$gb_id = $gb_id_explode[1];
			        	$gb = $gb_id_explode[0];
			    	}else{
			        	$gb_id = 0;
			        	$gb = $gb_id_explode[0];
			    	}
			    	
			    	if($gb == 8){
			    		$total_inventory = $eight_gb_total;
			    	}elseif($gb == 16){
			    		$total_inventory = $sixteen_gb_total;
			    	}elseif($gb == 32){
			    		$total_inventory = $thirdytwo_gb_total;
			    	}elseif($gb == 64){
			    		$total_inventory = $sixfour_gb_total;
			    	}elseif($gb == 128){
			    		$total_inventory = $hundeight_gb_total;
			    	}
                    
                    ?>
                    <td width="10%"><?=$total_inventory;?></td>
                    <?php
                    }
                    ?>
                </tr>
            </tbody>
        </table>
		
		<?php
		}
		?>
		
	</div>
	<div class="tab-pane fade <?php if($this->uri->segment(3) == 'parts'): echo 'active in'; endif; ?>" id="default-tab-2">
		<ul class="nav nav-pills" style="margin-bottom: 15px">
			<?php
			foreach($products as $product):
			?>
			<li class="<?php if($product->id == $this->uri->segment(4)): echo 'active'; endif; ?>"><a href="<?=site_url('products/inventory/'.$this->uri->segment(3).'/'.$product->id);?>"><?=$product->name;?></a></li>
			<?php
			endforeach;
			?>
		</ul>
		
		
		<h1>
			Reservedele <a href="<?=site_url('products/inventory/parts/'.$this->uri->segment(4).'?poi=1');?>" style="font-size: 12px; <?php if($this->input->get('poi') == 1 || $this->input->get('poi') == 0): echo 'text-decoration: underline'; endif; ?>">Lagerstyring</a> <span style="font-size: 12px">-</span> <a href="<?=site_url('products/inventory/parts/'.$this->uri->segment(4).'?poi=2');?>" style="font-size: 12px; <?php if($this->input->get('poi') == 2): echo 'text-decoration: underline'; endif; ?>">Ikke lagerstyring</a>
			<div class="pull-right">
				<?php
	            if (strpos($rank_permissions,'all') !== false) {
				?>
			        <?php if (!$this->uri->segment(4)): ?>
						<a href="#" class="btn btn-default" onclick="alert('Vælg først en enhed!');" >Opret reservedel</a>
				
					<?php else: ?>
						<a href="#" class="btn btn-default" data-toggle="modal" data-target="#create_part">Opret reservedel</a>
					<?php endif; ?>
				<?php
				}
				if (strpos($rank_permissions,'all') !== false || strpos($rank_permissions,'create_defect') !== false) {
				?>
				<a href="#" class="btn btn-danger" data-toggle="modal" data-target="#create_broke">Opret defekt</a>
				<?php
				}
				?>
			</div>
		</h1>
		
		<table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Navn</th>
                    <?php
                    foreach($boutique_info as $boutique):
                    ?>
                    <th><?=$boutique->name;?> <a href="<?=site_url('export/part_list/'.$boutique->id.'/'.$this->uri->segment(4));?>" style="color: #2e2e2e; font-size: 12px; padding-left: 5px"><i class="fa fa-print"></i></a></th>
                    <?php
                    endforeach;
                    ?>
                    <th>Pris</th>
                    <?php
                    if (strpos($rank_permissions,'all') !== false) {
					?> 
                    <th></th>
                    <?php
                    }
                    ?>
                </tr>
            </thead>
            <tbody style="font-size: 12px" id="parts_sortable">
            	<?php
            	// count intervals
            	$this->db->where('product_id',$this->uri->segment(4));
            	$this->db->where('hide',0);
				$this->db->where('boutique_id',$this->session->userdata('active_boutique'));
            	
            	if($this->input->get('poi') == 2){
	            	$this->db->where('part_of_inventory',0);
            	}else{
	            	$this->db->where('part_of_inventory',1);
            	}
				$this->db->group_by('unqiue_string');
                $this->db->order_by('part_order','asc');
				$parts = $this->db->get('parts')->result();
            	foreach($parts as $part):
            	            	
            	?>
		<tr class="odd gradeX" style="font-size: 20px" id="item-<?php echo $part->id;?>">
                    <td width="25%" style="font-size: 14px"><?=$part->name;?></td>
                    <?php
                    foreach($boutique_info as $boutique):
                    
                    // get inventory to single boutique
                    $this->db->where('unqiue_string',$part->unqiue_string);
	            	$this->db->where('boutique_id',$boutique->id);
					$parts_boutique = $this->db->get('parts')->result();
                    
                    if($parts_boutique){
	                    $inventory = $parts_boutique[0]->inventory;
	                    $boutique_part_id = $parts_boutique[0]->id;
	                    
	                    
	                    // count defect parts and minus
	                    $this->db->where('part_id',$part->id);
	                    $this->db->where('boutique_id',$boutique->id);
	                    $defects = $this->db->get('defects')->num_rows();
	                    	                    
	                    $inventory = $inventory-$defects;
	                    
                    }else{
	                    $inventory = 0;
	                    $boutique_part_id = 0;
                    }
                    
                    ?>
                    <td width="120px" style="font-size: 14px; <?php if($this->session->userdata('active_boutique') == $boutique->id): echo 'background: #f5efd9;'; endif; ?>">
                    	<?php
                    	if($this->session->userdata('uid') == 1){
                    	?>
                    	<form action="<?=site_url('products/update_inventory/'.$boutique_part_id.'/'.$this->uri->segment(4));?>" method="post">
                    	<input type="text" class="form-control" name="inventory" value="<?=$inventory;?>" />
                    	</form>
                    	<?php
                    	}else{
                    	?>
                    	<?=$inventory;?>
                    	<?php
                    	}
                    	?>
                    </td>
                    <?php
                    endforeach;
                    ?>
                    <td width="10%" style="font-size: 14px"><?=number_format($part->price,0,',','.');?> kr</td>
                    <?php
                    if (strpos($rank_permissions,'all') !== false) {
					?> 
                    <td width="10px"><a href="#" class="btn btn-xs btn-default" data-toggle="modal" data-target="#edit_part" data-device="<?=$this->uri->segment(4);?>" data-id="<?=$part->unqiue_string;?>" style="width: 100%">Rediger</a>
                    <?php
                    }
                    
                    if (strpos($rank_permissions,'all') !== false || strpos($rank_permissions,'transfer_inventory') !== false) {
					?> 
                    <td width="10px"><a href="#" class="btn btn-xs btn-default" data-toggle="modal" data-target="#transfer_part" data-device="<?=$this->uri->segment(4);?>" data-id="<?=$part->unqiue_string;?>" style="width: 100%">Overfør</a></td>
                    <?php
                    }
                    ?>
                </tr>
                <?php
                endforeach;
                ?>
            </tbody>
            
            <?php
            /*if($this->uri->segment(4)){
            ?>
            <tbody>
            	<tr>
            		<td colspan="20"><h4>Tilføj reservedel</h4></td>
            	</tr>
            	</tr>
            	<?=form_open(current_url());?>
				<tr class="odd gradeX" style="font-size: 20px">
                    <td><input type="text" class="form-control" name="name" placeholder="Navn" value="" /></td>
                    <?php
                    foreach($boutique_info as $boutique):
                    ?>
                    <td></td>
                    <?php
                    endforeach;
                    ?>
                    <td><input type="text" class="form-control" name="price" placeholder="Pris" value="" /></td>
                    <td>
                    	<input type="hidden" value="<?=$this->uri->segment(3);?>" name="part_id" />
                    	<input type="submit" class="btn btn-success" name="add_part" value="Opdater" />
                    </td>
                </tr>
                <?php
                echo form_close();
                ?>
            </tbody>
            <?php
            }*/
            ?>
                        
        </table>
        
        
        
        <h1>
			Defekter
		</h1>
		
		<table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Navn</th>
                    <?php
                    foreach($boutique_info as $boutique):
                    ?>
                    <th><?=$boutique->name;?></th>
                    <?php
                    endforeach;
                    ?>
                </tr>
            </thead>
            <tbody style="font-size: 12px">
            	<?php
            	// count intervals
            	$this->db->where('product_id',$this->uri->segment(4));
            	$this->db->where('hide',0);
            	$this->db->group_by('unqiue_string');
            	if($this->input->get('poi') == 2){
	            	$this->db->where('part_of_inventory',0);
            	}else{
	            	$this->db->where('part_of_inventory',1);
            	}
				$parts = $this->db->get('parts')->result();
            	foreach($parts as $part):
            	            	
            	?>
            	<?=form_open(current_url());?>
				<tr class="odd gradeX" style="font-size: 20px;">
                    <td width="25%" style="font-size: 14px"><?=$part->name;?></td>
                    <?php
                    foreach($boutique_info as $boutique):
                    
                    // get inventory to single boutique
                    $this->db->where('part_id',$part->id);
                    $this->db->where('boutique_id',$boutique->id);
					$parts_boutique = $this->db->get('defects')->num_rows();
                    
                    $inventory = $parts_boutique;
                    
                    ?>
                    <td width="120px" onclick="javascript: top.location.href = '<?=site_url('products/inventory/parts/'.$this->uri->segment(4).'/defects/'.$boutique->id.'/'.$part->id);?>';" style="font-size: 14px; cursor: pointer; <?php if($this->session->userdata('active_boutique') == $boutique->id): echo 'background: #f5efd9;'; endif; ?>">
                    	<?=$inventory;?>
                    </td>
                    <?php
                    endforeach;
                    ?>

                </tr>
                <?php
                echo form_close();
                endforeach;
                ?>
            </tbody>
            
            <?php
            /*if($this->uri->segment(4)){
            ?>
            <tbody>
            	<tr>
            		<td colspan="20"><h4>Tilføj reservedel</h4></td>
            	</tr>
            	</tr>
            	<?=form_open(current_url());?>
				<tr class="odd gradeX" style="font-size: 20px">
                    <td><input type="text" class="form-control" name="name" placeholder="Navn" value="" /></td>
                    <?php
                    foreach($boutique_info as $boutique):
                    ?>
                    <td></td>
                    <?php
                    endforeach;
                    ?>
                    <td><input type="text" class="form-control" name="price" placeholder="Pris" value="" /></td>
                    <td>
                    	<input type="hidden" value="<?=$this->uri->segment(3);?>" name="part_id" />
                    	<input type="submit" class="btn btn-success" name="add_part" value="Opdater" />
                    </td>
                </tr>
                <?php
                echo form_close();
                ?>
            </tbody>
            <?php
            }*/
            ?>
                        
        </table>
				
	</div>
</div>

</div>


<script>
    $("#parts_sortable").sortable({
        update: function (event, ui) {
            var data = $(this).sortable('serialize');
            $.blockUI({message: '<h3>Updating...</h3>'});
            // POST to server using $.post or $.ajax
            $.ajax({
                data: data,
                type: 'POST',
                url: '<?php echo base_url('products/sort_part'); ?>',
                success: function (result) {
                    //console.log(result);
                },
                complete: function () {
                  $.unblockUI();
                }
            });
        }
    });
</script>

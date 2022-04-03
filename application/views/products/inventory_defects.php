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
      	<input type="text" class="form-control" name="price" style="margin-bottom: 10px" placeholder="Pris" value="" />
      	
		<input type="hidden" value="<?=$this->uri->segment(3);?>" name="part_id" />
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
	<div class="tab-pane fade <?php if($this->uri->segment(3) == 'parts'): echo 'active in'; endif; ?>" id="default-tab-2">
		<ul class="nav nav-pills" style="margin-bottom: 15px">
			<?php
			foreach($products as $product):
			?>
			<li class="<?php if($product->id == $this->uri->segment(4)): echo 'active'; endif; ?>"><a href="<?=site_url('products/inventory/'.$this->uri->segment(3).'/'.$product->id.'/defects/'.$this->uri->segment(6).'/'.$this->uri->segment(7));?>"><?=$product->name;?></a></li>
			<?php
			endforeach;
			?>
		</ul>

        
        <h1>
			Oversigt over defekter for <?=$boutique_name;?>
		</h1>
		
		<table class="table table-striped table-bordered">
			<thead>
                <tr>
                	<th width="100px">#</th>
                    <th>Navn</th>
                    <th>Defekt del</th>
                    <th>Oprettet</th>
                    <th>Beskrivelse</th>
                </tr>
            </thead>
            <tbody style="font-size: 12px">	
 
            	<?php
            	foreach($defects as $defect):
            	
            	// get user
            	$this->db->where('id',$defect->uid);
            	$user = $this->db->get('users_kasse')->result();
            	
            	if($user){
	            	$username = $user[0]->name;
            	}else{
	            	$username = '?';
            	}
            	
            	// get user
            	$this->db->where('id',$defect->part_id);
            	$part = $this->db->get('parts')->result();
            	
            	if($part){
	            	$partname = $part[0]->name;
            	}else{
	            	$partname = '?';
            	}
            	
            	?>
            	<tr>
            		<td><?=$defect->unique_name;?></td>
            		<td><?=$username;?></td>
            		<td><?=$partname;?></td>
            		<td><?=date("d/m/Y H:i",$defect->created_timestamp);?></td>
            		<td><?=$defect->description;?></td>
            	</tr>
            	<?php
            	endforeach;
            	?>
            </tbody>
          
        </table>
				
	</div>
</div>

</div>

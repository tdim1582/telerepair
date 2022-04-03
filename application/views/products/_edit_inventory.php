<?=form_open('products/inventory/parts/'.$device);?>
<table class="table table-striped table-bordered">
    <thead>
    	<tr>
            <th></th>
            <th colspan="<?=count($boutique_info);?>" style="background: #f5da2d"><center>Udfyld kun disse felter, hvis i tilføjer til lager</center></th>
            <th></th>
        </tr>
        <tr>
            <th>Navn</th>
            <?php
            foreach($boutique_info as $boutique):
            ?>
            <th><?=$boutique->name;?></th>
            <?php
            endforeach;
            ?>
            <th>Pris</th>
        </tr>
    </thead>
    <tbody style="font-size: 12px">
    	<?php
    	// count intervals
    	foreach($parts as $part):
    	            	
    	?>
		<tr class="odd gradeX" style="font-size: 20px">
            <td width="25%" style="font-size: 14px"><input type="text" class="form-control" name="name" style="margin-bottom: 10px" placeholder="Navn" value="<?=$part->name;?>" /></td>
            <?php
            foreach($boutique_info as $boutique):
            
            // get inventory to single boutique
            $this->db->where('unqiue_string',$part->unqiue_string);
        	$this->db->where('boutique_id',$boutique->id);
			$parts_boutique = $this->db->get('parts')->result();
            
            if($parts_boutique){
                $inventory = $parts_boutique[0]->inventory;
            }else{
                $inventory = 0;
            }
            
            ?>
            <td width="100px" style="font-size: 14px; <?php if($this->session->userdata('active_boutique') == $boutique->id): echo 'background: #f5efd9;'; endif; ?>">
            	<input type="text" class="form-control" name="boutique_inventory[]" style="margin-bottom: 10px" placeholder="Antal" value="0" />
            	<input type="hidden" name="boutique_id[]" value="<?=$boutique->id;?>" />
            </td>
            <?php
            endforeach;
            ?>
            <td width="10%" style="font-size: 14px">
	            <input type="text" class="form-control" name="price" style="margin-bottom: 10px" placeholder="Pris" value="<?=$part->price;?>" />
            </td>
        </tr>
        <input type="hidden" name="unique_string" value="<?=$part->unqiue_string;?>" />
        <?php
        endforeach;
        ?>
    </tbody>
        
</table>

<div class="checkbox">
<label>
  <input type="checkbox" name="part_of_inventory" value="1" <?php if($part->part_of_inventory == 1): echo 'checked="true"'; endif; ?>> En del af lagerstyring?
</label>
</div>

<input type="submit" class="btn btn-success" name="edit_part" value="Opdater" />
<?php
echo form_close();
?>
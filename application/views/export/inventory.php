<h1>
	Reservedele
</h1>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Navn</th>
            <?php
            $this->db->where('active',1);
            $this->db->where('id',$this->uri->segment(3));
            $boutique_info = $this->db->get('boutiques')->result();
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
		$parts = $this->db->get('parts')->result();
    	foreach($parts as $part):
    	            	
    	?>
    	<?=form_open(current_url());?>
		<tr class="odd gradeX" style="font-size: 20px">
            <td width="25%" style="font-size: 14px"><?=$part->name;?></td>
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
            <td width="120px" style="font-size: 14px; <?php if($this->session->userdata('active_boutique') == $boutique->id): echo 'background: #f5efd9;'; endif; ?>">
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
         
</table>

<script type="text/javascript">
print();
</script>
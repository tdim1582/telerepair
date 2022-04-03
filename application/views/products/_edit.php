<?=form_open(current_url());?>
<div class="row">

    <div class="col-md-6">
        <label>Navn</label>
        <input type="text" class="form-control" value="<?=$products->name;?>" name="name" required style="margin-bottom: 10px" />
        
        <label>Styr priserne</label>
        <input type="checkbox" value="1" name="control_prices" <?php if($products->control_prices == 1): echo 'checked="true"'; endif; ?> />
        
    </div>
    
    <div class="col-md-6">
        <label>GB</label>
    
        <!--- SÆLG ENHED --->
        <?php
        $i = 0;
        $permission_list = $this->global_model->gbs();
        
        foreach($permission_list as $permission => $real_name):
        
        $this->db->where('product_id',$products->id);
        $this->db->where('name',$permission);
        $check_if_gb_is_created = $this->db->get('gbs')->num_rows();
        
        ?>
        <div class="checkbox">
		  <label>
		    <input type="checkbox" <?php if($check_if_gb_is_created): echo 'checked="true"'; endif; ?> value="<?=$permission;?>" name="gbs[]" /> <?=$real_name;?>
		  </label>
		</div>
        <?php
        $i++;
        endforeach;
        ?>
    </div>
    
    <div class="col-md-12">
    	
    	<hr />
    	
    	<label>Opkøbs merpriser</label><br />
		
        <!--- SÆLG ENHED --->
        
        <div class="row">
        	<div class="col-md-6">
        		 <div style="font-size: 14px; margin-top: 10px">Defekt</div>
	        	<input type="text" class="form-control" name="sell_defect" value="<?php if($products->sell_defect > 0): echo $products->sell_defect; endif; ?>" placeholder="Indtast merpris" />
			</div>
			<div class="col-md-6">
        		 <div style="font-size: 14px; margin-top: 10px">Slidt</div>
	        	<input type="text" class="form-control" name="sell_worn" value="<?php if($products->sell_worn > 0): echo $products->sell_worn; endif; ?>" placeholder="Indtast merpris" />
			</div>
        </div>

        <div class="clearfix"></div>
        
        <div class="row">
        	<div class="col-md-6">
        		<div style="font-size: 14px; margin-top: 10px">God stand</div>
	        	<input type="text" class="form-control" name="sell_good_condition" value="<?php if($products->sell_good_condition > 0): echo $products->sell_good_condition; endif; ?>" placeholder="Indtast merpris" />
			</div>
			<div class="col-md-6">
        		<div style="font-size: 14px; margin-top: 10px">Helt ny</div>
	        	<input type="text" class="form-control" name="sell_new" value="<?php if($products->sell_new > 0): echo $products->sell_new; endif; ?>" placeholder="Indtast merpris" />
			</div>
        </div>
    
    </div>
    
    <div class="col-md-12">
    	
    	<hr />
    	
    	<label>Salgs merpriser</label><br />
		
        <!--- SÆLG ENHED --->
        
        <div class="row">
        	<div class="col-md-6">
        		<div style="font-size: 14px; margin-top: 10px">Helt ny</div>
	        	<input type="text" class="form-control" name="buy_new" value="<?php if($products->buy_new > 0): echo $products->buy_new; endif; ?>" placeholder="Indtast merpris" />
			</div>
        </div>

    </div>
    
    <div class="col-md-12">
    	
    	<hr />
    	
    	<label>Priser</label><br />
		
        <!--- SÆLG ENHED --->
        
        <?php
        $i = 0;
        
        $permission_list = $this->global_model->gbs();
        
        foreach($permission_list as $permission => $real_name):
        
        $this->db->where('product_id',$products->id);
        $this->db->where('name',$permission);
        $check_if_gb_is_created = $this->db->get('gbs')->result();
        
        if($check_if_gb_is_created){
        ?>
        <div style="font-size: 14px; margin-top: 10px"><?=$real_name;?></div>
        <div class="row">
        	<div class="col-md-6">
	        	<input type="text" class="form-control" name="used_price[]" value="<?php if($check_if_gb_is_created[0]->used_price > 0): echo number_format($check_if_gb_is_created[0]->used_price,0,'',''); endif; ?>" placeholder="Opkøbs pris" />
			</div>
	        <div class="col-md-6">
	        	<input type="text" class="form-control" name="new_price[]" value="<?php if($check_if_gb_is_created[0]->new_price > 0): echo number_format($check_if_gb_is_created[0]->new_price,0,'',''); endif; ?>" placeholder="Salgs pris" />
	        </div>
        </div>
        <input type="hidden" name="price_id[]" value="<?=$permission;?>" />
        <?php
        }
        
        $i++;
        endforeach;
        ?>
    
    </div>

    <div class="col-md-12">
    	<input type="hidden" name="id" value="<?=$products->id;?>" />
    	<input type="submit" class="btn btn-success" name="submit_product" value="Opdater" style="margin-top: 20px" />
    </div>

</div>
<?=form_close();?>
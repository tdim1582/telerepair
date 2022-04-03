<h1 class="page-header">
	Telefonafstemning <?php if($counting): echo ' - '.date("d/m/Y H:i",$counting[0]->created_timestamp); endif; ?>
</h1>

<div class="row">
	<div class="col-md-6">
		<div class="table-responsive">
			
			<?php
			if($counting):
			?>
			<table class="table" style="margin-top: 15px">
			  <tbody>
			  	<tr>
			  		<th></th>
			  		<th>ID</th>
			  		<th>Enhed</th>
			  		<th>IMEI</th>
			  	</tr>
			  	<?php
			  	foreach($counting as $counting):
			  	$on_inventory = json_decode($counting->info);
			  	$not_on_inventory = json_decode($counting->missing_phones);
			  	
			  	foreach($not_on_inventory as $not_inventory):
			  	?>
			  	<tr>
			  		<td>
				  		<i class="fa fa-minus-circle" style="color: #cd0816"></i>
			  		</td>
			  		<td width="80px"><?=$not_inventory->id;?></td>
			  		<td><?=$not_inventory->name;?></td>
			  		<td><?=$not_inventory->imei;?></td>
			  	</tr>
			  	<?php
			  	endforeach;
			  	foreach($on_inventory as $inventory):
			  	?>
			  	<tr>
			  		<td>
				  		<i class="fa fa-check-circle" style="color: #2dbe2f"></i>
			  		</td>
			  		<td width="80px"><?=$inventory->id;?></td>
			  		<td><?=$inventory->name;?></td>
			  		<td><?=$inventory->imei;?></td>
			  	</tr>
			  	<?php
			  	endforeach;
			  	endforeach;
			  	?>
			  	
			  </tbody>
			</table>
			<?php
			else:
			?>
			<?=form_open(current_url());?>
			
			<span style="color: #2e2e2e; font-size: 16px">Vælg hvilke telefoner der er på lager i butikken herunder og tryk "Afstem"</span>
			
			<table class="table" style="margin-top: 15px">
			  <tbody>
			  	<tr>
			  		<th></th>
			  		<th><a href="<?=site_url('status/phone');?>?sortby=id" style="color: #2e2e2e">#</a></th>
			  		<th><a href="<?=site_url('status/phone');?>?sortby=device" style="color: #2e2e2e">Enhed</a></th>
			  		<th><a href="<?=site_url('status/phone');?>?sortby=imei" style="color: #2e2e2e">IMEI</a></th>
			  	</tr>
			  	<?php
			  	foreach($phones as $phone):
			  	?>
			  	<tr>
			  		<td><input type="checkbox" class="" name="on_inventory[]" value="<?=$phone->id;?>" /></td>
			  		<td><a href="<?=site_url('orders/show/'.$phone->id);?>"><?=$phone->id;?></a></td>
			  		<td><?=$phone->product;?>, <?=$phone->gb;?>GB, <?=$phone->color;?></td>
			  		<td><?=$phone->imei;?></td>
			  	</tr>
			  	<?php
			  	endforeach;
			  	?>
			  	
			  </tbody>
			</table>
			

			
			<input type="hidden" name="date" value="<?=$date;?>" />
			<input type="submit" class="btn btn-success confirm" name="create" value="Afstem" />
			
			<?=form_close();?>
			
			<?php
			endif;
			?>
			
		</div>
	</div>
	
	<div class="col-md-5 col-md-offset-1 hidden-print">
		<b>Tidligere afstemninger</b>
		<hr style="margin-top: 10px; margin-bottom: 10px;" />
		<table>
			<tr>
				<td><b>#</b></td>
				<td><b>Dato</b></td>
				<?php
				if (strpos($rank_permissions,'status_edit') !== false || strpos($rank_permissions,'all') !== false) {
				?>
				<td><b>Af</b></td>
				<?php
				}
				?>
			</tr>
			<?php
			$this->db->order_by('id','desc');
			$this->db->where('boutique_id',$this->session->userdata('active_boutique'));
			$countinfo = $this->db->get('telefonafstemning')->result();
			foreach($countinfo as $count):
			?>
			<tr>
				<td width="140px"><a href="<?=site_url('status/phone/'.$count->id);?>">#<?=$boutique[0]->initial;?><?=$count->unique_id;?></a></td>
				<td width="200px"><a href="<?=site_url('status/phone/'.$count->id);?>"><?=date("d/m/Y",$count->created_timestamp);?></a></td>
				<?php
				if (strpos($rank_permissions,'status_edit') !== false || strpos($rank_permissions,'all') !== false) {
				
				// get user info
				$this->db->where('id',$count->uid);
				$userinfo = $this->db->get('users_kasse')->result();
				
				?>
				<td>
					<?=$userinfo[0]->name;?>
				</td>
				<?php
				}
				?>
			</tr>
			<?php
			endforeach;
			?>
			
		</table>
		
	</div>
	
</div>

<input type="hidden" class="rememberCardReminder" value="1" />

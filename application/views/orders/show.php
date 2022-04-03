<div class="modal fade" id="edit_device">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Rediger enhed</h4>
      </div>
      <div class="modal-body">
        
        <center><img src="<?=base_url();?>assets/images/loader.gif" /></center>
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="tested">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Testet af</h4>
      </div>
      <div class="modal-body">
        
        <center><img src="<?=base_url();?>assets/images/loader.gif" /></center>
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="reason_for_creditnote">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Krediter salg</h4>
      </div>
      <div class="modal-body">
        
        <form action="<?=site_url('sold/cancel');?>?redirect=<?=current_url();?>" method="post">
           
           <label>Skriv et par linjer omkring hvorfor salget er blevet annulleret</label><br />
           <textarea class="form-control" name="reason" rows="5" required="true"></textarea>
           
           <input type="submit" class="btn btn-danger" style="margin-top: 10px;" value="Krediter salg" />
           
           <input type="hidden" name="line_id" class="cancelCreditLineID" value="" />
           
        <?=form_close();?>
        
        <div class="editContentSold" style="display: none">
	        
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="transfer">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Overfør ordre til anden butik</h4>
      </div>
      <div class="modal-body">
        
        <center><img src="<?=base_url();?>assets/images/loader.gif" /></center>
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="parts_used">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Dele brugt til at reparere enhed</h4>
      </div>
      <div class="modal-body">
        
        <center><img src="<?=base_url();?>assets/images/loader.gif" /></center>
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="create_defect">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Opret defekt</h4>
      </div>
      <div class="modal-body">
        
        <?=form_open(current_url());?>
        <div class="row">

	        <div class="col-md-12">
		        <label>Udfyld ID</label>
		        <input type="text" class="form-control orderid" name="id"  value="<?=$order->id;?>" required style="margin-bottom: 10px" />
	        </div>

	        <hr />

	        <div class="col-md-12">
	        	<input type="hidden" name="alreadyTested" value="0" />
	        	<input type="submit" class="btn btn-success" name="create_defect" value="Opret defekt" style="margin-top: 20px" />
	        </div>
        
        </div>
        <?=form_close();?>
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="create_fraud">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Opret mistet telefon (svind)</h4>
      </div>
      <div class="modal-body">
        
        <?=form_open(current_url());?>
        <div class="row">

	        <div class="col-md-12">
		        <label>Udfyld ID</label>
		        <input type="text" class="form-control orderid" name="id" value="<?=$order->id;?>" required style="margin-bottom: 10px" />
	        </div>

	        <hr />

	        <div class="col-md-12">
	        	<input type="hidden" name="alreadyTested" value="0" />
	        	<input type="submit" class="btn btn-success" name="create_fraud" value="Opret svind" style="margin-top: 20px" />
	        </div>
        
        </div>
        <?=form_close();?>
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="row">

<div class="col-md-12">
	<h1 class="page-header">
		<?php
		if($this->session->flashdata('success')):?>
		<div class="alert alert-success" style="font-size: 15px"><?=$this->session->flashdata('success');?></div>
		<?php
		endif;
		?>
		Ordre #<?=$order->id;?>
		<div class="pull-right">
			<?php
			if (strpos($rank_permissions,'all') !== false) {
			if($order->defect == 0 && $order->fraud == 0):
			?>
			<a href="#" class="btn btn-sm btn-danger" data-toggle="modal" style="float: left; margin-right: 5px" data-target="#create_defect">Opret defekt</a>
			<a href="#" class="btn btn-sm btn-default" data-toggle="modal" style="float: left; margin-right: 5px" data-target="#create_fraud">Opret svind</a>
			<?php
			endif;
			}
			?>
			<a href="#" data-toggle="modal" data-id="<?=$order->id;?>" data-target="#edit_device" style="float: left; margin-right: 5px" class="btn btn-info btn-sm">Rediger</a>
	      	<a href="#" data-toggle="modal" data-id="<?=$order->id;?>" data-target="#parts_used" style="float: left; margin-right: 5px" class="btn btn-warning btn-sm">Dele brugt</a>
	      	<?php if($order->sold == 1){ ?><a href="#" class="btn btn-success btn-sm" style="float: left; margin-right: 5px">Solgt</a>
		    <?php
	      	}else{
	      	$lasttwohours = strtotime("-2 hours");
	      	if($lasttwohours > $order->created_timestamp){}else{
	      	?>
	      	<a href="<?=site_url('bought/cancel/'.$order->id);?>" style="float: left; margin-right: 5px" class="btn btn-default btn-sm confirm">Annuller</a>
	      	<?php
	      	}
	      	}
	      	?>
	      	<a href="<?=site_url('export/print_/'.$order->id);?>"  target="_blank" class="btn btn-default btn-sm" style="float: left; margin-right: 5px">Kvittering</a>
	      	
	      	<a href="#" data-toggle="modal" data-id="<?=$order->id;?>" data-target="#transfer" class="btn btn-default btn-sm" style="float: left; margin-right: 5px">Overfør</a>
	      	
	      	<?php
	      	$this->db->where('order_id',$order->id);
	      	$tested = $this->db->get('tests')->result();
	      	
	      	if(!$tested && $order->already_tested == 0):
	      	?>
	      	<a href="<?=site_url('bought/test/'.$order->id);?>" class="btn btn-info btn-sm" style="float: left; margin-right: 5px">Test</a>
	      	<?php
	      	else:
	      	?>
	      	<a href="#" class="btn btn-default btn-sm" data-toggle="modal" data-id="<?=$order->id;?>" data-target="#tested" style="float: left; margin-right: 5px; margin-left: 15px">Testet</a>
	      	<a href="<?=site_url('bought/test/'.$order->id);?>" class="btn btn-info btn-sm" style="float: left; margin-right: 5px">Test igen</a>
	      	<?php
	      	endif;
	      	?>
		</div>
	</h1>
</div>

<div class="col-md-6">
<b>Sælger</b>
<table width="100%" class="table">
	<tr>
		<td>ID</td>
		<td><?=$order->id;?></td>
	</tr>
	<tr>
		<td width="50%">Oprettet af:</td>
		<td>
			<?php
	      	// get user
			$this->db->where('id',$order->uid);
			$user = $this->db->get('users_kasse')->result();
			
			if($user){
				echo $user[0]->name;
			}
			
	      	?>
		</td>
	</tr>
	<?php
	if($order->company):
	?>
	<tr>
		<td width="50%">Sælger firma:</td>
		<td>
			<?php
	      	echo $order->company;
	      	?>
		</td>
	</tr>
	<?php
	endif;
	?>
	<tr>
		<td width="50%">Sælger</td>
		<td>
			<?php
	      	if($order->payment_type == 'webshop'){
		      	echo $order->webshop_id;
	      	}else{
	      	?>
	      	<?=$order->name;?><br />
	      	<?=$order->address;?>
	      	<?php
	      	}
	      	?>
		</td>
	</tr>
	<tr>
		<td width="25%">Købsdato</td>
		<td><?=date("d/m/Y H:i",$order->created_timestamp);?></td>
	</tr>
	<tr>
		<td width="25%">Enhed</td>
		<td><?=$order->product;?>, <?=$order->gb;?>GB, <?=$order->color;?> </td>
	</tr>
	<tr>
		<td width="25%">IMEI</td>
		<td><?=$order->imei;?></td>
	</tr>
	<tr>
		<td width="25%">Tlf. nummer</td>
		<td><?=$order->number;?></td>
	</tr>
	<tr>
		<td width="25%">Pris</td>
		<td>
			<?=$order->price;?> kr
		</td>
	</tr>
	
	<tr>
		<td width="25%">Reg nr.</td>
		<td>
			<?=$order->reg_nr;?> 
		</td>
	</tr>
	
	<tr>
		<td width="25%">Konto nr.</td>
		<td>
			<?=$order->account_nr;?> 
		</td>
	</tr>
	
	
	<tr>
		<td width="25%">Sælger nummer</td>
		<td>
			<?=$order->seller_id;?>
		</td>
	</tr>
	
	<tr>
		<td width="25%">Sælger email</td>
		<td>
			<?=$order->seller_email;?>
		</td>
	</tr>

</table>

<?php
if($order->fraud): 
	$inventory_status = 'Svind lager'; 
elseif($order->defect): 
	$inventory_status = 'Defekt lager'; 
elseif($order->sold == 1):
	$inventory_status = 'Solgt';
else: 
	// get boutique info
	$this->db->where('id',$order->boutique_id);
	$boutique_info = $this->db->get('boutiques')->result();
	$inventory_status = 'Butik ('.$boutique_info[0]->name.')'; 
endif;

if($order->transfered):
	$transfered = 1;
else:
	$transfered = 0;
endif;
?>
</div>
<div class="col-md-6">
	
	<?php
	// sold info
	$this->db->where('bought_from_order_id',$order->id);
	$this->db->where('cancelled',0);
	$order = $this->db->get('orders')->result();
	
	if($order){
	
	$order = $order[0];
	?>
	
	<b>Køber</b>
	<table width="100%" class="table">
		<tr>
			<td>ID</td>
			<td><?=$order->id;?></td>
		</tr>
		<tr>
			<td width="50%">Solgt af:</td>
			<td>
				<?php
		      	// get user
				$this->db->where('id',$order->uid);
				$user = $this->db->get('users_kasse')->result();
				
				if($user){
					echo $user[0]->name;
				}
				
		      	?>
			</td>
		</tr>
		<tr>
			<td width="50%">Køber</td>
			<td>
				<?php
		      	if($order->payment_type == 'webshop'){
			      	echo $order->webshop_id;
		      	}else{
		      	?>
		      	<?=$order->name;?><br />
		      	<?=$order->address;?>
		      	<?php
		      	}
		      	?>
			</td>
		</tr>
		<tr>
			<td width="25%">Tlf .nummer</td>
			<td><?=$order->number;?></td>
		</tr>
		<tr>
			<td width="25%">Salgsdato</td>
			<td><?=date("d/m/Y H:i",$order->created_timestamp);?></td>
		</tr>
		<tr>
			<td width="25%">Enhed</td>
			<td><?=$order->product;?>, <?=$order->gb;?>GB, <?=$order->color;?> </td>
		</tr>
		<tr>
			<td width="25%">IMEI</td>
			<td><?=$order->imei;?></td>
		</tr>
		<tr>
			<td width="25%">Betalingstype</td>
			<td>
				<?php
				echo $this->global_model->payment_type($order->payment_type);
				?>
			</td>
		</tr>
		<tr>
			<td width="25%">Pris</td>
			<td>
				<?=$order->price;?> kr
				(<?php
			    $profit = number_format($this->global_model->calculate_earnings_on_phone($order->id),2,',','.');
			    if($profit > 0){
				    echo '<span style="color: green">+'.$profit.' kr</span>';
			    }else{
				    echo '<span style="color: red">'.$profit.' kr</span>';
			    }
			    ?>)
			</td>
		</tr>
		
		<tr>
			<td></td>
			<td><a href="#" data-toggle="modal" data-id="<?=$order->id;?>" data-target="#reason_for_creditnote"  class="btn btn-default btn-xs">Krediter</a></td>
		</tr>
	
	</table>
	<?php
	}
	?>
</div>

<div class="clearfix"></div>

<div class="row">
	<hr />
	
	<div class="col-md-6" id="intern_comments">
		<h2>Interne kommentarer til ordre</h2>
		
		<?=form_open(current_url());?>
		<textarea class="form-control" name="comment_text" rows="6"></textarea>
		<input type="submit" class="btn btn-success" name="comment" style="margin-top: 10px" value="Opret kommentar" />
		<?=form_close();?>
		
		<hr />
		
		<table width="100%">
			
			<?php
			$this->db->where('order_id',$this->uri->segment(3));
			$this->db->where('active',1);
			$comments = $this->db->get('comments')->result();
			foreach($comments as $comment):
			
			// get user
			$this->db->where('id',$comment->uid);
			$user = $this->db->get('users_kasse')->result();
			
			?>
			<tr>
				<td><b><?=$user[0]->name;?></b></td>
				<td align="right"><?=date("d/m/Y H:i",$comment->created_timestamp);?></td>
				<td align="right">
					<a href="<?=site_url('orders/delete/'.$this->uri->segment(3).'/'.$comment->id);?>" class="confirm">Slet</a>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="font-size: 12px; padding-top: 15px">
					<?=$comment->comment;?>
				</td>
			</tr>
			<?php
			endforeach;
			?>
		</table>
		
	</div>
	
	<div class="col-md-6">
		<h2>Info vedr. ordre</h2>
		
		<table class="table">
			<tr>
				<td width="50%">Testet:</td>
				<td>
					<?php
					$this->db->where('order_id',$this->uri->segment(3));
					$this->db->order_by('id','desc');
					$tested = $this->db->get('tests')->result();
					
					if($tested):
					?>
					Ja<br />
					<?php
					foreach($tested as $testinfo):
					// get user
					$this->db->where('id',$testinfo->uid);
					$user = $this->db->get('users_kasse')->result();
					
					
					if($user){
						$name = $user[0]->name;
					}else{
						$name = '-';
					}
					
					?>
					Af: <?=$name;?> <small>(<?=date("d/m/Y",$testinfo->created_timestamp);?>)</small><br />
					<a href="<?=site_url('export/print_test/'.$this->uri->segment(3).'/'.$testinfo->id);?>">Gå til test</a>
					<br />
					<?php
					endforeach;
					else:
					?>
					Nej
					<?php
					endif;
					?>
					
				</td>
			</tr>
			<tr>
				<td width="50%">Overført:</td>
				<td>
					<?php
					if($transfered): echo 'Ja'; else: echo 'Nej'; endif;
					?>
				</td>
			</tr>
			<tr>
				<td width="50%">Status:</td>
				<td>
					<?php
					echo $inventory_status;
					?>
				</td>
			</tr>
			
		</table>

	</div>
	
</div>

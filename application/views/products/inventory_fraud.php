<h1 class="page-header">
	Oversigt over svind for <?=$boutique_name;?>
</h1>

<div class="clearfix"></div>

<div class="table-responsive">

<div class="tab-content" style="margin-top: 15px;">
	<div class="tab-pane fade active in" id="default-tab-2">
		<table class="table table-striped table-bordered">
			<thead>
                <tr>
                	<th width="100px">#</th>
                    <th>Telefon</th>
                    <th>Kunde</th>
                    <th>IMEI</th>
                    <th>Oprettet</th>
                    <th>Tlf. nummer</th>
                    <th>Pris</th>
                    <th>Svind af</th>
                    <th></th>
                </tr>
            </thead>
            <tbody style="font-size: 12px">	
 
            	<?php
            	foreach($phones as $order):
            	
            	// get user
            	$this->db->where('action','fraud_order');
            	$this->db->where('action_id',$order->id);
            	$this->db->order_by('id','desc');
            	$this->db->limit(1);
            	$log = $this->db->get('log')->result();
            	
            	if($log){
            		
            		$this->db->where('id',$log[0]->uid);
            		$user = $this->db->get('users_kasse')->result();
            		
            		if($user){
	            		$username = $user[0]->name;
	            	}else{
		            	$username = 'Ikke logget';
	            	}
            	}else{
	            	$username = 'Ikke logget';
            	}

            	
            	?>
            	 <tr>
			      <td><a href="<?=site_url('orders/show/'.$order->id);?>"><?=$order->id;?></a></td>
			      <td>
			      	<?=$order->product;?><br /> 
			      	<?=$order->gb;?>GB<br />
			      	<?=$order->color;?>
			      </td>
			      <td>
			      	<?=$order->name;?><br />
			      	<?=$order->address;?>
			      </td>
			      <td><?=$order->imei;?></td>
			      <td><?=date("d/m/Y H:i",$order->created_timestamp);?></td>
			      <td><?=$order->number;?></td>
			      <td><?=number_format($order->price,2,',','.');?> kr</td>
			      <td><?=$username;?></td>
			      <td><a href="<?=site_url('products/transfer_back_to_inventory/'.$order->id.'?r='.current_url());?>" class="btn btn-danger btn-xs confirm">Overfør til lager</a></td>
			    </tr>
            	<?php
            	endforeach;
            	?>
            </tbody>
          
        </table>
				
	</div>
</div>

</div>

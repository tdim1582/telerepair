<h1 class="page-header">
	Krediterede salg
</h1>

<div class="table-responsive">
<table class="table table-striped">
  <thead>
    <tr>
      <th>#</th>
      <th>Enhed</th>
      <th>Grund til kreditering</th>
      <th>Krediteret d.</th>
      <th>Beløb</th>
      <th>Af</th>
      <th>Krediteret linje ID</th>
    </tr>
  </thead>
  <tbody>
  	<?php

  	foreach($orders as $order):
  	
  	// get user
  	$this->db->where('id',$order->uid);
  	$userinfo = $this->db->get('users_kasse')->result();
  	
  	if($userinfo){
	  	$username = $userinfo[0]->name;
  	}else{
	  	$username = '?';
  	}
  	
  	
  	// get credit line
  	$this->db->where('id',$order->creditlineConnectedID);
  	$creditline = $this->db->get('orders')->result();
  	
  	if($creditline){
	  	$creditline_id = site_url('orders/show/'.$creditline[0]->bought_from_order_id);
  	}else{
	  	$creditline_id = '#';
  	}
  	
  	?>
    <tr>
      <td><?=$order->id;?></td>
      <td>
      	<?=$order->product;?><br /> <?=$order->gb;?>GB
	  	<?php
	  	if($order->part):
	  		echo '<br />'.$order->part;
	  	endif;
	  	?>
      </td>
      <td width="350px">
      	<?=$order->credit_reason;?>
      </td>
      <td><?=date("d/m/Y H:i",$order->created_timestamp);?></td>
      <td><?=$order->price;?></td>
      <td><?=$username;?></td>
      <td><a href="<?=$creditline_id;?>"><?=$order->creditlineConnectedID;?></a></td>
    </tr>
    <?php
    endforeach;
    ?>
  </tbody>
</table>

<?php /*$this->pagination->create_links(); */ ?>

</div>

<input type="hidden" class="disableChained" value="1" />
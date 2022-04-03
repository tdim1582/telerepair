<h1 class="page-header">
	Solgte forsikringer
</h1>

<div class="table-responsive">
<table class="table table-striped">
  <thead>
    <tr>
      <th>#</th>
      <th>Dato</th>
      <th>Solgt af</th>
      <th>Beløb</th>
      <th>Antal år</th>
    </tr>
  </thead>
  <tbody>
  	<?php

  	foreach($orders as $order):
  	
  	
  	$this->db->where('id',$order->uid);
  	$user = $this->db->get('users_kasse')->result();
  	
  	if($user){
	  	$username = $user[0]->name;
  	}else{
	  	$username = '';
  	}
  	
  	?>
    <tr>
      <td><a style="color: #2e2e2e" href="<?=site_url('orders/show/'.$order->bought_from_order_id);?>"><?=$order->bought_from_order_id;?></a></td>
      <td><?=date("d/m/Y H:i",$order->created_timestamp);?></td>
      <td><?=$username;?></td>
      <td><?=$order->insurance_price;?></td>
      <td><?=$order->insurance_years;?> år</td>
    </tr>
    <?php
    endforeach;
    ?>
  </tbody>
</table>

</div>

<input type="hidden" class="disableChained" value="1" />
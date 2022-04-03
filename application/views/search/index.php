<h1 class="page-header">
	Søgning
</h1>

<div class="table-responsive">
<table class="table table-striped">
  <thead>
    <tr>
      <th>#</th>
      <th>Enhed</th>
      <th>Type</th>
      <th>Køber / Webshop ID</th>
      <th>IMEI</th>
      <th>Dato</th>
      <th>Betalingsform</th>
      <th>Pris</th>
      <th>Butik</th>
    </tr>
  </thead>
  <tbody>
  	<?php
  	if($orders){
  	foreach($orders as $order):
  	
  	// get boutique name
  	$boutique = $this->boutique_model->get_by_id($order->boutique_id);
  	
  	if($boutique){
	  	$b_name = $boutique->name;
  	}else{
	  	$b_name = '';
  	}
  	
  	if($order->type == 'bought'){
	  	$type = 'Opkøbt';
  	}elseif($order->type == 'sold'){
	  	$type = 'Solgt';
	}elseif($order->type == 'access'){
	  	$type = 'Tilbehør';
  	}else{
	  	$type = $order->type;
  	}
  	
  	if($order->bought_from_order_id){
	  	$orderid = $order->bought_from_order_id;
  	}else{
	  	$orderid = $order->id;
  	}
  	
  	?>
  	<tr>
      <td><a style="color: #2e2e2e" href="<?=site_url('orders/show/'.$orderid);?>"><?=$orderid;?></a></td>
      <td><?=$order->product;?><br /> <?=$order->gb;?>GB</td>
      <th><?=$type;?></th>
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
      <td><?=$order->imei;?></td>
      <td><?=date("d/m/Y H:i",$order->created_timestamp);?></td>
      <td>
	      <?php
	      echo $this->global_model->payment_type($order->payment_type);
	      ?>
      </td>
      <td><?=$order->price;?></td>
      <td>
	      <?php
	      echo $b_name;
	      ?>
      </td>
    </tr>
  	<?php
  	endforeach;
  	}
  	?>
  </tbody>
</table>
</div>
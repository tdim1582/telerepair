
<div class="row">
	<div class="col-md-9 col-xs-6" style="margin: 15px 0px; font-size: 17px;">
		Dagens omsætning for webshop
	</div>
	<div class="col-md-3 col-xs-6 pull-right" style="margin: 15px 0px; float: right; font-size: 17px;">
		<?=$boutique[0]->name;?>, <?=date("d/m/Y",$counting[0]->created_timestamp);?>
	</div>
</div>

<div class="clearfix"></div>

<div class="table-responsive">
<table class="table table-striped">
  <thead>
    <tr>
      <th>Ordre ID</th>
      <th>Enhed</th>
      <th>Webshop ID</th>
      <th>IMEI</th>
      <th>Dato</th>
      <th>Pris</th>
    </tr>
  </thead>
  <tbody>
  	<?php
  	$total_price = 0;
  	
  	$this->db->order_by('id','desc');
  	$this->db->where('created_timestamp >=',$start);
  	$this->db->where('created_timestamp <=',$end);
  	$this->db->where('boutique_id',$this->session->userdata('active_boutique'));
  	$this->db->where('type','sold');
  	$orders = $this->db->get('orders')->result();
  	
  	foreach($orders as $order):
  	?>
    <tr>
      <td><?=$order->bought_from_order_id;?></td>
      <td><?=$order->product;?><br /> <?=$order->gb;?>GB</td>
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
      <td><?=$order->price;?></td>
    </tr>
    <?php
    $total_price += $order->price;
    endforeach;
    ?>
    <tr>
      <td colspan="5"><b>TOTAL</b></td>
      <td><b><?=number_format($total_price,2,',','.');?></b></td>
    </tr>
  </tbody>
</table>
</div>
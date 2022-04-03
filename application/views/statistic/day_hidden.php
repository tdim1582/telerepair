<?php
if($this->input->get('sdate') == $this->input->get('edate')){
	$day_type = ' i dag';
}else{
	$day_type = ', '.$this->input->get('sdate').' - '.$this->input->get('edate');
}
?>
<link href="/assets/plugin/jqueryui/jquery-ui.min.css" rel="stylesheet">
<h1 class="page-header">
	Salg for <?=$boutique[0]->name;?><?=$day_type;?>
	<div class="pull-right">
		<form action="<?=site_url('statistic/hidden/'.$this->uri->segment(3));?>" method="get">
		<input type="text" style="float: left; width: 100px; margin-top: 8px" name="sdate" value="<?=$this->input->get('sdate');?>" class="form-control datepicker" />
		<div style="float: left; width: 20px; font-size: 12px; padding-top: 16px; text-align: center">-</div>
		<input type="text" style="float: left; width: 100px; margin-top: 8px; margin-right: 10px" value="<?=$this->input->get('edate');?>" name="edate" class="form-control datepicker" />
		<input type="submit" class="btn btn-success" value="Filtrer" />
		</form>
	</div>
</h1>

<div class="row">
	<div class="col-md-6">
		<h3>Enheder solgt</h3>
		<table class="table">
			<?php
			$total_price = 0;
			foreach($orders_bought as $order):

			if($order->type == 'sold'):
				$order_id = $order->bought_from_order_id;
			else:
				$order_id = $order->id;
			endif;

			if($order->type == 'bought'):
				$total_price = $total_price-$order->price;
			else:
				$total_price += $order->price;
			endif;

			?>
			<tr>
				<td><a href="<?=site_url('orders/show/'.$order_id);?>">#<?=$order_id;?></a></td>
				<td><?=date("d/m/Y",$order->created_timestamp);?></td>
				<td>
					<?php
					if($order->type == 'sold'):
						echo 'Solgt';
					else:
						echo 'Opkøb';
					endif;
					?>
				</td>
				<td><?=$order->product;?>, <?=$order->gb;?>GB</td>
				<td><?php if($order->type == 'bought'): echo '-'; endif; ?><?=number_format($order->price,2,',','.');?> kr</td>
			</tr>
			<?php
			endforeach;
			?>
			<tr style="font-weight: bold">
				<td colspan="4">Total</td>
				<td><?=number_format($total_price,2,',','.');?> kr</td>
			</tr>
		</table>


		<h3>Enheder købt</h3>
		<table class="table">
			<?php
			$total_price = 0;
			foreach($orders_sold as $order):

			if($order->type == 'sold'):
				$order_id = $order->bought_from_order_id;
			else:
				$order_id = $order->id;
			endif;

			if($order->type == 'bought'):
				$total_price = $total_price-$order->price;
			else:
				$total_price += $order->price;
			endif;

			?>
			<tr>
				<td><a href="<?=site_url('orders/show/'.$order_id);?>">#<?=$order_id;?></a></td>
				<td><?=date("d/m/Y",$order->created_timestamp);?></td>
				<td>
					<?php
					if($order->type == 'sold'):
						echo 'Solgt';
					else:
						echo 'Opkøb';
					endif;
					?>
				</td>
				<td><?=$order->product;?>, <?=$order->gb;?>GB</td>
				<td><?php if($order->type == 'bought'): echo '-'; endif; ?><?=number_format($order->price,2,',','.');?> kr</td>
			</tr>
			<?php
			endforeach;
			?>
			<tr style="font-weight: bold">
				<td colspan="4">Total</td>
				<td><?=number_format($total_price,2,',','.');?> kr</td>
			</tr>
		</table>


	</div>
	<div class="col-md-6">
		<h3>Tilbehør solgt<?php echo $delete_link; ?></h3>
		<table class="table">
			<?php
			$total_price = 0;
			foreach($access as $acces):

			$total_price += $acces->price;
			?>
			<tr>
				<td>#<?=$acces->id;?></td>
				<td><?=date("d/m/Y",$acces->created_timestamp);?></td>
				<td>
					<?php //$acces->product;?> <?php //$acces->part;?>
					<?php echo $this->device_model->get_item_names_concat($acces->id); ?>
				</td>

				<td><?=number_format($acces->price,2,',','.');?> kr</td>
			</tr>
			<?php
			endforeach;
			?>
			<tr style="font-weight: bold">
				<td colspan="3">Total</td>
				<td><?=number_format($total_price,2,',','.');?> kr</td>
			</tr>
		</table>

		<h3>Krediteret</h3>
		<table class="table">
			<?php
			$total_price = 0;
			foreach($orders_credit as $order):

			$total_price = $total_price-$order->price;

			?>
			<tr>
				<td>#<?=$order->id;?></td>
				<td><?=date("d/m/Y",$order->created_timestamp);?></td>
				<td>
					Krediteret
				</td>
				<td><?=$order->product;?>, <?=$order->gb;?>GB</td>
				<td>-<?=number_format($order->price,2,',','.');?> kr</td>
			</tr>
			<tr>
				<td colspan="6" style="border-top: 0px"><?=$order->credit_reason;?></td>
			</tr>
			<?php
			endforeach;
			?>
			<tr style="font-weight: bold">
				<td colspan="4">Total</td>
				<td><?=number_format($total_price,2,',','.');?> kr</td>
			</tr>
		</table>

	</div>
</div>

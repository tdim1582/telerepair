<h1 class="page-header">Salg for <?=$boutique[0]->name;?> i <?=$this->global_model->get_month_name($this->uri->segment(3));?></h1>

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
				<td colspan="3">Total</td>
				<td><?=number_format($total_price,2,',','.');?> kr</td>
			</tr>
		</table>
		
			
	</div>
	<div class="col-md-6">
		<h3>Tilbehør solgt</h3>
		<table class="table">
			<?php
			$total_price = 0;
			foreach($access as $acces):
			
			$total_price += $acces->price;
			?>
			<tr>
				<td>#<?=$acces->id;?></td>
				<td><?=$acces->product;?>, <?=$acces->part;?></td>
				<td><?=number_format($acces->price,2,',','.');?> kr</td>
			</tr>
			<?php
			endforeach;
			?>
			<tr style="font-weight: bold">
				<td colspan="2">Total</td>
				<td><?=number_format($total_price,2,',','.');?> kr</td>
			</tr>
		</table>
				
	</div>
</div>
<h1 class="page-header">Salg fordelt over måneder</h1>

<div class="row">
	<div class="col-md-12">
		
		<table class="table table-bordered table-hover">
			<tr>
				<th></th>
				<?php
				$boutiques = $this->boutique_model->get();
				
				foreach($boutiques as $boutique):
				?>
				<th><?=$boutique->name;?></th>
				<?php
				endforeach;
				?>
			</tr>
			<?php
			$month_array = array();
			for ($x = 1; $x <= 12; $x++) {
			$earnings = 0;		
			?>
			<tr>
				<td><?=$this->global_model->get_month_name($x);?></td>
				<?php
				foreach($boutiques as $boutique):
				// calculate earnings on month
				if($x < 10){
					$monthx = '0'.$x;
				}else{
					$monthx = $x;
				}
				$first_day_this_month = date('01-'.$monthx.'-Y');
				$last_day_this_month = date('31-'.$monthx.'-Y');
				
				$earnings = $this->global_model->calculate_sale_by_month($x,$boutique->id,$first_day_this_month,$last_day_this_month);
				
				if(!isset($month_array[$boutique->id])){
					$month_array[$boutique->id] = 0;
				}
				
				$month_array[$boutique->id] += $earnings;
				?>
				<td><a href="<?=site_url('statistic/month_numbers_detailed/'.$x.'/'.$boutique->id);?>" style="color: #2e2e2e"><?=number_format($earnings,2,',','.');?></a></td>
				<?php
				endforeach;
				?>
			</tr>
			<?php
			}
			?>
			<tr>
				<td><b>TOTAL</b></td>
				<?php
				foreach($boutiques as $boutique):
				?>
				<td><b><?=number_format($month_array[$boutique->id],2,',','.');?></b></td>
				<?php
				endforeach;
				?>
			</tr>
		</table>
		
	</div>
</div>
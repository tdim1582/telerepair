<h1 class="page-header">
	Statistik
	
	<div class="pull-right" style="padding-top: 5px">
		<form action="<?=current_url();?>" method="GET">
		<select class="form-control" name="boutique" style="width: 150px; float: left; margin-right: 10px">
			<option value="all" <?php if($this->input->get('boutique') == 'all'){ echo 'selected="true"'; } ?>>Alle</option>
			<?php
			$this->db->where('active',1);
			$this->db->order_by('id','desc');
			$boutiques = $this->db->get('boutiques')->result();
			
			foreach($boutiques as $boutiques){
				if($this->input->get('boutique') == $boutiques->id || $this->session->userdata('active_boutique') == $boutiques->id && $this->input->get('boutique') == false){
					$selected = 'selected="true"';
				}else{
					$selected = '';
				}
				echo '<option value="'.$boutiques->id.'" '.$selected.'>'.$boutiques->name.'</option>';
			}
			?>
		</select>
		<input type="date" class="form-control" name="from" value="<?=date("Y-m-d",strtotime("first day of this month"));?>" style="float: left; margin-right: 10px; width: 160px; text-align: center;" />
		<input type="date" class="form-control" name="to" value="<?=date("Y-m-d");?>" style="float: left; width: 160px; text-align: center;" />
		<input type="submit" class="btn btn-info" style="float: left; margin-left: 10px" value="Filtrer" />
		<?=form_close();?>
	</div>
	
</h1>

<div class="">

	<div style="width: 100%">
		<h4 style="text-align: center;">Fortjeneste</h4>
		<canvas id="canvas" height="450" width="1500"></canvas>
	</div>


	<script>
	var randomScalingFactor = function(){ return Math.round(Math.random()*100)};

	var barChartData = {
		labels : ["Jan","Feb","Mar","Apr","Maj","Jun","Jul","Aug","Sept","Okt","Nov","Dec"],
		datasets : [
			{
				fillColor : "rgba(220,220,220,0.5)",
				strokeColor : "rgba(220,220,220,0.8)",
				highlightFill: "rgba(220,220,220,0.75)",
				highlightStroke: "rgba(220,220,220,1)",
				data : [<?=$january;?>,<?=$february;?>,<?=$march;?>,<?=$april;?>,<?=$may;?>,<?=$june;?>,<?=$july;?>,<?=$august;?>,<?=$september;?>,<?=$october;?>,<?=$november;?>,<?=$december;?>]
			}
		]

	}
	window.onload = function(){
		var ctx = document.getElementById("canvas").getContext("2d");
		window.myBar = new Chart(ctx).Bar(barChartData, {
			responsive : true
		});
	}

	</script>

</div>

<hr />

<div class="table-responsive col-md-3">
	
	<h4 style="text-align: center;">Salg</h4>
	
	<div class="number-box">+<?=number_format($sale,2,',','.');?> kr</div>
	
	<div class="number-types col-md-10 col-md-offset-1">
		<table width="100%">
			<tr>
				<td width="50%" align="left">Kontant</td>
				<td align="right"><?=number_format($cash_sold,2,',','.');?></td>
			</tr>
			<tr>
				<td width="50%" align="left">Kort</td>
				<td align="right"><?=number_format($card_sold,2,',','.');?></td>
			</tr>
			<tr>
				<td width="50%" align="left">Mobilepay</td>
				<td align="right"><?=number_format($mobilepay_sold,2,',','.');?></td>
			</tr>
		</table>
	</div>
	
</div>

<div class="table-responsive col-md-3">
	
	<h4 style="text-align: center;">Køb</h4>
	
	<div class="number-box">-<?=number_format($bought,2,',','.');?> kr</div>
	
	
</div>

<div class="table-responsive col-md-3">
	
	<h4 style="text-align: center;">Tilbehør</h4>
	
	<div class="number-box">+<?=number_format($access,2,',','.');?> kr</div>

	
</div>

<div class="table-responsive col-md-3">
	
	<h4 style="text-align: center;">Dele brugt</h4>
	
	<div class="number-box">-<?=number_format($parts,2,',','.');?> kr</div>

	
</div>

<div class="clearfix"></div>
<hr style="margin-top: 50px" />

<div class="table-responsive col-md-6 col-md-offset-3" style="margin-top: 50px">
	
	<h4 style="text-align: center;">Resultat for periode</h4>
	
	<div class="number-box" style="font-size: 50px">= <span class="<?=$type;?>-number"><?=number_format($result,2,',','.');?> kr</span></div>

	
</div>

<div class="clearfix"></div>
<hr style="margin-top: 50px" />

<div class="table-responsive col-md-12" style="margin-top: 30px">
	
	<h4 style="text-align: center; padding-bottom: 30px">Kassebeholdning i periode</h4>
	
	<table class="table table-striped">
	  <thead>
	    <tr>
	      <th>#</th>
	      <th>Dato</th>
	      <th>Kontant</th>
	      <th>Kort</th>
	      <th>Mobilepay</th>
	      <th>Tilbehør</th>
	      <th>Resultat</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php
	  	$this->db->order_by('id','desc');
	  	$this->db->where('boutique_id',$this->session->userdata('active_boutique'));
	  	$this->db->where('type','sold');
	  	$orders = $this->db->get('orders')->result();
	  	
	  	
	  	$cash_orders_total = 0;
		$card_orders_total = 0;
		$mobilepay_orders_total = 0;
		$access_orders_total = 0;
		$total_result_total = 0;
		
	  	// Start date
		$date = $start_date;
		$dateend = strtotime($start_date.' 23:59:59');

		while (strtotime($date) <= strtotime($end_date)) {
			
			// GET CASH
			$this->db->select_sum('price');
			$this->db->where('created_timestamp >=',strtotime($date));
			$this->db->where('created_timestamp <=',strtotime($dateend));
		  	if($this->input->get('boutique')){
				if($this->input->get('boutique') != 'all'){
					$this->db->where('boutique_id',$this->input->get('boutique'));
				}
			}else{
				$this->db->where('boutique_id',$this->session->userdata('active_boutique'));
			}
		  	$this->db->where('type','sold');
		  	$this->db->where('payment_type','cash');
		  	$cash_orders = $this->db->get('orders')->result();

		  	if($cash_orders){
			  	$cash_orders = $cash_orders[0]->price;
		  	}else{
			  	$cash_orders = 0;
		  	}
		  	
		  	
		  	// GET MOBILEPAY
			$this->db->select_sum('price');
			$this->db->where('created_timestamp >=',strtotime($date));
			$this->db->where('created_timestamp <=',strtotime($dateend));
		  	if($this->input->get('boutique')){
				if($this->input->get('boutique') != 'all'){
					$this->db->where('boutique_id',$this->input->get('boutique'));
				}
			}else{
				$this->db->where('boutique_id',$this->session->userdata('active_boutique'));
			}
		  	$this->db->where('type','sold');
		  	$this->db->where('payment_type','mobilepay');
		  	$mobilepay_orders = $this->db->get('orders')->result();

		  	if($mobilepay_orders){
			  	$mobilepay_orders = $mobilepay_orders[0]->price;
		  	}else{
			  	$mobilepay_orders = 0;
		  	}
		  	
		  	// GET CARD
			$this->db->select_sum('price');
			$this->db->where('created_timestamp >=',strtotime($date));
			$this->db->where('created_timestamp <=',strtotime($dateend));
		  	if($this->input->get('boutique')){
				if($this->input->get('boutique') != 'all'){
					$this->db->where('boutique_id',$this->input->get('boutique'));
				}
			}else{
				$this->db->where('boutique_id',$this->session->userdata('active_boutique'));
			}
		  	$this->db->where('type','sold');
		  	$this->db->where('payment_type','card');
		  	$card_orders = $this->db->get('orders')->result();

		  	if($card_orders){
			  	$card_orders = $card_orders[0]->price;
		  	}else{
			  	$card_orders = 0;
		  	}
		  	
		  	
		  	// GET ACCESS
			$this->db->select_sum('price');
			$this->db->where('created_timestamp >=',strtotime($date));
			$this->db->where('created_timestamp <=',strtotime($dateend));
		  	if($this->input->get('boutique')){
				if($this->input->get('boutique') != 'all'){
					$this->db->where('boutique_id',$this->input->get('boutique'));
				}
			}else{
				$this->db->where('boutique_id',$this->session->userdata('active_boutique'));
			}
		  	$this->db->where('type','access');
		  	$access_orders = $this->db->get('orders')->result();

		  	if($access_orders){
			  	$access_orders = $access_orders[0]->price;
		  	}else{
			  	$access_orders = 0;
		  	}
		  	
		  	
		  	$total_result = $cash_orders+$mobilepay_orders+$card_orders+$access_orders;
		  				
			$this->db->order_by('id','desc');
		  	if($this->input->get('boutique')){
				if($this->input->get('boutique') != 'all'){
					$this->db->where('boutique_id',$this->input->get('boutique'));
				}
			}else{
				$this->db->where('boutique_id',$this->session->userdata('active_boutique'));
			}
		  	$this->db->where('date',$date);
		  	$day_results = $this->db->get('day_results')->result();
			
			if($day_results){
			
				$total_result = $total_result+$day_results[0]->cash_boutique+$day_results[0]->card_boutique;
			
				$boutique_cash = $day_results[0]->cash_boutique;
				$boutique_card = $day_results[0]->card_boutique;

			}else{
				$boutique_cash = '';
				$boutique_card = '';
			}
			
			$cash_orders_total += $cash_orders;
			$card_orders_total += $card_orders;
			$mobilepay_orders_total += $mobilepay_orders;
			$access_orders_total += $access_orders;
			$total_result_total += $total_result;
			?>
			<tr>
		      <td>-</td>
		      <td><?=$date;?></td>
		      <td><?=number_format($cash_orders,2,',','.');?></td>
		      <td><?=number_format($card_orders,2,',','.');?></td>
		      <td><?=number_format($mobilepay_orders,2,',','.');?></td>
		      <td><?=number_format($access_orders,2,',','.');?></td>
		      <td><?=number_format($total_result,2,',','.');?></td>
		    </tr>
		    <?php
			$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
			
			$dateend = date ("Y-m-d", strtotime("+1 day 23:59:59", strtotime($date)));
			
		}
	    ?>
	    
	    <tr style="font-weight: bold">
	      <td>-</td>
	      <td>TOTAL</td>
	      <td><?=number_format($cash_orders_total,2,',','.');?></td>
	      <td><?=number_format($card_orders_total,2,',','.');?></td>
	      <td><?=number_format($mobilepay_orders_total,2,',','.');?></td>
	      <td><?=number_format($access_orders_total,2,',','.');?></td>
	      <td><?=number_format($total_result_total,2,',','.');?></td>
	    </tr>
	  </tbody>
	</table>
	
</div>
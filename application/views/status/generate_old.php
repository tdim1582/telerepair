<?php
$info = json_decode($counting[0]->info);

if(isset($info->cashInfo->halvore)){
	if($info->cashInfo->halvore){
		$halvore = $info->cashInfo->halvore/2;
	}else{
		$halvore = 0;
	}
}else{
	$halvore = 0;
}
if(isset($info->cashInfo->enkr)){
	if($info->cashInfo->enkr){
		$enkr    = $info->cashInfo->enkr;
	}else{
		$enkr = 0;
	}
}else{
	$enkr 	 = 0;
}
if(isset($info->cashInfo->tokr)){
	if($info->cashInfo->tokr){
		$tokr 	 = $info->cashInfo->tokr*2;
	}else{
		$tokr = 0;
	}
}else{
	$tokr	 = 0;
}
if(isset($info->cashInfo->femkr)){
	if($info->cashInfo->femkr){
		$femkr   = $info->cashInfo->femkr*5;
	}else{
		$femkr = 0;
	}
}else{
	$femkr   = 0;
}
if(isset($info->cashInfo->tikr)){
	if($info->cashInfo->tikr){
		$tikr    = $info->cashInfo->tikr*10;
	}else{
		$tikr = 0;
	}
}else{
	$tikr    = 0;
}
if(isset($info->cashInfo->tyvekr)){
	if($info->cashInfo->tyvekr){
		$tyvekr  = $info->cashInfo->tyvekr*20;
	}else{
		$tyvekr = 0;
	}
}else{
	$tyvekr  = 0;
}
if(isset($info->cashInfo->halvtredskr)){
	if($info->cashInfo->halvtredskr){
		$halvtredskr = $info->cashInfo->halvtredskr*50;
	}else{
		$halvtredskr = 0;
	}
}else{
	$halvtredskr = 0;
}
if(isset($info->cashInfo->hundkr)){
	if($info->cashInfo->hundkr){
		$hundkr  = $info->cashInfo->hundkr*100;
	}else{
		$hundkr = 0;
	}
}else{
	$hundkr  = 0;
}
if(isset($info->cashInfo->tohundkr)){
	if($info->cashInfo->tohundkr){
		$tohundkr = $info->cashInfo->tohundkr*200;
	}else{
		$tohundkr = 0;
	}
}else{
	$tohundkr = 0;
}
if(isset($info->cashInfo->femhundkr)){
	if($info->cashInfo->femhundkr){
		$femhundkr = $info->cashInfo->femhundkr*500;
	}else{
		$femhundkr = 0;
	}
}else{
	$femhundkr = 0;
}
if(isset($info->cashInfo->tusindkr)){
	if($info->cashInfo->tusindkr){
		$tusindkr  = $info->cashInfo->tusindkr*1000;
	}else{
		$tusindkr = 0;
	}
}else{
	$tusindkr  = 0;
}

$total = $halvore+$enkr+$tokr+$femkr+$tikr+$tyvekr+$halvtredskr+$hundkr+$tohundkr+$femhundkr+$tusindkr;

$ultimo = ($primo_amount+$cash)-$counting[0]->to_bank;

//$total_cash = $ultimo-$total;

$total_cash = ($primo_amount+$cash)-$total;

if(isset($info->cardInfo->dankort)){
	if($info->cardInfo->dankort){
		$dankort = $info->cardInfo->dankort;
	}else{
		$dankort = 0;
	}
}else{
	$dankort = 0;
}
if(isset($info->cardInfo->danskeecmcvi)){
	if($info->cardInfo->danskeecmcvi){
		$danskeecmcvi = $info->cardInfo->danskeecmcvi;
	}else{
		$danskeecmcvi = 0;
	}
}else{
	$danskeecmcvi = 0;
}
if(isset($info->cardInfo->udlexmxvijcb)){
	if($info->cardInfo->udlexmxvijcb){
		$udlexmxvijcb = $info->cardInfo->udlexmxvijcb;
	}else{
		$udlexmxvijcb = 0;
	}
}else{
	$udlexmxvijcb = 0;
}
if(isset($info->cardInfo->gebyr)){
	if($info->cardInfo->gebyr){
		$gebyr = $info->cardInfo->gebyr;
	}else{
		$gebyr = 0;
	}
}else{
	$gebyr = 0;
}

$total_card = ($dankort+$danskeecmcvi+$udlexmxvijcb-$gebyr);

$card_diff = $total_card-$card;


// update ultimo
$string = array(
	'ultimo' => $ultimo
);
$this->db->where('id',$counting[0]->id);
$this->db->update('kasseafstemning',$string);

?>

<h1>
	Kasseafstemning
	<div class="pull-right" style="font-size: 13px; font-weight: normal; margin-top: 15px">
		#<?=$boutique[0]->initial;?><?=$counting[0]->unique_id;?> - <?=$boutique[0]->address;?>, <?=date("d/m/Y",$counting[0]->created_timestamp);?>
	</div>
</h1>

<div class="row">
	
	<div class="col-md-6 col-xs-6">		
		<table class="table">
			
			<tr>
				<td colspan="2" style="padding-bottom: 20px" width="50%"><b>Kontant</b></td>
			</tr>
			
			<tr>
				<td width="50%">Primo beholdning</td>
				<td><?=number_format($primo_amount,2,',','.');?> kr</td>
			</tr>
			
			<tr>
				<td width="50%">Kontant salg</td>
				<td><?=number_format($cash,2,',','.');?> kr</td>
			</tr>
						
			<tr>
				<td width="50%">Til bank</td>
				<td><?=number_format($counting[0]->to_bank,2,',','.');?> kr</td>
			</tr>
			<tr>
				<td>Ultimo beholdning</td>
				<td><?=number_format($ultimo,2,',','.');?> kr</td>
			</tr>
		
		</table>

		<hr />
		
		<b>Optælling</b>
		
		
		<table class="table">
			
			<tr>
				<td></td>
				<td>Antal</td>
				<td>Total</td>
			</tr>
			
			<tr>
				<td width="50%">0,50 kr</td>
				<td><?=$halvore*2;?></td>
				<td><?=number_format($halvore,2,',','.');?> kr</td>
			</tr>
			<tr>
				<td>1 kr</td>
				<td><?=$enkr;?></td>
				<td><?=number_format($enkr,2,',','.');?> kr</td>
			</tr>
			<tr>
				<td>2 kr</td>
				<td><?=$tokr/2;?></td>
				<td><?=number_format($tokr,2,',','.');?> kr</td>
			</tr>
			<tr>
				<td>5 kr</td>
				<td><?=$femkr/5;?></td>
				<td><?=number_format($femkr,2,',','.');?> kr</td>
			</tr>
			<tr>
				<td>10 kr</td>
				<td><?=$tikr/10;?></td>
				<td><?=number_format($tikr,2,',','.');?> kr</td>
			</tr>
			<tr>
				<td>20 kr</td>
				<td><?=$tyvekr/20;?></td>
				<td><?=number_format($tyvekr,2,',','.');?> kr</td>
			</tr>
			<tr>
				<td>50 kr</td>
				<td><?=$halvtredskr/50;?></td>
				<td><?=number_format($halvtredskr,2,',','.');?> kr</td>
			</tr>
			<tr>
				<td>100 kr</td>
				<td><?=$hundkr/100;?></td>
				<td><?=number_format($hundkr,2,',','.');?> kr</td>
			</tr>
			<tr>
				<td>200 kr</td>
				<td><?=$tohundkr/200;?></td>
				<td><?=number_format($tohundkr,2,',','.');?> kr</td>
			</tr>
			<tr>
				<td>500 kr</td>
				<td><?=$femhundkr/500;?></td>
				<td><?=number_format($femhundkr,2,',','.');?> kr</td>
			</tr>
			<tr>
				<td>1.000 kr</td>
				<td><?=$tusindkr/1000;?></td>
				<td><?=number_format($tusindkr,2,',','.');?> kr</td>
			</tr>
			
			<tr>
				<td colspan="2"><b>TOTAL</b></td>
				<td><b><?=number_format($total,2,',','.');?> kr</b></td>
			</tr>
			
			<tr>
				<td colspan="2"><b>Difference</b></td>
				<td><b><?=number_format($total_cash,2,',','.');?> kr</b></td>
			</tr>
		
		</table>
		
		<?php
		$totalexchange = 0;
		
		$this->db->where('created_timestamp >=',$start);
		$this->db->where('created_timestamp <=',$end);
		$this->db->where('exchangeId >',0);
		$this->db->where('hidden',0);
		$this->db->where('boutique_id',$this->session->userdata('active_boutique'));
		$exchangePhones = $this->db->get('orders')->result();
		
		if($exchangePhones){
		?>
		
		<hr />	
		
		<b>Enheder taget i bytte</b>
		
		<table class="table">
			<?php
			$totalexchange = 0;
			foreach($exchangePhones as $exchange):
			?>
			<tr>
				<td>#<?=$exchange->exchangeId;?></td>
				<td>-<?=number_format($exchange->exchangeBoughtPrice,2,',','.');?> kr</td>
			</tr>
			<?php
			$totalexchange += $exchange->exchangeBoughtPrice;
			endforeach;
			?>
			<tr>
				<td><b>TOTAL</b></td>
				<td><b>-<?=number_format($totalexchange,2,',','.');?> kr</b></td>
			</tr>
		</table>
		<?php
		}
			
		$this->db->where('created_timestamp >=',$start);
		$this->db->where('created_timestamp <=',$end);
		$this->db->where('payment_type','invoice');
		$this->db->where('hidden',0);
		$this->db->where('boutique_id',$this->session->userdata('active_boutique'));
		$invoicePhones = $this->db->get('orders')->result();
		
		if($invoicePhones){
		?>
		
		<hr />	
		
		<b>Faktura</b>
		
		<table class="table">
			<?php
			$totalinvoice = 0;
			foreach($invoicePhones as $invoicePhone):
			?>
			<tr>
				<td>#<?=$invoicePhone->id;?></td>
				<td><?=$invoicePhone->company;?></td>
				<td>+<?=number_format($invoicePhone->price,2,',','.');?> kr</td>
			</tr>
			<?php
			$totalinvoice += $invoicePhone->price;
			endforeach;
			?>
			<tr>
				<td colspan="2"><b>TOTAL</b></td>
				<td><b>+<?=number_format($totalinvoice,2,',','.');?> kr</b></td>
			</tr>
		</table>
		<?php
		}
		?>
		
		
		
		<?php
		$totalcredit = 0;
		$totalCreditPhone = 0;
		$totalCreditAccess = 0;
		
		$this->db->where('created_timestamp >=',$start);
		$this->db->where('created_timestamp <=',$end);
		$this->db->where('type','credit');
		$this->db->group_by('creditlineConnectedID');
		$this->db->where('hidden',0);
		$this->db->where('boutique_id',$this->session->userdata('active_boutique'));
		$creditSales = $this->db->get('orders')->result();
		
		if($creditSales){
		?>
		
		<hr />	
		
		<b>Krediterede salg</b>
		
		<table class="table">
			<?php
			$totalcredit = 0;
			$totalCreditPhone = 0;
			$totalCreditAccess = 0;
			foreach($creditSales as $credit):
			
			if($credit->part == false){
				$totalCreditPhone += $credit->price;
			}else{
				$totalCreditAccess += $credit->price;
			}
			?>
			<tr>
				<td>#<?=$credit->creditlineConnectedID;?></td>
				<td>-<?=number_format($credit->price,2,',','.');?> kr</td>
			</tr>
			<?php
			$totalcredit += $credit->price;
			endforeach;
			?>
			<tr>
				<td><b>TOTAL</b></td>
				<td><b>-<?=number_format($totalcredit,2,',','.');?> kr</b></td>
			</tr>
		</table>
		<?php
		}
		?>
		
	</div>
	
	<div class="col-md-6 col-xs-6">

		<table class="table">
			
			<tr>
				<td style="padding-bottom: 20px" width="200px"><b>Kortomsætning</b></td>
				<td style="padding-bottom: 20px"><b><?=number_format($card,2,',','.');?> kr</b></td>
			</tr>
			
			<tr>
				<td width="50%">Dankort</td>
				<td><?=number_format($dankort,2,',','.');?> kr</td>
			</tr>
			<tr>
				<td>Danske EC/MC/VI</td>
				<td><?=number_format($danskeecmcvi,2,',','.');?> kr</td>
			</tr>
			<tr>
				<td>Udl. EC/MC/VI/JCB</td>
				<td><?=number_format($udlexmxvijcb,2,',','.');?> kr</td>
			</tr>
			<tr>
				<td>Gebyr</td>
				<td>-<?=number_format($gebyr,2,',','.');?> kr</td>
			</tr>
			
			<tr>
				<td><b>TOTAL</b></td>
				<td><b><?=number_format($total_card,2,',','.');?> kr</b></td>
			</tr>
			
			<tr>
				<td><b>Difference</b></td>
				<td><b><?=number_format($card_diff,2,',','.');?> kr</b></td>
			</tr>
		
		</table>
		
		
		<table class="table">
			
			<tr>
				<td style="padding-bottom: 0px" width="50%"><b>MobilePay</b></td>
				<td style="padding-bottom: 0px"><b><?=number_format($mobilepay,2,',','.');?> kr</b></td>
			</tr>
						
		</table>
		
				
		<table class="table">
			
			<tr>
				<td style="padding-bottom: 0px" width="50%"><b>Lån</b></td>
				<td style="padding-bottom: 0px"><b><?=number_format($loan,2,',','.');?> kr</b></td>
			</tr>
						
		</table>
		
		<table class="table">
			
			<tr>
				<td style="padding-bottom: 0px" width="50%"><b>Webshop</b></td>
				<td style="padding-bottom: 0px"><b><?=number_format($webshop,2,',','.');?> kr</b></td>
			</tr>
						
		</table>
		
		<table class="table">
			
			<tr>
				<td style="padding-bottom: 0px" width="50%"><b>Nettalk</b></td>
				<td style="padding-bottom: 0px"><b><?=number_format($nettalk,2,',','.');?> kr</b></td>
			</tr>
						
		</table>
		
		
		<br />
		
		<table class="table">
			
			<tr>
				<td style="padding-bottom: 20px; border-bottom: 2px solid #000; color: #4da71a;" width="50%"><b>Total omsætning</b></td>
				<td style="padding-bottom: 20px; border-bottom: 2px solid #000; color: #4da71a;"><b><?=number_format($totalRevenue-$totalexchange,2,',','.');?> kr</b></td>
			</tr>
			
			<tr>
				<td style="padding-bottom: 20px; font-size: 12px" width="50%">Faktura til kunder</td>
				<td style="padding-bottom: 20px; font-size: 12px"><?=number_format($invoice,2,',','.');?> kr</td>
			</tr>

		</table>
		
		
		<br />
		
		<table class="table">
			
			<tr>
				<td style="padding-bottom: 20px" width="50%"><b>Telefonsalg</b></td>
				<td style="padding-bottom: 20px"><b><?=number_format($phoneSale-$totalCreditPhone,2,',','.');?> kr</b></td>
			</tr>
			
			<tr>
				<td style="padding-bottom: 20px" width="200px"><b>Tilbehør</b></td>
				<td style="padding-bottom: 20px"><b><?=number_format($access-$totalCreditAccess,2,',','.');?> kr</b></td>
			</tr>
			
		</table>
		
	</div>
	
	<div class="col-md-6 col-md-offset-6" style="float: right; margin-top: 50px">
		
		<div style="border-bottom: 1px solid #000"></div>
		
		Afstemt af: <?=$user[0]->name;?>
	</div>

</div>
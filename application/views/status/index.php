<div class="modal fade" id="remember_card_counting">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Husk kortafstemning</h4>
      </div>
      <div class="modal-body">
      	<p>Husk at lave dankort afstemning, så du har det klar når du starter med at lave indsætte tallene</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" style="float: left" data-dismiss="modal">Det er modtaget</button>
      </div>
    </div>
  </div>
</div>


<?php
if($counting){
	
	$info = json_decode($counting[0]->info);
	
	if(isset($info->cashInfo->halvore)){
		$halvore = $info->cashInfo->halvore;
	}else{
		$halvore = 0;
	}
	if(isset($info->cashInfo->enkr)){
		$enkr    = $info->cashInfo->enkr;
	}else{
		$enkr = 0;
	}
	if(isset($info->cashInfo->tokr)){
		$tokr 	 = $info->cashInfo->tokr;
	}else{
		$tokr = 0;
	}
	
	if(isset($info->cashInfo->femkr)){
		$femkr   = $info->cashInfo->femkr;
	}else{
		$femkr = 0;
	}
	if(isset($info->cashInfo->tikr)){
		$tikr    = $info->cashInfo->tikr;
	}else{
		$tikr = 0;
	}
	if(isset($info->cashInfo->tyvekr)){
		$tyvekr = $info->cashInfo->tyvekr;
	}else{
		$tyvekr  = 0;
	}
	if(isset($info->cashInfo->halvtredskr)){
		$halvtredskr = $info->cashInfo->halvtredskr;
	}else{
		$halvtredskr = 0;
	}
	if(isset($info->cashInfo->hundkr)){
		$hundkr  = $info->cashInfo->hundkr;
	}else{
		$hundkr = 0;
	}
	if(isset($info->cashInfo->tohundkr)){
		$tohundkr = $info->cashInfo->tohundkr;
	}else{
		$tohundkr = 0;
	}
	if(isset($info->cashInfo->femhundkr)){
		$femhundkr = $info->cashInfo->femhundkr;
	}else{
		$femhundkr = 0;
	}
	if(isset($info->cashInfo->tusindkr)){
		$tusindkr  = $info->cashInfo->tusindkr;
	}else{
		$tusindkr = 0;
	}
		
	$total = $halvore+$enkr+$tokr+$femkr+$tikr+$tyvekr+$halvtredskr+$hundkr+$femhundkr+$tusindkr;
	
	$total_cash = $total-$cash;
	
	if(isset($info->cardInfo->dankort)){
		$dankort = $info->cardInfo->dankort;
	}else{
		$dankort = 0;
	}
	if(isset($info->cardInfo->danskeecmcvi)){
		$danskeecmcvi = $info->cardInfo->danskeecmcvi;
	}else{
		$danskeecmcvi = 0;
	}
	if(isset($info->cardInfo->udlexmxvijcb)){
		$udlexmxvijcb = $info->cardInfo->udlexmxvijcb;
	}else{
		$udlexmxvijcb = 0;	
	}
	if(isset($info->cardInfo->gebyr)){
		$gebyr = $info->cardInfo->gebyr;
	}else{
		$gebyr = 0;
	}
	
	$total_card = ($dankort+$danskeecmcvi+$udlexmxvijcb-$gebyr);
	
	$card_diff = $total_card-$card;
	
	$tobank = $counting[0]->to_bank;
	
}else{
	
	$halvore = 0;
	$enkr    = 0;
	$tokr 	 = 0;
	$femkr   = 0;
	$tikr    = 0;
	$tyvekr  = 0;
	$halvtredskr	= 0;
	$hundkr  		= 0;
	$tohundkr 		= 0;
	$femhundkr 		= 0;
	$tusindkr  		= 0;
	
	$dankort = 0;
	$danskeecmcvi = 0;
	$udlexmxvijcb = 0;
	$gebyr = 0;
	
	$tobank = 0;
	
}
?>

<h1 class="page-header">
	Kasseafstemning for i dag
</h1>

<?=form_open(current_url());?>
<div class="row">
	<div class="col-md-6">
		<div class="table-responsive">
			
			<span style="color: #2e2e2e; font-size: 16px">Dagens registrerede omsætning for <?=$boutique[0]->name;?></span>
			
			<table class="table" style="margin-top: 15px">
			  <tbody>
			  	
			  	<tr>
			  		<td width="200px"><b>Kortomsætning</b></td>
			  		<td><?=number_format($card,2,',','.');?></td>
			  	</tr>
			  	<tr>
			  		<td><b>Kontant</b></td>
			  		<td><?=number_format($cash,2,',','.');?></td>
			  	</tr>
			  	<tr>
			  		<td><b>Mobilepay</b></td>
			  		<td><?=number_format($mobilepay,2,',','.');?></td>
			  	</tr>
			  	<tr>
			  		<td><b>Webshop</b></td>
			  		<td><?=number_format($webshop,2,',','.');?></td>
			  	</tr>
			  	<tr>
			  		<td><b>Lån</b></td>
			  		<td><?=number_format($loan,2,',','.');?></td>
			  	</tr>
			  	<tr>
			  		<td><b>Nettalk</b></td>
			  		<td><?=number_format($nettalk,2,',','.');?></td>
			  	</tr>
			  	<tr>
			  		<td><b>Faktura</b></td>
			  		<td><?=number_format($invoice,2,',','.');?></td>
			  	</tr>
			  	<tr>
			  		<?php
			  		$total = $card+$cash+$mobilepay+$invoice+$loan+$nettalk+$webshop;
			  		?>
			  		<td style="border-top: 1px dashed #2e2e2e; font-size: 20px"><b>TOTAL</b></td>
			  		<td style="border-top: 1px dashed #2e2e2e; font-size: 20px"><b><?=number_format($total,2,',','.');?></b></td>
			  	</tr>
			  	
			  </tbody>
			</table>
			
			<hr />
			
			<span style="color: #2e2e2e; font-size: 16px">Dagens kasseafstemning (kortsalg)</span>
			
			<table class="table" style="margin-top: 15px">
			  <tbody>
			  	
			  	<tr>
			  		<td width="200px"><b>Kortomsætning</b></td>
			  		<td><?=number_format($card,2,',','.');?></td>
			  	</tr>
			  	<tr>
			  		<td><b>Dankort</b></td>
			  		<td>
			  			<div class="form-group has-feedback" style="margin-bottom: 0px">
						  <input type="text" class="form-control manuelDankort calculate_diff" name="dankort" value="<?=$dankort;?>" />
						  <span class="glyphicon glyphicon-ok form-control-feedback" style="display: none" aria-hidden="true"></span>
						</div>
			  		</td>
			  	</tr>
			  	<tr>
			  		<td><b>Danske EC/MC/VI</b></td>
			  		<td>
			  			<div class="form-group has-feedback" style="margin-bottom: 0px">
						  <input type="text" class="form-control manuelDanskeECMCVI calculate_diff" name="danskeecmcvi" value="<?=$danskeecmcvi;?>" />
						  <span class="glyphicon glyphicon-ok form-control-feedback" style="display: none" aria-hidden="true"></span>
						</div>
			  		</td>
			  	</tr>
			  	<tr>
			  		<td><b>Udl. EC/MC/VI/JCB</b></td>
			  		<td>			  		
			  			<div class="form-group has-feedback" style="margin-bottom: 0px">
						  <input type="text" class="form-control manuelECMCVIJBC calculate_diff" name="udlexmxvijcb" value="<?=$udlexmxvijcb;?>" />
						  <span class="glyphicon glyphicon-ok form-control-feedback" style="display: none" aria-hidden="true"></span>
						</div>
			  		</td>
			  	</tr>
			  	<tr>
			  		<td><b>Gebyr</b></td>
			  		<td>
			  			<div class="form-group has-feedback" style="margin-bottom: 0px">
						  <input type="text" class="form-control manuelGebyr calculate_diff" name="gebyr" value="<?=$gebyr;?>" />
						  <span class="glyphicon glyphicon-ok form-control-feedback" style="display: none" aria-hidden="true"></span>
						</div>
			  		</td>
			  	</tr>
			  	
			  </tbody>
			</table>
			
			<label>Til bank <small style="font-weight: normal">(overført beløb til bank)</small></label>
			<input type="text" class="form-control" placeholder="" value="<?=$tobank;?>" name="to_bank" />
			
			<hr />
			
			<?php
			if($counting):
			if (strpos($rank_permissions,'status_edit') !== false || strpos($rank_permissions,'all') !== false) {
			?>
			<input type="hidden" name="id" value="<?=$this->uri->segment(3);?>" />
			<input type="submit" class="btn btn-success" name="edit" value="Gem" />
			<?php
			}else{
			?>
			<input type="submit" class="btn btn-default disabled" name="create" value="Du har allerede afstemt denne kasse i dag" />
			<?php
			}
			else:
			?>
			<input type="hidden" name="date" value="<?=$date;?>" />
			<?php
			$boutique_id = $this->session->userdata('active_boutique');
			$users = $this->db->get('users_kasse')->result();
			
			$emails = "";
			$key = 0;
			foreach ($users as $user) {
				$user_email_stores = " ".$user->raport_email_boutiques.",";
				if (strpos($user_email_stores," ".$boutique_id.",") !== false) {
					if ($key == 0) {
						$emails .= $user->email;
					} else {
						$emails .= ',' . $user->email;
					}
					$key += 1;
				}
			}

			?>
			<input type="hidden" id="raport_emails" name="raport_emails" value="<?=$emails?>" />
			<input type="submit" class="btn btn-success confirm" name="create" value="Gem" />
			<?php
			endif;
			?>
			
		</div>
	</div>
	
	<div class="col-md-5 col-md-offset-1">
		<b>Tidligere afstemninger</b>
		<hr style="margin-top: 10px; margin-bottom: 10px;" />
		<table>
			<tr>
				<td><b>#</b></td>
				<td><b>Dato</b></td>
				<td></td>
			</tr>
			<?php
			$this->db->order_by('id','desc');
			$this->db->where('boutique_id',$this->session->userdata('active_boutique'));
			$countinfo = $this->db->get('kasseafstemning')->result();
			foreach($countinfo as $count):
			?>
			<tr>
				<td width="140px"><a href="<?=site_url('status/generate/'.$count->id);?>">#<?=$boutique[0]->initial;?><?=$count->unique_id;?></a></td>
				<td width="200px"><a href="<?=site_url('status/generate/'.$count->id);?>"><?=date("d/m/Y",$count->created_timestamp);?></a></td>
				<?php
				if (strpos($rank_permissions,'status_edit') !== false || strpos($rank_permissions,'all') !== false) {
				?>
				<td><a href="<?=site_url('status/index/'.$count->id);?>">Rediger</a></td>
				<?php
				}
				?>
			</tr>
			<?php
			endforeach;
			?>
			
		</table>
		
	</div>
	
</div>

<input type="hidden" class="kasseKort" value="<?=$card;?>" />
<input type="hidden" class="kasseKontant" value="<?=$cash+$primo_amount;?>" />

<input type="hidden" class="rememberCardReminder" value="1" />

<?=form_close();?>

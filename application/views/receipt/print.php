
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Kvittering</title>
    <meta name="description" content="">
    <meta name="author" content="">

	<style type="text/css">
		body{
			font-family: arial, sans-serif;
			font-size: 16px;
		}

	</style>

	<script type="text/javascript">
	window.print();
	</script>

  </head>

  <body>

	  <div style="width: 220px; padding: 0px">

	  	<center><img src="<?=base_url();?>assets/images/logo-telerepair.png" width="150px" /></center>
	  	<!-- <center><img src="<?=base_url();?>assets/images/logo-green.png" width="150px" /></center> -->

	  	<center style="font-size: 11px; margin-top: 15px">
	  		<?=nl2br($address);?> <br />
	  		<?=nl2br($tlcvremail);?>
	  	</center>

	  	<div style="width: 100px; float: left; margin-top: 25px; font-size: 11px">
	  		<?=date("d/m/Y H:i",$receipt[0]->created_timestamp);?>
	  	</div>

	  	<div style="width: 100px; text-align: right; float: right; margin-top: 25px; font-size: 11px">
	  		Ordrenr: <?=$receipt[0]->id;?>
	  	</div>

	  	<h1 style="font-size: 17px; margin-top: 70px; margin-bottom: 30px"><center>Indleverings kvittering</center></h1>

	  	<table>
	  		<tr>
	  			<td width="130px" style="font-size: 12px"><b>Navn</b></td>
	  			<td style="font-size: 12px"><?=$receipt[0]->name;?></td>
	  		</tr>
	  		<?php if($receipt[0]->phone) { ?>
			<tr>
	  			<td style="font-size: 12px"><b>Email</b></td>
	  			<td style="font-size: 12px"><?=$receipt[0]->email;?></td>
	  		</tr>
			<?php } ?>
	  		<tr>
	  			<td style="font-size: 12px"><b>Telefonnr</b></td>
	  			<td style="font-size: 12px"><?=$receipt[0]->phone;?></td>
	  		</tr>

	  		<tr>
	  			<td style="font-size: 12px"><b>Kode</b></td>
	  			<td style="font-size: 12px"><?=$receipt[0]->phone_code;?></td>
	  		</tr>

	  		<tr>
	  			<td style="font-size: 12px"><b>Pin kode</b></td>
	  			<td style="font-size: 12px"><?=$receipt[0]->pin;?></td>
	  		</tr>

	  		<tr>
	  			<td style="font-size: 12px"><b>Afhentnings tidspunkt</b></td>
	  			<td style="font-size: 12px"><?=$receipt[0]->pickup_time;?></td>
	  		</tr>
			
			<tr>
	  			<td style="font-size: 12px"><b>Enhed</b></td>
	  			<td style="font-size: 12px"><?=$receipt[0]->product_name;?></td>
	  		</tr>

	  		<?php
	  		if($receipt[0]->description){
	  		?>
	  		<tr>
	  			<td style="font-size: 12px"><b>Note</b></td>
	  			<td style="font-size: 12px"><?=$receipt[0]->description;?></td>
	  		</tr>
	  		<?php
	  		}
	  		?>


	  	</table>

	  	<!----- ----->

	  	<?php
	  	$total_price = 0;

	  	if($repairs){

	  	?>

	  	<table cellpadding="0" cellspacing="0" width="100%" style="margin-top: 30px;">
	  		<tr>
	  			<th align="left" width="140px" style="border-left: 2px solid #2e2e2e; padding: 5px; font-size: 13px; border-top: 2px solid #2e2e2e; border-bottom: 2px solid #2e2e2e;">Beskrivelse</th>
	  			<!--<th align="left"  style="border: 3px solid #2e2e2e; padding: 5px; font-size: 14px;">Antal</th>-->
	  			<th align="left"  style="border-right: 2px solid #2e2e2e; border-left: 2px solid #2e2e2e; padding: 5px; font-size: 13px; border-top: 2px solid #2e2e2e; border-bottom: 2px solid #2e2e2e;">Pris</th>
	  		</tr>

	  		<?php
	  		foreach($repairs as $repair){

	  		$total_price +=  $repair->price;
		  	?>

	  		<tr>
	  			<td width="90px" style="font-size: 12px; padding: 5px"><?=$repair->name;?></td>
	  			<td style="font-size: 12px; padding: 5px"><?=$repair->price;?></td>
	  		</tr>

	  		<?php
	  		}
		  	?>

	  		
        <?php if($receipt[0]->discount > 0){ ?>
		<tr>
	  			<td width="90px" style="font-size: 12px; padding: 5px; border-top: 2px solid #2e2e2e">Subtotal</td>
	  			<td style="font-size: 12px; padding: 5px; border-top: 2px solid #2e2e2e"><?=$total_price;?> kr</td>
	  		</tr>
        <tr>
	  			<td width="90px" style="font-size: 12px; padding: 5px; ">Rabat</td>
	  			<td style="font-size: 12px; padding: 5px; ">
            (<?=$receipt[0]->discount;?> %)
            <span>-<?=$receipt[0]->discount_amount;?> kr</span>
          </td>
	  		</tr>
        

        <tr>
	  			<td width="90px" style="font-size: 12px; padding: 5px; border-top: 2px solid #2e2e2e">Total (Inkl. moms)</td>
	  			<td style="font-size: 12px; padding: 5px; border-top: 2px solid #2e2e2e"><?=$receipt[0]->total_after_discount;?> kr</td>
	  		</tr>
			  <?php } else { ?>
				<td width="90px" style="font-size: 12px; padding: 5px; border-top: 2px solid #2e2e2e">Total (Inkl. moms)</td>
	  			<td style="font-size: 12px; padding: 5px; border-top: 2px solid #2e2e2e"><?=$total_price;?> kr</td>
			<?php }?>
			  
	  	</table>

	  	<?php
	  	}
	  	?>

	  	<div style="font-size: 13px; margin-top: 20px">
	  		<b>
			<?php if($receipt[0]->paid == 0){ echo 'Ikke betalt'; }else { echo 'Betalt'; } ?>,
			<?php if($receipt[0]->delivered == 0){ echo 'Ikke udleveret'; }else { echo 'Udleveret'; } ?>
			</b>
	  	</div>
	  	
	  	
	  	<?php if($receipt[0]->no_test == 1){ echo '<div style="font-size: 13px; font-style: italic; margin-top: 20px"><strong>'.$warranty.'</strong></div>'; }?>
	  	
	  	<div style="font-size: 13px; margin-top: 20px">På gensyn</div>

	  </div>

  </body>
</html>

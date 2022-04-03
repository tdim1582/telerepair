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
	  		<?=$address;?> <br />
	  		<?=nl2br($tlfcvrinfo);?>
	  	</center>

	  	<div style="width: 100px; float: left; margin-top: 25px; font-size: 11px">
	  		<?=date("d/m/Y H:i",$phone[0]->created_timestamp);?>
	  	</div>

	  	<div style="width: 100px; text-align: right; float: right; margin-top: 25px; font-size: 11px">
	  		Ordrenr: <?=$initial;?><?=$phone[0]->id;?>
	  		<?php
	  		if($phone[0]->webshop_id){
	  		?>
	  		<br />
	  		Web ordrenr: #<?=$phone[0]->webshop_id;?>
	  		<?php
	  		}
	  		?>
	  	</div>

	  	<?php
	  	if($type == 'access'){

	  	$total = $phone[0]->price;

	  	?>

	  	<h1 style="font-size: 17px; margin-top: 70px; margin-bottom: 30px"><center>Tilbehørs kvittering</center></h1>

	  	<table style="width:220px">



	  		<tr>
	  			<td style="font-size: 12px"><?=$phone[0]->product;?></td>
	  		</tr>

	  		<tr>
	  			<td style="font-size: 12px" width="60px"><?=$phone[0]->part;?></td>
	  			<td style="font-size: 12px" width="30px">1</td>
	  			<td style="font-size: 12px"><?=number_format($phone[0]->price,0,',','.');?> kr</td>
	  		</tr>

	  		<?php
	  		$this->db->where('extra_access_to_order_id',$phone[0]->id);
	  		$extra_access_to_note = $this->db->get('orders')->result();

	  		foreach($extra_access_to_note as $extra):
	  		?>
	  		<tr>
	  			<td width="130px" colspan="3" style="font-size: 12px;  padding: 10px 0px;"><div style="border-bottom: 1px dashed #2e2e2e;"></div></td>
	  		</tr>
	  		<tr>
	  			<td style="font-size: 12px"><?=$extra->product;?></td>
	  		</tr>

	  		<tr>
	  			<td style="font-size: 12px" width="100px"><?=$extra->part;?></td>
	  			<td style="font-size: 12px" width="30px">1</td>
	  			<td style="font-size: 12px"><?=number_format($extra->price,0,',','.');?> kr</td>
	  		</tr>
	  		<?php
	  		$total += $extra->price;

	  		endforeach;
	  		?>

	  		<tr>
	  			<td width="130px" colspan="3" style="font-size: 12px;  padding: 10px 0px;"><div style="border-bottom: 1px solid #2e2e2e;"></div></td>
	  		</tr>

			<tr>
	  			<td style="font-size: 12px" width="100px">Subtotal</td>
	  			<td style="font-size: 12px" width="30px"></td>
	  			<td style="font-size: 12px; text-align: right;"><?=number_format($phone[0]->subtotal,0,',','.');?> kr</td>
	  		</tr>
			<?php if($phone[0]->discount){ ?>
			<tr>
	  			<td style="font-size: 12px" width="100px">Rabat</td>
	  			<td style="font-size: 12px" width="30px"><?php echo $phone[0]->discount;?>%</td>
	  			<td style="font-size: 12px; text-align: right;">-<?=number_format(($phone[0]->discount*$phone[0]->subtotal)/100,0,',','.');?> kr</td>
	  		</tr>
	  		<?php } ?>


	  		<tr style="font-weight: bold">
	  			<td style="font-size: 12px; padding-top:10px;" width="100px"><b>Total</b></td>
	  			<td style="font-size: 12px; padding-top:10px;" width="30px"></td>
	  			<td style="font-size: 12px; text-align: right; padding-top:10px;"><?=number_format($total,0,',','.');?> kr</td>
	  		</tr>

	  		<tr>
	  			<td style="font-size: 12px" colspan="3">Priserne er inkl. moms</td>
	  		</tr>


	  	</table>
	  	<?php
	    }elseif($type == 'sale'){
	  	?>

	  	<h1 style="font-size: 17px; margin-top: 70px; margin-bottom: 30px"><center>Salgskvittering</center></h1>
      <?php if($phone[0]->show_name){ ?>
        <div style="font-size:12px;margin-bottom: 20px;">
          <strong>Kunde:</strong><br />
          <?php echo $phone[0]->name; ?> <br />
          <?php if($phone[0]->company){ ?><?php echo $phone[0]->company; ?> <br /><?php } ?>
          <?php if($phone[0]->cvr){ ?>CVR: <?php echo $phone[0]->cvr; ?> <br /><?php } ?>
          <?php if($phone[0]->email){ ?><?php echo $phone[0]->email; ?> <br /><?php } ?>
        </div>
      <?php } ?>
	  	<table style="width:220px">
	  		<?php
	  		if(!$phone[0]->show_name && $phone[0]->company):
	  		?>
	  		<tr>
	  			<td width="120px" style="font-size: 12px"><b>Firma</b></td>
	  			<td style="font-size: 12px"><?=$phone[0]->company;?></td>
	  		</tr>
	  		<?php
	  		endif;
	  		?>
	  		<tr>
	  			<td width="120px" style="font-size: 12px"><b>Telefon</b></td>
	  			<td style="font-size: 12px"><?=$phone[0]->product;?></td>
	  		</tr>

	  		<tr>
	  			<td style="font-size: 12px"><b>GB</b></td>
	  			<td style="font-size: 12px"><?=$phone[0]->gb;?></td>
	  		</tr>

	  		<tr>
	  			<td style="font-size: 12px"><b>Farve</b></td>
	  			<td style="font-size: 12px"><?=ucfirst($phone[0]->color);?></td>
	  		</tr>

	  		<tr>
	  			<td style="font-size: 12px" valign="top"><b>Forsikring</b></td>
	  			<td style="font-size: 12px"><?php if($phone[0]->insurance): echo 'Ja (+'.number_format($phone[0]->insurance_price,2,',','.').' kr, '.$phone[0]->insurance_years.' år)'; else: echo 'Nej'; endif; ?></td>
	  		</tr>

	  		<tr>
	  			<td style="font-size: 12px"><b>Salgspris</b></td>
	  			<td style="font-size: 12px"><?=number_format($phone[0]->price,2,',','.');?> kr</td>
	  		</tr>

	  		<tr>
	  			<td style="font-size: 12px"><b>IMEI</b></td>
	  			<td style="font-size: 12px"><?=$phone[0]->imei;?></td>
	  		</tr>

	  		<?php
	  		if($phone[0]->exchangeId):

	  		$exchangePrice = (int)$phone[0]->price-(int)$phone[0]->exchangeBoughtPrice;

	  		?>
	  		<tr>
	  			<td style="font-size: 12px"><b>Enhed i bytte #<?=$phone[0]->exchangeId;?></b></td>
	  			<td style="font-size: 12px">-<?=$phone[0]->exchangeBoughtPrice;?></td>
	  		</tr>
	  		<tr>
	  			<td style="font-size: 12px; border-top: 1px solid #2e2e2e"><b>Total til betaling</b></td>
	  			<td style="font-size: 12px; border-top: 1px solid #2e2e2e"><b><?=number_format($exchangePrice,2,',','.');?></b></td>
	  		</tr>
	  		<?php
	  		endif;
	  		?>
	  		<tr>
	  			<td style="font-size: 12px; padding-top: 20px;" colspan="2"><b><i>Der ydes 24 måneders reklamationsret</i></b></td>
	  		</tr>

	  		<tr>
	  			<td width="100px" style="font-size: 12px" colspan="2">Solgt via brugtmomsordningen</td>
	  		</tr>

	  		<tr>
	  			<td width="100px" style="font-size: 11px; margin-top: 20px" colspan="2">Fortjenstmargenordning - brugte genstande - køber har ikke fradrag for momsen</td>
	  		</tr>


	  	</table>
	  	<?php
	  	}else{
	  	?>
	  	<h1 style="font-size: 17px; margin-top: 70px; margin-bottom: 30px"><center>Købskvittering</center></h1>

	  	<table style="width:220px">
	  		<?php
	  		if($phone[0]->company):
	  		?>
	  		<tr>
	  			<td width="130px" style="font-size: 12px"><b>Firma</b></td>
	  			<td style="font-size: 12px"><?=$phone[0]->company;?></td>
	  		</tr>
	  		<?php
	  		endif;
	  		?>
	  		<tr>
	  			<td width="130px" style="font-size: 12px"><b>Navn</b></td>
	  			<td style="font-size: 12px"><?=$phone[0]->name;?></td>
	  		</tr>

	  		<tr>
	  			<td width="130px" style="font-size: 12px"><b>Email</b></td>
	  			<td style="font-size: 12px"><?=$phone[0]->seller_email;?></td>
	  		</tr>

	  		<tr>
	  			<td width="130px" style="font-size: 12px"><b>Nummer</b></td>
	  			<td style="font-size: 12px"><?=$phone[0]->number;?></td>
	  		</tr>

	  		<tr>
	  			<td width="130px" style="font-size: 12px"><b>Købspris</b></td>
	  			<td style="font-size: 12px"><?=number_format($phone[0]->price,2,',','.');?> kr</td>
	  		</tr>

	  		<tr>
	  			<td width="130px" style="font-size: 12px"><b>Kørekort nummer</b></td>
	  			<td style="font-size: 12px"><?=$phone[0]->seller_id;?></td>
	  		</tr>
	  		<tr>
	  			<td width="130px" style="font-size: 12px"><b>Telefon</b></td>
	  			<td style="font-size: 12px"><?=$phone[0]->product;?></td>
	  		</tr>

	  		<tr>
	  			<td style="font-size: 12px"><b>GB</b></td>
	  			<td style="font-size: 12px"><?=$phone[0]->gb;?></td>
	  		</tr>
	  		<tr>
	  			<td style="font-size: 12px"><b>Farve</b></td>
	  			<td style="font-size: 12px"><?=$phone[0]->color;?></td>
	  		</tr>

	  		<tr>
	  			<td style="font-size: 12px"><b>IMEI</b></td>
	  			<td style="font-size: 12px"><?=$phone[0]->imei;?></td>
	  		</tr>

	  		<?php
	  		if($phone[0]->errors){
	  		?>
	  		<tr>
	  			<td style="font-size: 12px" colspan="2"><b>Note</b></td>
	  		</tr>
	  		<tr>
	  			<td style="font-size: 12px" colspan="2"><?=$phone[0]->errors;?></td>
	  		</tr>
	  		<?php
	  		}
	  		?>

	  		<tr>
	  			<td style="font-size: 12px; padding-top: 30px" colspan="2"><b>____________________________</b></td>
	  		</tr>
	  		<tr>
	  			<td style="font-size: 11px" colspan="2">Jeg bekræfter alle oplysninger er troværdige</td>
	  		</tr>

	  	</table>


	  	<?php
	  	}
	  	?>
	  	<!----- ----->

      <?php if($type == 'access'){ ?>

      <div style="font-size: 12px;padding-left: 3px;">
        <?php if($phone[0]->garanti == 2){ ?>
         <br /> Ingen reklamationsret på enheden - den er vandskadet
        <?php } ?>
      </div>
	  
	  <?php if($phone[0]->comment){ ?>
		<div style="margin-top: 10px;"><strong>Note</strong><br /><?php echo $phone[0]->comment; ?></div>
	  <?php } ?>
    <?php } ?>
	  	<div style="font-size: 13px; margin-top: 20px">På gensyn</div>

	  </div>

  </body>
</html>

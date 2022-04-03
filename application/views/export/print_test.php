
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Købsbevis</title>
    <meta name="description" content="">
    <meta name="author" content="">
	
	<style type="text/css">
		body{
			font-family: arial, sans-serif;
			font-size: 16px;
		}
		
		.check{
			color: #94bc20;
			font-size: 18px;
		}
		
		.print_text{
			color: #a9a9a9;
			font-size: 11px;
		}
		
		.test_device_list tr td{
			padding-bottom: 15px;
		}

	</style>
	
	<link rel="stylesheet" href="<?=base_url();?>assets/css/bootstrap.css">
	
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	
	<script type="text/javascript">
	window.print();
	</script>
	
  </head>

  <body style="width: 950px; margin: auto">
	<h1 class="page-header">
		Købsbevis
	</h1>
	
	<div class="pull-right"><img src="<?=base_url();?>assets/images/logo_bi.jpg" style="margin-top: -150px" width="150px" /></div>
	
	<table width="350px">
		<tr>
			<td>Tekniker</td>
			<td width=""><?=$user[0]->name;?></td>
		</tr>
		<tr>
			<td>Enhed</td>
			<td><?=$order->product;?></td>
		</tr>
		<tr>
			<td>GB</td>
			<td><?=$order->gb;?></td>
		</tr>
		<tr>
			<td>IMEI</td>
			<td><?=$order->imei;?></td>
		</tr>
	</table>
		
	
	<table class="test_device_list " width="100%" style="margin-top: 30px">
		<tr>
			<td width="20px">
				<i class="fa fa-check-circle check"></i>
			</td>
			<td>Signal test</td>
			
			<td width="20px">
				<i class="fa fa-check-circle check"></i>
			</td>
			<td>LCD test</td>
			
			<td width="20px">
				<i class="fa fa-check-circle check"></i>
			</td>
			<td>Mikrofon test</td>
		</tr>
		<tr>
			<td width="20px">
				<i class="fa fa-check-circle check"></i>
			</td>
			<td>WiFi test</td>
			
			<td width="20px">
				<i class="fa fa-check-circle check"></i>
			</td>
			<td>Ørehøjtaler test</td>
			
			<td width="20px">
				<i class="fa fa-check-circle check"></i>
			</td>
			<td>Test af knapper</td>
		</tr>
		<tr>
			<td width="20px">
				<i class="fa fa-check-circle check"></i>
			</td>
			<td>Skærm test</td>
			
			<td width="20px">
				<i class="fa fa-check-circle check"></i>
			</td>
			<td>Højtaler test</td>
			
			<td width="20px">
				<i class="fa fa-check-circle check"></i>
			</td>
			<td>Lade test</td>
		</tr>
		<tr>
			<td width="20px">
				<i class="fa fa-check-circle check"></i>
			</td>
			<td>Tænd/sluk knap test</td>
			
			<td width="20px">
				<i class="fa fa-check-circle check"></i>
			</td>
			<td>Vibration test</td>
			
			<td width="20px">
				<i class="fa fa-check-circle check"></i>
			</td>
			<td>Front kamera test</td>
		</tr>
		<tr>
			<td width="20px">
				<i class="fa fa-check-circle check"></i>
			</td>
			<td>Bag kamera test</td>
			
			<td width="20px">
				<i class="fa fa-check-circle check"></i>
			</td>
			<td>Proximity sensor test</td>
			
			<td width="20px">
				<i class="fa fa-check-circle check"></i>
			</td>
			<td>Lyd test</td>
		</tr>
		<tr>
			<td width="20px">
				<?php
				if($test[0]->touchid):
				?>
				<i class="fa fa-check-circle check"></i>
				<?php
				endif;
				?>
			</td>
			<td>Touch-ID test</td>
			
			<td width="20px">
				<i class="fa fa-check-circle check"></i>
			</td>
			<td>Sim skuffe tjek</td>
			
			<td width="20px">
				<i class="fa fa-check-circle check"></i>
			</td>
			<td>Skrue tjek</td>
		</tr>
		
		<tr>
			<td width="20px" valign="top">
				<i class="fa fa-check-circle check"></i>
			</td>
			<td colspan="7">
				Batteri test
				<div class="clearfix"></div>
				<br />
				<table class="table table-bordered" style="padding-top: 15px; width: 600px">
					<tr>
						<td width="150px">Battery Cycles</td>
						<td width="300px">
							<?=$test[0]->battery_cycles;?>
						</td>
					</tr>
					<tr>
						<td>Battery DesignCapacity</td>
						<td>
							<?=$test[0]->battery_design;?>
						</td>
					</tr>
					<tr>
						<td>Battery FullChargeCapacity</td>
						<td>
							<?=$test[0]->battery_fullcharge;?>
						</td>
					</tr>
				</table>
				
			</td>
		</tr>
		
		<tr>
			<td width="20px"><i class="fa fa-check-circle check"></i></td>
			<td colspan="6">Nulstillet og klar til salg</td>
			
		</tr>
		
		
	</table>
	
	<br />
	
	<p><?=$boutique[0]->name;?>, <?=date("d/m/Y",$test[0]->created_timestamp);?></p>
	
	<hr />
	
	<p class="print_text">
	
		Når du handler på 2ndBest har du selvfølgelig 24 måneders reklamationsret. Det betyder, at du enten kan få varen repareret, ombyttet, pengene tilbage eller afslag i prisen, afhængig af den specifikke situation.
Det vil være i følgende rækkefølge:<br />
Reparation af enheden - Her har vi retten til at reparere enheden for samme fejl 3 gange.<br />
Enheden bliver ombyttet hvis samme fejl ikke kan udbedres efter 3 gange<br />
Hvis den ombyttede enhed ikke lever op til forventningerne, og der er problemer med den, har kunden ret til at få pengene tilbage inden for den første måned af købet. Herefter vil det kun være muligt at få ombyttet telefonen til en anden.
 <br /><br />
Det er selvfølgelig et krav, at reklamationen er berettiget, og at manglen ikke er opstået som følge af en fejlagtig brug af produktet eller anden skadeforvoldende adfærd. Eventuelle fejl eller mangler ved køb, salg eller reparation hos 2ndBest skal informeres til os indenfor rimelig tid efter, at du har opdaget fejlen. Det er kundens pligt at angive og så vidt muligt vise, hvordan fejlen eller manglen opstår.<br />
For varer med begrænset holdbarhed, er din klagemulighed afgrænset af den holdbarhedsperiode, 2ndBest har stillet dig i udsigt. Du kan som forbruger vælge om varen skal repareres eller byttes. Ved reparationer bliver fejlen dog kun udbedret i form af en ny reservedel. Returnering af købsbeløbet er normalt IKKE en mulighed ved reklamation. Undtagelsen til denne hovedregel er, hvis ombytning eller reparation er en umulighed eller vil medføre uforholdsmæssige store omkostninger for 2ndBest. Vi bestræber os på, at behandle reklamationer inden for 24 timer efter modtagelse af varen, men under visse omstædnigheder kan det tage længere tid.<br />
Vi refunderer IKKE rimelige fragtomkostninger<br />
Reklamationer skal sendes til:
<br /><br />
2ndBest ApS<br />
Østerbrogade 140<br />
2100 København Ø<br />
Telefon: 70 60 59 60<br />
Mail: info@2ndBest
	
	</p>
	
	</body>
</html>
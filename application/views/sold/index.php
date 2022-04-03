<?php
if($this->input->get('open_receipt')):
?>
<script type="text/javascript">
var win = window.open('<?=site_url();?>export/print_/<?=$this->input->get('open_receipt');?>', '_blank');
win.focus();

top.location.href = '<?=site_url('sold');?>';
</script>
<?php
endif;
?>


<div class="modal fade" id="buy_device">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Sælg enhed</h4>
      </div>
      <div class="modal-body">
        <?php
        $array = array(
        	'id' => 'getDeviceInfo'
        );
        ?>
        <?=form_open('',$array);?>
        <div class="row">

	        <div class="col-md-12">
		        <label>Udfyld ID</label>
		        <input type="text" class="form-control orderid" name="bought_id" required style="margin-bottom: 10px" />
	        </div>

	        <hr />

	        <div class="col-md-12">
	        	<input type="hidden" name="alreadyTested" value="0" />
	        	<input type="submit" class="btn btn-info" name="create_user" value="Hent informationer" style="margin-top: 20px" />
	        </div>

        </div>
        <?=form_close();?>

        <div class="loader_order" style="display: none">
	        <hr />
	        <center><img src="<?=base_url();?>assets/images/loader.gif" /></center>
        </div>

        <div class="no_order_found" style="font-size: 18px; display: none; font-weight: bold; text-align: center;">Ordren blev ikke fundet</div>
        <div class="no_test_found" style="font-size: 18px; display: none; font-weight: bold; text-align: center;">Test er ikke udført</div>
        <div class="already_tested_admin" style="font-size: 18px; display: none; font-weight: bold; text-align: center;"><a href="#" class="alreadyTestedAdmin">Allerede testet - klik her</a></div>
        <div class="already_sold" style="font-size: 18px; display: none; font-weight: bold; text-align: center;">Denne enhed er allerede solgt</div>

        <?=form_open(current_url());?>
        <div class="row sell_unit" style="display: none">
	        <div class="col-md-6">
		        <label>Model</label>
		        <select class="form-control" disabled="true" id="devices" name="model" required style="margin-bottom: 10px">
		        	<option value="">-</option>
		        	<?php
		        	foreach($products as $product):
		        	?>
		        	<option value="<?=$product->id;?>"><?=$product->name;?></option>
		        	<?php
		        	endforeach;
		        	?>
		        </select>
	        </div>

	        <div class="col-md-6">
		        <label>GB</label>
		        <select class="form-control" disabled="true" id="gbs" name="gb" required style="margin-bottom: 10px">
		        	<option value="">-</option>
		        	<?php
		        	foreach($gbs_list as $gbview):
		        	?>
		        	<option value="<?=$gbview->id;?>" class="<?=$gbview->product_id;?>"><?=$gbview->name;?></option>
		        	<?php
		        	endforeach;
		        	?>
		        </select>
	        </div>

	        <div class="col-md-6">
		        <label>IMEI</label>
		        <input type="text" disabled="true" class="form-control" name="imei" required style="margin-bottom: 10px" />
	        </div>
	        <div class="col-md-6">
		        <label>Farve</label>
		        <input type="text" disabled="true" class="form-control" name="color" required style="margin-bottom: 10px" />
	        </div>

	        <div class="col-md-12">
		        <label>Stand</label>
		        <select class="form-control calculateSoldPriceBasedOnValues" required name="condition">
		        	<option value="">-</option>
		        	<option value="2">Lettere brugt</option>
		        	<option value="1">Helt ny</option>
		        </select>

		        <input type="hidden" class="order_device_info_hidden" value="" />
	        </div>

	        <div class="clearfix"></div>
	        <hr />
          <div class="col-md-12">
              <label><input type="checkbox" class="show_name" value="1" name="show_name" /> Navn på kvittering?</label>

          </div>
          <div style="display:none" class="name_checked">
            <div class="col-md-6">
                <label>Navn</label>
                <input type="text"  class="form-control" name="buyer_name" style="margin-bottom: 10px" />
            </div>
            <div class="col-md-6">
                <label>E-mail</label> <input type="checkbox" value="1" name="send_email" />
                <input type="text"  class="form-control" name="email" style="margin-bottom: 10px" />
            </div>
            <div class="col-md-6">
                <label>Evt. firma navn</label>
                <input type="text"  class="form-control" name="company_name" style="margin-bottom: 10px" />
            </div>
            <div class="col-md-6">
                <label>CVR nummer</label>
                <input type="text"  class="form-control" name="cvr" style="margin-bottom: 10px" />
            </div>
          </div>
          <div class="col-md-12">
            <hr />
          </div>
			<div class="col-md-12">

		        <label>Betalingsmetode</label>
		        <?php
	        	if (strpos($rank_permissions,'hidden_btn') !== false || strpos($rank_permissions,'all') !== false) {
	        	?>
				<div style="float: right; display: none" class="hidden_checkboks"><input type="checkbox" name="hidden" value="1" /></div>
				<?php
				}
				?>
				<select class="form-control" name="payment_type" required style="margin-bottom: 10px">
		        	<option value="">-</option>
		        	<option value="cash">Kontant</option>
		        	<option value="webshop">Webshop</option>
		        	<option value="card">Kort</option>
		        	<option value="mobilepay">Mobilepay</option>
		        	<option value="nettalk">Nettalk</option>
		        	<option value="loan">Lån</option>
		        	<option value="invoice">Faktura</option>
		        </select>

	        </div>

	        <div class="invoice_informations" style="display: none">
            <!--
	        	<div class="col-md-6">
			        <label>Firmanavn</label>
			        <input type="text"  class="form-control" name="invoice_company_name" value="" style="margin-bottom: 10px" />
		        </div>
		        <div class="col-md-6">
			        <label>Kundens navn</label>
			        <input type="text"  class="form-control" name="invoice_buyer_name" value="" style="margin-bottom: 10px" />
		        </div>
		        <div class="col-md-6">
			        <label>Tlf nummer</label>
			        <input type="text"  class="form-control" name="invoice_number" value="" style="margin-bottom: 10px" />
		        </div>
		        <div class="col-md-6">
			        <label>CVR</label>
			        <input type="text"  class="form-control" name="invoice_cvr" value="" style="margin-bottom: 10px" />
		        </div>

		        <div class="clearfix"></div>
		        <hr />
          -->
	        </div>

	        <div class="name_number" style="display: none">
            <!--
	        	<div class="col-md-12">
			        <label>Kundens firmanavn (valgfrit)</label>
			        <input type="text"  class="form-control" name="company_name" value="" style="margin-bottom: 10px" />
		        </div>
		        <div class="col-md-6">
			        <label>Kundens navn</label>
			        <input type="text"  class="form-control" name="buyer_name" style="margin-bottom: 10px" />
		        </div>
		        <div class="col-md-6">
			        <label>Kundens nummer</label>
			        <input type="text"  class="form-control" name="number" style="margin-bottom: 10px" />
		        </div>
          -->
	        </div>

	        <div class="order_id_webshop" style="display: none">
		        <div class="col-md-12">
			        <label>Ordre ID fra webshop</label>
			        <input type="text" class="form-control" name="order_id" style="margin-bottom: 10px" />
		        </div>
	        </div>

	        <div class="col-md-8">

		        <label>Varens pris</label>
		        <!--<div class="pricearea">Prisen vil fremgå her når model, GB og tilstand er valgt</div>-->
		        <input type="text" class="form-control" name="price" required style="margin-bottom: 10px" />

				<div class="addPanser" style="display: none"><label style="font-weight: normal"><input type="checkbox" name="panserBox" class="panserBox" value="1" /> Panser (+200 kr)</label></div>

				<div class="addPanser" style="display: none"><label style="font-weight: normal"><input type="checkbox" name="beskyttelseBox" class="beskyttelseBox" value="1" /> Beskyttelsespakke (+200 kr)</label></div>

				<div class="addPanser" style="display: none"><label style="font-weight: normal"><input type="checkbox" name="headsetBox" class="headsetBox" value="1" /> Headset (+200 kr)</label></div>

				<div class="addInsurance" style="display: none">
					<label style="font-weight: normal"><input type="checkbox" name="insuranceBox" class="insuranceBox" value="1" /> Forsikring</label>

					<div class="insuranceDataBox" style="display: none">
						<div class="clearfix"></div>
						<hr style="margin-top: 5px; margin-bottom: 5px" />

						<div class="row">
							<div class="col-md-6">
								<label>Pris for forsikring</label>
						        <div class="form-group">
							    <div class="input-group">
							      <div class="input-group-addon">+</div>
							      <input type="number" class="form-control" name="insurancePrice" id="" placeholder="">
							      <div class="input-group-addon">kr</div>
							    </div>
						        </div>
						    </div>
						    <div class="col-md-6">
						    	<select class="form-control" name="insurance_years" style="margin-top: 25px">
						    		<option value="">Vælg antal år</option>
						    		<option value="1">1 år</option>
						    		<option value="2">2 år</option>
						    	</select>
						    </div>
						</div>
					</div>

				</div>

	        </div>

	        <div class="col-md-4">

		        <label>Rabat (Maks 10% rabat)</label>
		        <div class="form-group">
			    <div class="input-group">
			      <input type="number" class="form-control" name="discount_amount" id="" max="10" placeholder="">
			      <div class="input-group-addon">%</div>
			    </div>
			    </div>

	        </div>

	        <div class="col-md-12">

	        	<!--<label><input type="checkbox" class="splitPayment" name="splitPayment" /> Split betaling?</label>-->

	        	<div class="row splitPaymentArea" style="display: none">

	        		<div class="col-md-6">
		        		<label>Kontant betaling</label>
				        <input type="text" class="form-control" name="split_cash" style="margin-bottom: 10px" />
	        		</div>
	        		<div class="col-md-6">
		        		<label>Kort betaling</label>
				        <input type="text" class="form-control" name="split_card" style="margin-bottom: 10px" />
	        		</div>

	        	</div>

	        </div>

	        <div class="clearfix"></div>
	        <hr />

	        <div class="col-md-12">
		        <label><input type="checkbox" class="exchangePhoneCheckbox" /> Byttetelefon</label>

				<div class="clearfix"></div>

				<div class="exchangePhoneArea" style="display: none">
					<label>Ordrenummer på byttetelefon</label><br />
					<input type="text" style="width: 40%; float: left; margin-right: 15px" class="form-control" name="exchange_id" />
					<a href="#" style="width: 20%; float: left" class="btn btn-default exchangePhone">Hent info</a>

					<div class="clearfix"></div>

					<table width="100%" class="exchangeTable" style="margin-top: 30px; display: none; font-size: 14px">
						<tr>
							<td width="100px">Salgspris</td>
							<td class="exchangeSoldPrice">2.500 kr</td>
						</tr>
						<tr>
							<td>Byttetelefon</td>
							<td class="exchangePrice">-1.500 kr</td>
						</tr>
						<tr>
							<td><b>Total</b></td>
							<td><b class="totalExchangePrice">1.000 kr</b></td>
						</tr>
					</table>
				</div>

	        </div>

	        <div class="col-md-12">
	        	<input type="hidden" name="bought_order_id" value="" />
	        	<input type="hidden" name="exchangeId" value="" />
	        	<input type="hidden" name="exchangeBoughtPrice" value="" />
	        	<input type="hidden" name="exchangePrice" value="" />
	        	<input type="submit" class="btn btn-success" name="sold_device" value="Sælg" style="margin-top: 20px" />
	        </div>

        </div>
        <?=form_close();?>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="edit_sold_device">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Rediger solgt enhed</h4>
      </div>
      <div class="modal-body">

        <div class="loader">
        <center><img src="<?=base_url();?>assets/images/loader.gif" /></center>
        </div>

        <div class="editContentSold" style="display: none">

        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<div class="modal fade" id="reason_for_creditnote">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Krediter salg</h4>
      </div>
      <div class="modal-body">

        <?=form_open('sold/cancel');?>

           <label>Skriv et par linjer omkring hvorfor salget er blevet annulleret</label><br />
           <textarea class="form-control" name="reason" rows="5" required="true"></textarea>

           <input type="submit" class="btn btn-danger" style="margin-top: 10px;" value="Krediter salg" />

           <input type="hidden" name="line_id" class="cancelCreditLineID" value="" />

        <?=form_close();?>

        <div class="editContentSold" style="display: none">

        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<h1 class="page-header">
	Solgte enhed
	<?php
	if($this->global_model->check_permission('create_sold_device',FALSE)){
	?>
	<div class="pull-right">

		<a href="#" class="btn btn-success" data-toggle="modal" data-target="#buy_device">Sælg enhed</a>
	</div>
	<?php
	}
	?>
</h1>

<div class="table-responsive">

<form action="<?=current_url();?>" method="GET">
	<input type="date" class="form-control" style="float: left; width: 160px; margin-right: 10px;" name="from_date" />
	<div  style="float: left; width: 10px; margin-right: 10px; text-align: center; padding-top: 6px">-</div>
	<input type="date" class="form-control" style="float: left; width: 160px; margin-right: 10px;" name="to_date" />
	<input type="submit" class="btn btn-info" style="float: left; width: 100px" value="Filtrer" />
</form>
<?php
if($this->input->get('from_date') == true || $this->input->get('to_date') == true){
?>
<a href="<?=site_url('sold');?>" class="btn btn-danger" style="margin-left: 10px">Nulstil</a>
<?php
}
?>
<div class="clearfix"></div>
<hr />

<table class="table table-striped">
  <thead>
    <tr>
      <th>#</th>
      <th>Enhed</th>
      <th>Køber / Webshop ID</th>
      <th>IMEI</th>
      <th>Dato</th>
      <th>Betalingsform</th>
      <th>Pris</th>
      <th>Fortjeneste</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  	<?php

  	foreach($orders as $order):
  	?>
    <tr>
      <td><a style="color: #2e2e2e" href="<?=site_url('orders/show/'.$order->bought_from_order_id);?>"><?=$order->bought_from_order_id;?></a></td>
      <td><?=$order->product;?><br /> <?=$order->gb;?>GB</td>
      <td>
      	<?php
      	if($order->payment_type == 'webshop' || $order->payment_type == 'nettalk'){
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
      <td>
	      <?php
	      echo $this->global_model->payment_type($order->payment_type);
	      ?>
      </td>
      <td>
      	<?=$order->price;?>
      	<?php
      	if($order->split_cash > 0 && $order->split_card > 0){
      	?>
      	<br />
      	<small>
      	Kontant: <?=$order->split_cash;?><br />
      	Kort: <?=$order->split_card;?>
      	</small>
      	<?php
      	}
      	?>
      </td>
      <td>
	      <?php
	      $profit = number_format($this->global_model->calculate_earnings_on_phone($order->id),2,',','.');
	      if($profit > 0){
		      echo '<span style="color: green">+'.$profit.' kr</span>';
	      }else{
		      echo '<span style="color: red">'.$profit.' kr</span>';
	      }
	      ?>
      </td>
      <td width="150px">
      	<a href="#" data-toggle="modal" data-id="<?=$order->id;?>" data-target="#edit_sold_device" class="btn btn-info btn-xs">Rediger</a>

      	<a href="#" data-toggle="modal" data-id="<?=$order->id;?>" data-target="#reason_for_creditnote"  class="btn btn-default btn-xs">Krediter</a>

      	<a href="<?=site_url('export/print_/'.$order->id);?>" target="_blank" class="btn btn-default btn-xs">Kvittering</a>
      </td>
    </tr>
    <?php
    endforeach;
    ?>
  </tbody>
</table>

<?php echo $this->pagination->create_links();  ?>

</div>

<input type="hidden" class="disableChained" value="1" />

<script>
$(document).on("change",".show_name",function(){

  if($(this).is(':checked')){

    $(".name_checked").css("display","block");
  }else{
    $(".name_checked").css("display","none");
  }
});
</script>

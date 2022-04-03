<?=form_open(current_url());?>
<div class="row sell_unit">
    <div class="col-md-6">
        <label>Model</label>
        <select class="form-control" disabled="true" id="devices" name="model" required style="margin-bottom: 10px">
        	<option value="">-</option>
        	<?php
        	foreach($products as $product):
        	?>
        	<option value="<?=$product->id;?>" <?php if($order->product_id == $product->id): echo 'selected="true"'; endif; ?>><?=$product->name;?></option>
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
        	<option value="<?=$gbview->id;?>" <?php if($order->gb_id == $gbview->id): echo 'selected="true"'; endif; ?> class="<?=$gbview->product_id;?>"><?=$gbview->name;?></option>
        	<?php
        	endforeach;
        	?>
        </select>
    </div>

    <div class="col-md-6">
        <label>IMEI</label>
        <input type="text" class="form-control" name="imei" value="<?=$order->imei;?>" required style="margin-bottom: 10px" />
    </div>
    <div class="col-md-6">
        <label>Farve</label>
        <input type="text" class="form-control" name="color" value="<?=$order->color;?>" required style="margin-bottom: 10px" />
    </div>

    <div class="col-md-12"><hr /></div>
    <div class="col-md-12">
        <label><input type="checkbox" class="show_name" value="1" name="show_name" <?php if($order->show_name){ echo "checked"; } ?> /> Navn på kvittering?</label>

    </div>
    <div style="<?php if(!$order->show_name){ ?>display:none<?php } ?>" class="name_checked">
      <div class="col-md-6">
          <label>Navn</label>
          <input type="text" value="<?php echo $order->name; ?>" class="form-control" name="buyer_name" style="margin-bottom: 10px" />
      </div>
      <div class="col-md-6">
          <label>E-mail</label> <input type="checkbox" value="1" name="send_email" />
          <input type="text" value="<?php echo $order->email; ?>" class="form-control" name="email" style="margin-bottom: 10px" />
      </div>
      <div class="col-md-6">
          <label>Evt. firma navn</label>
          <input type="text" value="<?php echo $order->company; ?>" class="form-control" name="company_name" style="margin-bottom: 10px" />
      </div>
      <div class="col-md-6">
          <label>CVR nummer</label>
          <input type="text" value="<?php echo $order->cvr; ?>" class="form-control" name="cvr" style="margin-bottom: 10px" />
      </div>
    </div>
    <div class="col-md-12">
      <hr />
    </div>

	<div class="col-md-12">

        <label>Betalingsmetode</label>
		<select class="form-control" name="payment_type" required style="margin-bottom: 10px">
        	<option value="" <?php if($order->payment_type == ''): echo 'selected="true"'; endif; ?> >-</option>
        	<option value="cash" <?php if($order->payment_type == 'cash'): echo 'selected="true"'; endif; ?> >Kontant</option>
        	<option value="webshop" <?php if($order->payment_type == 'webshop'): echo 'selected="true"'; endif; ?> >Webshop</option>
        	<option value="card" <?php if($order->payment_type == 'card'): echo 'selected="true"'; endif; ?> >Kort</option>
        	<option value="mobilepay" <?php if($order->payment_type == 'mobilepay'): echo 'selected="true"'; endif; ?> >Mobilepay</option>
        	<option value="nettalk" <?php if($order->payment_type == 'nettalk'): echo 'selected="true"'; endif; ?> >Nettalk</option>
        	<option value="loan" <?php if($order->payment_type == 'loan'): echo 'selected="true"'; endif; ?> >Lån</option>
        	<option value="invoice" <?php if($order->payment_type == 'invoice'): echo 'selected="true"'; endif; ?> >Faktura</option>
        </select>

    </div>

    <div class="name_number" style="display: <?php if($order->payment_type == 'mobilepay' || $order->payment_type == 'card' || $order->payment_type == 'cash'): echo 'block'; else: echo 'none'; endif; ?>">
      <!--
        <div class="col-md-12">
	        <label>Kundens firmanavn (valgfrit)</label>
	        <input type="text"  class="form-control" name="company_name" value="<?=$order->company;?>" style="margin-bottom: 10px" />
        </div>
        <div class="col-md-6">
	        <label>Kundens navn</label>
	        <input type="text"  class="form-control" name="buyer_name" value="<?=$order->name;?>" style="margin-bottom: 10px" />
        </div>
        <div class="col-md-6">
	        <label>Kundens nummer</label>
	        <input type="text"  class="form-control" name="number" value="<?=$order->number;?>" style="margin-bottom: 10px" />
        </div>
      -->
    </div>

    <div class="order_id_webshop" style="display: <?php if($order->payment_type == 'webshop'): echo 'block'; else: echo 'none'; endif; ?>">
        <div class="col-md-12">
	        <label>Ordre ID fra webshop</label>
	        <input type="text" class="form-control" name="order_id" value="<?=$order->webshop_id;?>" style="margin-bottom: 10px" />
        </div>
    </div>

    <div class="col-md-12">

        <label>Varens pris</label>
        <input type="text" class="form-control" value="<?=$order->price;?>" name="price" required  style="margin-bottom: 10px" />


    </div>

    <div class="col-md-12">
    	<input type="hidden" name="id" value="<?=$order->id;?>" />
    	<input type="hidden" name="bought_order_id" value="<?=$order->bought_from_order_id;?>" />
    	<input type="submit" class="btn btn-success" name="edit_device" value="Rediger" style="margin-top: 20px" />
    </div>

</div>
<?=form_close();?>

<?=form_open(current_url());?>
<div class="row sell_unit">
  <div id="access_items">
    <?php
    if($items){

    foreach($items as $item){ ?>
      <div class="access_item col-md-12" style="margin-bottom:15px;" id="item_id_<?php echo $item['item_id'];?>">
          <div class="col-md-3">
              <label>Tilbehør tilhører telefon</label>
              <select class="form-control selectpicker select_devices" name="model[]" required style="margin-bottom: 10px;  width: 118px;">
                  <option value="">-</option>
                  <?php
                  foreach ($products as $product):
                      ?>
                      <option value="<?= $product->id; ?>" <?php if($product->id == $item['product_id']){?>selected<?php }?>><?= $product->name; ?></option>
                      <?php
                  endforeach;
                  ?>
              </select>
          </div>

          <div class="col-md-3">
              <label>Tilbehør1</label>
              <div class="space"></div>
              <select class="form-control checkIfNewAccess2 selectpicker select_gbs" name="access[]" disabled required style="margin-bottom: 10px; width: 118px;">
                  <option value="">-</option>

              </select>
              <div class="newAccess hidden">
                <label>Tilbehør navn</label>
                <input type="text" name="newAccessName[]" style="width: 180px;height: 28px;  margin-top: 19px;" value="" class="form-control" />
              </div>
          </div>
          <div class="col-md-2">
              <label>Qty</label>
              <select class="form-control" name="qty[]" style="height:28px;  margin-top: 19px;">
                <?php for($i=1;$i<=10;$i++){ ?>
                  <option value="<?php echo $i;?>" <?php if($item['qty'] == $i){ echo "selected"; } ?>><?php echo $i;?></option>
                <?php } ?>
              </select>
          </div>
          
          <div class="col-md-2 pris_div">
              <label>Pris</label>
              <input class="form-control item_pris" value="<?php echo $item['price'];?>" type="number" required name="item_pris[]" style=" height: 28px;  margin-top: 19px;" />
          </div>

          <div class="col-md-2" style="margin-left: -10px;">
            <label>Discount (%)</label>
            <div class="space"></div>
            <input type="number" value='<?php echo $item['product_discount'];?>' class="form-control discount_add" style="height: 28px;" name="discount_add[]" />
          </div>

          <div class="col-md-1 item_del_div">


          </div>
          <input type='hidden' name='item_id[]' value='<?php echo $item['item_id'];?>' />
      </div>
      <script>
        $("#item_id_<?php echo $item['item_id'];?>").find(".select_devices").trigger('change',[<?php echo $item['part_id'];?>]);
      </script>
    <?php }
  }
     ?>
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
          <label>Phone</label>
          <input type="text"  class="form-control" id="buyer_phone_edit" value="<?php echo $order->number; ?>" name="number" style="margin-bottom: 10px" />
      </div>
      <div class="col-md-4">
          <label>E-mail</label> <input type="checkbox" value="1" name="send_email" />
          <input type="text" value="<?php echo $order->email; ?>" class="form-control" name="email" style="margin-bottom: 10px" />
      </div>
      <div class="col-md-4">
          <label>Evt. firma navn</label>
          <input type="text" value="<?php echo $order->company; ?>" class="form-control" name="company_name" style="margin-bottom: 10px" />
      </div>
      <div class="col-md-4">
          <label>CVR nummer</label>
          <input type="text" value="<?php echo $order->cvr; ?>" class="form-control" name="cvr" style="margin-bottom: 10px" />
      </div>
    </div>
    <div class="col-md-12">
      <hr />
    </div>

    <div class="col-md-12">
      <div class="col-md-6">
        <label>Receipt telefon</label>
        <div class="space"></div>
        <?php
          $receipts = $this->db->get('receipt')->result();
        ?>
        <select class="form-control selectpicker select_devices" name="receipt" required style="margin-bottom: 10px;  width: 187px;">
            <option value="46236">-</option>
            <?php
            foreach ($receipts as $receipt):
                ?>
                <option value="<?= $receipt->id; ?>" <?php if($receipt->id == $order->receipt_id){?>selected<?php }?>><?= $receipt->phone ? $receipt->phone : $receipt->name; ?></option>
                <?php
            endforeach;
            ?> 
        </select>
      </div>
    </div>
    <div class="col-md-12">
      <hr style="    width: 92%;margin-left: 29px;" />
    </div>

    <div class="col-md-6">

        <label>Betalingsmetode</label>
		<select class="form-control" name="payment_type" required style="margin-bottom: 10px">
        	<option value="" <?php if($order->payment_type == ''): echo 'selected="true"'; endif; ?> >-</option>
        	<option value="cash" <?php if($order->payment_type == 'cash'): echo 'selected="true"'; endif; ?> >Kontant</option>
        	<option value="webshop" <?php if($order->payment_type == 'webshop'): echo 'selected="true"'; endif; ?> >Webshop</option>
        	<option value="card" <?php if($order->payment_type == 'card'): echo 'selected="true"'; endif; ?> >Kort</option>
        	<option value="mobilepay" <?php if($order->payment_type == 'mobilepay'): echo 'selected="true"'; endif; ?> >Mobilepay</option>
        </select>

    </div>

    <div class="col-md-6">
      <label>Garanti</label>
      <select class="form-control" name="garanti" required style="margin-bottom: 10px">
          <!-- <option value="1">Standard</option>
          <option value="2" <?php if($order->garanti == 2): echo 'selected="true"'; endif; ?>>Vandskade</option> -->

          <?php for($i=0; $i<count($garantiData); $i++){ ?>
            <option <?php if($order->garanti == $garantiData[$i]['id']): echo 'selected="true"'; endif; ?> value="<?php echo $garantiData[$i]['id'];?>"><?php echo $garantiData[$i]['name'];?></option>
          <?php } ?>
      </select>
    </div>



    <div class="order_id_webshop" style="display: <?php if($order->payment_type == 'webshop'): echo 'block'; else: echo 'none'; endif; ?>">
        <div class="col-md-6">
	        <label>Ordre ID fra webshop</label>
	        <input type="text" class="form-control" name="order_id" value="<?=$order->webshop_id;?>" style="margin-bottom: 10px" />
        </div>
    </div>
    <div class="col-md-12"><hr style="margin-bottom:0px;" /></div>

    <div class="col-md-4">
     
    </div>
    <div class="col-md-2">
      <label></label>
      <div style=" margin-top: 20px;"><b>Total Pris</b></div>
    </div>
    <div class="col-md-3">
      <div style=" margin-top: 35px;"></div>
      <div class="total_pris" style="font-weight:bold; font-size:18px;">
        <?=(int)$order->price, "\n";?> kr 
      </div>

    </div>

    <div class="col-md-3">
      <input type='hidden' name='subtotal' class='subtotal' id='subtotal_edit' value='<?=$order->subtotal;?>' />
    	<input type="hidden" name="id" value="<?=$order->id;?>" />
    	<input type="submit" class="btn btn-success  col-md-12 pull-right" name="edit_access" value="Sælg" style="margin-top: 25px" />
    </div>
	
	<?php if($order->comment){ ?>
   <div class="col-md-12">
	  <hr />
	  <label>Kommentar</label><br />
	  <textarea class="form-control" name="comment" rows="3"><?php echo $order->comment; ?></textarea>
   </div>
	<?php } ?>

</div>
<?=form_close();?>


<script>
$('.selectpicker').select2();

payment_type();
</script>
<style>
.space{
  margin-top:19px;
}
</style>
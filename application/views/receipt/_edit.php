<form class="form-signin" action="<?=base_url('receipt/update');?>" method="POST">

  <div class="row">

  <div class="col-md-6" style="margin-bottom: 10px;">
    <label>Navn</label>
    <input type="text" required class="form-control" name="name" value="<?php echo $receipt->name; ?>" placeholder="Navn">
  </div>

  <div class="col-md-6" style="margin-bottom: 10px;">
	<label>Email</label>
	<input type="email"  class="form-control" value="<?php echo $receipt->email; ?>" name="email" placeholder="Email">
</div>

<div class="col-md-6" style="margin-bottom: 10px;">
    <label>Tlf kode</label>
    <input type="text" class="form-control" value="<?php echo $receipt->phone_code; ?>" name="phone_code" placeholder="Tlf kode">
  </div>

  <div class="col-md-6" style="margin-bottom: 10px;">
    <label>Tlf nummer</label>
    <input type="text" class="form-control" name="phone" value="<?php echo $receipt->phone; ?>" placeholder="Telefon">
  </div>


  <div class="col-md-6" style="margin-bottom: 10px;">
    <label>Pin</label>
    <input type="text" class="form-control" value="<?php echo $receipt->pin; ?>" name="pin" placeholder="Pin">
  </div>



<div class="col-md-6" style="margin-bottom: 10px;">
  <label>Afhentnings tidspunkt</label>
    <input type="text" class="form-control" value="<?php echo $receipt->pickup_time; ?>" name="pickup_time" placeholder="Afhentnings tidspunkt">
</div>

<div class="col-md-6" style="margin-bottom: 10px;">
<!--<label>Tilbehør tilhører telefon</label>-->
<select class="form-control selectpicker select_devices" name="product_id" required style="width: 268px;">
	<option value="">- Vælg enhed -</option>
	<?php
	foreach ($products as $product):
		?>
		<option value="<?= $product->id; ?>" <?php echo ($receipt->product_id == $product->id)?"selected":""; ?>><?= $product->name; ?></option>
		<?php
	endforeach;
	?>
  <option value='diverse'>Diverse</option>
</select>
</div>

<div class="col-md-6 hidden product_name" style="margin-bottom: 10px;">
    <label>Enhed</label>
    <input type="text" name="product_name" class="form-control" />
</div>

<div class="col-md-6" style="margin-bottom: 10px;">
  <label><input type="checkbox" name="no_test" value="1" /> Ingen test af enhed</label>
</div>

<div class="col-md-12" style="margin-bottom: 10px;">
<label>Beskrivelse</label>
<textarea name="description" style="width: 100%" class="form-control" placeholder="Beskrivelse"><?php echo $receipt->description; ?></textarea>
</div>

  <hr />


  <div class="repairs" style="margin-bottom: 10px;">
    <?php if($repairs){
		$i = 1;
      foreach($repairs as $repair){
      ?>
    <div class="col-md-6" style="margin-top: 10px;">
		<?php if($i == 1){ ?>
      <label>Reparations navn</label>
		<?php } ?>
      <input type="text" class="form-control" placeholder="Reparation" value="<?php echo $repair->name; ?>" name="repair_name_existing[<?php echo $repair->id; ?>]">
    </div>
    <div class="col-md-6" style="margin-top: 10px;">
	<?php if($i == 1){ ?>
      <label>Reparations pris</label>
	<?php } ?>
      <input type="text" class="form-control" placeholder="Reparation pris" value="<?php echo $repair->price; ?>" name="repair_price_existing[<?php echo $repair->id; ?>]">
    </div>
  <?php
  $i++;
    }
  } else {
    ?>
    <div class="col-md-6" style="margin-top: 10px;">
      <label>Reparations navn</label>
      <input type="text" class="form-control" placeholder="Reparation"  name="repair_name[]">
    </div>
    <div class="col-md-6" style="margin-top: 10px;">
      <label>Reparations pris</label>
      <input type="text" class="form-control" placeholder="Reparation pris" name="repair_price[]">
    </div>
    <?php
  } ?>

  </div>



<div class="col-md-6" style="margin-bottom: 10px;">
  <a href="#" class="add_repair">Tilføj +</a><br />
  <label>Discount (%)</label>
  <input type="text" name="discount" value='<?php echo $receipt->discount; ?>' class="form-control" />
  <br/>
<label style="padding-right: 20px;">
  <input type="checkbox" name="paid" <?php if($receipt->paid == 1){ echo "checked"; } ?> value="1" />
Betalt?
</label>
<label>
  <input type="checkbox" name="comment_status" class="comment_status" <?php if($receipt->comment_status == 1){ echo "checked"; } ?> value="1" />
  Koment
</label>
<!--
<label style="margin-left:20px;">
  <input type="checkbox" name="delivered" <?php if($receipt->delivered == 1){ echo "checked"; } ?> value="1" />
Udleveret
</label>
-->
</div>

<div class="col-md-6" style="margin-bottom: 10px;">
</div>
  
<div class="col-md-12" style="margin-bottom: 10px;">
  
  <textarea name="comment" style="width: 100%; display: <?php if($receipt->comment_status == 1) { echo "block"; } else { echo "none";} ?>;" class="form-control comment_vis" placeholder="Koment" ></textarea>
</div>
<br /><br />

<div class="col-md-12">
<input type="hidden" name="id" value="<?php echo $receipt->id; ?>" />
<input type="submit" class="btn btn-success" name="update" value="Opret" />
</div>

  </div>

</form>

<?php if(isset($_SERVER['HTTPS'])){
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    }
    else{
        $protocol = 'http';
    }
echo(form_open($protocol . '://' . $_SERVER['HTTP_HOST'] . '/receipt/edit_repairs')); ?>
<div class="row sell_unit">
    <div id="access_items_rep">
        <?php
        $total_price = 0;

        if($repairs){?>
            <div class="col-md-12">
                <table cellpadding="0" cellspacing="0" width="100%" style="margin-top: 30px;">
                    <tr>
                        <th align="left"  width="35%" style="padding: 5px; font-size: 13px;">Telefone</th>
                        <th align="left"  width="35%" style="padding: 5px; font-size: 13px;">Beskrivelse</th>
                        <!--<th align="left"  style="border: 3px solid #2e2e2e; padding: 5px; font-size: 14px;">Antal</th>-->
                        <th align="left"  width="15%" style="padding: 5px; font-size: 13px;">Pris</th>
                        <th align="left"  width="15%" style="padding: 5px; font-size: 13px;">Discount (%)</th>
                    </tr> <?php
                    $products = $this->db->get('products')->result();
                    foreach($repairs as $key => $repair){ 
                        $total_price +=  floatval($repair->price) * (100 - $repair->discount) / 100;
                        ?>
                        <!-- <input type="hidden" class="form-control " placeholder="Reparation" value="<?php echo $repair->product_id; ?>" name="repair_product[<?php echo $repair->id; ?>]"> -->
                        <tr> 
                            <td width="90px" style="font-size: 12px; padding: 5px">

                              <select class="form-control selectpicker select_devices" name="repair_product[<?php echo $repair->id; ?>]" required>
                              <option value="">-</option>
                              <?php
                              foreach ($products as $product):
                                  ?>
                                  <option value="<?= $product->id; ?>" <?php if($product->id == $repair->product_id){?>selected<?php }?>><?= $product->name; ?></option>
                                  <?php
                              endforeach;
                              ?>
                              </select>
                            </td>
                            <td width="90px" style="font-size: 12px; padding: 5px">
                              <input type="text" class="form-control " placeholder="Reparation" value="<?php echo $repair->name; ?>" name="repair_name_existing[<?php echo $repair->id; ?>]">
                            </td>
                            <td style="font-size: 12px; padding: 5px">
                              <input type="number" class="form-control item_pris_rep" placeholder="Reparation pris" value="<?php echo $repair->price; ?>" name="repair_price_existing[<?php echo $repair->id; ?>]">
                            </td>
                            <td style="font-size: 12px; padding: 5px">
                              <input type="number" class="form-control discount_add_rep" placeholder="Reparation discount" value="<?php echo $repair->discount; ?>" name="repair_discount_existing[<?php echo $repair->id; ?>]">
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        <?php } ?>
    </div>

    <div class="col-md-12" style="margin-top: 15px; margin-botton:15px;">
      <div class="col-md-6" style="padding-left: 7px;">
        <label><input type="checkbox" class="show_name" value="1" name="show_name" /> Navn på kvittering?</label>
      </div>
    </div>
    <div style="display:none" class="name_checked">
        <div class="col-md-12">
          <div class="col-md-6" style="padding-left: 7px;">
              <label>Navn</label>
              <input type="text"  class="form-control" name="buyer_name" style="margin-bottom: 10px" />
          </div>
          <div class="col-md-6" style="padding-left: 7px;">
              <label>E-mail</label>
               <!-- <input type="checkbox" value="1" name="send_email" /> -->
              <input type="text"  class="form-control" name="email" style="margin-bottom: 10px" />
          </div>
        </div>
    </div>
<!-- 
    <div class="col-md-12">
      <hr style="    width: 92%;margin-left: 29px;" />
    </div> -->

    <div class="col-md-12"><hr style="margin-bottom:0px;" /></div>

    <div class="col-md-4">
     
    </div>
    <!-- <div class="col-md-2">
      <label></label>
      <div style=" margin-top: 20px;"><b>Total Pris</b></div>
    </div> -->
    <!-- <div class="col-md-3">
      <div style=" margin-top: 35px;"></div>
      <div class="total_pris" style="font-weight:bold; font-size:18px;">
        <?=$total_price, "\n";?> kr 
      </div>

    </div> -->

    <div class="col-md-3">
    
      <input type='hidden' name='subtotal' class='subtotal' id='subtotal_edit' value='<?=$total_price?>' />
      <input type='hidden' name='receipt_id' class='receipt_' id='receipt_id' value='<?=$id?>' />
      <?php 
      $repairs_id_string = '';
      foreach ($repairs_id as $key => $repair_id) {
        if ($key == 0) {
          $repairs_id_string .= $repair_id;
        } else {
          $repairs_id_string .= ',' . $repair_id;
        }
      }
      ?>
      <input type="hidden" name="id" value="<?=$repairs_id_string;?>" />
    </div>

    <div class="col-md-12">
      <div class="col-md-4">
        <div class="col-md-11">

          <label>Betalingsmetode</label>
          <select class="form-control" name="payment_type" required style="margin-bottom: 10px">
            <option value="" <?php if($order->payment_type == ''): echo 'selected="true"'; endif; ?> >-</option>
            <option value="cash" >Kontant</option>
            <option value="card" >Kort</option>
            <option value="mobilepay" >Mobilepay</option>
          </select>

        </div>

        <div class="col-md-11">
          <label>Garanti</label>
          <select class="form-control" name="garanti" required style="margin-bottom: 10px">
            <!-- <option value="1">Standard</option>
            <option value="2" <?php if($order->garanti == 2): echo 'selected="true"'; endif; ?>>Vandskade</option> -->

            <?php for($i=0; $i<count($garantiData); $i++){ ?>
              <option <?php if($order->garanti == $garantiData[$i]['id']): echo 'selected="true"'; endif; ?> value="<?php echo $garantiData[$i]['id'];?>"><?php echo $garantiData[$i]['name'];?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="col-md-8" style="    font-size: 16px;font-weight: 700; margin-top: 5px;">
        <div class="col-md-12">
          <div class="col-md-6">Subtotal</div>
          <div class="col-md-6"><p class="subtotal_show_rep right"><span>Kr</span></p></div>
        </div>
        <div class="col-md-12" style="margin-bottom: -7px;">
          <div class="col-md-6">Rabat</div>
          <div class="col-md-6"><p class="discount_show_rep right"><span>Kr</span></p></div>
        </div>
        <hr style="width: 81%; margin-left: 28px; border: solid 1px #eee;">
        <div class="col-md-12" style="margin-top: -14px;">
          <div class="col-md-6"><i>Total</i></div>
          <div class="col-md-6"><i><p class="total_pris_rep right"><span>Kr</span></p></i></div>
        </div>

        <div class="col-md-11" style="margin-left: 16px;">
          <input type="submit" class="btn btn-success col-md-12 pull-right" name="edit_repairs" value="Sælg" style="margin-top: 25px" />

        </div>

      </div>
    </div>

</div>
<?=form_close();?>


<script>

function calc_total_price_rep(){
      var totalPrice = 0;
      var subtotal  = 0;
      var unit_price = 0;
      var product_discount=0;
      var each_discount_price=0;
      var show_discount=0;
     
      $('.item_pris_rep').each(function(i,n){
          product_discount = $(n).parents('tr').find('.discount_add_rep').val();
          unit_price = $(n).val()?parseFloat($(n).val()):0;
          subtotal  = subtotal+(unit_price);
          each_discount_price  = ((unit_price)*product_discount)/100 ;
          totalPrice = totalPrice + (unit_price)-each_discount_price;
          show_discount = subtotal-totalPrice;
        });
          
      subtotal = subtotal.toFixed(2);
      show_discount = show_discount.toFixed(2);
      totalPrice = totalPrice.toFixed(2);
      $("#subtotal_edit").val(subtotal);
      $(".subtotal_show_rep").text(subtotal+" kr");
      $(".discount_show_rep").text(show_discount+" kr");
      
      $(".total_pris_rep").html((totalPrice)+" kr");
    }

calc_total_price_rep();
$(document).on("keyup",".item_pris_rep",function(e){
  calc_total_price_rep();
});
$(document).on("change",".discount_add_rep",function(e){
  calc_total_price_rep();
});

$(document).on("change",".item_pris_rep",function(e){
  calc_total_price_rep();
});

$(document).on("keyup",".discount_add_rep",function(e){
  calc_total_price_rep();
});

$("#access_items_rep").on('hidden.bs.modal', function () {
  calc_total_price_rep();
});

$(document).on("change",".show_name",function(){

  if($(this).is(':checked')){

    $(".name_checked").css("display","block");
  }else{
    $(".name_checked").css("display","none");
  }
});

// $('.selectpicker_inner').select2();

payment_type();
</script>
<style>
.space{
  margin-top:19px;
}
</style>
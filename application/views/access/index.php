<?php
if ($this->input->get('open_receipt')):
    ?>
    <script type="text/javascript">
        var win = window.open('<?= site_url(); ?>export/print_/<?= $this->input->get('open_receipt'); ?>', '_blank');
            win.focus();

            top.location.href = '<?= site_url('access'); ?>';
    </script>
    <?php
endif;
?>


<div class="modal fade" id="buy_device">
    <div class="modal-dialog">
        <div class="modal-content sell_popup">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Sælg tilbehør</h4>
            </div>
            <div class="modal-body">
                <?= form_open(current_url()); ?>
                <div class="row sell_unit">

                    <?php
                    if ($access_extra) {
                        ?>
                        <div class="col-md-12">
                            <div class="alert alert-info">Du er ved at oprette ekstra tilbehør til ordre #<?= $access_extra[0]->id; ?>. <a href="<?= site_url('access'); ?>">Klik her hvis dette er en fejl</a></div>
                        </div>
                        <?php
                    }
                    ?>
                    <div id="access_items">
                        <div class="access_item col-md-12" style="margin-bottom:15px;">
                        <div class="col-md-7">
                            <div class="col-md-6">
                                <label>Tilbehør tilhører telefon</label>
                                <div class="space"></div>
                                <select class="form-control selectpicker select_devices" name="model[]" required style="margin-bottom: 10px;  width: 187px;">
                                    <option value="">-</option>
                                    <?php
                                    foreach ($products as $product):
                                        ?>
                                        <option value="<?= $product->id; ?>"><?= $product->name; ?></option>
                                        <?php
                                    endforeach;
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Tilbehør</label>
                                <div class="space"></div>
                                <select class="form-control checkIfNewAccess2 selectpicker select_gbs" name="access[]" disabled required style="margin-bottom: 10px;  width: 210px;">
                                    <option value="">-</option>

                                </select>
                                <div class="newAccess hidden">
                                  <label>Tilbehør navn</label>
                                  <input type="text" name="newAccessName[]" style="width: 213px;height: 28px; margin-top: 19px;" value="" class="form-control" />
                                </div>
                            </div>
                            </div>
                            <div class="col-md-5">
                            <div class="col-md-3">
                                <label>Qty</label>
                                <div class="space"></div>
                                <select class="form-control" name="qty[]" style="height:28px; width: 63px;">
                                  <?php for($i=1;$i<=10;$i++){ ?>
                                    <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                  <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-4 pris_div">
                                <label class="right">Pris</label>
                                <div class="space"></div>
                                <input class="form-control item_pris" value="0" type="number" required name="item_pris[]" style="margin-left: 8px; margin-top: 39px; height: 28px;" />
                            </div>
                            <div class="col-md-5" style="margin-left: -10px;">
                              <label class="right">Discount (%)</label>
                              <div class="space"></div>
                              <input type="number" value='0' class="form-control discount_add" style="height: 28px; margin-top: 39px; margin-left: 2px;" name="discount_add[]" />
                            </div>
                            </div>
                            <div class="item_del_div">
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12" style="margin-top:10px; margin-left: -38px;">
                      <button class="btn btn-info pull-right btn-xs" style='margin-top:-10px;' id="access_prod_add">+Add Product</button>
                      <hr class="hr_line" />
                    </div>

                    <div class="col-md-12">
                     <div class="col-md-6" style="margin-left: 15px;">
                        <label><input type="checkbox" class="show_name" value="1" name="show_name" /> Navn på kvittering?</label>
                      </div>
                    </div>
                    <div style="display:none" class="name_checked">
                    <div class="col-md-12">
                      <div class="col-md-12">
                          <div class="col-md-6">
                              <label>Navn</label>
                              <input type="text"  class="form-control" name="buyer_name" style="margin-bottom: 10px" />
                          </div>
                          <div class="col-md-6">
                              <label>E-mail</label> <input type="checkbox" value="1" name="send_email" />
                              <input type="text"  class="form-control" name="email" style="margin-bottom: 10px" />
                          </div>
                       </div>
                    </div>

                    <div class="col-md-12">
                     <div class="col-md-6" style="margin-left: 15px;">
                        <label><input type="checkbox" class="show_name" value="1" name="show_name" /> Navn på kvittering?</label>
                      </div>
                    </div>

                    </div>

                    <div class="col-md-12">
                      <hr style="    width: 92%;margin-left: 29px;" />
                    </div>
                    <div class="col-md-12">
                      <div class="col-md-12">
                        <div class="col-md-6">
                          <label>Receipt telefon</label>
                          <div class="space"></div>
                          <?php
                            $receipts = $this->db->get('receipt')->result();
                          ?>
                          <select class="form-control selectpicker select_devices" name="receipt" required style="margin-bottom: 10px;  width: 187px;">
                              <option value="">-</option>
                              <?php
                              foreach ($receipts as $receipt):
                                  ?>
                                  <option value="<?= $receipt->id; ?>"><?= $receipt->phone ? $receipt->phone : $receipt->name; ?></option>
                                  <?php
                              endforeach;
                              ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <hr style="    width: 92%;margin-left: 29px;" />
                    </div>

                    <div class="col-md-12">
                    <div class="col-md-7">
                    <div class="col-md-9">
                          <label>
                            Betalingsmetode
                        </label>
                        <?php
                        if (strpos($rank_permissions, 'hidden_btn') !== false || strpos($rank_permissions, 'all') !== false) {
                            ?>
                            <div style="float: right; display: none;" class="hidden_checkboks"><input type="checkbox"  name="hidden" value="1" /></div>
                            <?php
                        }
                        ?>
                        <select class="form-control" name="payment_type" required style="margin-bottom: 10px">
                            <option value="">-</option>
                            <option value="cash">Kontant</option>
                            <option value="webshop">Webshop</option>
                            <option value="card">Kort</option>
                            <option value="mobilepay">Mobilepay</option>
                            <option value="invoice">Faktura</option>
                            <option value="loan">Lån</option>
                        </select>

                    </div>
                    <div class="col-md-9">
                      <label>Garanti</label>
                      <select class="form-control" name="garanti" required style="margin-bottom: 10px">
                          <?php for($i=0; $i<count($garantiData); $i++){ ?>
                            <option value="<?php echo $garantiData[$i]['id'];?>"><?php echo $garantiData[$i]['name'];?></option>
                          <?php } ?>
                      </select>
                    </div>
                    </div>

                    <div class="col-md-5" style="    font-size: 16px;font-weight: 700; margin-top: 5px;">
                      <div class="col-md-12">
                        <div class="col-md-6">Subtotal</div>
                        <div class="col-md-6"><p class="subtotal_show right"><span>Kr</span></p></div>
                      </div>
                      <div class="col-md-12" style="margin-bottom: -7px;">
                        <div class="col-md-6">Rabat</div>
                        <div class="col-md-6"><p class="discount_show right"><span>Kr</span></p></div>
                      </div>
                      <hr style="width: 81%; margin-left: 28px; border: solid 1px #eee;">
                      <div class="col-md-12" style="margin-top: -14px;">
                        <div class="col-md-6"><i>Total</i></div>
                        <div class="col-md-6"><i><p class="total_pris right"><span>Kr</span></p></i></div>
                      </div>

                      <div class="col-md-11" style="margin-left: 16px;">
                        <input type="submit" class="btn btn-success col-md-12 pull-right" name="sold_access" value="Sælg" style="margin-top: 25px" />

                      </div>

                    </div>



                    

                  </div>


                    <div class="order_id_webshop" style="display: none">
                        <div class="col-md-6">
                            <label>Ordre ID fra webshop</label>
                            <input type="text" class="form-control" name="order_id" />
                        </div>
                    </div>
                    <!-- <div class="col-md-12"><hr style="margin-bottom:0px;" /></div>
                    <div class="col-md-4">
     
                    </div>
                    <div class="col-md-2">
                      <label></label>
                      <div style=" margin-top: 20px;"><b>Total Pris</b></div>
                    </div>
                    <div class="col-md-3">

                        <div style="margin-top: 35px;"></div>
                        <div class="total_pris" style="font-weight:bold; font-size:18px;">
                          0 kr
                        </div>

                    </div> -->

                    <div class="col-md-3">
                        <input type='hidden' name='subtotal' class='subtotal' value='0' />
                        <input type="hidden" name="bought_order_id" value="" />
                        <input type="hidden" name="extra_access_to_order_id" value="<?= $this->uri->segment(3); ?>" />
                        <input type="hidden" name="redirect_element" value="access" />
                        <!-- <input type="submit" class="btn btn-success col-md-12 pull-right" name="sold_access" value="Sælg" style="margin-top: 25px" /> -->

                      <!--  <div class="pull-right" style="margin-top: 25px;">
                            <input type="checkbox" name="extra_access" value="1" style="padding-right: 20px" /> Tilføj ekstra tilbehør
                        </div>
                      -->
                    </div>


                </div>
                <?= form_close(); ?>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="edit_access">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Rediger solgt tilbehør</h4>
            </div>
            <div class="modal-body">

                <div class="loader">
                    <center><img src="<?= base_url(); ?>assets/images/loader.gif" /></center>
                </div>

                <div class="editContent" style="display: none">

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

                <?= form_open('access/cancel'); ?>

                <label>Skriv et par linjer omkring hvorfor salget er blevet annulleret</label><br />
                <textarea class="form-control" name="reason" rows="5" required="true"></textarea>

                <input type="submit" class="btn btn-danger" style="margin-top: 10px;" value="Krediter salg" />

                <input type="hidden" name="line_id" class="cancelCreditLineID" value="" />

                <?= form_close(); ?>

                <div class="editContentSold" style="display: none">

                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<h1 class="page-header">
    Solgt tilbehør
    <div class="pull-right">
        <a href="#" class="btn btn-success" data-toggle="modal" data-target="#buy_device">Sælg tilbehør</a>
    </div>
</h1>

<div class=""> <!--table-responsive-->
    <table class="table table-striped" id="dtable_access">
        <thead>
            <tr>
                <th>#</th>
                <th>Tilbehør</th>
                <th>Tidspunkt</th>
                <th>Køber</th>
                <th>Betalingsform</th>
                <th>Pris</th>
                <th>Fortjeneste</th>
                <th width="200px"></th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>


<script>
var columns_full = [{"db": "id", "dt": 0, "field": "id"},
        {"db": "part", "dt": 1, "field": "part"},
        {"db": "created_timestamp", "dt": 2, "field": "created_timestamp"},
        {"db": "name", "dt": 3, "field": "name"},
        {"db": "payment_type", "dt": 4, "field": "payment_type"},
        {"db": "price", "dt": 5, "field": "price"},
        {"db": "extra_access_to_order_id", "dt": 6, "field": ""},
        {"db": "address", "dt": 7, "field": ""},
    ];

var table = $("#dtable_access").DataTable({
        "ajax": {
            "type": "POST",
            "url": "<?php echo base_url('dataTable/getTable'); ?>",
            "data": {"table": "orders", "primary_key": 'id', "page": "access", "columns": columns_full, "receipt_id": 46236}
        },
        "processing": true,
        "serverSide": true,
        "bStateSave": true,
        "aaSorting": [[0, 'desc']],
        "columnDefs": [
          {
            "targets": 1,
            "render": function (data, type, full, meta) {
                return full['item_name'];
            }
          },
          {
            "targets": 6,
            "render": function (data, type, full, meta) {
              full['profit'] = parseFloat(full['profit']);
              if(full['profit'] > 0){
                return '<span style="color: green">+' + full['profit'] + ' kr</span>';
              }else{
                return '<span style="color: red">' + full['profit'] + ' kr</span>';
              }
            }
          },
          {
            "targets": 7,
            "render": function(data, type, full, meta){
                return  '<a href="#" data-toggle="modal" data-id="'+full[0]+'" data-target="#edit_access" class="btn btn-info btn-xs">Rediger</a> ' +
                        '<a href="#" data-toggle="modal" data-id="'+full[0]+'" data-target="#reason_for_creditnote"  class="btn btn-default btn-xs">Krediter</a> '+
                        '<a target="_blank" href="<?= site_url('export/print_'); ?>/'+full[0]+'" class="btn btn-default btn-xs">Kvittering</a>'
            }
          },
        ]
    });
    

$(document).on("change",".select_devices",function(e, access_id){
    console.log('select device');
    var select_gbs = $(this).parents(".access_item").find(".select_gbs");
    var product_id = $(this).val();
    if(product_id){
      $.ajax({
        url: "<?php echo base_url('access/select_gbs'); ?>",
        type: "post",
        data: {product_id: product_id, access_id: access_id},
        success: function(result){
          select_gbs.html(result);
          select_gbs.removeAttr('disabled');
        }
      });
    }else{
      select_gbs.attr('disabled','disabled');
    }

});

$(document).on("change",'.checkIfNewAccess2',function(){

  var newAccess = $(this).parents(".access_item").find(".newAccess");
  if($(this).val() == 'new_access'){
    newAccess.removeClass('hidden');
  }else{
    newAccess.addClass('hidden');
  }
});

// function calc_total_price(){
//   var totalPrice = 0;
//   var qty = 0;
//   var unit_price = 0;
//   if($("#discount_edit").length){
//     var discount = $("#discount_edit").val();
//   }else{
//     var discount = $(".discount").val();
//   }

//   $('.item_pris').each(function(i,n){
//       qty = $(n).parents('.access_item').find('select[name="qty[]"]').val();
//       qty = parseFloat(qty);
//       unit_price = $(n).val()?parseFloat($(n).val()):0;
//       totalPrice = totalPrice + (unit_price * qty);
//     });

//     $(".subtotal").val(totalPrice);
//     totalPrice = totalPrice - (totalPrice * parseFloat(discount) / 100);
//     //alert(totalPrice);
//     $(".total_pris").html(parseInt(totalPrice)+" kr");
// }


function calc_total_price(){
      var totalPrice = 0;
      var subtotal  = 0;
      var qty = 0;
      var unit_price = 0;
      var product_discount=0;
      var each_discount_price=0;
      var show_discount=0;
     $('.item_pris').each(function(i,n){
          qty = $(n).parents('.access_item').find('select[name="qty[]"]').val();
          product_discount = $(n).parents('.access_item').find('input[name="discount_add[]"]').val();
          qty = parseFloat(qty);
          unit_price = $(n).val()?parseFloat($(n).val()):0;
          subtotal  = subtotal+(unit_price * qty);
          each_discount_price  = Math.round( ((unit_price * qty)*product_discount)/100 );
          totalPrice = totalPrice + (unit_price * qty)-each_discount_price;
           show_discount = subtotal-totalPrice;
         
        });
    
        $(".subtotal").val(subtotal+" kr");
        $(".subtotal_show").text(subtotal+" kr");
        $(".discount_show").text(show_discount+" kr");
       
        $(".total_pris").html(parseInt(totalPrice)+" kr");
    }



$(document).on("change","select[name='qty[]']",function(){
  calc_total_price();
});

$(document).on("click",".item_row_delete",function(e){
  e.preventDefault();
  $(this).parents(".access_item").remove();
  calc_total_price();
});


calc_total_price();
$(document).on("keyup",".item_pris",function(e){
  calc_total_price();
});
$(document).on("change",".discount_add",function(e){
  calc_total_price();
});

$(document).on("change",".item_pris",function(e){
  calc_total_price();
});

$(document).on("keyup",".discount_add",function(e){
  calc_total_price();
});

  $("#access_prod_add").on("click",function(e){
    e.preventDefault();
    var new_item = $(".access_item:first").clone();
    $("#access_items").append(new_item);
    $(new_item).find(".item_del_div").html('<button class="btn btn-danger btn-xs item_row_delete" style="">X</button>');
     $(new_item).find(".select2-container").remove();
     var select2 = $(new_item).find("select.selectpicker");
     $(new_item).find(".newAccess").addClass('hidden');
     $(new_item).find('.item_pris').val('0');
     $(new_item).find('.discount_add').val('0');
     
     calc_total_price();
     $(new_item).find("select.select_gbs").attr('disabled','disabled');
     select2.select2();
  });

  $("#buy_device").on('hidden.bs.modal', function () {
    $(this).data('bs.modal', null);
    $(this).find(".modal-body form")[0].reset();
    calc_total_price();
  });
  $("#edit_access").on('hidden.bs.modal', function () {
    $(this).data('bs.modal', null);
    $(this).find(".editContent").html("");
    calc_total_price();
  });

  $(document).on("change",".show_name",function(){

    if($(this).is(':checked')){

      $(".name_checked").css("display","block");
    }else{
      $(".name_checked").css("display","none");
    }
  });
</script>
<style>
.space{
  margin-top:14px;
}
.item_del_div{
    margin-right: -8px;
    margin-top: -28px;
    float: right
}

.sell_popup {
    margin-left: -6%;
    width: 790px;
}
.right{
  float: right;
}
.hr_line{
  width: 92%;
    margin-left: 60px;
}
</style>

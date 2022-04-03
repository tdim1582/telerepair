<h1 class="page-header">
	Receipt #<?=$this->uri->segment(3);?>
</h1>
<div class="row">
	<div class="col-md-7">
		<div class="table-responsive">
		<?=form_open(current_url());?>
		<table class="table table-striped">
		  <tbody>
		  	<tr>
		  		<td width="200px">Navn</td>
		  		<td><?=$receipt[0]->name;?></td>
		  	</tr>
		  	<tr>
		  		<td  width="200px">E-mail</td>
		  		<td><?=$receipt[0]->email;?></td>
		  	</tr>
            <tr>
		  		<td  width="200px">Tlf. nummer</td>
		  		<td><?=$receipt[0]->phone;?></td>
		  	</tr>
		  </tbody>
		</table>
		<?=form_close();?>
		</div>
	</div>
	
	<div class="col-md-4 col-md-offset-1">
		<div class="table-responsive">
		<table class="table table-striped">
		  <tbody>
		  	<tr>
		  		<td width="200px">Oprettet af</td>
		  		<td><?=$by_name;?></td>
		  	</tr>
		  	<tr>
		  		<td  width="200px">Taget ind på</td>
		  		<td><?=$boutique_name;?></td>
		  	</tr>
		  	<tr>
		  		<td  width="200px">Oprettet d.</td>
		  		<td><?=date("d/m/Y H:i",$receipt[0]->created_timestamp);?></td>
		  	</tr>
		  </tbody>
		</table>
		</div>
	</div>
	
	<div class="clearfix"></div>
	
	<div class="col-md-7" style="min-width: 1010px;">
		<br /><br />

		<b>Orders</b>
		<div class=""> <!--table-responsive-->
			<table class="table table-striped" id="dtable_access" style="min-width: 1010px;">
				<thead>
					<tr>
						<th style="min-width: 40px;" >#</th>
						<th style="min-width: 210px;" >Tilbehør</th>
						<th style="min-width: 120px;">Tidspunkt</th>
						<th style="min-width: 55px;">Køber</th>
						<th style="min-width: 110px;">Betalingsform</th>
						<th style="min-width: 40px;">Pris</th>
						<th style="min-width: 90px;">Fortjeneste</th>
						<th style="min-width: 200px;"></th>
						<th style="display: none;"></th>
					</tr>
				</thead>
				<tbody>

				</tbody>
			</table>
		</div>

	</div>
	<div class="col-md-7" style="min-width: 780px;">
		<br /><br />

    <div class="col-md-12" style=" padding: 0;">
		<b>Reparation</b>

		<?php
    $this->load->model('product_model');
		$this->load->model('order_model');
		$products = $this->db->get('products')->result();
    ?>
    <div class="col-md-12 " style="padding: 0; display: flex; flex-direction: column;" >
      <div class ="repairs_adding_list"> 
        <div class="col-md-12 " style="padding-right: 10px; padding-left: 0;">
          <div class="col-md-4" style="margin-top: 10px; padding-left: 0;">
            <label>Tilbehør tilhører telefon</label>
            <!-- <div class="space"></div> -->
            <select class="new_repair_model" class="form-control selectpicker" name="model[]" required style="width: 187px;height: 26px;">
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
          <div class="col-md-4" style="margin-top: 10px;display: flex;flex-direction: column;justify-content: space-between;">
            <label>Reparations navn</label>
            <input class="new_repair_name" type="text" class="form-control" placeholder="Reparation" value="" name="name[]">
          </div>
          <div class="col-md-4" style="margin-top: 10px;display: flex;flex-direction: column;justify-content: space-between;">
            <label>Reparations pris</label>
            <input class="new_repair_price" type="text" class="form-control" placeholder="Reparation pris" value="" name="price[]">
          </div>
        </div>
      </div>
      <a href="#" class="add_repair_" style="margin-top: 15px;">Tilføj +</a>
      <input id="new_repair" type="submit" class="btn btn-success" value="Opret reparation" style="margin-top: 15px; width: 187px;" name="create_reparation" />
      <br /><br />
    </div>

		<table class="table table-striped">
			<tbody id="repairs_tabel">
			<?php
			$this->db->where('receipt_id',$receipt[0]->id);
			$this->db->order_by('id','desc');
			$repairs = $this->db->get('repairs')->result();
			if (count($repairs) > 0) {
				?>
  				<thead>
					<tr>
						<th></th>
						<th style="min-width: 140px;">Reparations telefon </th>
						<th style="min-width: 140px;">Reparations navn </th>
						<th style="min-width: 140px;">Reparations pris</th>
            <th>Betaling</th>
            <th></th>
            <th></th>
					</tr>
				</thead>
				<?php
			}
			foreach($repairs as $repair):
				?>
				<tr>
          <th> <input type="checkbox" id="repair_<?= $repair->id?>" class="repair_check" name="scales" ></th>
					<th><?php 
            $this->db->where('id',$repair->product_id);
            $product = $this->db->get('products')->result();
            if (count($product) > 0) {
              echo($product[0]->name);
            } else {
              echo("-");
            }
          ?></th>
					<th><?php
            if ( strlen($repair->name) > 37 ) {
              echo substr($repair->name, 0, 37) . '...';
            } else {
              echo $repair->name;
            }
          ?></th>
					<th><?=$repair->price;?></th>
          <th><?php if($repair->payment_type) {echo('Ja');} else {echo('Ingen');} ?></th>
          <th style="display: flex; position: relative;"> <img class="question-mark" src="<?= base_url(); ?>assets/images/iconmonstr-clock-thin.svg" />
            <div class="hover-display" >
              <?php
              $this->db->where('id',$repair->uid);
              $userinfo = $this->db->get('users_kasse')->result();
              
              if($userinfo){
                $username = $userinfo[0]->name;
              }else{
                $username = '?';
              }
              ?>
              <?=$username;?>, <?=date("d/m/Y H:i",$repair->created_timestamp);?>
            </div>
          </th>
          <th class="repair_delete" id="repair_delete_<?= $repair->id?>">
            <p class="repair_delete_p" style="">  Delete </p>
          </th>

				</tr>
				<?php
			endforeach;
			?>
		 	</tbody>
		</table>

    <a id="pay_repair_" href="#" data-toggle="modal" data-id=[] data-target="#pay_repair" class="btn btn-info btn-xs">Sælg</a> 

    <!-- <a id="print_repairs" target="_blank" href="<?= site_url('receipt/print_repairs'); ?>/<?=$receipt[0]->id ?>?&repairs_list[]=59707&repairs_list[]=59706" class="btn btn-default btn-xs">Kvittering</a> -->
    <a id="print_repairs" target="" href="#" class="btn btn-default btn-xs">Opret</a>
    
		<br /><br />

		
	</div>

	<div class="col-md-7">
	
		<b>Komment status</b>
		
		<?=form_open(current_url());?>
		<select class="form-control" name="comment_status">
			<option value="1" <?php if($receipt[0]->comment_status == '1'): echo 'selected="true"'; endif; ?>>Komment</option>
			<option value="0" <?php if($receipt[0]->comment_status != '1'): echo 'selected="true"'; endif; ?>>No komment</option>
		</select>
		<input type="submit" class="btn btn-success" name="comment_status_update" style="margin-top: 15px" value="Opdater komment status" />
		<?=form_close();?>
		
		<br /><br />
		<hr />
		
		<b>Kommentarer</b>
		<?=form_open(current_url());?>
		<textarea class="form-control" name="comment" rows="5"></textarea>
		<input type="submit" class="btn btn-success" value="Opret kommentar" style="margin-top: 15px" name="create_comment" />
		<?=form_close();?>
		<br /><br />
		<?php
		$this->db->where('receipt_id',$receipt[0]->id);
		$this->db->order_by('id','desc');
		$comments = $this->db->get('receipt_comments')->result();
		
		foreach($comments as $comment):
		
		$this->db->where('id',$comment->uid);
		$userinfo = $this->db->get('users_kasse')->result();
		
		if($userinfo){
			$username = $userinfo[0]->name;
		}else{
			$username = '?';
		}
		?>
		<b><?=$username;?>, <?=date("d/m/Y H:i",$comment->created_timestamp);?></b><br />
		<?=$comment->comment;?>
		<hr />
		<?php
		endforeach;
		?>
	</div>

</div>

<?php global $access_id?>

<div class="modal fade" id="buy_device">
    <div class="modal-dialog">
        <div class="modal-content sell_popup">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Sælg tilbehør</h4>
            </div>
            <div class="modal-body">
                <!-- <?= form_open(current_url()); ?> -->
				<?php if(isset($_SERVER['HTTPS'])){
						$protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
					}
					else{
						$protocol = 'http';
					}
					echo(form_open($protocol . '://' . $_SERVER['HTTP_HOST'] . '/access/edit')); ?>
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


                    </div>

                    <div class="col-md-12">
                      <hr style="    width: 92%;margin-left: 29px;" />
                    </div>
                    <!-- <div class="col-md-12">
                      <div class="col-md-12">
                        <div class="col-md-6">
                          <label>Receipt telefon</label>
                          <div class="space"></div>
                          <?php
                            // $receipts = $this->db->get('receipt')->result();
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
                    </div> -->
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


<div class="modal fade" id="edit_access_inner">
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

<div class="modal fade" id="pay_repair">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Reparationsbetaling</h4>
            </div>
            <div class="modal-body">

                <div class="loader">
                    <center><img src="<?= base_url(); ?>assets/images/loader.gif" /></center>
                </div>

                <div class="editContent_rep" style="display: none">

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

<input type="hidden" class="disableChained" value="1" />

<script>

var columns_full_order = [{"db": "id", "dt": 0, "field": "id"},
        {"db": "part", "dt": 1, "field": "part"},
        {"db": "created_timestamp", "dt": 2, "field": "created_timestamp"},
        {"db": "name", "dt": 3, "field": "name"},
        {"db": "payment_type", "dt": 4, "field": "payment_type"},
        {"db": "price", "dt": 5, "field": "price"},
        {"db": "extra_access_to_order_id", "dt": 6, "field": ""},
        {"db": "address", "dt": 7, "field": ""},
        {"db": "receipt_id", "dt": 8, "field": "receipt_id"}
    ];

var order_table = $("#dtable_access").DataTable({
        "ajax": {
            "type": "POST",
            "url": "<?php echo base_url('dataTable/getTable'); ?>",
            "data": {"table": "orders", "primary_key": 'id', "page": "access", "columns": columns_full_order, "receipt_id": 46236}
        },
        "processing": true,
        "serverSide": true,
        "bStateSave": true,
        "aaSorting": [[0, 'desc']],
        "columnDefs": [
          {
            "targets": 1,
            "render": function (data, type, full, meta) {
                if (full['item_name'].length > 37) {
                  return full['item_name'].substring(1, 37) + '...';
                } else {
                  return full['item_name'];
                }
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
                return  '<a href="#" data-toggle="modal" data-id="'+full[0]+'" data-target="#edit_access_inner" class="btn btn-info btn-xs">Rediger</a> ' +
                        '<a href="#" data-toggle="modal" data-id="'+full[0]+'" data-target="#reason_for_creditnote"  class="btn btn-default btn-xs">Krediter</a> '+
                        '<a target="_blank" href="<?= site_url('export/print_'); ?>/'+full[0]+'" class="btn btn-default btn-xs">Kvittering</a>'
            }
          },
          {
            "targets": 8,
            "render": function (data, type, full, meta) {
                return '';
            }
          },
        ]
    });
    
  order_table.columns(8).search( <?=$this->uri->segment(3);?> ).draw();

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

$("#edit_access_inner").on('hidden.bs.modal', function () {
    $(this).data('bs.modal', null);
    $(this).find(".editContent").html("");
    calc_total_price();
});

$('#edit_access_inner').on('shown.bs.modal', function (event) {
	var siteurl = $('.siteurl').val();
	var button = $(event.relatedTarget) // Button that triggered the modal
	var id = button.data('id')

	$('.loader').show();
	$('.editContent').html('');
	$('.editContent').hide();

	$.ajax({
		type: "POST",
		url: siteurl+"access/inneredit",
		data: { id: id, reciept_id: '<?=$this->uri->segment(3);?>' }
	}).done(function( msg ) {
		$('.loader img').hide();

		$('.editContent').html(msg);

		$('.editContent').fadeIn('fast');

	});


	return false;

});

$("#pay_repair").on('hidden.bs.modal', function () {
    $(this).data('bs.modal', null);
    $(this).find(".editContent_rep").html("");
});

$('#pay_repair').on('shown.bs.modal', function (event) {
	var siteurl = $('.siteurl').val();
	var id = $('input[name=extra_access_to_order_id]').val();
  var repairs_id = $('#pay_repair_').data('id');
	$('.loader').show();
	$('.editContent_rep').html('');
	$('.editContent_rep').hide();

	$.ajax({
		type: "POST",
		url: siteurl+"receipt/repairs_",
		data: { id: id, repairs_id: repairs_id }
	}).done(function( msg ) {
		$('.loader img').hide();

		$('.editContent_rep').html(msg);

		$('.editContent_rep').fadeIn('fast');

	});


	return false;

});


$('.repair_delete').click(function(event) {  //on click
		const id = this.id.split("_")[2];
		if (confirm('Do you want to delete the prapaire?')) {
			const receipt_id = $('input[name=extra_access_to_order_id]').val();
			var siteurl = $('.siteurl').val();
			$.ajax({
				type: "POST",
				url: siteurl+"receipt/repairs_delete",
				data: { id: id, receipt_id: receipt_id }
			}).done(function(msg) {
        const response = JSON.parse(msg);
        if ( response['response'] == "Success" ) {
          location.reload();
        }
			});
		} 
	});

$('#new_repair').on('click', function (event) {
		const siteurl = $('.siteurl').val();
	  const model = $('.new_repair_model');
	  const receipt_id = $('input[name=extra_access_to_order_id]').val();
	  const name = $('.new_repair_name');
	  const price = $('.new_repair_price');
    let alert_ = false;
    for (let i = 0; i < name.length; i++) {
      if (model[i].value == '' || name[i].value == '' || price[i].value == '') {
        alert_ = true;
      } else {
        $.ajax({
          type: "POST",
          url: siteurl+"receipt/create_reparation",
          data: { 
            receipt_id: receipt_id,
            model: model[i].value,
            name: name[i].value,
            price: price[i].value,
        }
        }).done(function( msg ) {
          $("#repairs_tabel").append(msg);
          model[i].parentNode.parentNode.remove();
        });
      } 
    }

    if (alert_) {
      alert("Fill al reparation field!");
    } else {
      const siteurl = $('.siteurl').val();
      $.ajax({
        type: "POST",
        url: siteurl+"receipt/empty_new_rep",
        data: {}
      }).done(function( msg ) {
        $(".repairs_adding_list").append(msg);
      });
    }

		return false;
	
});

$('.add_repair_').click(function(){
	const siteurl = $('.siteurl').val();
  $.ajax({
    type: "POST",
    url: siteurl+"receipt/empty_new_rep",
    data: {}
  }).done(function( msg ) {
    $(".repairs_adding_list").append(msg);
  });
  
  return false;
});

$(document).on("change",".select_devices",function(e, access_id){
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

</script>

<style> 
#dtable_access_info {
	display: none;
}

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

.hover-display {
  visibility: hidden;
  padding: 10px 10px;
  position: absolute;
  z-index: 1;
  background-color: #cdd;
  text-align: center;
  border-radius: 6px;
  width: 250px;
  top: 35px;
}

.question-mark:hover + .hover-display {
  visibility: visible;
}

.repair_delete_p {
  background-color: red; 
  padding: 5px 5px; 
  border: solid 2px red; 
  border-radius: 5px; 
  color: #000; 
  text-align: center; 
  margin-bottom: 0;
}

</style>
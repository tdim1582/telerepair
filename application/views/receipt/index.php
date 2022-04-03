<?php
if($this->input->get('open_receipt')):
?>
<script type="text/javascript">
var win = window.open('<?=site_url();?>receipt/print_/<?=$this->input->get('open_receipt');?>', '_blank');
win.focus();

top.location.href = '<?=site_url('receipt');?>';
</script>
<?php
endif;
?>


<div class="modal fade" id="receipt_edit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Rediger</h4>
      </div>
      <div class="modal-body">

      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="receipt">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Opret kvittering</h4>
      </div>
      <div class="modal-body">

        <form class="form-signin" action="<?=current_url();?>" method="POST">

          <div class="row">

          <div class="col-md-6" style="margin-bottom: 10px;">
              <input type="text" autocomplete="off" class="form-control" required name="name" placeholder="Navn">
          </div>


          <div class="col-md-6" style="margin-bottom: 10px;">
              <input type="email" autocomplete="off" class="form-control" id="customer_email"  name="email" placeholder="Email">
          </div>



          <div class="col-md-6" style="margin-bottom: 10px;">
              <input type="text" autocomplete="off" class="form-control" name="phone_code" placeholder="Tlf kode">
          </div>

          <div class="col-md-6" style="margin-bottom: 10px;">
              <input type="text" autocomplete="off" class="form-control" id="customer_phone" required name="phone" placeholder="Telefon">
          </div>

          <div class="col-md-6" style="margin-bottom: 10px;">
              <input type="text" autocomplete="off" class="form-control" name="pin" placeholder="Pin">
          </div>
          
          <div class="col-md-6" style="margin-bottom: 10px;">
              <input type="text" autocomplete="off" class="form-control" name="pickup_time" placeholder="Afhentnings tidspunkt">
          </div>

          <div class="col-md-6" style="margin-bottom: 10px;">
            <!--<label>Tilbehør tilhører telefon</label>-->
            <select class="form-control selectpicker select_devices" name="product_id" required style="width: 268px;">
                <option value="">- Vælg enhed -</option>
                <?php
                foreach ($products as $product):
                    ?>
                    <option value="<?= $product->id; ?>"><?= $product->name; ?></option>
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
              <textarea name="description" style="width: 100%" class="form-control" placeholder="Beskrivelse"></textarea>
          </div>

	        <hr />


	        <div class="repairs" style="margin-bottom: 10px;">
<?php 
	if($this->input->get('action') == 'create' && $this->input->get('repair')){
		$repair = $this->input->get('repair');
		$repairs = explode("<br />",$repair);
		foreach($repairs as $key=>$repair){
?>
		        <div class="col-md-6" style="margin-bottom: 10px;">
		        	<?php if($key == 0){ ?><label>Reparations navn</label><?php } ?>
		        	<input type="text" class="form-control" placeholder="Reparation" value="<?php echo $repair; ?>"  name="repair_name[]">
		        </div>
		        <div class="col-md-6" style="margin-bottom: 10px;">
		        	<?php if($key == 0){ ?><label>Reparations pris</label><?php } ?>
		        	<input type="text" class="form-control" placeholder="Reparation pris"  name="repair_price[]">
		        </div>
		<?php } ?>
	<?php }else{ ?>
				<div class="col-md-6" style="margin-bottom: 10px;">
		        	<label>Reparations navn</label>
		        	<input type="text" class="form-control" placeholder="Reparation"  name="repair_name[]">
		        </div>
		        <div class="col-md-6" style="margin-bottom: 10px;">
		        	<label>Reparations pris</label>
		        	<input type="text" class="form-control" placeholder="Reparation pris"  name="repair_price[]">
		        </div>
	<?php } ?>
	        </div>



			<div class="col-md-6" style="margin-bottom: 10px;">
        <a href="#" class="add_repair">Tilføj +</a><br />
        <label>Discount (%)</label>
        <input type="text" name="discount" value='0' class="form-control" />
        <br />
				<input type="checkbox" name="paid" value="1" />
				<label style="padding-right: 20px;">Betalt?</label>
        <label>
          <input type="checkbox" name="comment_status" class="comment_status" <?php if($receipt->comment_status == 1){ echo "checked"; } ?> value="1" />
          Koment
        </label>
			</div>
      <div class="col-md-6" style="margin-bottom: 10px;">

      </div>
      <div class="col-md-12" style="margin-bottom: 10px;">
        
        <textarea name="comment" style="width: 100%; display: none;" class="form-control comment_vis" placeholder="Koment" ></textarea>
      </div>
			<br /><br />

			<div class="col-md-12">
				<input type="submit" class="btn btn-success" name="create" value="Opret" />
        <!--<input type="submit" class="btn btn-info" name="create_print" value="Opret og udskrive kvittering" />-->
			</div>

	        </div>

		</form>

      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<h1 class="page-header">
	Indleveringskvitteringer

	<div class="pull-right">

		<a href="#" class="btn btn-success" data-toggle="modal" data-target="#receipt">Opret</a>
	</div>

</h1>


<table class="table table-striped datatable" id="datatable_receipt">
  <thead>
    <tr>
      <th>#</th>
      <th>Navn</th>
      <th>Dato</th>
	  <th>Enhed</th>
	  <th>Betalt</th>
	  <!--<th>Udleveret</th>-->
      <th></th>
      <th style="display: none;"></th>
      <th style="display: none;"></th>
    </tr>
  </thead>
  <tbody>

  </tbody>
</table>

<div class='hidden' id='print_now'></div>
<input type="hidden" class="disableChained" value="1" />

<script>
<?php if($this->input->get('print_now')){ ?>
var win = window.open('<?php echo base_url('receipt/print_/'.$this->input->get('print_now')); ?>','_blank');
if (win) {
    //Browser has allowed it to be opened
    win.focus();
} else {
    //Browser has blocked it
    alert('Please allow popups for this website');
}
<?php } ?>
var columns_full = [{"db": "id", "dt": 0, "field": "id"},
        {"db": "name", "dt": 1, "field": "name"},
        {"db": "created_timestamp", "dt": 2, "field": "created_timestamp"},
		    {"db": "product_id", "dt": 3, "field": "product_id"},
        {"db": "paid", "dt": 4, "field": "paid"},
        {"db": "total_after_discount", "dt": 5, "field": "total_after_discount"},
        {"db": "comment_status", "dt": 6, "field": "comment_status"},
        {"db": "phone", "dt": 7, "field": "phone"},
    ];

  var table = $("#datatable_receipt").DataTable({
        "ajax": {
            "type": "POST",
            "url": "<?php echo base_url('dataTable/getTable'); ?>",
            "data": {"table": "receipt", "primary_key": 'id', "page": "receipt", "columns": columns_full}
        },
        "processing": true,
        "serverSide": true,
        "bStateSave": true,
        "aaSorting": [[6, 'desc'], [0, 'desc']],
        "columnDefs": [
          {
            "searchable": true,
            "targets": 1,
            "render": function (data, type, full, meta) {
              return '<a href="<?= site_url('receipt/show'); ?>/'+full[0]+'" class="" style="text-decoration: none; color: #333;">' + data + '</a> ';
            }
          },
		      {
            "targets": 3,
            "render": function (data, type, full, meta) {
              return full['product_name'];
            }
          },
          {
            "targets": 4,
            "render": function (data, type, full, meta) {
              if (full[6] == '1') {
                return "<span class='label label-danger'>Attention</span>"
              } else {
                if(data == '1'){
                  return "<span class='label label-info'>Betalt</span>";
                }else{
                  return "<span class='label label-warning'>Ikke betalt</span>";
                }
              }
            }
          },
          {
            "targets": 5,
            "render": function(data, type, full, meta){
                return  '<a href="<?= site_url('receipt/edit'); ?>/'+full[0]+'" class="btn btn-info btn-xs receipt_edit">Rediger</a> ' +
                        '<a target="_blank" href="<?= site_url('receipt/print_'); ?>/'+full[0]+'" class="btn btn-default btn-xs">Kvittering</a>'+
                        '<a href="<?= site_url('receipt/edit'); ?>/'+full[0]+'" class="btn btn-danger btn-xs receipt_edit" style="margin-left: 5px;">Komment</a> '
            }
          },
          {
            "targets": 6,
            "render": function(data, type, full, meta){
                return  '';
            }
          },
          {
            "targets": 7,
            "render": function(data, type, full, meta){
                return  '';
            }
          },
        ]
    });

$(document).on("click",".receipt_edit",function(e){
  e.preventDefault();
  var href = $(this).attr('href');

  $.ajax({
    url: href,
    type: 'GET',
    success: function(result){
      $("#receipt_edit").find(".modal-body").html(result);
    },
    complete: function(){
      $("#receipt_edit").modal('show');
	  $(".selectpicker").select2();
    }
  });


});


$(document).on("change",".select_devices",function(e){
    e.preventDefault();
    var device = $(this).val();
    var form = $(this).parents("form");
    if(device == 'diverse'){
      form.find(".product_name").removeClass('hidden');
      form.find("input[name='product_name']").prop('required',true);
    }else{
      form.find(".product_name").addClass('hidden');
      form.find("input[name='product_name']").prop('required',false);
    }

});

$(document).on("blur","#customer_phone",function(e){
    var phone = $(this).val();
    var form = $(this).parents("form");
    if(phone.length > 4){
      $.ajax({
        url: "<?php echo base_url('customer/get_json_by_phone'); ?>",
        type: "GET",
        dataType: "json",
        data: {phone: phone},
        success: function(data){
          if(data.id){
            form.find("input[name='name']").val(data.name);
            form.find("input[name='email']").val(data.email);
      			form.find("input[name='phone_code']").val(data.phone_code);
      			//form.find("input[name='phone']").val(data.phone);
      			form.find("input[name='pin']").val(data.pin);
            form.find("input[name='discount']").val(data.discount);
          }
        }
      });
    }
});

<?php
if($this->input->get('action') == 'create'){
?>
  $("#receipt").find("input[name='name']").val("<?php echo $this->input->get('name'); ?>");
  $("#receipt").find("input[name='phone']").val("<?php echo $this->input->get('phone'); ?>");
  $("#receipt").find("input[name='email']").val("<?php echo $this->input->get('email'); ?>");
  <?php if($this->input->get('product')){
    $product_id_q = $this->db->select('id')->where('name',$this->input->get('product'))->get('products');
    if($product_id_q->num_rows()){
      $product_id = $product_id_q->row()->id;
    }else{
      $product_id = 0;
    }
    ?>
    $("#receipt").find("select[name='product_id']").val("<?php echo $product_id; ?>");
  <?php } ?>
  $("#receipt").modal('show');

<?php } ?>

//$(".datatable").dataTable();
</script>

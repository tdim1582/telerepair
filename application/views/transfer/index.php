<h1 class="page-header">
	Overførsler

	<div class="pull-right" style="font-size: 12px">
		<a href="<?=site_url('transfer');?>" class="btn btn-<?php if($this->uri->segment(2) == false): echo 'primary'; else: echo 'default'; endif; ?>">Alle</a>
		<a href="<?=site_url('transfer/2');?>" class="btn btn-<?php if($this->uri->segment(2) == 2): echo 'primary'; else: echo 'default'; endif; ?>">Ikke overført</a>
		<a href="<?=site_url('transfer/1');?>" class="btn btn-<?php if($this->uri->segment(2) == 1): echo 'primary'; else: echo 'default'; endif; ?>">Overført</a>
		<a href="<?=site_url('transfer/3');?>" class="btn btn-<?php if($this->uri->segment(2) == 3): echo 'primary'; else: echo 'default'; endif; ?>">Forkert</a>

			<select class="form-control select_boutique" style="width: 120px;float: right;margin-left: 5px;padding:2px;">
				<option value=''>All Butik</option>
			<?php
			$this->db->where('active', 1);
			$this->db->order_by('name', 'asc');
			$boutiques = $this->db->get('boutiques')->result_array();
			foreach($boutiques as $boutique){
			?>
			<option value="<?php echo $boutique['id']; ?>" <?php if(isset($_GET['boutique_id']) && ($_GET['boutique_id'] == $boutique['id'])){ ?>selected<?php } ?>><?php echo $boutique['name']; ?></option>
		<?php } ?>
			</select>
	</div>

</h1>

<?=form_open(current_url());?>

<div>
<table class="table table-striped" id="dtable_transfer">
  <thead>
    <tr>
      <th>#</th>
      <th>Beløb</th>
      <th>Model</th>
      <th>Dato</th>
      <th>Reg-konto</th>
      <th align="right" width="180">
      	<input type="submit" style="float: right; margin-right: 20px" class="btn btn-info btn-xs" name="bulk_transfer" value="Bulk overfør"  />
      </th>
      <th>Butik</th>
    </tr>
  </thead>
  <tbody>

  </tbody>
</table>
</div>

<input type="hidden" class="disableChained" value="1" />



<script>
var columns_full = [
        {"db": "id", "dt": 0, "field": "id"},
        {"db": "price", "dt": 1, "field": "price"},
        {"db": "product", "dt": 2, "field": "product"},
        {"db": "created_timestamp", "dt": 3, "field": "created_timestamp"},
        {"db": "reg_nr", "dt": 4, "field": "reg_nr"},
        {"db": "transfered", "dt": 5, "field": "transfered"},
		{"db": "gb", "dt": 6, "field": "gb"},
		{"db": "account_nr", "dt": 7, "field": "account_nr"},
		{"db": "wrong", "dt": 8, "field": "wrong"},
		{"db": "boutique_id", "dt": 9, "field": "boutique_id"}
    ];

$("#dtable_transfer").DataTable({
        "ajax": {
            "type": "POST",
            "url": "<?php echo base_url('dataTable/getTable'); ?>",
            "data": {"table": "orders", "primary_key": 'id', "page": "transfer", "columns": columns_full, "status": "<?php echo $status; ?>","boutique_id":"<?php echo $_GET['boutique_id'];?>"},
						"complete": function(){
							$('.regnr').editable();
							$('.kontonr').editable();
						}
        },
        "processing": true,
        "serverSide": true,
        "bStateSave": false,
        "aaSorting": [[5, 'asc'],[0, 'asc']],
        "columnDefs": [
          {
            "targets": 0,
            "render": function (data, type, full, meta) {
                return '<a href="<?=site_url('orders/show/');?>/'+full[0]+'" style="color: #fff">'+full[0]+'</a>';
            }
          },
          {
            "targets": 2,
            "render": function (data, type, full, meta) {
                return full[2] +", "+ full[6]+"GB";
            }
          },
					{
            "targets": 4,
            "render": function (data, type, full, meta) {

							return '<span class="regnr" style="cursor: pointer;" data-name="regnr" data-type="text" data-pk="'+full[0]+'" data-url="<?=site_url();?>transfer/edit" data-title="Rediger reg. nr">'+full[4]+'</span>'
      				+' - '+
      				'<span class="kontonr" style="cursor: pointer;" data-name="kontonr" data-type="text" data-pk="'+full[0]+'" data-url="<?=site_url();?>transfer/edit" data-title="Rediger konto nr">'+full[7]+'</span>'

            }
          },
					{
            "targets": 5,
            "render": function (data, type, full, meta) {
							var str = "";
							if(!full[5] || full[5]=='0'){
								str += '<a href="<?=site_url('transfer/complete/');?>/'+full[0]+'?r=<?php echo current_url();?>" class="btn btn-default btn-sm">Overfør</a>';
								if(full[8] == '1'){
									str += ' <a href="#" class="btn btn-default btn-sm">Sat forkert</a>';
								}else{
									str += ' <a href="<?=site_url('transfer/mark_as_wrong/');?>/'+full[0]+'?r=<?php echo current_url();?>" class="btn btn-info btn-sm">Forkert</a>'
									str += ' <input type="checkbox" name="bulk[]" class="bulkCheck" value="'+full[0]+'" style="margin-left: 10px" />';
								}
							}

							return str;
            }
          },
          {
            "targets": 6,
            "render": function (data, type, full, meta) {
              return full[9];
              
            }
          }
          
        ],
				"createdRow": function ( row, data, index ) {
					if(data[5] == '1'){
						$(row).css('background','#91bb22');
					}else{
						$(row).css('background','#e5443f');
					}
				}
    });

		$(document).on("change",".select_boutique",function(e){
			var boutique_id = $(this).val();
			if(boutique_id){
				location.href = "<?php echo base_url('transfer'); ?>?boutique_id="+boutique_id;
			}else{
				location.href = "<?php echo base_url('transfer'); ?>";
			}

		});

</script>

<style>
	#dtable_transfer td:nth-child(2),#dtable_transfer td:nth-child(3),#dtable_transfer td:nth-child(4){
		color: #FFF;
	}
</style>

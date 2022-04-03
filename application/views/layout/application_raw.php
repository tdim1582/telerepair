<?php
$rank_permissions = $this->global_model->get_rank_permissions();
$me = $this->global_model->me();

$boutiques = $this->global_model->get_boutiques();
?>
<!DOCTYPE html>
<html lang="da">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title><?php if(isset($title)): echo $title; endif; ?></title>

   <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="<?=base_url();?>assets/css/bootstrap.css">
	

    <!-- Custom styles for this template -->
    <link href="<?=base_url();?>assets/css/style.css" rel="stylesheet">

	<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

	  
    <div class="container">
          
      <div class="row">

        <div class="col-sm-12 col-md-12">
 
          <?php
          $data['rank_permissions'] = $rank_permissions;
          $this->load->view($yield,$data);
          ?>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?=base_url();?>assets/js/jquery.js"></script>
    <script src="<?=base_url();?>assets/js/bootstrap.js"></script>
    
    <script src="<?=base_url();?>assets/js/chained.js"></script>
    
    <script src="<?=base_url();?>assets/js/Chart.min.js"></script>
    
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
    
    <script src="<?=base_url();?>assets/js/custom.js"></script>
    
    <?php
    if($this->input->get('modal')):
	?>
	<script type="text/javascript">
	$(document).ready(function() {
	   $('#buy_device').modal('show');   
	});
	</script>
	<?php
	endif;
	?>
	
	<script type="text/javascript">
    $(document).ready(function() {
    	
    	$('.add_repair').click(function(){
	    	
	    	$('.repairs').append('<div class="col-md-6" style="margin-top: 10px">\
		        	<label>Reparations navn</label>\
		        	<input type="text" class="form-control" placeholder="Reparation"  name="repair_name[]">\
		        </div>\
		        <div class="col-md-6" style="margin-top: 10px">\
		        	<label>Reparations pris</label>\
		        	<input type="text" class="form-control" placeholder="Reparation pris"  name="repair_price[]">\
		        </div>');
	    	
	    	return false;
    	});
    	  
	});

    </script>
    
  </body>
</html>

<input type="hidden" class="siteurl" value="<?=site_url();?>" />

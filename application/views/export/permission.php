
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Rettighedsliste</title>
    <meta name="description" content="">
    <meta name="author" content="">
	
	<style type="text/css">
		body{
			font-family: arial, sans-serif;
			font-size: 16px;
		}
		
		.check{
			color: #94bc20;
			font-size: 18px;
		}
		
		.print_text{
			color: #a9a9a9;
			font-size: 11px;
		}
		
		.test_device_list tr td{
			padding-bottom: 15px;
		}
		
		.filledbg{
			background: #2e2e2e;
			color: #2e2e2e;
			text-align: center;
			font-weight: bold;
		}

	</style>
	
	<link rel="stylesheet" href="<?=base_url();?>assets/css/bootstrap.css">
	
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

  </head>

  <body style="width: 1150px; margin: auto">
	<h1 class="page-header">
		Rettighedsliste
	</h1>
	
	<table class="table table-striped table-bordered">
		<tr>
			<td></td>
			<?php
			$ranks = $this->db->get('ranks')->result();
			foreach($ranks as $rank):
			?>
			<td><b><?=$rank->name;?></b></td>
			<?php
			endforeach;
			?>
		</tr>
		
		<?php
		$permission_list = $this->global_model->permission_array();
		foreach($permission_list as $key => $permission):
		?>
		<tr>
			<td width="280px"><?=$permission;?></td>
			<?php
			foreach($ranks as $rank):
			
			$mystring = $rank->permission;
			$findme   = $key;
			$pos = strpos($mystring, $findme);
			if ($pos !== false || $rank->permission == 'all') {
				$class = 'filledbg';
				$class_text = 'X';
			}else{
				$class = '';
				$class_text = '';
			}
			?>
			<td class="<?=$class;?>"><?=$class_text;?></td>
			<?php
			endforeach;
			?>
		</tr>
		<?php
		endforeach;
		?>
	</table>
	
	</body>
</html>
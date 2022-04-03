<div class="modal fade" id="new_user">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Opret rettighed</h4>
      </div>
      <div class="modal-body">
        
        <?=form_open(current_url());?>
        
        <label>Navn</label>
        <input type="text" class="form-control" name="name" required style="margin-bottom: 10px" />
        
        
        <label>Rettigheder</label>
        
        <!--- SÆLG ENHED --->
        <?php
        $permission_list = $this->global_model->permission_array();
        
        foreach($permission_list as $permission => $real_name):
        ?>
        <div class="checkbox">
		  <label>
		    <input type="checkbox" value="<?=$permission;?>" name="permissions[]" /> <?=$real_name;?>
		  </label>
		</div>
        <?php
        endforeach;
        ?>

        <input type="submit" class="btn btn-success" name="create_permission" value="Opret rettighed" style="margin-top: 20px" />
        
        <?=form_close();?>
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="edit_permission">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Rediger rettighed</h4>
      </div>
      <div class="modal-body">
        
        <div class="loader">
        <center><img src="<?=base_url();?>assets/images/loader.gif" /></center>
        </div>
        
        <div class="editContent" style="display: none">
	        
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<h1 class="page-header">
	Rettigheder
	
	<div class="pull-right">
		<a href="#" class="btn btn-success" data-toggle="modal" data-target="#new_user">Opret ny rettighed</a>
	</div>
	
</h1>

<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>ID</th>
      <th>Navn</th>
      <th>Rettigheder</th>
      <th>Oprettet</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  	<?php
  	foreach($rank_list as $rank):
  	?>
    <tr>
      <th><?=$rank->id;?></th>
      <td><?=$rank->name;?></td>
      <td>
      	<?php
      	$explode = explode(", ",$rank->permission);
      	
      	foreach($explode as $permission_text){
      		$result = isset($permission_list[$permission_text]) ? $permission_list[$permission_text] : null;
      		echo '- '.$result.' <br />';
	  	}
	  	?>
      </td>
      <td><?=date("d/m/Y H:i",$rank->created_timestamp);?></td>
      <td width="150px">
      	<a href="#" class="btn btn-info btn-xs" data-toggle="modal" data-id="<?=$rank->id;?>" data-target="#edit_permission">Rediger</a>
      	<a href="<?=site_url('users/cancel_permission/'.$rank->id);?>" class="confirm btn btn-default btn-xs">Deaktiver</a>
      </td>
    </tr>
    <?php
    endforeach;
    ?>
  </tbody>
</table>
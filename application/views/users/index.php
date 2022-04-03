<div class="modal fade" id="new_user">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Opret bruger</h4>
      </div>
      <div class="modal-body">
        
        <?=form_open(current_url());?>
        
        <label>Navn</label>
        <input type="text" class="form-control" name="name" required style="margin-bottom: 10px" />
        
        <label>Email</label>
        <input type="text" class="form-control" name="email" required style="margin-bottom: 10px" />
        
        <label>Personligt ID</label>
        <input type="text" class="form-control" name="personal_id" required style="margin-bottom: 10px" />
        
        <label>Rank</label>
        <select class="form-control" name="rank" required min="1" style="margin-bottom: 20px">
        	<option value="">Vælg rank</option>
        	<?php
        	foreach($rank_list as $rank):
        	?>
        	<option value="<?=$rank->id;?>"><?=$rank->name;?></option>
        	<?php
        	endforeach;
        	?>
        </select>
        
        
        <label>Brugeren har adgang til følgende butikker</label>
        <?php
        $boutiques = $this->global_model->get_boutiques();
        
        foreach($boutiques as $boutique){
	    ?>
	    <div class="checkbox">
		  <label>
		    <input type="checkbox" value="<?=$boutique->id;?>" name="boutiques[]" /> <?=$boutique->name;?>,
		  </label>
      <label>
        <input type="checkbox" value="<?=$boutique->id;?>" name="raport_email_boutiques[]" />
        Email in raport
      </label>
		</div>
	    <?php  
        }
        ?>
        
        <input type="submit" class="btn btn-success" name="create_user" value="Opret bruger" style="margin-top: 20px" />
        
        <?=form_close();?>
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="edit_user">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Rediger bruger</h4>
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
	Brugere
	
	<div class="pull-right">
		<a href="#" class="btn btn-success" data-toggle="modal" data-target="#new_user">Opret ny bruger</a>
	</div>
	
</h1>

<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>ID</th>
      <th>Navn</th>
      <th>Email</th>
      <th>Personligt ID</th>
      <th>Oprettet</th>
      <th>Sidste login</th>
      <th>Rank</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  	<?php
  	foreach($users as $user):
  	?>
    <tr>
      <th><?=$user->id;?></th>
      <td><?=$user->name;?></td>
      <td><?=$user->email;?></td>
      <td><?=$user->personal_id;?></td>
      <td><?=date("d/m/Y H:i",$user->created_timestamp);?></td>
      <td>
      	<?php
      	if(!$user->last_login){
      		echo '-';
      	}else{
      		echo date("d/m/Y H:i",$user->last_login);
      	}
      	?>
      </td>
      <td><?=$this->global_model->get_rank($user->rank);?></td>
      <td width="150px">
      	<a href="#" class="btn btn-info btn-xs" data-toggle="modal" data-id="<?=$user->id;?>" data-target="#edit_user">Rediger</a>
      	<a href="<?=site_url('users/cancel/'.$user->id);?>" class="confirm btn btn-default btn-xs">Deaktiver</a>
      </td>
    </tr>
    <?php
    endforeach;
    ?>
  </tbody>
</table>

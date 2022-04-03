<?=form_open(current_url());?>
        
<label>Navn</label>
<input type="text" class="form-control" value="<?=$user[0]->name;?>" name="name" required style="margin-bottom: 10px" />

<label>Email</label>
<input type="text" class="form-control" value="<?=$user[0]->email;?>" name="email" required style="margin-bottom: 10px" />

<label>Personligt ID</label>
<input type="text" class="form-control" value="<?=$user[0]->personal_id;?>" name="personal_id" required style="margin-bottom: 10px" />

<label>Adgangskode <small>(efterlad blankt hvis det ikke skal rettes)</small></label>
<input type="text" class="form-control" name="password" style="margin-bottom: 10px" />

<label>Rank</label>
<select class="form-control" name="rank" required min="1" style="margin-bottom: 20px">
	<option value="0">Vælg rank</option>
	<?php
	foreach($rank_list as $rank):
	?>
	<option value="<?=$rank->id;?>" <?php if($user[0]->rank == $rank->id): echo 'selected="true"'; endif; ?>><?=$rank->name;?></option>
	<?php
	endforeach;
	?>
</select>

<label>Brugeren har adgang til følgende butikker</label>
<?php
$boutiques = $this->global_model->get_boutiques();

//ID fix string for stores the user has access to. We have a space " " at the start of each store and a comma "," at the end of each store in the database string.
$stores = " ".$user[0]->boutiques.",";
$email_stores = " ".$user[0]->raport_email_boutiques.",";

foreach($boutiques as $boutique){
?>
<div class="checkbox">
  <label>
    <input type="checkbox" <?php if($stores){ if (strpos($stores," ".$boutique->id.",") !== false) { echo 'checked="true"'; } } ?> value="<?=$boutique->id;?>" name="boutiques[]" /> <?=$boutique->name;?>,
  </label>
  <label>
    <input type="checkbox" <?php if($stores){ if (strpos($email_stores," ".$boutique->id.",") !== false) { echo 'checked="true"'; } } ?> value="<?=$boutique->id;?>" name="raport_email_boutiques[]" />
	Email in raport
  </label>
</div>
<?php  
}
?>

<input type="hidden" name="uid" value="<?=$user[0]->id;?>" />
<input type="submit" class="btn btn-success" name="edit_user" value="Opret bruger" style="margin-top: 20px" />

<?=form_close();?>

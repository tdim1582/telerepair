<?=form_open(current_url());?>

<label>Navn</label>
<input type="text" class="form-control" name="name" value="<?=$rank_list[0]->name;?>" required style="margin-bottom: 10px" />


<label>Rettigheder</label>

<!--- SÆLG ENHED --->
<?php
$permission_list = $this->global_model->permission_array();

foreach($permission_list as $permission => $real_name):
?>
<div class="checkbox">
  <label>
    <input type="checkbox" value="<?=$permission;?>" <?php if (strpos($rank_list[0]->permission,$permission) !== false) { echo 'checked="true"'; } ?>  name="permissions[]" /> <?=$real_name;?>
  </label>
</div>
<?php
endforeach;
?>

<input type="hidden" value="<?=$rank_list[0]->id;?>" name="id" />
<input type="submit" class="btn btn-success" name="edit_permission" value="Rediger rettighed" style="margin-top: 20px" />

<?=form_close();?>
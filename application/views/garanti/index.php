<h1 class="page-header">
  Garanti  
	<div class="pull-right"><a href="<?=site_url('garanti/create');?>" class="btn btn-success">Opret Garanti</a></div>
</h1>

<div class="table-responsive">
<table class="table table-striped">
  <thead>
    <tr>
      <th>Garanti Name</th>
      <th>Garanti Description</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
  	<?php

  	foreach($GarantiData as $Garanti_values):

  	
  	?>
    <tr>
    
      <td><?=$Garanti_values['name'];?></td>
      <td><?=$Garanti_values['text'];?></td>
      <td>
        <a href="<?php echo base_url('garanti/create/'.$Garanti_values['id']); ?>"  class="btn btn-sm btn-success">Rediger</a>
        <a onclick="return confirm('Are you sure want to delete this item?')" href="<?php echo base_url('garanti/delete_garanti/'.$Garanti_values['id']); ?>" class="btn btn-sm btn-danger">Slet</a>
      </td>
     
      
    </tr>
    <?php
    endforeach;
    ?>
  </tbody>
</table>

<?php /*$this->pagination->create_links(); */ ?>

</div>

<input type="hidden" class="disableChained" value="1" />
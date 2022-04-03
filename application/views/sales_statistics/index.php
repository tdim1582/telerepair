<h1 class="page-header">
    <?php echo $title; ?>
        
    <div class="pull-right" style="padding-top: 5px">
        <form action="<?=current_url();?>" method="GET">
        <select class="form-control" name="boutique" style="width: 150px; float: left; margin-right: 10px">
            <option value="all" <?php if($this->input->get('boutique') == 'all'){ echo 'selected="true"'; } ?>>Alle</option>
            <?php
            $this->db->where('active',1);
            $this->db->order_by('id','desc');
            $boutiques = $this->db->get('boutiques')->result();
            
            foreach($boutiques as $boutiques){
                    if($this->input->get('boutique') == $boutiques->id || $this->session->userdata('active_boutique') == $boutiques->id && $this->input->get('boutique') == false){
                            $selected = 'selected="true"';
                    }else{
                            $selected = '';
                    }
                    echo '<option value="'.$boutiques->id.'" '.$selected.'>'.$boutiques->name.'</option>';
            }
            ?>
        </select>
        
        <? // input type month not compatible with firefox etc. https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/month 
        
        ?>
        <select id="month_filter" name="month_filter" class="form-control" style="width: 150px; float: left; margin-right: 10px">
            <option>January</option>
            <option>February</option>
            <option>March</option>
            <option>April</option>
            <option>May</option>
            <option>June</option>
            <option>July</option>
            <option>August</option>
            <option>September</option>
            <option>October</option>
            <option>November</option>
            <option>December</option>
        </select>
        
        <script type="text/javascript">
            document.getElementById('month_filter').value = "<?php echo $_GET['month_filter'];?>";
        </script>

        <input type="submit" class="btn btn-info" style="float: left; margin-left: 10px" value="Filtrer" />
        <?=form_close();?>
    </div>
</h1>

<div>
    <h2><?php echo ucfirst($choosen_month); ?></h2>
    
   <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th class="th-sm">Navn</th>
                <th class="th-sm">Salgstal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($user_names as $key=>$names): ?>
                <tr>
                    <td><?php echo $names; ?></td>
                    <td><?php echo $user_sales[$key]; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>    
</div>

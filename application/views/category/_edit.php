<?=form_open(current_url());?>
<div class="row">

    <div class="col-md-6">
        <label>Navn</label>
        <input type="text" class="form-control" value="<?=$categories->name;?>" name="name" required style="margin-bottom: 10px" />
        
        <label>Parent</label>
        <?php
        $this->load->model('category_model');
        $categories_ = $this->category_model->get_category();
        ?>
        <select class="form-control selectpicker select_devices" name="parent" style="width: 268px;">
            <option value="">- Vælg catgory -</option>
            <?php
            foreach ($categories_ as $category):
                if ($category->parent == 0 && $category->id != $categories->id) {
                    ?>
                    <option value="<?= $category->id; ?>" <?php if($category->id == $categories->parent) {echo 'selected';}?>><?= $category->name; ?></option>
                    <?php
                }
            endforeach;
            ?>
        </select>
    </div>

    <div class="col-md-12">
    	<input type="hidden" name="id" value="<?=$categories->id;?>" />
    	<input type="submit" class="btn btn-success" name="submit_category" value="Opdater" style="margin-top: 20px" />
    </div>

</div>
<?=form_close();?>
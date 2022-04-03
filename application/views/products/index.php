<div class="modal fade" id="buy_device">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Opret enhed</h4>
            </div>
            <div class="modal-body">

                <?= form_open(current_url()); ?>
                <div class="row">

                    <div class="col-md-6">
                        <label>Navn</label>
                        <input type="text" class="form-control" name="name" required style="margin-bottom: 10px" />
                    </div>

                    <div class="col-md-6">
                        <label>GB</label>

                        <!--- SÆLG ENHED --->
                        <?php
                        $permission_list = $this->global_model->gbs();

                        foreach ($permission_list as $permission => $real_name):
                            ?>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="<?= $permission; ?>" name="gbs[]" /> <?= $real_name; ?>
                                </label>
                            </div>
                            <?php
                        endforeach;
                        ?>
                    </div>

                    <div class="col-md-12">
                        <input type="submit" class="btn btn-success" name="submit_product" value="Opret" style="margin-top: 20px" />
                    </div>

                </div>
                <?= form_close(); ?>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="edit_device_phone">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Rediger enhed</h4>
            </div>
            <div class="modal-body editContent">

                <center><img src="<?= base_url(); ?>assets/images/loader.gif" /></center>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<h1 class="page-header">
    Enheder
    <div class="pull-right">
        <a href="#" class="btn btn-success" data-toggle="modal" data-target="#buy_device">Opret enhed</a>
    </div>
</h1>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Enhed</th>
                <th>Dato</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="prod_sort">
            <?php
            foreach ($products as $product):
                ?>
                <tr id="item-<?php echo $product->id; ?>">
                    <td><?= $product->id; ?></td>
                    <td>
                        <?= $product->name; ?>
                    </td>
                    <td><?= date("d/m/Y H:i", $product->created_timestamp); ?></td>
                    <td width="150px">
                        <a href="#" class="btn btn-info btn-xs" data-toggle="modal" data-id="<?= $product->id; ?>" data-target="#edit_device_phone">Rediger</a>
                        <a href="<?= site_url('products/cancel/' . $product->id); ?>" class="btn btn-default btn-xs">Deaktiver</a>
                    </td>
                </tr>
                <?php
            endforeach;
            ?>
        </tbody>
    </table>
</div>


<script>
    $("#prod_sort").sortable({
        update: function (event, ui) {
            $.blockUI({message: '<h3>Updating...</h3>'});
            var data = $(this).sortable('serialize');

            // POST to server using $.post or $.ajax
            $.ajax({
                data: data,
                type: 'POST',
                url: '<?php echo base_url('products/sort_product'); ?>',
                success: function (result) {
                    //console.log(result);
                },
                complete: function () {
                  $.unblockUI();
                }
            });
        }
    });
</script>
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
                        <label>Parent</label>

                        <!--- SÆLG ENHED --->
                        <?php
                        $this->load->model('category_model');
                        $categories = $this->category_model->get_category();
                        ?>
                        <select class="form-control selectpicker select_devices" name="parent" style="width: 268px;">
                            <option value="">- Vælg catgory -</option>
                            <?php
                            foreach ($categories as $category):
                                if ($category->parent == 0) {
                                    ?>
                                    <option value="<?= $category->id; ?>"><?= $category->name; ?></option>
                                    <?php
                                }
                            endforeach;
                            ?>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <input type="submit" class="btn btn-success" name="submit_category" value="Opret" style="margin-top: 20px" />
                    </div>

                </div>
                <?= form_close(); ?>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="edit_category">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Rediger category</h4>
            </div>
            <div class="modal-body editContent">

                <center><img src="<?= base_url(); ?>assets/images/loader.gif" /></center>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<h1 class="page-header">
    Category
    <div class="pull-right">
        <a href="#" class="btn btn-success" data-toggle="modal" data-target="#buy_device">Opret category</a>
    </div>
</h1>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Parent</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="prod_sort">
            <?php
            $parents = array();
            foreach ($categories as $key=>$category) {
                $parents[$category->id] =  $category->name;
            }
            foreach ($categories as $category):
                ?>
                <tr id="item-<?php echo $category->id; ?>">
                    <td><?= $category->id; ?></td>
                    <td>
                        <?= $category->name; ?>
                    </td>
                    <td><?php
                        if ($category->parent) {
                            echo($parents[$category->parent]);
                        } else {
                            echo '-';
                        }
                        ?></td>
                    <td width="150px">
                        <a href="#" class="btn btn-info btn-xs" data-toggle="modal" data-id="<?= $category->id; ?>" data-target="#edit_category">Rediger</a>
                        <a href="<?= site_url('category/delete/' . $category->id); ?>" class="btn btn-default btn-xs">Delete</a>
                    </td>
                </tr>
                <?php
            endforeach;
            ?>
        </tbody>
    </table>
</div>


<script>
    // $("#prod_sort").sortable({
    //     update: function (event, ui) {
    //         $.blockUI({message: '<h3>Updating...</h3>'});
    //         var data = $(this).sortable('serialize');

    //         // POST to server using $.post or $.ajax
    //         $.ajax({
    //             data: data,
    //             type: 'POST',
    //             url: '<?php echo base_url('products/sort_product'); ?>',
    //             success: function (result) {
    //                 //console.log(result);
    //             },
    //             complete: function () {
    //               $.unblockUI();
    //             }
    //         });
    //     }
    // });
    $('#edit_category').on('shown.bs.modal', function (event) {
        var siteurl = $('.siteurl').val();
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id')

        $('.loader').show();
        $('.editContent').html('');
        $('.editContent').hide();

        $.ajax({
            type: "POST",
            url: siteurl+"category/edit",
            data: { id: id }
        }).done(function( msg ) {
            $('.loader img').hide();

            $('.editContent').html(msg);

            $('.editContent').fadeIn('fast');

        });


        return false;

    });
</script>

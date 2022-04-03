<?php
$rank_permissions = $this->global_model->get_rank_permissions();
$me = $this->global_model->me();

$boutiques_access = explode(",", $me[0]->boutiques);
$boutiques_access_list = implode(",",explode(",", $me[0]->boutiques));

$boutiques = $this->global_model->get_boutiques();

$timer = $this->global_model->get_active_timer();
?>
<!DOCTYPE html>
<html lang="da">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

		<meta http-equiv="cache-control" content="max-age=0" />
		<meta http-equiv="cache-control" content="no-cache" />
		<meta http-equiv="expires" content="0" />
		<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
		<meta http-equiv="pragma" content="no-cache" />

        <link rel="icon" href="../../favicon.ico">

        <title><?php
            if (isset($title)): echo $title;
            else: echo 'Kassesystem';
            endif;
            ?></title>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="<?= base_url(); ?>assets/css/bootstrap.css">

        <link href="<?= base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet">

        <link href="<?= base_url(); ?>assets/css/datepicker.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="<?= base_url(); ?>assets/css/style.css" rel="stylesheet">
        <link href="<?= base_url(); ?>assets/css/print.css" media="print" rel="stylesheet">

        <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>

        <link href="<?= base_url(); ?>assets/plugin/select2/css/select2.min.css" rel="stylesheet" />
        <link href="<?php echo site_url('assets/plugin/datatables/plugins/bootstrap/dataTables.bootstrap.css'); ?>" rel="stylesheet" type="text/css"/>
        <script src="<?= base_url(); ?>assets/js/jquery.js"></script>
        <script src="<?= base_url(); ?>assets/js/bootstrap.js"></script>
        <!--<link href="<?= base_url(); ?>assets/plugin/jqueryui/jquery-ui.min.css" rel="stylesheet">-->
        <script src="<?= base_url(); ?>assets/plugin/jqueryui/jquery-ui.min.js"></script>
        <script src="<?= base_url(); ?>assets/plugin/jquery.blockUI.js"></script>
        <script src="<?= base_url(); ?>assets/plugin/datatables/media/js/jquery.dataTables.min.js"></script>
        <script src="<?= base_url(); ?>assets/plugin/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
        <script src="<?= base_url(); ?>assets/js/chained.js"></script>
        <script src="<?= base_url(); ?>assets/js/sort_table.js"></script>
        <style>
          .dropdown-submenu ul.dropdown-menu{
            padding-left: 15px;
          }
        </style>
        <script>
          $(document).on("click",".dropdown-submenu a.dropdown-toggle",function(e){
            e.preventDefault();
            e.stopPropagation();
            $(this).parents('.dropdown-submenu').toggleClass('open');
            $(this).parents('li.dropdown').addClass('open');
          });
        </script>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>

        <div class="modal fade" id="logout">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Vælg log ud type</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="box_out end_day_box">Dagens udgang</div>
                            </div>

                            <div class="col-md-6">
                                <div class="box_out change_click" url="<?= site_url('logout'); ?>">Normalt log ud</div>
                            </div>

                            <div class="col-md-12 logout_end_day " style="display: none">
                                <hr />

                                <div class="row">

                                    <?= form_open('authenticate/logout_end_day'); ?>

                                    <div class="col-md-6">
                                        <label>Kassebeholdning</label>
                                        <input type="text" class="form-control" name="cash_boutique" required style="margin-bottom: 10px" />
                                    </div>
                                    <div class="col-md-6">
                                        <label>Dankortbeholdning</label>
                                        <input type="text" class="form-control" name="card_boutique" required style="margin-bottom: 10px" />
                                    </div>

                                    <div class="col-md-6">
                                        <input type="submit" class="btn btn-success" name="submit" value="Log ud" required style="margin-bottom: 10px" />
                                    </div>

                                    <?= form_close(); ?>

                                </div>

                            </div>

                        </div>

                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


        <div class="modal fade" id="afstemnings_type">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Hvilken afstemning vil du lave?</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="box_out change_click" url="<?= site_url('status'); ?>">Kasseafstemning</div>
                            </div>

                            <div class="col-md-6">
                                <div class="box_out change_click" url="<?= site_url('status/phone'); ?>">Telefonafstemning</div>
                            </div>

                        </div>

                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <nav class="navbar navbar-default navbartop navbar-fixed-top" style="display: none">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo base_url(); ?>"><img src="<?= base_url(); ?>assets/images/logo-telerepair2.png" width="100" /></a>
                    <!-- <a class="navbar-brand" href="<?php echo base_url(); ?>"><img src="<?= base_url(); ?>assets/images/logo-green.png" width="100" /></a> -->
                    <?php
                    if (strpos($rank_permissions, 'all') !== false ) {
                        ?>
                        <select class="form-control change_redirect" style="width: 120px;float: right;margin-top: 8px;margin-right: 5px;padding:2px;">
                            <?php
                            $boutiques_access = explode(",", $me[0]->boutiques);

                            foreach ($boutiques_access as $boutique_info) {
                                $this->db->where('id', $boutique_info);
                                $this->db->where('active', 1);
                                $this->db->order_by('name', 'asc');
                                $single_boutique = $this->db->get('boutiques')->result();
                                if ($single_boutique) {
                                    if ($single_boutique[0]->id == $this->session->userdata('active_boutique')) {
                                        $selected = 'selected="true"';
                                    } else {
                                        $selected = '';
                                    }
                                    echo '<option value="' . site_url('boutiques/change/' . $single_boutique[0]->id) . '" ' . $selected . '>' . $single_boutique[0]->name . '</option>';
                                }
                            }
                            ?>
                        </select>
                        <?php
                    } else {
                        echo '<br />' . $this->global_model->get_boutique_name_by_id($this->session->userdata('active_boutique'));
                    }
                    ?>
                </div>
                <div id="navbar" class="navbar-collapse collapse" style="max-height:none">
                  <ul class='nav navbar-nav'>
                        <li class="<?php
                          if ($this->uri->segment(1) == 'receipt'): echo 'active';
                          endif;
                              ?>">
                            <a href="<?= site_url('receipt'); ?>">Indleveringskvittering</a>

                        </li>
                        <?php if (strpos($rank_permissions, 'sell_access_overview') !== false || strpos($rank_permissions, 'all') !== false) { ?>
                        <li class="<?php
                          if ($this->uri->segment(1) == 'access'): echo 'active';
                          endif;
                              ?>">
                            <a href="<?= site_url('access'); ?>">Sælg tilbehør</a>

                        </li>
                      <?php } ?>
                      <?php if (strpos($rank_permissions, 'sold_devices_overview') !== false || strpos($rank_permissions, 'all') !== false) { ?>
                        <li class="<?php
                          if ($this->uri->segment(1) == 'sold'): echo 'active';
                          endif;
                              ?>">
                            <a href="<?= site_url('sold'); ?>">Sælg enhed</a>

                        </li>
                      <?php } ?>
                      <?php if (strpos($rank_permissions, 'bought_devices_overview') !== false || strpos($rank_permissions, 'all') !== false) { ?>
                        <li class="<?php
                          if ($this->uri->segment(1) == 'bought'): echo 'active';
                          endif;
                              ?>">
                            <a href="<?= site_url('bought'); ?>">Køb en enhed</a>

                        </li>
                      <?php } ?>
              <li class="<?php if ($this->uri->segment(1) == 'booking'): echo 'active'; endif; ?>">
                <a href="<?= site_url('booking'); ?>">Reservation</a>
              </li>
              <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin <span class="caret"></span></a>
                          <ul class="dropdown-menu multi-level">
                            <?php
                            if (strpos($rank_permissions, 'tranfer_overview') !== false || strpos($rank_permissions, 'all') !== false) {
                                ?>
                            <li class="<?php
                                if ($this->uri->segment(1) == 'transfer'): echo 'active';
                                endif;
                                ?>"><a href="<?= site_url('transfer'); ?>">Overførsler</a></li>
                                <?php
                            }
                            ?>
                            <?php
                                if (strpos($rank_permissions, 'transfer_sidebar') !== false || strpos($rank_permissions, 'all') !== false) {
                                    ?>
                                <li class="<?php
                                    if ($this->uri->segment(1) == 'move'): echo 'active';
                                    endif;
                                    ?>"><a href="<?= site_url('move'); ?>">Overfør enhed</a></li>
                                <?php
                              }
                              ?>
                              <?php
                              if (strpos($rank_permissions, 'complaints') !== false || strpos($rank_permissions, 'all') !== false) {
                                      ?>
                                  <li class="<?php
                              if ($this->uri->segment(1) == 'complaints'): echo 'active';
                              endif;
                                      ?>"><a href="<?= site_url('complaints'); ?>">Reklamation</a></li>
                                  <?php
                              }
                              ?>
                              <?php
                              if (strpos($rank_permissions, 'statistic') !== false || strpos($rank_permissions, 'all') !== false) {
                                  ?>
                                  <li class="<?php
                                      if ($this->uri->segment(1) == 'statistic'): echo 'active';
                                      endif;
                                      ?>"><a href="<?= site_url('statistic'); ?>">Statistik</a></li>
                                  <li><a href="<?= site_url('export'); ?>">Eksport</a></li>
                                  <?php
                              }
                              ?>
                              <?php
                              if (strpos($rank_permissions, 'boutique_overview') !== false || strpos($rank_permissions, 'all') !== false) {
                                  ?>
                                  <li class="<?php
                                  if ($this->uri->segment(1) == 'boutiques'): echo 'active';
                                  endif;
                                  ?>"><a href="<?= site_url('boutiques'); ?>">Butikker</a></li>
                                  <?php
                              }
                              if (strpos($rank_permissions, 'users_overview') !== false || strpos($rank_permissions, 'all') !== false) {
                                  ?>
                                  <li class="dropdown-submenu <?php
                              if ($this->uri->segment(1) == 'users'): echo 'active open';
                              endif;
                                  ?>">
                                      <a href="#" class="dropdown-toggle">Brugere <span class="caret"></span></a>
                                      <ul class="dropdown-menu">
                                          <li><a href="<?= site_url('users'); ?>">Brugere</a></li>
                                          <li><a href="<?= site_url('users/permissions'); ?>">Rettigheder</a></li>
                                      </ul>
                                  </li>
                                  <?php
                              }
                              ?>
                              <?php
                              if (strpos($rank_permissions, 'inventory_overview') !== false || strpos($rank_permissions, 'all') !== false) {
                                  ?>

                                  <li class="dropdown-submenu <?php
                                  if ($this->uri->segment(1) == 'products'): echo 'active open';
                                  endif;
                                  ?>">
                                    <a href="#" class="dropdown-toggle">Enheder <span class="caret"></span></a>

                                      <ul class="dropdown-menu">
                                          <li><a href="<?= site_url('products'); ?>">Enheder</a></li>
                                          <li><a href="<?= site_url('products/inventory'); ?>">Lagerstyring</a></li>
                                      </ul>
                                  </li>
                                <?php
                                }
                                ?>
                                <li class="<?php
                                    if ($this->uri->segment(1) == 'customer'): echo 'active';
                                    endif;
                                    ?>">
                                    <a href="<?= site_url('customer'); ?>">Kundekartotek</a>
                                </li>
                          </ul>
                      </li>


                  </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>

        <div class="container-fluid">

            <div class="row">
                <div class="earningarea hidden-print">

                    <div class="row">
                        <div class="col-md-12 earningsliderarea">

                            <?php
                            if (strpos($rank_permissions, 'earning_sidebar') !== false || strpos($rank_permissions, 'all') !== false) {

                                if (strpos($rank_permissions, 'earning_sidebar_month') !== false || strpos($rank_permissions, 'all') !== false) {
                                    ?>
                                    <div class="revenue_box" style="margin-bottom: 0px">
                                        <div class="" style="padding: 10px 0px 10px 10px;">
                                            <div class="name">&nbsp;</div>
                                            <div class="revenue">I dag</div>
                                            <div class="revenue">Denne måned <a href="<?= site_url('statistic/month_numbers'); ?>">+</a></div>
                                        </div>
                                    </div>
                                    <?php
                                }

                                $first_day_of_this_month = date("m/d/Y", strtotime("first day of this month 00:00:00"));
                                $last_day_of_this_month = date("m/d/Y", strtotime("last day of this month 23:59:59"));

                                $total_earnings = 0;
                                $total_earnings_month = 0;
                                $earnings_month_contest = 0;
                                $total_earnings_month_contest = 0;

                                foreach ($boutiques as $boutique):

                                    // get earnings
                                    $earnings = $this->global_model->calculate_sale_by_month(false, $boutique->id);
                                    $earnings_month = $this->global_model->calculate_sale_by_month(true, $boutique->id);

                                    $total_earnings += $earnings;
                                    $total_earnings_month += $earnings_month;
                                    
                                    if (strpos($rank_permissions, $boutique->id . 'day') !== false || strpos($rank_permissions, 'all') !== false || strpos($rank_permissions, $boutique->id . 'month') !== false || strpos($boutiques_access_list, $boutique->id) !== false ) {
                                        ?>
                                        <div class="revenue_box" style="margin-bottom: 0px; margin-left: 34px;">
                                            <div class="" style="padding: 10px">
                                                <div class="name">Salg <?= $boutique->name; ?></div>
                                                <?php
                                                if (strpos($rank_permissions, $boutique->id . 'day') !== false || strpos($rank_permissions, 'all') !== false  || strpos($boutiques_access_list, $boutique->id) !== false ) {
                                                    ?>
                                                    <div class="revenue <?php
                                                    if ($total_earnings < 0): echo 'negative';
                                                    else: echo 'positive';
                                                    endif;
                                                    ?>"><a href="<?= site_url('statistic/interval/' . $boutique->id . '?sdate=' . date("Y-m-d") . '&edate=' . date("Y-m-d")); ?>" style="color: #86aa20;"><?= number_format($earnings, 2, ',', '.'); ?> DKK</a></div>
                                                         <?php
                                                     }
                                                     if (strpos($rank_permissions, 'earning_sidebar_month') !== false || strpos($rank_permissions, 'all') !== false) {
                                                         if (strpos($rank_permissions, $boutique->id . 'month') !== false || strpos($rank_permissions, 'all') !== false || strpos($rank_permissions, $boutique->id . 'month') !== false  || strpos($boutiques_access_list, $boutique->id) !== false ) {
                                                             ?>
                                                        <div class="revenue <?php
                                                        if ($total_earnings_month < 0): echo 'negative';
                                                        else: echo 'positive';
                                                        endif;
                                                        ?>" style="font-size: 11px"><a href="<?= site_url('statistic/interval/' . $boutique->id . '?sdate=' . $first_day_of_this_month . '&edate=' . $last_day_of_this_month); ?>" style="color: #86aa20;"><?= number_format($earnings_month, 2, ',', '.'); ?> DKK</a></div>

                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                endforeach;
                                if (strpos($rank_permissions, 'total_sale_today') !== false || strpos($rank_permissions, 'total_sale_month') !== false || strpos($rank_permissions, 'all') !== false) {
                                    ?>
                                    <div class="revenue_box " style="margin-bottom: 0px">
                                        <div class="" style="padding: 10px">
                                            <div class="name">Total salg</div>
                                            <?php
                                            if (strpos($rank_permissions, 'total_sale_today') !== false || strpos($rank_permissions, 'all') !== false) {
                                                ?>
                                                <div class="revenue <?php
                                                if ($total_earnings < 0): echo 'negative';
                                                else: echo 'positive';
                                                endif;
                                                ?>">
                                                    <?= number_format($total_earnings, 2, ',', '.'); ?> DKK
                                                </div>
                                                <?php
                                            }
                                            if (strpos($rank_permissions, 'total_sale_month') !== false || strpos($rank_permissions, 'all') !== false) {
                                                ?>
                                                <div class="revenue <?php
                                                if ($total_earnings_month < 0): echo 'negative';
                                                else: echo 'positive';
                                                endif;
                                                ?>" style="font-size: 11px">
                                                    <?= number_format($total_earnings_month, 2, ',', '.'); ?> DKK
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <!-- <div class="col-md-5">
                           <div class="col-md-4">
                            <label>Logget ind på butik:</label>

                            <?php
                            if (strpos($rank_permissions, 'all') !== false) {
                                ?>
                                <select class="form-control change_redirect 1111">
                                    <?php
                                    $boutiques_access = explode(",", $me[0]->boutiques);

                                    foreach ($boutiques_access as $boutique_info) {
                                        $this->db->where('id', $boutique_info);
                                        $this->db->where('active', 1);
                                        $this->db->order_by('name', 'asc');
                                        $single_boutique = $this->db->get('boutiques')->result();
                                        if ($single_boutique) {
                                            if ($single_boutique[0]->id == $this->session->userdata('active_boutique')) {
                                                $selected = 'selected="true"';
                                            } else {
                                                $selected = '';
                                            }
                                            echo '<option value="' . site_url('boutiques/change/' . $single_boutique[0]->id) . '" ' . $selected . '>' . $single_boutique[0]->name . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <?php
                            } else {
                                echo '<br />' . $this->global_model->get_boutique_name_by_id($this->session->userdata('active_boutique'));
                            }
                            ?>
                          
                          <div class="col-md-8">
                            <div class="logoutarea">

                                <?php
                                if (strpos($rank_permissions, 'logout_cash') !== false || strpos($rank_permissions, 'all') !== false) {
                                    ?>
                                    <center><a href="#" class="choose_logout btn btn-default" style="width: 130px; float: right; margin-right: 10px" data-toggle="modal" data-target="#logout">Log ud</a></center>
                                    <?php
                                } else {
                                    ?>
                                    <center><a href="<?= site_url('logout'); ?>" class="btn btn-default" style="width: 130px; float: right; margin-right: 10px">Log ud</a></center>
                                    <?php
                                }
                                ?>

                                <?php
                                if (strpos($rank_permissions, 'kasseafstemning') !== false || strpos($rank_permissions, 'all') !== false) {
                                    ?>
                                    <center><a href="#" data-toggle="modal" data-target="#afstemnings_type" class="choose_logout btn btn-default" style="width: 150px; margin-right: 10px; float: right">Afstemning</a></center>
                                    <?php
                                }
                                ?>

                            </div>
                          </div>
                        </div> -->

                    </div>

                </div>


                <div class="col-sm-3 col-md-2 sidebar">
                    <!--
                    <?php
                    if (!$timer):
                        ?>
                                                <div class="working-btn start">Start</div>
                                                <div class="working-btn stop" style="display: none">Stop</div>
                        <?php
                    else:
                        ?>
                                                <div class="working-btn start" style="display: none">Start</div>
                                                <div class="working-btn stop">Stop</div>
                    <?php
                    endif;
                    ?>
                    -->
                    <div class="logo"><a href="<?= site_url(); ?>"><img src="<?= base_url(); ?>assets/images/logo-telerepair2.png" width="90%" /></a></div>
                    <!-- <div class="logo"><a href="<?= site_url(); ?>"><img src="<?= base_url(); ?>assets/images/logo-green.png" width="90%" /></a></div> -->


                    <?= form_open('search'); ?>
                    <input type="text" class="form-control" value="" name="search" placeholder="Søg i systemet" />
                    <?= form_close(); ?>

                    <label class="top_lab">Logget ind som:</label><br />
                    <?= $me[0]->name; ?>

                    <div style="margin-top:10px"></div>
                    <!-- Logged in to store: start here -->
                        <?php
                            //If you have rank permissions all or you have access to more than one store, then you have can switch store in the left drop down.
                            if (strpos($rank_permissions, 'all') !== false || count($boutiques_access) > 1) {
                        ?>
                                <select class="form-control change_redirect 1111">
                                    <?php
                                      foreach ($boutiques_access as $boutique_info) {
                                        $this->db->where('id', $boutique_info);
                                        $this->db->where('active', 1);
                                        $this->db->order_by('name', 'asc');
                                        $single_boutique = $this->db->get('boutiques')->result();
                                        if ($single_boutique) {
                                            if ($single_boutique[0]->id == $this->session->userdata('active_boutique')) {
                                                $selected = 'selected="true"';
                                            } else {
                                                $selected = '';
                                            }
                                            echo '<option value="' . site_url('boutiques/change/' . $single_boutique[0]->id) . '" ' . $selected . '>' . $single_boutique[0]->name . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <?php
                            } else {
                                echo '<br />' . $this->global_model->get_boutique_name_by_id($this->session->userdata('active_boutique'));
                            }
                            ?>
                    <!-- Logged in to store: end here -->
                    <hr style="margin-top:10px" />

                    <div id="accordian">
		<ul>
          <li class="<?php
            if ($this->uri->segment(1) == 'receipt'): echo 'active';
            endif;
                ?>">
    					<h3><a href="<?= site_url('receipt'); ?>"><i class="fa fa-lg fa-list"></i>Indleveringskvittering</a></h3>

    			</li>
          <?php if (strpos($rank_permissions, 'sell_access_overview') !== false || strpos($rank_permissions, 'all') !== false) { ?>
          <li class="<?php
            if ($this->uri->segment(1) == 'access'): echo 'active';
            endif;
                ?>">
    					<h3><a href="<?= site_url('access'); ?>"><i class="fa fa-lg fa-list"></i>Sælg tilbehør</a></h3>

    			</li>
        <?php } ?>
        <?php if (strpos($rank_permissions, 'sold_devices_overview') !== false || strpos($rank_permissions, 'all') !== false) { ?>
          <li class="<?php
            if ($this->uri->segment(1) == 'sold'): echo 'active';
            endif;
                ?>">
    					<h3><a href="<?= site_url('sold'); ?>"><i class="fa fa-lg fa-list"></i>Sælg enhed</a></h3>

    			</li>
        <?php } ?>
        <?php if (strpos($rank_permissions, 'bought_devices_overview') !== false || strpos($rank_permissions, 'all') !== false) { ?>
          <li class="<?php
            if ($this->uri->segment(1) == 'bought'): echo 'active';
            endif;
                ?>">
              <h3><a href="<?= site_url('bought'); ?>"><i class="fa fa-lg fa-list"></i>Køb en enhed</a></h3>

          </li>
        <?php } ?>
        <?php if (strpos($rank_permissions, 'complaints') !== false || strpos($rank_permissions, 'all') !== false) { ?>
          <li class="<?php
            if ($this->uri->segment(1) == 'complaints'): echo 'active';
            endif;
                ?>">
                        <h3><a href="<?= site_url('complaints'); ?>"><i class="fa fa-lg fa-list"></i>Reklamation</a></h3>
                </li>
        <?php }?>

<li class="<?php if ($this->uri->segment(1) == 'booking'): echo 'active'; endif; ?>"><h3><a href="<?= site_url('booking'); ?>"><i class="fa fa-lg fa-calendar"></i>Reservation</a></h3></li>

				<li class='has_children'>
						<h3><a href="#"><i class="fa fa-lg fa-user"></i>Admin</a></h3>
						<ul>
              <?php
              if (strpos($rank_permissions, 'tranfer_overview') !== false || strpos($rank_permissions, 'all') !== false) {
                  ?>
              <li class="<?php
                  if ($this->uri->segment(1) == 'transfer'): echo 'active';
                  endif;
                  ?>"><a href="<?= site_url('transfer'); ?>">Overførsler</a></li>
                  <?php
              }
              ?>
              <?php
                  if (strpos($rank_permissions, 'transfer_sidebar') !== false || strpos($rank_permissions, 'all') !== false) {
                      ?>
                  <li class="<?php
                      if ($this->uri->segment(1) == 'move'): echo 'active';
                      endif;
                      ?>"><a href="<?= site_url('move'); ?>">Overfør enhed</a></li>
                  <?php
                }
                ?>


                <?php
                  if (strpos($rank_permissions, 'garanti') !== false || strpos($rank_permissions, 'all') !== false) {
                      ?>
                  <li class="<?php
                      if ($this->uri->segment(1) == 'garanti'): echo 'active';
                      endif;
                      ?>"><a href="<?= site_url('garanti'); ?>">Garanti options</a></li>
                  <?php
                }
                ?>


                
                <?php
                if (strpos($rank_permissions, 'statistic') !== false || strpos($rank_permissions, 'all') !== false) {
                    ?>
                    <li class="<?php
                        if ($this->uri->segment(1) == 'statistic'): echo 'active';
                        endif;
                        ?>">
                        <a href="<?= site_url('statistic'); ?>">Statistik</a></li>
                    <li class="<?php
                        if ($this->uri->segment(1) == 'sales_statistics'): echo 'active';
                        endif;
                        ?>">
                        <a href="<?= site_url('sales_statistics'); ?>">Salgstal</a></li>
                        
                    <li><a href="<?= site_url('export'); ?>">Eksport</a></li>
                    <?php
                }
                ?>
                <?php
                if (strpos($rank_permissions, 'boutique_overview') !== false || strpos($rank_permissions, 'all') !== false) {
                    ?>
                    <li class="<?php
                    if ($this->uri->segment(1) == 'boutiques'): echo 'active';
                    endif;
                    ?>"><a href="<?= site_url('boutiques'); ?>">Butikker</a></li>
                    <?php
                }
                if (strpos($rank_permissions, 'users_overview') !== false || strpos($rank_permissions, 'all') !== false) {
                    ?>
                    <li class="<?php
                if ($this->uri->segment(1) == 'users'): echo 'active';
                endif;
                    ?>">
                        <a href="#">Brugere</a>
                        <ul>
                            <li><a href="<?= site_url('users'); ?>">Brugere</a></li>
                            <li><a href="<?= site_url('users/permissions'); ?>">Rettigheder</a></li>
                        </ul>
                    </li>
                    <?php
                }
                ?>
                <?php
                if (strpos($rank_permissions, 'inventory_overview') !== false || strpos($rank_permissions, 'all') !== false) {
                    ?>

                    <li class="<?php
                    if ($this->uri->segment(1) == 'products'): echo 'active';
                    endif;
                    ?>">
                        <a href="#">Enheder</a>
                        <ul>
                            <li><a href="<?= site_url('products'); ?>">Enheder</a></li>
                            <li><a href="<?= site_url('products/inventory'); ?>">Lagerstyring</a></li>
                        </ul>
                    </li>
                  <?php
                  }
                  ?>
                  <li class="<?php
                      if ($this->uri->segment(1) == 'customer'): echo 'active';
                      endif;
                      ?>"><a href="<?= site_url('customer'); ?>">Kundekartotek</a></li>
						</ul>
				</li>




             
                <li style="margin-top: 20px;">
                <div class="btn_left">
                <?php
                    if (strpos($rank_permissions, 'logout_cash') !== false || strpos($rank_permissions, 'all') !== false) {
                        ?>
                        <center><a href="#" class="choose_logout btn btn-default"  data-toggle="modal" data-target="#logout">Log ud</a></center>
                        <?php
                    } else {
                        ?>
                        <center><a href="<?= site_url('logout'); ?>" class="btn btn-default">Log ud</a></center>
                        <?php
                    }
                    ?>
                </div>
                <div class="btn_right">
                <?php
                    if (strpos($rank_permissions, 'kasseafstemning') !== false || strpos($rank_permissions, 'all') !== false) {
                        ?>
                        <center><a href="#" data-toggle="modal" data-target="#afstemnings_type" class="choose_logout btn btn-default vote" >Afstemning</a></center>
                        <?php
                    }
                    ?>
                 </div>
                </li>
            


               


		</ul>
</div>






                    <div class="clearfix"></div>

<?php
if (strpos($rank_permissions, 'hidden_btn_earning') !== false || strpos($rank_permissions, 'all') !== false) {
    ?>
                        <a href="<?= site_url('statistic/hidden/' . $this->session->userdata('active_boutique') . '?sdate=' . $first_day_of_this_month . '&edate=' . $last_day_of_this_month . ''); ?>"><div class="hiddenbtn" style="border: none; width: 30px; margin-top: 0px; height: 30px;"></div></a>
    <?php
}
?>

                </div>
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

<?php
$data['rank_permissions'] = $rank_permissions;
$this->load->view($yield, $data);
?>


                </div>
            </div>
        </div>

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->




        <script src="<?= base_url(); ?>assets/js/Chart.min.js"></scr        ipt
        <script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.js"></script>

        <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

        <script src="<?= base_url(); ?>assets/plugin/select2/js/select2.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/custom.js"></script>

<?php
if ($this->input->get('modal')):
    ?>
            <script type="text/javascript">
                $(document).ready(function () {
                    $('#buy_device').modal('show');
                });
            </script>
    <?php
endif;
if ($this->uri->segment(3) && $this->uri->segment(1) == 'access') {
    ?>
            <script type="text/javascript">
                $(document).ready(function () {
                    $('#buy_device').modal('show');
                });
            </script>
    <?php
}
if ($this->input->get('cid')) {
    ?>
            <script type="text/javascript">
                $(document).ready(function () {
                    $('#buy_device').modal('show');
                });
            </script>
    <?php
}
?>

        <script type="text/javascript">
            $(document).ready(function () {

                $(document).on("click",'.add_repair',function (e) {
                  e.preventDefault();
                    $('.repairs').append('<div class="col-md-6" style="margin-top: 10px">\
                                <input type="text" class="form-control" placeholder="Reparation"  name="repair_name[]">\
                        </div>\
                        <div class="col-md-6" style="margin-top: 10px">\
                                <input type="text" class="form-control" placeholder="Reparation pris"  name="repair_price[]">\
                        </div>');

                    //return false;
                });

                if ($('.rememberCardReminder').length) {
                    //$('#remember_card_counting').modal('show');
                }

                $(document).on('change', '.comment_status', function () {
                    if ($(this).is(":checked")) {
                        console.log('checked ');
                        $('.comment_vis').show();
                    } else {
                        console.log('unchecked ');
                        $('.comment_vis').hide();
                    }
                });
            });

        </script>
		<input type="hidden" class="siteurl" value="<?= site_url(); ?>" />
    </body>
</html>

<style>
.vote{
    color: #fff;
    background-color: #31b0d5;
    border-color: #269abc;
}


.vote:focus, .vote:active:focus, .vote.active:focus, .vote.focus, .vote:active.focus, .vote.active.focus, .vote:hover{
    color: #fff;
    background-color: #31b0d5;
    border-color: #269abc;
}



.logo {
    margin-bottom: 20px;
}
.top_lab{
    margin-top: 15px;
}

.btn_left{
    width: 43%;
}
.btn_right{
    margin-top: -33px;
    width: 70%;
    float: right;
}
</style>

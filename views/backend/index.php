<?php $this->load->view('backend/sections/header'); ?>
<?php $this->load->view('backend/sections/top-nav.php'); ?>
<?php $this->load->view('backend/sections/leftmenu.php'); ?>
<?php $this->session->unset_userdata('msg');?>
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Admin Dashboard

        </h1>
        <ol class="breadcrumb">
            <li class="active"><i class="fa fa-dashboard"></i> Dashboard</a></li>

        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

<div class="row">
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>
                           <?php  echo '0';?>                       </h3>
                        <p>
                            Total Products 
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>

                </div>
            </div>
<!--            <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            <?php  echo '0';?>                      </h3>
                        <p>
                            Total Android App Installed
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-social-android"></i>
                    </div>

                </div>
            </div>-->
<!--            <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
                    <div class="inner">
                        <h3>
                           <?php  echo '0';?>                       </h3>
                        <p>
                            Total IOS App Installed
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-social-apple"></i>
                    </div>
                </div>
            </div>-->
        </div>

    </section><!-- /.content -->
</aside><!-- /.right-side -->

<?php $this->load->view('backend/sections/footer.php'); ?>
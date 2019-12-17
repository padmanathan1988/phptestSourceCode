<?php $this->load->view('backend/sections/header'); ?>
<?php $this->load->view('backend/sections/top-nav.php'); ?>
<?php $this->load->view('backend/sections/leftmenu.php'); ?>
<aside class="right-side">
    <section class="content-header">
        <h1>
           User Log Details
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>backend/dashboard"><i class="fa fa-dashboard"></i> User Log</a></li>
            

        </ol>
    </section>
    <section class="content">
        <?php
        $msg = $this->session->userdata('msg');
        ?>
        <?php if ($msg != '') { ?>
            <div class="msg_box alert alert-success">
                <button type="button" class="close" data-dismiss="alert" id="msg_close" name="msg_close">X</button>
                <?php
                echo $msg;
                $this->session->unset_userdata('msg');
                ?>
            </div>
        <?php } ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <form name="frm_admin_users" id="frm_admin_users" action="<?php echo base_url(); ?>backend/admin/list" method="post">
                        <div class="box-body table-responsive">
                            <div role="grid" class="dataTables_wrapper form-inline" id="example1_wrapper">									
                                <table class="table table-bordered table-striped dataTable" id="example1" aria-describedby="example1_info">
                                    <thead>
                                        <tr role="row">
                                            
                                    <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Username">Username</th>

                                    <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="First Name">Log Description</th>


        
                                   
                                    <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Created on">Created on</th>
                                   
                                    </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        foreach ($arr_log_list as $admin) {
                                             
                                             ?>
                                             <tr>
                                             <td><?php echo stripslashes($admin['user_name']); ?></td>
                                             <td><?php  echo stripslashes($admin['user_activity_text']);?></td>
                                             <td><?php echo date('d-m-Y H:m:s',strtotime($admin['user_active_time']))?></td>
                                             </tr>
                                            <?php }?>
                                    </tbody>
                                    
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
        </div>
        <?php $this->load->view('backend/sections/footer'); ?>

       
        </body>
        </html>
<!-- Left side column. contains the logo and sidebar -->
<aside class="left-side sidebar-offcanvas">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left info">
                <p>Hello, <?php echo "User" ?></p>
                <a href="javascript:void(0);"><i class="fa fa-circle text-success"></i> Logged In</a>
            </div>
        </div>
      
            <ul class="sidebar-menu">
                <li <?php if ($this->uri->segment(2) == 'home') { ?> class="active" <?php } ?>>
                    <a href="<?php echo base_url(); ?>backend/dashboard">
                        <i class="fa fa-dashboard"></i> <span>User Details</span>
                    </a>
                </li>
                <li <?php if ($this->uri->segment(2) == 'user-log') { ?> class="active" <?php } ?>>
                    <a href="<?php echo base_url(); ?>backend/user-log">
                        <i class="fa fa-dashboard"></i> <span>User Log </span>
                    </a>
                </li>
       
            </ul>
            <?php
        
        ?>
    </section>
    <!-- /.sidebar -->
</aside>

<!-- Right side column. Contains the navbar and content of the page -->

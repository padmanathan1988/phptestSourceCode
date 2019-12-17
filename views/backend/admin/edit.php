<?php $this->load->view('backend/sections/header'); ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>media/front/css/jquery.validate.password.css" />
<?php $this->load->view('backend/sections/top-nav.php'); ?>
<?php $this->load->view('backend/sections/leftmenu.php'); ?>
<aside class="right-side">
    <section class="content-header">
        <h1>
            Update Admin User Details

        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>backend/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?php echo base_url(); ?>backend/admin/list">  <i class="fa fa-fw fa-user"></i> Manage Admin Users</a></li>
            <li class="active">	Update Admin User Details </li>

        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <form name="frm_admin_details" id="frm_admin_details"  action="<?php echo $action ?>" method="POST" >
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="User Name">User Name <sup class="mandatory">*</sup></label>
                                        <input type="text" value="<?php echo str_replace('"', '&quot;', stripslashes($arr_admin_detail['user_name'])); ?>" id="user_name" name="user_name" class="form-control">
                                       

                                    </div>
                                    <div class="form-group">
                                        <label for="First Name">First Name <sup class="mandatory">*</sup></label>
                                        <input type="text" value="<?php echo str_replace('"', '&quot;', stripslashes($arr_admin_detail['first_name'])); ?>" name="first_name" id="first_name"  class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="Last Name">Middel Name </label>
                                        <input type="text" value="<?php echo str_replace('"', '&quot;', stripslashes($arr_admin_detail['middle_name'])); ?>" name="middel_name" id="middel_name"  class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="Last Name">Last Name <sup class="mandatory">*</sup></label>
                                        <input type="text" value="<?php echo str_replace('"', '&quot;', stripslashes($arr_admin_detail['last_name'])); ?>" name="last_name" id="last_name"  class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="Email Id">Email Id <sup class="mandatory">*</sup></label>
                                        <input type="text" value="<?php echo stripslashes($arr_admin_detail['user_email']); ?>" name="user_email" id="user_email" class="form-control">
                                       
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Email Id">Change Password</label>
                                        <input type="checkbox" class="form-control hide-show-pass-div" name="change_password" id="change_password">
                                    </div>
                                    <div id="change_password_div" style="display:none;">
                                        <div class="form-group">
                                            <label for="Password">Password <sup class="mandatory">*</sup></label>
                                            <input type="password" id="user_password" name="user_password" class="form-control">
                                            <div class="password-meter" style="display:none">
                                                <div class="password-meter-message password-meter-message-too-short">Too short</div>
                                                <div class="password-meter-bg">
                                                    <div class="password-meter-bar password-meter-too-short"></div>
                                                </div>
                                            </div>
                                            <span> (Password must be combination of atleast 1 number, 1 special character and 1 upper case letter with minimum 8 characters) </span> </div>

                                        <div class="form-group">
                                            <label for="Confirm Password">Confirm Password<sup class="mandatory">*</sup></label>
                                            <input type="password" value="" name="confirm_password" id="confirm_password" class="form-control">
                                        </div>
                                    </div>
                                    
                                    <?php
                                    if ($arr_admin_detail['user_type'] != 1) {
                                        ?>
                                        <div class="form-group">
                                            <label for="status">Change Status<sup class="mandatory">*</sup></label>
                                            <select id="user_status" name="status" class="form-control">
                                                
                                                <option value="1" <?php if ($arr_admin_detail['user_status'] == 1) { ?> selected="selected" <?php } ?>>Active</option>
                                                <option value="0" <?php if ($arr_admin_detail['user_status'] == 0) { ?> selected="selected" <?php } ?>>InActive</option>
                                            </select>
                                        </div>
                                        <?php
                                    } 
                                        ?>
                                        
                                    <?php
                                    if ($arr_admin_detail['user_type'] != 1) {
                                        ?>
                                        <div class="form-group">
                                            <label for="">Select User Type<sup class="mandatory">*</sup></label>
                                            <select id="" name="user_type" class="form-control">
                                            <option <?php if ($arr_admin_detail['user_type'] == 1) { ?> selected="selected" <?php } ?> value='1'> Normal/lock</option>
                                        <option <?php if ($arr_admin_detail['user_type'] == 2) { ?> selected="selected" <?php } ?> value='2'> Admin/unlock</option>
                                            </select>
                                        </div>
                                    <?php } 
                                        ?>
                                       
                                       
                                </div>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" name="btn_submit" class="btn btn-primary" value="Save" id="btnSubmit">Save Changes</button>
                            
                            <img src="<?php echo base_url(); ?>media/front/img/loader.gif" style="display: none;" id="loding_image">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
        </div>
<?php $this->load->view('backend/sections/footer'); ?>

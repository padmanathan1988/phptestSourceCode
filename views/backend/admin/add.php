<?php $this->load->view('backend/sections/header'); ?>
<?php $this->load->view('backend/sections/top-nav.php'); ?>
<?php $this->load->view('backend/sections/leftmenu.php'); ?>
<aside class="right-side">
    <section class="content-header">
        <h1>
            Add New Admin 

        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>backend/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?php echo base_url(); ?>backend/admin/list"><i class="fa fa-fw fa-user"></i> Manage Admin Users</a></li>
            <li class="active">	Add New Admin </li>

        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <form name="frm_admin_details" id="frm_admin_details"  action="<?php echo $action; ?>" method="POST" >
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="User Name">User Name <sup class="mandatory">*</sup></label>
                                        <input type="text" value="" required id="user_name" name="user_name" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="First Name">First Name <sup class="mandatory">*</sup></label>
                                        <input type="text" value="" required name="first_name" id="first_name"  class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="Middel Name">Middel Name </label>
                                        <input type="text" value=""  name="middel_name" id="middel_name"  class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="Last Name">Last Name <sup class="mandatory">*</sup></label>
                                        <input type="text" value="" required name="last_name" id="last_name"  class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="Email Id">Email Id <sup class="mandatory">*</sup></label>
                                        <input type="text" value="" required name="user_email" id="user_email" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
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
                                    <div class="form-group">
                                        <label for="status">Select Status<sup class="mandatory">*</sup></label>
                                        <select id="" required name="status" class="form-control">
                                        <option value='1'> Active</option>
                                        <option value='0'> InActive</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Select User Access<sup class="mandatory">*</sup></label>
                                        <select id="" required name="user_type" class="form-control">
                                        <option value='1'> Normal/lock</option>
                                        <option value='2'> Admin/unlock</option>
                                        </select>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" name="btn_submit" class="btn btn-primary" value="Save" id="btnSubmit">Save</button>
                            <img src="<?php echo base_url(); ?>media/front/img/loader.gif" style="display: none;" id="loding_image">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
        </div>
<?php $this->load->view('backend/sections/footer'); ?>

        <link rel="stylesheet" href="<?php echo base_url(); ?>media/front/css/jquery.validate.password.css" />
        <script src="<?php echo base_url(); ?>media/front/js/jquery.validate.password.js"></script>
        <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>media/backend/js/admin-manage/add-admin.js"></script>
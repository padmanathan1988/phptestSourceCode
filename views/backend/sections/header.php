<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content=" - admin panel.">
        <meta name="author" content="Padmanathan Gujiri" ><!--		Developed by Paddy-->
        <title><?php
        $user_account = $this->session->userdata('user_account');
        
        echo $user_account[0]['user_name'];
        
        ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="<?php echo base_url(); ?>media/backend/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?php echo base_url(); ?>media/backend/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="<?php echo base_url(); ?>media/backend/css/ionicons.min.css" rel="stylesheet" type="text/css" />

        <!-- DATA TABLES -->
        <link href="<?php echo base_url(); ?>media/backend/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo base_url(); ?>media/backend/css/AdminLTE.css" rel="stylesheet" type="text/css" />

        
    </head>
    <body class="skin-black">

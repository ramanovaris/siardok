<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Login | SIARDOK</title>
    <!-- Favicon-->
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?php echo base_url(); ?>assets/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?php echo base_url(); ?>assets/plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
    
</head>

<body class="login-page" style="background-color: #f44336">
    <?php if($this->session->flashdata('salah_nik', 5)): ?>
            <?php echo '<p class="alert alert-warning">'.$this->session->flashdata('salah_nik', 5).'</p>'; ?>
    <?php endif; ?>
    <?php if($this->session->flashdata('expired')): ?>
            <?php echo '<p class="alert alert-warning">'.$this->session->flashdata('expired').'</p>'; ?>
    <?php endif; ?>
    <div class="login-box">
        <div class="logo">
            <a href="javascript:void(0);">Login<b>SIARDOK</b></a>
            <small>Sistem Informasi Arsip Dokumen</small>
        </div>
        <div class="card">
            <div class="body">
                <?php echo form_open('login/login_step_one'); ?>
                    <div class="msg">Sign in to start your session</div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="txtNIK" placeholder="Masukkan NIK" required autofocus>
                        </div>
                    </div>
                    <div class="row">
                                <button class="btn bg-pink btn-lg waves-effect" type="submit" title="Sign In" data-toggle="tooltip" data-placement="bottom" style="padding: 15px 50px; font-size: 12px; border-radius: 8px; position: relative; top: -4px; left: 46px;">SIGN IN</button>
                                <a href="<?php echo base_url(); ?>beranda"><button class="btn btn-lg btn-default" type="button" title="Back To Home" data-toggle="tooltip" data-placement="bottom" style="padding: 15px 30px; font-size: 12px; border-radius: 8px; position: relative; top: -4px; left: 46px;">BACK TO HOME</button>
                                </a>
                    </div>
            </div>
                <?php echo form_open(); ?>
            </div>
        </div>
    </div>

    <!-- Jquery Core Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/node-waves/waves.js"></script>

    <!-- Validation Plugin Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/jquery.validate.js"></script>

    <!-- Custom Js -->
    <script src="<?php echo base_url(); ?>assets/js/admin.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/pages/examples/sign-in.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/pages/ui/tooltips-popovers.js"></script>
</body>

</html>
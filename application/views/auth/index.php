
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login Page </title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url('assets') ?>/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url('assets') ?>/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url('assets') ?>/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?php echo base_url('assets') ?>/vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url('assets') ?>/build/css/custom.min.css" rel="stylesheet">

</head>

<body style="background-size: 100%;">
    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <div>
                    <img src="<?php echo base_url() ?>assets/images/logo_gaji.jpeg" width="120px;" height="120px;">
                    <h3 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: chocolate;">Sistem Informasi </h3>

                    <h1 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: chocolate;">PENGGAJIAN</h1>
                </div>
                <?php echo form_open("Auth/", array('method' => 'POST', 'class' => 'login-form')); ?>
                <hr>
                <div>
                    <div class="text-left"><?php echo form_error('username'); ?></div>
                    <?php echo form_input(array('type' => 'text', 'class' => 'form-control', 'placeholder' => 'Username', 'name' => 'username', 'id' => 'username')); ?>
                </div>
                <div>
                    <div class="text-left"> <?php echo form_error('password'); ?> </div>
                    <?php echo form_input(array('type' => 'password', 'class' => 'form-control', 'placeholder' => 'Password', 'name' => 'password', 'id' => 'password')); ?>
                </div>
                <div>
                    <button class="btn btn-danger btn-sm" style="width: 100%;" type="submit"> <i class='fa fa-user'></i> Masuk</button>
                </div>

                <div class="clearfix"></div>
                <label class="text-left">
                    <?php
                    $message = $this->session->flashdata('result_login');
                    if ($message) { ?>
                        <div style="color: red;"><?php echo $message; ?></div>
                    <?php } ?>
                </label>
                <div class="separator">
                    <div class="clearfix"></div>
                    <br />

                </div>
                <?php echo form_close(); ?>
            </section>
            <div class="text" style="color:white;font-size:9px;">
              
            </div>
        </div>

    </div>
</body>


</html>
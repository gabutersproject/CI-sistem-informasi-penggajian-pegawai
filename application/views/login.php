<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>kumpulankode.com</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- ========Bootstrap 3.3.2======= -->
        <link href="<?php echo base_url('assets/adminlte/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="<?php echo base_url('assets/font-awesome-4.3.0/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo base_url('assets/adminlte/dist/css/AdminLTE.min.css') ?>" rel="stylesheet" type="text/css" />
        <!-- iCheck -->
        <link href="<?php echo base_url('assets/adminlte/plugins/iCheck/square/blue.css') ?>" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="login-page">
        <div class="login-box">
            <div class="login-logo">
                
            </div><!-- /.login-logo -->
            <div class="login-box-body">
                <h3 class="login-box-msg with-border"><strong style="font-size: 27px">LOGIN PENGGAJIAN PEGAWAI</strong></h3>
                
                <p><?php echo $this->session->flashdata('msg');?></p>
                <?php echo form_open('auth/login');?>
                    <div class="form-group has-feedback">
                        <input type="text" id="idusername" name="username" class="form-control"/>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        <span class="text-danger">
                            <?php echo form_error('username')?>
                        </span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" name="password" class="form-control" />
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        <span class="text-danger">
                            <?php echo form_error('password')?>
                        </span>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 pull-right">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
                        </div><!-- /.col -->
                    </div>
                </form>

            </div><!-- /.login-box-body -->
        </div><!-- /.login-box -->

        <!-- jQuery 2.1.3 -->
        <script src="<?php echo base_url('assets/adminlte/plugins/jQuery/jquery-2.2.3.min.js') ?>"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script src="<?php echo base_url('assets/adminlte/bootstrap/js/bootstrap.min.js') ?>" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="<?php echo base_url('assets/adminlte/plugins/iCheck/icheck.min.js') ?>" type="text/javascript"></script>
        <script>
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
            });
            $(document).ready(function(){
                $('#idusername').focus();
            });
            
        </script>
    </body>
</html>
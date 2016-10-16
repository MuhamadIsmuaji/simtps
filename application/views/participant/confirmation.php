<!DOCTYPE html>
<html>
<head>
	<title>SIM TPS | Confirmation Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

     <!-- Fonts -->
    <!-- <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:300,400' rel='stylesheet' type='text/css'> -->
    <!-- <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'> -->
    
    <!-- CSS Libs -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/font-awesome.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/animate.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bootstrap-switch.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/checkbox3.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/jquery.dataTables.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/dataTables.bootstrap.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/select2.min.css') ?>">

    <!-- CSS App -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/themes/flat-blue.css') ?>">

    <!-- Javascript Libs -->
    <script type="text/javascript" src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>

    <style type="text/css">
        body.login-page {
            background: none;
            background-color: #353d47;
        }

        body.login-page .login-box {
            max-width: 450px;
        }
    </style>
	
</head>
<body class="flat-blue login-page">
    <div class="container">
        <div class="login-box">
            <div>
                <div class="login-form row">
                    <div class="col-sm-12 text-center login-header">
                        <i class="login-logo fa fa-university fa-5x"></i>
                        <h4 class="login-title">SIM TPS | Halaman Konfirmasi</h4>
                    </div>
                    <div class="col-sm-12">
                        <div class="login-body">
                            <form action="<?= base_url('participant/confirmation/confirmationProcess') ?>" method="POST">
                                <div class="control">
                                    <input type="text" class="form-control" name="email" placeholder="Alamat email" />
                                    <?php echo form_error('email'); ?>
                                </div>
                                <div class="control">
                                    <input type="password" class="form-control" name="pwd" placeholder="Password baru" />
                                    <?php echo form_error('pwd'); ?>
                                </div>
                                <div class="control">
                                    <input type="password" class="form-control" name="pwdconf" placeholder="Ulangi Password baru" />
                                    <?php echo form_error('pwdconf'); ?>                                    
                                </div>
                                <div class="login-button text-center">
                                    <input type="submit" class="btn btn-block btn-primary" value="Simpan">
                                </div>
                            </form>
                        </div>
                        <div class="login-footer">
                            <!-- <span class="text-right"><a href="#" class="color-white">Forgot password?</a></span> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Javascript Libs -->
    <script type="text/javascript" src="<?= base_url('assets/js/Chart.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/bootstrap-switch.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/jquery.matchHeight-min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/dataTables.bootstrap.min.js') ?>"></script>
    <!-- <script type="text/javascript" src="<?= base_url('assets/js/select2.full.min.js') ?>"></script> -->
    <script type="text/javascript" src="<?= base_url('assets/js/ace/ace.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/ace/mode-html.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/ace/theme-github.js') ?>"></script>

</body>
</html>
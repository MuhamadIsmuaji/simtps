<!DOCTYPE html>
<html>
<head>
	<title>SIM TPS | <?= $pagetitle ?></title>
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

    <!-- Auto complete -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/autocomplete.css'); ?>">
    
    <!-- DatePicker -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap-datetimepicker.css'); ?>">

     <!-- include summernote css -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/summernote.css') ?>">

    <!-- CSS App -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/themes/flat-blue.css') ?>">

    <!-- Javascript Libs -->
    <script type="text/javascript" src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>

    <!-- jquiery ui -->
    <script src="<?= base_url('assets/js/jquery-ui.min.js')?>"></script>

     <!-- DatePicker -->
    <script src="<?= base_url('assets/js/moment-with-locales.js') ?>"></script>
    <script src="<?= base_url('assets/js/locale_indo.js') ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap-datetimepicker.js') ?>"></script>
    
    <!-- include summernote js -->
    <script src="<?= base_url('assets/js/summernote.js') ?>"></script>



</head>
<body class="flat-blue">

	<!-- app-container -->
	<div class="app-container">

		<!-- row content-container -->
		<div class="row content-container">

			<!-- navbar navbar-default navbar-fixed-top navbar-top -->
			<nav class="navbar navbar-default navbar-fixed-top navbar-top">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-expand-toggle">
                            <i class="fa fa-bars icon"></i>
                        </button>
                        <ol class="breadcrumb navbar-breadcrumb">
                        	<li><?= $navbartitle ?></li>
                        </ol>
                        <button type="button" class="navbar-right-expand-toggle pull-right visible-xs">
                            <i class="fa fa-th icon"></i>
                        </button>
                    </div>
                    <ul class="nav navbar-nav navbar-right">
                        <button type="button" class="navbar-right-expand-toggle pull-right visible-xs">
                            <i class="fa fa-times icon"></i>
                        </button>
                        
                        <?php 
                            if ($this->session->userdata('isAdminTps') || $this->session->userdata('isLecturerTps')) {
                                $this->load->view('header_menu/lecturer_header');
                            } else if ($this->session->userdata('isParticipantTps')) {
                                $this->load->view('header_menu/participant_header');
                            }
                            else {
                                $this->load->view('header_menu/public_header');
                            }
                        ?>
                    </ul>
                </div>
            </nav>
			<!-- navbar navbar-default navbar-fixed-top navbar-top -->
			
			<!-- sidebar -->
			<?php $this->load->view('sidebar') ?>
			<!-- sidebar -->
			
			<!-- Main Content -->
            <div class="container-fluid">
				<!-- side-body padding-top -->
                <div class="side-body padding-top">



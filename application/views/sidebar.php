<!-- side-menu sidebar-inverse -->
<div class="side-menu sidebar-inverse">
	<nav class="navbar navbar-default" role="navigation">
	    <div class="side-menu-container">
	        <div class="navbar-header">
	            <a class="navbar-brand" href="<?= base_url('public/home') ?>">
	                <!-- <div class="icon fa fa-university fa-lg"></div> -->

	                <!-- <div class="title"><strong>SIM TPS</strong></div> -->
                 	<div class="icon">
                        <img src="<?= base_url('assets/img/logo/favicon-untag.png') ?>" class="icon-navbar-brand logo-header" style="max-height: 37px;" alt="logo-header">
                    </div>
                    <div class="title navtitle" style="margin-left: -7px; margin-top: 1px; font-size: 14px;">
                        <strong>Tugas Perancangan Sistem</strong>
                    </div>
                </a>
	            <button type="button" class="navbar-expand-toggle pull-right visible-xs">
	                <i class="fa fa-times icon"></i>
	            </button>
	        </div>
	        <ul class="nav navbar-nav">
	            <?php 
	            	//Public sidebar
	            	$this->load->view('sidebar_menu/public_sidebar'); 

	            	if ( $this->session->userdata('isAdminTps') ) {
	            		$this->load->view('sidebar_menu/admin_sidebar');
	            	}

	            	if ( $this->session->userdata('isLecturerTps') || $this->session->userdata('isAdminTps') ) {
	            		$this->load->view('sidebar_menu/lecturer_sidebar');	
	            	}

	            	if ( $this->session->userdata('isParticipantTps') ) {
	            		$this->load->view('sidebar_menu/participant_sidebar');	
	            	}
	            ?>
	        </ul>
	    </div>
	    <!-- /.navbar-collapse -->
	</nav>
</div>
<!-- side-menu sidebar-inverse -->
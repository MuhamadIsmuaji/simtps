<!-- side-menu sidebar-inverse -->
<div class="side-menu sidebar-inverse">
	<nav class="navbar navbar-default" role="navigation">
	    <div class="side-menu-container">
	        <div class="navbar-header">
	            <a class="navbar-brand" href="<?= base_url('public/home') ?>">
	                <div class="icon fa fa-university fa-lg"></div>
	                <div class="title"><strong>SIM TPS</strong></div>
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
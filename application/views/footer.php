				</div>
				<!-- side-body padding-top -->
			</div>
			<!-- Main Content -->

		</div>
		<!-- row content-container -->

		<!-- app-footer -->
		<footer class="app-footer">
			<div class="wrapper">
				<span class="pull-right">Page Loaded : <strong>{elapsed_time}</strong> seconds | <a href="#"><i class="fa fa-long-arrow-up"></i></a></span> Powered By Code For Tech © 2016 Copyright.
			</div>
		</footer>
		<!-- app-footer -->

	</div>
	<!-- app-container -->

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
    
    <!-- Javascript -->
    <script type="text/javascript" src="<?= base_url('assets/js/app.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/js/numberOnly.js') ?>"></script>
    <!-- <script type="text/javascript" src="<?= base_url('assets/js/index.js') ?>"></script> -->

	<!-- For notif request group participant -->
    <?php if ( $this->session->userdata('isParticipantTps') ): ?>
		<script type="text/javascript">
	    	
	    	$(function(){
	    		setInterval(notifRequestGroup, 1000);
	    	});

	    	function notifRequestGroup() {
	    		$.ajax({
	        		url : "<?= base_url('participant/request/checkRequest') ?>",
	        		dataTypes : 'json',
	        		success : function(status){
	        			if ( status == 0 ) {
	        				$('#notifReqSign').html('<strong></strong>');
	    					$('#badgeNotifReqGroup').text('0');
	        			} else {
	        				$('#notifReqSign').html('<strong>*</strong>');
	    					$('#badgeNotifReqGroup').text('1');
	        			}
	        		}
	        	});
	    	}

	    </script>
	<?php endif; ?>
	<!-- For notif request group participant -->
</body>
</html>
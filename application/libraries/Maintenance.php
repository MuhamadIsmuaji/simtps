<?php

class Maintenance {

    private $CI;

    public function __construct() {

        $this->CI =& get_instance();
        $this->CI->load->view('maintenance/vw_maintenance');
    }

}
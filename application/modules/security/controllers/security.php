<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Security extends MX_Controller {
	function __construct() {
	}

	function isLoggedInAndHaveAccess() {
        if(!is_numeric($this->session->userdata('user_id'))) {
			redirect('auth/login');
        }
        
        $module = $this->router->fetch_class();
        $this->load->model('security/mdl_security');

        //Access based on database
        // if(!$this->mdl_security->haveAccess($module)) {
		// 	redirect('home', 'refresh');
        // }

        //Access based on session data
        foreach($this->session->userdata('modules_access') as $module_access) {
            if(trim($module, ' ') == trim($module_access['name'], ' ')) {
                return true;
            }
        }
        redirect('home', 'refresh');
    }

    function haveRight($user_id, $module_id, $right_id) {
        $this->load->model('security/mdl_security');
        return $this->mdl_security->haveRight($user_id, $module_id, $right_id);
    }
}
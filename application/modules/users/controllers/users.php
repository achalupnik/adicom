<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MX_Controller {
	function __construct() {
		if(!is_numeric($this->session->userdata('user_id'))) {
			redirect('auth/login');
		}
	}


	function index()
	{
	
    }
	
	
    function check_modules_access() {
		$this->load->model('users/mdl_users');
		return $this->mdl_users->check_modules_access();
    }
}

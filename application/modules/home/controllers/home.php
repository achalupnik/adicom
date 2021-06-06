<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MX_Controller {
	function __construct() {
		if(!is_numeric($this->session->userdata('user_id'))) {
			redirect('auth/login');
        }
	}

	function index()
	{
		$data['view_file'] = 'welcome_message';
		$data['module'] = 'home';		
		$this->load->module('template');
		$this->template->main($data);
	}
}

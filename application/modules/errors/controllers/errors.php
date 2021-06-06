<?php 
class errors extends MX_Controller {
   public function __construct()  {
      parent::__construct(); 
   } 

   public function index()  { 
      $this->output->set_status_header('404'); 
      $this->load->view('404');
   } 
} 
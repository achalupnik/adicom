<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Mdl_template extends CI_Model
{
    function __construct() {
        parent::__construct();
        $this->load->library('Datatables');
    }

    
}
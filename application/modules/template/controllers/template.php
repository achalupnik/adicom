<?php
class Template extends MX_Controller 
{

function __construct() {
parent::__construct();


}

function main($data) {
    $modules = $this->session->userdata('modules_access');
    foreach($modules as $module) {
        if($module['parent'] == 0) {
            $unsorted_menu_items[$module['id']] = $module;
        } else {
            settype($unsorted_menu_items[$module['parent']]['parent'], 'array');
            $unsorted_menu_items[$module['parent']]['parent'][$module['menu_nr']] = $module;
        }
    }
    foreach($unsorted_menu_items as $item) {
        $menu_items[$item['menu_nr']] = $item;
    }

 
    $data['menu_items'] = $menu_items;
    $data['css_main'][] = css_link('bootstrap.css','template');  //4.1.3
    $data['css_main'][] = css_link('font-awesome.css','template');  //5.14.0
    $data['css_main'][] = css_link('datatables.min.css','template');  //1.10.21
    $data['css_main'][] = css_link('jquery.dataTables.min.css','template');  //remove console errors
    $data['css_main'][] = css_link('dataTables.bootstrap4.min.css','template');  //boost for appearance
    $data['css_main'][] = css_link('global_css.css','template');  //boost for appearance


    //$data['css_main'][] = css_link('bootstrap-combined.no-icons.min.css','template');
    //$data['css_main'][] = css_link('font/css/font-awesome.min.css','template');


    // $data['css_main'][] = css_link('style.css','template');
    // $data['css_main'][] = css_link('bootstrapValidator.min.css','template');
    // $data['css_main'][] = css_link('jquery.dataTables.css','template');
    // $data['css_main'][] = css_link('jquery-ui.css','template');
    // $data['css_main'][] = css_link('chosen.min.css','template');
    // $data['css_main'][] = css_link('dataTables.tableTools.min.css','template');
    // $data['css_main'][] = css_link('nowe_menu.css','template');
    // $data['css_main'][] = css_link('custom_style.css','template');


    $data['js_main'][] = js_link('jquery.js','template');  //3.5.1
    $data['js_main'][] = js_link('jquery-ui.min.js','template');  //1.12.1
    $data['js_main'][] = js_link('bootstrap.js','template');
    $data['js_main'][] = js_link('font-awesome.js','template');
    $data['js_main'][] = js_link('datatables.min.js','template');
    $data['js_main'][] = js_link('dataTables.bootstrap4.min.js','template');
    $data['js_main'][] = js_link('datatables.default.js','template');
    $data['js_main'][] = js_link('jquery.dataTables.min.js','template');
    $data['js_main'][] = js_link('jquery.cookie.js','template');

    // $data['js_main'][] = js_link('script.js','template');
    // $data['js_main'][] = js_link('bootbox.min.js','template');
    // $data['js_main'][] = js_link('gofrendi.chosen.ajaxify.js','template');
    // $data['js_main'][] = js_link('alerts.js','template');

    // $data['js_main'][] = js_link('nowe_menu.js','template');
    // $data['js_main'][] = js_link('bootstrapValidator.min.js','template');
    // $data['js_main'][] = js_link('language/pl_PL.js','template');
    // $data['js_main'][] = js_link('jquery.cookie.js','template');
    // $data['js_main'][] = js_link('jquery-ui.min.js','template');
    // $data['js_main'][] = js_link('chosen.jquery.min.js','template');
    // $data['js_main'][] = js_link('jquery.dataTables.js','template');
    // $data['js_main'][] = js_link('dataTables.bootstrap.js','template');
    // $data['js_main'][] = js_link('datatables.default.js','template');
    // $data['js_main'][] = js_link('dataTables.tableTools.min.js','template');
    // $data['js_main'][] = js_link('jquery.validate.js','template');
    // $data['js_main'][] = js_link('jquery.validate.messages.js','template');

    if (!isset($data['module'])) {
        $data['module'] = $this->uri->segment(1);
    }
    foreach($modules as $module) {
        if($module['name'] == $data['module']) {
            $data['site_title'] = $module['desc'];
        }
    }

    $this->load->view('include/header', $data);
    $this->load->view('include/menubar', $data);
    if(isset($data['headerbar_info'])) $this->load->view('include/headerbar', $data);
    
    if (!isset($data['view_file'])) {
            $data['view_file'] = $this->uri->segment(2);
        }

        if (!isset($data['module'])) {
            $data['module'] = $this->uri->segment(1);
        }
        
        if (($data['view_file']!="") && ($data['module']!="")) {
        $path = $data['module']."/".$data['view_file'];
        $this->load->view($path,$data);
    }
    $this->load->view('include/footer', $data);
}

function login($data) {
    $data['css_main'][] = css_link('bootstrap.css','template');
    $data['js_main'][] = js_link('jquery.js','template');
    $data['js_main'][] = js_link('bootstrap.js','template');
    $this->load->view('include/header', $data);
    $this->load->view('auth/auth/login',$data);
    $this->load->view('include/footer', $data);
}

function ajax($data) {
    //Modules::run('app_security/_check_is_logged_in');
    if (!$this->input->is_ajax_request()) return;
    $this->load->view('include/ajax_header', $data);
    if(isset($data['headerbar_info'])) $this->load->view('include/headerbar', $data);
    if (!isset($data['view_file']) || !isset($data['module'])) return;
    if (($data['view_file']!="") && ($data['module']!="")) {
        $path = $data['module']."/".$data['view_file'];
        $this->load->view($path,$data);
    }
}

}
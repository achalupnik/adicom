<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Groups_rights extends MX_Controller {
	function __construct() {
		Modules::run('security/isLoggedInAndHaveAccess');
        $this->load->model('groups_rights/mdl_groups_rights');
	}


	function index() {
		$data['view_file'] = 'main_groups_list';
		$data['module'] = 'groups_rights';
		$this->load->module('template');
		$this->template->main($data);
  }
    

    function getGroups() {
        $this->mdl_groups_rights->getGroups();
    }

	function getGroupsAccessRights() {
		$group_id = $this->input->post('group_id', true);
		$data['all_modules_rights'] = $this->getModulesRights();
		$data['group_modules_rights'] = $this->getGroupModulesRights($group_id);
		$data['view_file'] = 'm_group_modules_rights';
		$data['module'] = 'groups_rights';
		$this->load->module('template');
		$this->template->ajax($data);
    }

	function getModulesRights() {
		$modules_rights = $this->mdl_groups_rights->getModulesRights();
		foreach($modules_rights as $module_right) {
			$rights_in_modules['module_id'][$module_right->module_id]['module_desc'] = $module_right->module_desc;
			$rights_in_modules['module_id'][$module_right->module_id]['right_id'][$module_right->right_id] = $module_right->right_name;
		}
		return $rights_in_modules;
	}

	function getGroupModulesRights($group_id) {
		$group_modules_rights = $this->mdl_groups_rights->getGroupModulesRights($group_id);
		$group_module_right_array = array();
		foreach($group_modules_rights as $group_module_right) {
			$group_module_right_array['module_id'][$group_module_right->module_id]['right_id'][$group_module_right->right_id] = 1;
		}
		return $group_module_right_array;
	}

    function saveGroupAccessRights() {
		$post = $this->input->post(null, true);
		$group_id = $post['group_id'];
		if(!Modules::run('security/haveRight',$this->session->userdata('user_id'), 4, 2)) {
			echo json_encode([1, 'Brak uprawnień do wykonania tego działania']);
			return;
		} 
		$changed_data_encoded = $post['changed_inputs'];
		$changed_data = json_decode($changed_data_encoded);

		if($group_id == 1) {
			foreach($changed_data as $values) {
				if($values->module_id == 3) {
					echo json_encode([1, 'Nie można zmieniać uprawnień administratora do modułu zarządzającego uprawnieniami']);
					return;
				}
			}
		}

		if($this->mdl_groups_rights->saveGroupAccessRights($group_id, $changed_data)) {
			echo json_encode([2, 'Zmiany zostały zapisane']);
		} else {
			echo json_encode([1, 'W trakcie wprowadzania zmian wystąpił błąd']);
		}
		return;
	}

}

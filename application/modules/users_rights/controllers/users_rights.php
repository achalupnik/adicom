<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_rights extends MX_Controller {
	function __construct() {
		Modules::run('security/isLoggedInAndHaveAccess');
        $this->load->model('users_rights/mdl_users_rights');
	}


	function index() {
		$data['view_file'] = 'main_users_list';
		$data['module'] = 'users_rights';
		$this->load->module('template');
		$this->template->main($data);
    }
    

    function getUsers() {
        $this->mdl_users_rights->getUsers();
    }

	function getUserAccessRights() {
		$user_id = $this->input->post('user_id', true);
		$data['all_modules_rights'] = $this->getModulesRights();
		$data['user_modules_rights'] = $this->getUserModulesRights($user_id);
		$data['user_groups_rights'] = $this->getUserGroupsRights($user_id);
		$data['view_file'] = 'm_user_modules_rights';
		$data['module'] = 'users_rights';
		$this->load->module('template');
		$this->template->ajax($data);
    }

	function getModulesRights() {
		$modules_rights = $this->mdl_users_rights->getModulesRights();
		foreach($modules_rights as $module_right) {
			$rights_in_modules['module_id'][$module_right->module_id]['module_desc'] = $module_right->module_desc;
			$rights_in_modules['module_id'][$module_right->module_id]['right_id'][$module_right->right_id] = $module_right->right_name;
		}
		return $rights_in_modules;
	}

	function getUserModulesRights($user_id) {
		$user_modules_rights = $this->mdl_users_rights->getUserModulesRights($user_id);
		$user_module_right_array = array();
		foreach($user_modules_rights as $user_module_right) {
			$user_module_right_array['module_id'][$user_module_right->module_id]['right_id'][$user_module_right->right_id] = 1;
		}
		return $user_module_right_array;
	}

	function getUserGroupsRights($user_id) {
		$user_groups_rights = $this->mdl_users_rights->getUserGroupsRights($user_id);
		$user_groups_rights_array = array();
		foreach($user_groups_rights as $user_group_right) {
			$user_groups_rights_array['module_id'][$user_group_right->module_id]['right_id'][$user_group_right->right_id]['number_groups'] = $user_group_right->number_groups;
			$user_groups_rights_array['module_id'][$user_group_right->module_id]['right_id'][$user_group_right->right_id]['groups_names'] = $user_group_right->group_name;
		}
		return $user_groups_rights_array;
	}

    function saveUserAccessRights() {
		$post = $this->input->post(null, true);
		$user_id = $post['user_id'];
		$this->load->module('security');
		if(!Modules::run('security/haveRight',$this->session->userdata('user_id'), 3, 2)) {
			echo json_encode([1, 'Brak uprawnień do wykonania tego działania']);
			return;
		} 
		$changed_data_encoded = $post['changed_inputs'];
		$changed_data = json_decode($changed_data_encoded);

		if($user_id == 1) {
			foreach($changed_data as $values) {
				if($values->module_id == 3) {
					echo json_encode([1, 'Nie można zmieniać uprawnień administratora do modułu zarządzającego uprawnieniami']);
					return;
				}
			}
		}

		if($this->mdl_users_rights->saveUserAccessRights($user_id, $changed_data)) {
			echo json_encode([2, 'Zmiany zostały zapisane']);
		} else {
			echo json_encode([1, 'W trakcie wprowadzania zmian wystąpił błąd']);
		}
		return;
	}

}

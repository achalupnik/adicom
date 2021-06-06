<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Mdl_users_rights extends CI_Model
{
    function __construct() {
        parent::__construct();
        $this->load->library('Datatables');
    }

    function getUsers() {
        echo $this->datatables->select('id as id, username as username', false)
            ->where('active', 1)
            ->from('users')
            ->generate();
    }

    function getModulesRights() {
        return $this->db->select('m.id as module_id, m.desc as module_desc, r.id as right_id, r.name as right_name')
            ->where('m.auxiliary', 0)
            ->join('rights r', 'r.module_id=m.id or r.module_id is null')
            ->order_by('m.id, r.id')
            ->get('modules m')->result();
    }

    function getUserModulesRights($user_id) {
        return $this->db->select('u.id as user_id, ua.module_id as module_id, ua.right_id as right_id')
            ->join('users_access ua', 'u.id=ua.user_id')
            ->where('u.id =', $user_id)
            ->get('users u')->result();
    }

    function getUserGroupsRights($user_id) {
        return $this->db->select('ug.user_id as user_id, ga.module_id as module_id, ga.right_id as right_id, GROUP_CONCAT(DISTINCT(g.description) SEPARATOR ", ") as group_name, count(DISTINCT(ug.group_id)) as number_groups')
            ->where('ug.user_id', $user_id)
            ->join('groups_access ga', 'ug.group_id=ga.group_id')
            ->join('groups g', 'g.id=ug.group_id')
            ->group_by('ga.module_id', 'ga.right_id')
            ->get('users_groups ug')->result();
    }

    function saveUserAccessRights($user_id, $changed_data) {
        $save_flag = 1;
        foreach($changed_data as $single_log) {
            $single_log_array = array(
                'user_id' => $user_id,
                'module_id' => $single_log->module_id,
                'right_id'=> $single_log->right_id
            );
            $parent_module = $this->db->select('parent')
                ->where('id', $single_log->module_id)
                ->get('modules')->result()[0]->parent;
            
            if($single_log->value) {
                $is_in_db = $this->db->get_where('users_access', $single_log_array)->num_rows();
                if(!$is_in_db) {
                    if($parent_module != 0 && $single_log->right_id == 1) {
                        $have_access_to_parent = $this->db->where('user_id', $user_id)
                            ->where('module_id', $parent_module)
                            ->where('right_id', 1)
                            ->get('users_access')->num_rows();
                        if(!$have_access_to_parent) {
                            $access_to_parent = array(
                                'user_id' => $user_id,
                                'module_id' => $parent_module,
                                'right_id'=> 1
                            );
                            $this->db->insert('users_access', $access_to_parent);
                            if(!$this->db->affected_rows()) {
                                $save_flag = 0;
                                return $save_flag;
                            }
                        }
                    }
                    $this->db->insert('users_access', $single_log_array);
                    if(!$this->db->affected_rows()) {
                        $save_flag = 0;
                    }
                } else {
                    $save_flag = 0;
                }
            } else {
                if($parent_module != 0 && $single_log->right_id == 1) {
                    $access_to_parent_childrens = $this->db->where('m.parent', $parent_module)
                        ->where('ua.user_id', $user_id)
                        ->where('ua.right_id', 1)
                        ->join('modules m', 'm.id=ua.module_id')
                        ->get('users_access ua')->num_rows();

                    if($access_to_parent_childrens == 1) {
                        $this->db->where('user_id', $user_id)
                            ->where('right_id', 1)
                            ->where('module_id', $parent_module)
                            ->delete('users_access');
                    }
                }
                $this->db->where($single_log_array)
                    ->delete('users_access');
                if(!$this->db->affected_rows()) {
                    $save_flag = 0;
                }
            }
        }
        return $save_flag;
    }
}
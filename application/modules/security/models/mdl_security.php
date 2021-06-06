<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Mdl_security extends CI_Model
{
    function __construct() {
        parent::__construct();
    }


    function haveAccess($module) {
        $module_id = $this->db->select('id')
            ->where('name', $module)
            ->get('modules')->row();
        if(!isset($module_id->id)) {
            return false;
        } else {
            $module_id = $module_id->id;
        }

        $user_id = $this->session->userdata('user_id');
        $user_access = $this->db->where('user_id', $user_id)
            ->where('module_id', $module_id)
            ->where('right_id', 1)
            ->get('users_access')->num_rows();

        if($user_access) {
            return true;
        } 

        $groups_access = $this->db->where('ug.user_id', $user_id)
            ->where('ga.module_id', $module_id)
            ->where('right_id', 1)
            ->join('groups_access ga', 'ug.group_id=ga.group_id', 'left')
            ->get('users_groups ug')->num_rows();

        if($groups_access) {
            return true;
        } else {
            return false;
        }
    }

    function haveRight($user_id, $module_id, $right_id) {
        $users_access = $this->db->where('user_id', $user_id)
            ->where('module_id', $module_id)
            ->where('right_id', $right_id)
            ->get('users_access')->num_rows();

        if($users_access) {
            return true;
        }

        $groups_access = $this->db->where('ug.user_id', $user_id)
            ->where('ga.module_id', $module_id)
            ->where('ga.right_id', $right_id)
            ->join('groups_access ga', 'ug.group_id=ga.group_id')
            ->get('users_groups ug')->num_rows();

            if($groups_access) {
                return true;
            } else {
                return false;
            }
    }
}
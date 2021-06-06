<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Mdl_users extends CI_Model
{
    public function __construct() {
        parent::__construct();
    }


    function check_modules_access() {
        $user_id = $this->session->userdata('user_id');
        $user_groups_string = '';

        $user_groups = $this->db->select('group_id')
            ->where('user_id', $user_id)
            ->get('users_groups')->result_array();
        foreach($user_groups as $key => $user_group) {
            if($key != 0) {
                $user_groups_string .= ',';
            }
            $user_groups_string .= $user_group['group_id'];
        }

        return $this->db->distinct()
            ->select('m.*')
            ->where_in('ga.group_id', $user_groups_string)
            ->or_where('ua.user_id', $user_id)
            ->join('users_access ua', 'ua.module_id=m.id', 'left')
            ->join('groups_access ga', 'ga.module_id=m.id', 'left')
            ->order_by('m.parent, m.menu_nr')
            ->get('modules m')->result_array();
    }
}
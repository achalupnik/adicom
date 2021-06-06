<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Mdl_groups_rights extends CI_Model
{
    function __construct() {
        parent::__construct();
        $this->load->library('Datatables');
    }

    function getGroups() {
        echo $this->datatables->select('id as id, name as name', false)
            ->from('groups')
            ->generate();
    }

    function getModulesRights() {
        return $this->db->select('m.id as module_id, m.desc as module_desc, r.id as right_id, r.name as right_name')
            ->where('m.auxiliary', 0)
            ->join('rights r', 'r.module_id=m.id or r.module_id is null')
            ->order_by('m.id, r.id')
            ->get('modules m')->result();
    }

    function getGroupModulesRights($group_id) {
        return $this->db->select('g.id as group_id, ga.module_id as module_id, ga.right_id as right_id')
            ->join('groups_access ga', 'g.id=ga.group_id')
            ->where('g.id =', $group_id)
            ->get('groups g')->result();
    }

    function saveGroupAccessRights($group_id, $changed_data) {
        $save_flag = 1;
        foreach($changed_data as $single_log) {
            $single_log_array = array(
                'group_id' => $group_id,
                'module_id' => $single_log->module_id,
                'right_id'=> $single_log->right_id
            );
            $parent_module = $this->db->select('parent')
                ->where('id', $single_log->module_id)
                ->get('modules')->result()[0]->parent;

            if($single_log->value) {
                $is_in_db = $this->db->get_where('groups_access', $single_log_array)->num_rows();
                if(!$is_in_db) {
                    if($parent_module != 0 && $single_log->right_id == 1) {
                        $have_access_to_parent = $this->db->where('group_id', $group_id)
                            ->where('module_id', $parent_module)
                            ->where('right_id', 1)
                            ->get('groups_access')->num_rows();
                        if(!$have_access_to_parent) {
                            $access_to_parent = array(
                                'group_id' => $group_id,
                                'module_id' => $parent_module,
                                'right_id'=> 1
                            );
                            $this->db->insert('groups_access', $access_to_parent);
                            if(!$this->db->affected_rows()) {
                                $save_flag = 0;
                                return $save_flag;
                            }
                        }
                    }
                    $this->db->insert('groups_access', $single_log_array);
                    if(!$this->db->affected_rows()) {
                        $save_flag = 0;
                    }
                } else {
                    $save_flag = 0;
                }
            } else {
                if($parent_module != 0 && $single_log->right_id == 1) {
                    $access_to_parent_childrens = $this->db->where('m.parent', $parent_module)
                        ->where('ga.group_id', $group_id)
                        ->where('ga.right_id', 1)
                        ->join('modules m', 'm.id=ga.module_id')
                        ->get('groups_access ga')->num_rows();

                    if($access_to_parent_childrens == 1) {
                        $this->db->where('group_id', $group_id)
                            ->where('right_id', 1)
                            ->where('module_id', $parent_module)
                            ->delete('groups_access');
                    }
                }
                $this->db->where($single_log_array)
                    ->delete('groups_access');
                if(!$this->db->affected_rows()) {
                    $save_flag = 0;
                }
            }
        }
        return $save_flag;
    }
}
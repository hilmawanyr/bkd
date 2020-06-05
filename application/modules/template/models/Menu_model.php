<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model {

	public function get_menu($group)
	{
		return $this->db->get_where('view_menu', ['group' => $group, 'parent IS NULL' => NULL])->result();
	}

	public function get_submenu($group, $parent_id)
	{
		return $this->db->get_where('view_menu', ['group' => $group, 'parent' => $parent_id])->result();
	}

}

/* End of file Menu_model.php */
/* Location: ./application/modules/template/models/Menu_model.php */
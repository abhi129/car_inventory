<?php
class m_data extends CI_Model{
  
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function getUserRole($user_id = 0)
	{
		
		$this->db->select('status,role_id');
		$this->db->from('tbl_users');
		$this->db->where('tbl_users.id', $user_id);
		$query = $this->db->get();
		//echo $this->db->last_query(); die();		
		//$this->output->enable_profiler(TRUE);
		//print_r($query->result_array());
		return $query->result_array();
	}
	
	function getMemberRole($member_id = 1)
	{
		$this->db->select('user_role');
		$this->db->from('tbl_members');
		$this->db->where('tbl_members.id', $member_id);
		$query = $this->db->get();
		//$this->output->enable_profiler(TRUE);
		//print_r($query->result_array());
		return $query->result_array();
	}

 function isUserPermission()
    {
		$get_module=$this->router->fetch_class().'_'.$this->router->fetch_method();
		$user_id = getCurUserID();
	
		$permission =array();
		$role = getUserRole($user_id);
			//echo $role;
		//echo $role; die();
		$this->db->select('permission');
		$this->db->from('tbl_role');
		$this->db->where('tbl_role.role_id', $role);
		$query = $this->db->get();
		$query = $query->result_array();
		//pr($query);
		//$this->output->enable_profiler(TRUE);
		//return $query->result_array();
		$permission = $query[0];
		if($permission){
			$permission = explode(',' ,$permission['permission']);
		}
		
		if((in_array($get_module ,$permission)))
		{
			return 1;
		}
		else
		{
			return 0;
		}
    }
 

}
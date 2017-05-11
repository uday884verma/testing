<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	public function insert_data($data, $table)
	{
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}
	

}
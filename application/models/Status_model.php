<?php
class Status_model extends CI_Model
{
	private $table = 'status';

	public function get_products()
	{
		return $this->db->get($this->table)->result();  // Mengambil semua data status
	}

	public function get_by_id($id)
	{
		return $this->db->where('id_status', $id)->get($this->table)->row();
	}
}

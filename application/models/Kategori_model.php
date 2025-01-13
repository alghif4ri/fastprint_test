<?php
class Kategori_model extends CI_Model {
    private $table = 'kategori';

    public function get_products() {
        return $this->db->get($this->table)->result();  // Mengambil semua data kategori
    }

    public function get_by_id($id) {
        return $this->db->where('id_kategori', $id)->get($this->table)->row();
    }
}

<?php
class Product_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function save_data($data)
	{
		foreach ($data as $item) {
			// Simpan data kategori jika belum ada
			$this->db->select('id_kategori');
			$this->db->from('kategori');
			$this->db->where('nama_kategori', $item['kategori']);
			$query = $this->db->get();
			$kategori_id = $query->row('id_kategori');
			if (!$kategori_id) {
				// Jika kategori belum ada, simpan ke tabel kategori
				$this->db->insert('kategori', ['nama_kategori' => $item['kategori']]);
				$kategori_id = $this->db->insert_id();
			}

			// Simpan data status jika belum ada
			$this->db->select('id_status');
			$this->db->from('status');
			$this->db->where('nama_status', $item['status']);
			$query = $this->db->get();
			$status_id = $query->row('id_status');
			if (!$status_id) {
				// Jika status belum ada, simpan ke tabel status
				$this->db->insert('status', ['nama_status' => $item['status']]);
				$status_id = $this->db->insert_id();
			}

			// Simpan produk dengan kategori_id dan status_id
			$product = array(
				'nama_produk' => $item['nama_produk'],
				'harga' => $item['harga'],
				'kategori_id' => $kategori_id,
				'status_id' => $status_id
			);
			$this->db->insert('produk', $product);
		}
	}


	public function insert($data)
	{
		return $this->db->insert('produk', $data);
	}


	public function get_products()
	{
		$query = $this->db->select('produk.*, kategori.nama_kategori, status.status')
			->from('produk')
			->join('kategori', 'kategori.id_kategori = produk.kategori_id', 'left')
			->join('status', 'status.id_status = produk.status_id', 'left')
			->where('status', 'bisa dijual') // Hanya ambil produk yang 'bisa dijual'
			->where('produk.deleted_at', null)  // Hanya ambil produk yang aktif
			->get();
		return $query->result();
	}

	public function get_by_id($id)
	{
		$query = $this->db->get_where('produk', array('id_produk' => $id, 'deleted_at' => null));
		$result = $query->row();	

		return $result;
	}

	public function update($data)
	{
		$this->db->where('id_produk', $data['id_produk']);
		return $this->db->update('produk', $data);
	}


	public function delete($id)
	{
		$data = array('deleted_at' => date('Y-m-d H:i:s'));
		$this->db->where('id_produk', $id);
		return $this->db->update('produk', $data);
	}
}

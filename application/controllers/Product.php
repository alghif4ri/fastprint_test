<?php
class Product extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Product_model');  // Load model
		$this->load->model('Kategori_model');
		$this->load->model('Status_model');

		// Load form_validation library
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data['products'] = $this->Product_model->get_products(); // Mengambil semua produk
		$data['categories'] = $this->Kategori_model->get_products();
		$data['statuses'] = $this->Status_model->get_products();
		$this->load->view('product_list', $data); // Memuat view
	}

	public function add()
	{
		$data['categories'] = $this->Kategori_model->get_products();
		$data['statuses'] = $this->Status_model->get_products();
		$this->load->view('product_form', $data); // Load form view
	}

	public function insert()
	{
		$this->load->library('form_validation');
		$this->load->library('session');

		// Validasi input
		$this->form_validation->set_rules('nama_produk', 'Nama Produk', 'required', array('required' => 'Nama produk harus diisi.'));
		$this->form_validation->set_rules('harga', 'Harga', 'required|numeric', array('required' => 'Harga harus diisi.', 'numeric' => 'Harga harus berupa angka.'));
		$this->form_validation->set_rules('kategori_id', 'Kategori', 'required', array('required' => 'Kategori harus dipilih.'));
		$this->form_validation->set_rules('status_id', 'Status', 'required', array('required' => 'Status harus dipilih.'));

		if ($this->form_validation->run() == FALSE) {
			// Jika validasi gagal, kirimkan error sebagai JSON
			echo json_encode([
				'status' => 'error',
				'message' => validation_errors() // Mengembalikan semua pesan error
			]);
		} else {
			$data = array(
				'nama_produk' => $this->input->post('nama_produk'),
				'harga' => $this->input->post('harga'),
				'kategori_id' => $this->input->post('kategori_id'),
				'status_id' => $this->input->post('status_id')
			);

			$result = $this->Product_model->insert($data);

			if ($result) {
				// Jika berhasil, kirimkan respon sukses
				echo json_encode([
					'status' => 'success',
					'message' => 'Data berhasil disimpan.'
				]);
			} else {
				// Jika gagal menyimpan ke database
				echo json_encode([
					'status' => 'error',
					'message' => 'Terjadi kesalahan saat menyimpan data.'
				]);
			}
		}
	}

	public function edit($id)
	{
		$data['product'] = $this->Product_model->get_by_id($id);
		$data['categories'] = $this->Kategori_model->get_products();
		$data['statuses'] = $this->Status_model->get_products();
		$this->load->view('edit_form', $data);  // Load form view for editing
	}

	public function update()
	{
		$this->load->library('form_validation');

		// Validasi input
		$this->form_validation->set_rules('id_produk', 'ID Produk', 'required|numeric');
		$this->form_validation->set_rules('nama_produk', 'Nama Produk', 'required');
		$this->form_validation->set_rules('harga', 'Harga', 'required|numeric');
		$this->form_validation->set_rules('kategori_id', 'Kategori', 'required');
		$this->form_validation->set_rules('status_id', 'Status', 'required');

		if ($this->form_validation->run() == FALSE) {
			// Jika validasi gagal, tampilkan error dengan Swal
			$errors = validation_errors();
			echo json_encode([
				'status' => 'error',
				'message' => strip_tags($errors)
			]);
		} else {
			$data = array(
				'id_produk' => $this->input->post('id_produk'),
				'nama_produk' => $this->input->post('nama_produk'),
				'harga' => $this->input->post('harga'),
				'kategori_id' => $this->input->post('kategori_id'),
				'status_id' => $this->input->post('status_id'),
				'updated_at' => date('Y-m-d H:i:s')
			);

			$result = $this->Product_model->update($data);

			if ($result) {
				// Jika berhasil
				echo json_encode([
					'status' => 'success',
					'message' => 'Data berhasil diupdate.'
				]);
			} else {
				// Jika gagal
				echo json_encode([
					'status' => 'error',
					'message' => 'Terjadi kesalahan saat menyimpan data.'
				]);
			}
		}
	}


	public function delete($id)
	{
		$result = $this->Product_model->delete($id);  // Soft delete by setting deleted_at
		if ($result) {
			echo json_encode(array('status' => TRUE, 'message' => 'Data berhasil dihapus.'));
		} else {
			echo json_encode(array('status' => FALSE, 'message' => 'Terjadi kesalahan saat menghapus data.'));
		}
	}
}

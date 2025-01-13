<?php
class ApiFetcher extends CI_Controller
{
	public function fetch_data()
	{
		$username = "tesprogrammer130125C10";
		$password_prefix = "bisacoding-";

		date_default_timezone_set('Asia/Jakarta');  // Sesuaikan timezone server

		$currentDate = date("j");       // Hari
		$currentMonth = sprintf("%02d", date("n"));  // Bulan dengan dua digit
		$currentYear = date("Y");       // Tahun

		// Generate password dengan format baru
		$password = md5("bisacoding-" . $currentDate . "-" . $currentMonth . "-" . substr($currentYear, 2));

		$url = "https://recruitment.fastprint.co.id/tes/api_tes_programmer";

		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true); // Gunakan metode POST

		// Kirim body POST
		$post_data = [
			'username' => $username,
			'password' => $password
		];

		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

		// Header Basic Authorization
		$auth = base64_encode("$username:$password");
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			"Authorization: Basic $auth"
		]);

		$response = curl_exec($ch);
		if (curl_errno($ch)) {
			echo "cURL Error: " . curl_error($ch);
			return;
		}

		$data = json_decode($response, true);
		curl_close($ch);

		if (!empty($data['data'])) {
			$this->load->model('Product_model');
			$this->Product_model->save_data($data['data']);
			echo "Data berhasil disimpan ke database!";
		} else {
			echo "Gagal mengambil data API: " . json_encode($data);
		}
	}
}

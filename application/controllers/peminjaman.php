<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Peminjaman extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		//validasi jika user belum login
		$this->data['CI'] = &get_instance();
		$this->load->helper(array('form', 'url'));
		$this->load->model('M_Admin');
		$this->load->library(array('cart'));
		if ($this->session->userdata('masuk_sistem_rekam') != TRUE) {
			$url = base_url('login');
			redirect($url);
		}
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function index()
	{
		$this->data['title_web'] = 'Laporan Transaksi Peminjaman';
		$this->data['idbo'] = $this->session->userdata('ses_id');
		$this->data['pinjam'] = $this->db->query("SELECT DISTINCT `pinjam_id`, `anggota_id`, 
		`status`, `tgl_pinjam`, `lama_pinjam`, `tgl_balik`, `tgl_kembali` 
		FROM tbl_pinjam ORDER BY id_pinjam DESC");

		$this->load->view('header_view', $this->data);
		$this->load->view('sidebar_view', $this->data);
		$this->load->view('laporan/peminjaman_view', $this->data);
		$this->load->view('footer_view', $this->data);
	}
	public function prosesbuku()
	{
		if (!empty($this->input->get('buku_id'))) {

			$buku = $this->M_Admin->get_tableid_edit('tbl_buku', 'id_buku', htmlentities($this->input->get('buku_id')));

			$sampul = './assets_style/image/buku/' . $buku->sampul;
			if (file_exists($sampul)) {
				unlink($sampul);
			}

			$lampiran = './assets_style/image/buku/' . $buku->lampiran;
			if (file_exists($lampiran)) {
				unlink($lampiran);
			}

			$this->M_Admin->delete_table('tbl_buku', 'id_buku', $this->input->get('buku_id'));

			$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-warning">
			<p> Berhasil Hapus Buku !</p>
			</div></div>');
			redirect(base_url('data'));
		}
		if (!empty($this->input->post('tambah'))) {

			$post = $this->input->post();
			// setting konfigurasi upload
			$config['upload_path'] = './assets_style/image/buku/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png|pdf|doc';
			$config['encrypt_name'] = TRUE; //nama yang terupload nantinya
			// load library upload
			$this->load->library('upload', $config);
			$buku_id = $this->M_Admin->buat_kode('tbl_buku', 'BK', 'id_buku', 'ORDER BY id_buku DESC LIMIT 1');

			// upload gambar 1
			if (!empty($_FILES['gambar']['name'] && $_FILES['lampiran']['name'])) {

				$this->upload->initialize($config);

				if ($this->upload->do_upload('gambar')) {
					$this->upload->data();
					$file1 = array('upload_data' => $this->upload->data());
				} else {
					return false;
				}

				// script uplaod file kedua
				if ($this->upload->do_upload('lampiran')) {
					$this->upload->data();
					$file2 = array('upload_data' => $this->upload->data());
				} else {
					return false;
				}
				$data = array(
					'buku_id' => $buku_id,
					'id_kategori' => htmlentities($post['kategori']),
					'id_rak' => htmlentities($post['rak']),
					'isbn' => htmlentities($post['isbn']),
					'sampul' => $file1['upload_data']['file_name'],
					'lampiran' => $file2['upload_data']['file_name'],
					'title'  => htmlentities($post['title']),
					'pengarang' => htmlentities($post['pengarang']),
					'penerbit' => htmlentities($post['penerbit']),
					'thn_buku' => htmlentities($post['thn']),
					'isi' => $this->input->post('ket'),
					'jml' => htmlentities($post['jml']),
					'tgl_masuk' => date('Y-m-d H:i:s')
				);
			} elseif (!empty($_FILES['gambar']['name'])) {
				$this->upload->initialize($config);

				if ($this->upload->do_upload('gambar')) {
					$this->upload->data();
					$file1 = array('upload_data' => $this->upload->data());
				} else {
					return false;
				}
				$data = array(
					'buku_id' => $buku_id,
					'id_kategori' => htmlentities($post['kategori']),
					'id_rak' => htmlentities($post['rak']),
					'isbn' => htmlentities($post['isbn']),
					'sampul' => $file1['upload_data']['file_name'],
					'lampiran' => '0',
					'title'  => htmlentities($post['title']),
					'pengarang' => htmlentities($post['pengarang']),
					'penerbit' => htmlentities($post['penerbit']),
					'thn_buku' => htmlentities($post['thn']),
					'isi' => $this->input->post('ket'),
					'jml' => htmlentities($post['jml']),
					'tgl_masuk' => date('Y-m-d H:i:s')
				);
			} elseif (!empty($_FILES['lampiran']['name'])) {

				$this->upload->initialize($config);

				// script uplaod file kedua
				if ($this->upload->do_upload('lampiran')) {
					$this->upload->data();
					$file2 = array('upload_data' => $this->upload->data());
				} else {
					return false;
				}

				// script uplaod file kedua
				$this->upload->do_upload('lampiran');
				$file2 = array('upload_data' => $this->upload->data());
				$data = array(
					'buku_id' => $buku_id,
					'id_kategori' => htmlentities($post['kategori']),
					'id_rak' => htmlentities($post['rak']),
					'isbn' => htmlentities($post['isbn']),
					'sampul' => '0',
					'lampiran' => $file2['upload_data']['file_name'],
					'title'  => htmlentities($post['title']),
					'pengarang' => htmlentities($post['pengarang']),
					'penerbit' => htmlentities($post['penerbit']),
					'thn_buku' => htmlentities($post['thn']),
					'isi' => $this->input->post('ket'),
					'jml' => htmlentities($post['jml']),
					'tgl_masuk' => date('Y-m-d H:i:s')
				);
			} else {
				$data = array(
					'buku_id' => $buku_id,
					'id_kategori' => htmlentities($post['kategori']),
					'id_rak' => htmlentities($post['rak']),
					'isbn' => htmlentities($post['isbn']),
					'sampul' => '0',
					'lampiran' => '0',
					'title'  => htmlentities($post['title']),
					'pengarang' => htmlentities($post['pengarang']),
					'penerbit' => htmlentities($post['penerbit']),
					'thn_buku' => htmlentities($post['thn']),
					'isi' => $this->input->post('ket'),
					'jml' => htmlentities($post['jml']),
					'tgl_masuk' => date('Y-m-d H:i:s')
				);
			}

			$this->db->insert('tbl_buku', $data);

			$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-success">
			<p> Tambah Buku Sukses !</p>
			</div></div>');
			redirect(base_url('data'));
		}

		if (!empty($this->input->post('edit'))) {
			$post = $this->input->post();
			// setting konfigurasi upload
			$config['upload_path'] = './assets_style/image/buku/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['encrypt_name'] = TRUE; //nama yang terupload nantinya
			// load library upload
			$this->load->library('upload', $config);
			// upload gambar 1
			if (!empty($_FILES['gambar']['name'] && $_FILES['lampiran']['name'])) {

				$this->upload->initialize($config);

				if ($this->upload->do_upload('gambar')) {
					$this->upload->data();
					$file1 = array('upload_data' => $this->upload->data());
				} else {
					return false;
				}

				// script uplaod file kedua
				if ($this->upload->do_upload('lampiran')) {
					$this->upload->data();
					$file2 = array('upload_data' => $this->upload->data());
				} else {
					return false;
				}

				$gambar = './assets_style/image/buku/' . htmlentities($post['gmbr']);
				if (file_exists($gambar)) {
					unlink($gambar);
				}

				$lampiran = './assets_style/image/buku/' . htmlentities($post['lamp']);
				if (file_exists($lampiran)) {
					unlink($lampiran);
				}

				$data = array(
					'id_kategori' => htmlentities($post['kategori']),
					'id_rak' => htmlentities($post['rak']),
					'isbn' => htmlentities($post['isbn']),
					'sampul' => $file1['upload_data']['file_name'],
					'lampiran' => $file2['upload_data']['file_name'],
					'title'  => htmlentities($post['title']),
					'pengarang' => htmlentities($post['pengarang']),
					'penerbit' => htmlentities($post['penerbit']),
					'thn_buku' => htmlentities($post['thn']),
					'isi' => $this->input->post('ket'),
					'jml' => htmlentities($post['jml']),
					'tgl_masuk' => date('Y-m-d H:i:s')
				);
			} elseif (!empty($_FILES['gambar']['name'])) {
				$this->upload->initialize($config);

				if ($this->upload->do_upload('gambar')) {
					$this->upload->data();
					$file1 = array('upload_data' => $this->upload->data());
				} else {
					return false;
				}


				$gambar = './assets_style/image/buku/' . htmlentities($post['gmbr']);
				if (file_exists($gambar)) {
					unlink($gambar);
				}

				$data = array(
					'id_kategori' => htmlentities($post['kategori']),
					'id_rak' => htmlentities($post['rak']),
					'isbn' => htmlentities($post['isbn']),
					'sampul' => $file1['upload_data']['file_name'],
					'title'  => htmlentities($post['title']),
					'pengarang' => htmlentities($post['pengarang']),
					'penerbit' => htmlentities($post['penerbit']),
					'thn_buku' => htmlentities($post['thn']),
					'isi' => $this->input->post('ket'),
					'jml' => htmlentities($post['jml']),
					'tgl_masuk' => date('Y-m-d H:i:s')
				);
			} elseif (!empty($_FILES['lampiran']['name'])) {

				$this->upload->initialize($config);

				// script uplaod file kedua
				if ($this->upload->do_upload('lampiran')) {
					$this->upload->data();
					$file2 = array('upload_data' => $this->upload->data());
				} else {
					return false;
				}

				$lampiran = './assets_style/image/buku/' . htmlentities($post['lamp']);
				if (file_exists($lampiran)) {
					unlink($lampiran);
				}

				// script uplaod file kedua
				$this->upload->do_upload('lampiran');
				$file2 = array('upload_data' => $this->upload->data());

				$data = array(
					'id_kategori' => htmlentities($post['kategori']),
					'id_rak' => htmlentities($post['rak']),
					'isbn' => htmlentities($post['isbn']),
					'lampiran' => $file2['upload_data']['file_name'],
					'title'  => htmlentities($post['title']),
					'pengarang' => htmlentities($post['pengarang']),
					'penerbit' => htmlentities($post['penerbit']),
					'thn_buku' => htmlentities($post['thn']),
					'isi' => $this->input->post('ket'),
					'jml' => htmlentities($post['jml']),
					'tgl_masuk' => date('Y-m-d H:i:s')
				);
			} else {
				$data = array(
					'id_kategori' => htmlentities($post['kategori']),
					'id_rak' => htmlentities($post['rak']),
					'isbn' => htmlentities($post['isbn']),
					'title'  => htmlentities($post['title']),
					'pengarang' => htmlentities($post['pengarang']),
					'penerbit' => htmlentities($post['penerbit']),
					'thn_buku' => htmlentities($post['thn']),
					'isi' => $this->input->post('ket'),
					'jml' => htmlentities($post['jml']),
					'tgl_masuk' => date('Y-m-d H:i:s')
				);
			}

			$this->db->where('id_buku', htmlentities($post['edit']));
			$this->db->update('tbl_buku', $data);

			$this->session->set_flashdata('pesan', '<div id="notifikasi"><div class="alert alert-success">
			<p> Edit Buku Sukses !</p>
			</div></div>');
			redirect(base_url('data'));
		}
	}
}

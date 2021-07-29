<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Laporanbuku extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Laporanbukumodel');
  }
  public function index()
  {
    $tgl_awal = $this->input->get('tgl_awal'); // Ambil data tgl_awal sesuai input (kalau tidak ada set kosong)
    $tgl_akhir = $this->input->get('tgl_akhir'); // Ambil data tgl_awal sesuai input (kalau tidak ada set kosong)
    if (empty($tgl_awal) or empty($tgl_akhir)) { // Cek jika tgl_awal atau tgl_akhir kosong, maka :
      $transaksi = $this->Laporanbukumodel->view_all();  // Panggil fungsi view_all yang ada di TransaksiModel
      $url_cetak = 'Laporanbuku/cetak';
      $label = 'Semua Data Buku';
    } else { // Jika terisi
      $transaksi = $this->Laporanbukumodel->view_by_date($tgl_awal, $tgl_akhir);  // Panggil fungsi view_by_date yang ada di TransaksiModel
      $url_cetak = 'Laporanbuku/cetak?tgl_awal=' . $tgl_awal . '&tgl_akhir=' . $tgl_akhir;
      $tgl_awal = date('d-m-Y', strtotime($tgl_awal)); // Ubah format tanggal jadi dd-mm-yyyy
      $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir)); // Ubah format tanggal jadi dd-mm-yyyy
      $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
    }
    $data['transaksi'] = $transaksi;
    $data['url_cetak'] = base_url('index.php/' . $url_cetak);
    $data['label'] = $label;
    $this->load->view('laporan\laporanbukuview', $data);
  }
  public function cetak()
  {
    $tgl_awal = $this->input->get('tgl_awal'); // Ambil data tgl_awal sesuai input (kalau tidak ada set kosong)
    $tgl_akhir = $this->input->get('tgl_akhir'); // Ambil data tgl_awal sesuai input (kalau tidak ada set kosong)
    if (empty($tgl_awal) or empty($tgl_akhir)) { // Cek jika tgl_awal atau tgl_akhir kosong, maka :
      $transaksi = $this->Laporanbukumodel->view_all();  // Panggil fungsi view_all yang ada di TransaksiModel
      $label = 'Semua Data Buku';
    } else { // Jika terisi
      $transaksi = $this->Laporanbukumodel->view_by_date($tgl_awal, $tgl_akhir);  // Panggil fungsi view_by_date yang ada di TransaksiModel
      $tgl_awal = date('d-m-Y', strtotime($tgl_awal)); // Ubah format tanggal jadi dd-mm-yyyy
      $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir)); // Ubah format tanggal jadi dd-mm-yyyy
      $label = 'Periode Tanggal ' . $tgl_awal . ' s/d ' . $tgl_akhir;
    }
    $data['label'] = $label;
    $data['transaksi'] = $transaksi;
    ob_start();
    $this->load->view('print', $data);
    $html = ob_get_contents();
    ob_end_clean();
    require './assets/libraries/html2pdf/autoload.php'; // Load plugin html2pdfnya
    $pdf = new Spipu\Html2Pdf\Html2Pdf('P', 'A4', 'en');  // Settingan PDFnya
    $pdf->WriteHTML($html);
    $pdf->Output('Data Transaksi.pdf', 'D');
  }
}

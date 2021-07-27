<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Order extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('order_model');
    }
 
    public function index()
    {
        $data['orders'] = $this->order_model->get_all();
        $this->load->view('laporan\list_order', $data);
    }
 
    public function create()
    {
        $this->load->view('add_order');
    }
 
    public function store()
    {       
        $pinjam_id      = $this->input->post('pinjam_id');
        $anggota_id     = $this->input->post('anggota_id');
        $buku_id        = $this->input->post('buku_id');
        $tgl_pinjam     = $this->input->post('tgl_pinjam');
        $tgl_balik      = $this->input->post('tgl_balik');
        $tgl_kembali    = $this->input->post('tgl_kembali');
        $lama_pinjam    = $this->input->post('lama_pinjam');
        $status         = $this->input->post('status');
        $data = [
            'pinjam_id'     => $pinjam_id,
            'anggota_id'    => $anggota_id,
            'buku_id'       => $buku_id,
            'tgl_pinjam'    => $tgl_pinjam,
            'tgl_balik'     => $tgl_balik ,
            'tgl_kembali'   => $tgl_kembali,
            'lama_pinjam'   => $lama_pinjam,
            'status'        => $status
        ];
 
        $simpan = $this->order_model->insert("tbl_pinjam", $data);
        if($simpan){
            echo '<script>alert("Berhasil menambah data order");window.location.href="'.base_url('index.php/order').'";</script>';
        }
    }
 
    public function export() {
        $orders = $this->order_model->get_all();
        $tanggal = date('d-m-Y');
 
        $pdf = new \TCPDF();
        
        $pdf->AddPage('L');

    $pdf->writeHTML("Landscape !");
        $pdf->SetFont('', 'B', 20);
        $pdf->Cell(115, 0, "Laporan Order - ".$tanggal, 0, 1, 'L');
        $pdf->SetAutoPageBreak(true, 0);
 
        // Add Header
        $pdf->Ln(10);
        $pdf->SetFont('', 'B', 12);
        $pdf->Cell(7, 8, "No", 1, 0, 'C');
        $pdf->Cell(35, 8, "pinjam_id", 1, 0, 'C');
        $pdf->Cell(35, 8, "anggota_id", 1, 0, 'C');
        $pdf->Cell(35, 8, "buku_id", 1, 0, 'C');
        $pdf->Cell(35, 8, "tgl_pinjam", 1, 0, 'C');
        $pdf->Cell(35, 8, "tgl_balik", 1, 0, 'C');
        $pdf->Cell(35, 8, "tgl_kembali", 1, 0, 'C');
        $pdf->Cell(35, 8, "lama_pinjam", 1, 0, 'C');
        $pdf->Cell(35, 8, "status", 1, 1, 'C');
        $pdf->SetFont('', '', 12);
        foreach($orders->result_array() as $k => $order) {
            $this->addRow($pdf, $k+1, $order);
        }
        $tanggal = date('d-m-Y');
        $pdf->Output('Laporan Order - '.$tanggal.'.pdf'); 
    }
 
    private function addRow($pdf, $no, $order) {
        $pdf->Cell(7, 8, $no, 1, 0, 'C');
        $pdf->Cell(35, 8, $order['pinjam_id'], 1, 0, '');
        $pdf->Cell(35, 8, $order['anggota_id'], 1, 0, '');
        $pdf->Cell(35, 8, $order['buku_id'], 1, 0, '');
        $pdf->Cell(35, 8, date('d-m-Y', strtotime($order['tgl_pinjam'])), 1, 0, 'C');
        $pdf->Cell(35, 8, date('d-m-Y', strtotime($order['tgl_balik'])), 1, 0, 'C');
        $pdf->Cell(35, 8, date('d-m-Y', strtotime($order['tgl_kembali'])), 1, 0, 'C');
        $pdf->Cell(35, 8, $order['lama_pinjam'], 1, 0, 'C');
        $pdf->Cell(35, 8, $order['status'], 1, 0, 'C');
    }
}
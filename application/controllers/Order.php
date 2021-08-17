<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Order extends CI_Controller
{

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
        $denda          = $this->input->post('$harga_denda');
        $data = [
            'pinjam_id'     => $pinjam_id,
            'anggota_id'    => $anggota_id,
            'buku_id'       => $buku_id,
            'tgl_pinjam'    => $tgl_pinjam,
            'tgl_balik'     => $tgl_balik,
            'tgl_kembali'   => $tgl_kembali,
            'lama_pinjam'   => $lama_pinjam,
            'status'        => $status,
            'denda'         => $harga_denda
        ];

        $simpan = $this->order_model->insert("tbl_pinjam", $data);
        if ($simpan) {
            echo '<script>alert("Berhasil menambah data order");window.location.href="' . base_url('index.php/order_model') . '";</script>';
        }
    }
    public function denda()
    {
        $this->data['idbo'] = $this->session->userdata('ses_id');

        $this->data['denda'] =  $this->db->query("SELECT * FROM tbl_biaya_denda ORDER BY id_biaya_denda DESC");

        if (!empty($this->input->get('id'))) {
            $id = $this->input->get('id');
            $count = $this->M_Admin->CountTableId('tbl_biaya_denda', 'id_biaya_denda', $id);
            if ($count > 0) {
                $this->data['den'] = $this->db->query("SELECT *FROM tbl_biaya_denda WHERE id_biaya_denda='$id'")->row();
            } else {
                echo '<script>alert("KATEGORI TIDAK DITEMUKAN");window.location="' . base_url('order/denda') . '"</script>';
            }
        }

        $this->data['title_web'] = ' Denda ';
        $this->load->view('header_view', $this->data);
        $this->load->view('sidebar_view', $this->data);
        $this->load->view('denda/denda_view', $this->data);
        $this->load->view('footer_view', $this->data);
    }

    public function export()
    {
        $orders = $this->order_model->get_all();
        $tanggal = date('d-m-Y');

        $pdf = new \TCPDF();

        $pdf->AddPage('L');

        $pdf->writeHTML("Landscape !");
        $pdf->SetFont('', 'B', 20);
        $pdf->Cell(115, 0, "Laporan Order - " . $tanggal, 0, 1, 'L');
        $pdf->SetAutoPageBreak(true, 0);

        // Add Header
        $pdf->Ln(10);
        $pdf->SetFont('', 'B', 12);
        $pdf->Cell(7, 8, "No", 1, 0, 'C');
        $pdf->Cell(30, 8, "pinjam_id", 1, 0, 'C');
        $pdf->Cell(30, 8, "anggota_id", 1, 0, 'C');
        $pdf->Cell(30, 8, "buku_id", 1, 0, 'C');
        $pdf->Cell(30, 8, "tgl_pinjam", 1, 0, 'C');
        $pdf->Cell(30, 8, "tgl_balik", 1, 0, 'C');
        $pdf->Cell(30, 8, "tgl_kembali", 1, 0, 'C');
        $pdf->Cell(30, 8, "lama_pinjam", 1, 0, 'C');
        $pdf->Cell(30, 8, "status", 1, 1, 'C');
        $pdf->SetFont('', '', 12);
        foreach ($orders->result_array() as $row => $order) 
            $this->addRow($pdf, $row + 1, $order);
        
        $tanggal = date('d-m-Y');
        $pdf->Output('Laporan Order - ' . $tanggal . '.pdf');
    }


    private function addRow($pdf, $no, $order)
    {
        $pdf->Cell(7, 6, $no, 1, 0, 'C');
        $pdf->Cell(30, 6, $order['pinjam_id'], 1, 0, '');
        $pdf->Cell(30, 6, $order['anggota_id'], 1, 0, '');
        $pdf->Cell(30, 6, $order['buku_id'], 1, 0, '');
        $pdf->Cell(30, 6, date('d-m-Y', strtotime($order['tgl_pinjam'])), 1, 0);
        $pdf->Cell(30, 6, date('d-m-Y', strtotime($order['tgl_balik'])), 1, 0);
        $pdf->Cell(30, 6, date('d-m-Y', strtotime($order['tgl_kembali'])), 1, 0);
        $pdf->Cell(30, 6, $order['lama_pinjam'], 1, 0, 'C');
        $pdf->Cell(30, 6, $order['status'], 1, 0, 'C');
        
       
        $pdf->Ln();
    }
}

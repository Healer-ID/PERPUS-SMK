<?php
defined('BASEPATH') OR exit ('No direct script access allowed');
require_once('assets_style/dompdf/autoload.inc.php');
use Dompdf\Dompdf;

class Mypdf
{	protected $ci;
	public function _construct()
	{ $this->ci & get_instance() ;

	}
	public function generate($view, $data = array(),$filename = 'Laporan', $paper ='A4',$orientation ='lanscape')
	{
		$html = $this->ci->load->view($view,$data, TRUE );
		$dompdf->loadHtml($html);
		$dompdf->setPaper($paper, $orientation );
		$dompdf->render();
    	$dompdf->stream($filename,".pdf", array("Attachment" => FALSE));

	}

}

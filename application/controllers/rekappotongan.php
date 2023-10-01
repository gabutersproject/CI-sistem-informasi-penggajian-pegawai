<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rekappotongan extends CI_Controller {

	function __construct()
 	{
 		parent::__construct();
 		$this->load->model('global_model');
 		$this->load->helper('url');
 		$this->load->library('session');

		if(!$this->session->userdata('namalengkap','namauser','status'))
    {
      redirect(site_url('/'));
    }
		
 	}

 	public function index(){
		$data['divisi'] = $this->global_model->find_all('divisi');
 		// mengambil data dari database
 		$this->load->view('head/dash/index');
 		$this->load->view('konten/rekappotongan/index', $data);
 		$this->load->view('footer/dash/index');
 	}

	public function laporan(){
		$data['divisi'] = $this->global_model->find_by('divisi', array('kode_divisi' => $this->input->post('divisi')));
 		$data['bulan'] = $this->input->post('bulan');
 		$data['tahun'] = $this->input->post('tahun');

 		$this->load->view('head/laporan/index');
 		$this->load->view('konten/laporan/potongangaji',$data);
 		$this->load->view('footer/laporan/index');

 		/*dompdf convert html to pdf*/
		$html = $this->output->get_output();

		// Load/panggil library dompdfnya
		$this->load->library('dompdf_gen');

		// Convert to PDF
		$this->dompdf->load_html($html);
		$this->dompdf->set_paper('A3','landscape');
		$this->dompdf->render();
		//utk menampilkan preview pdf
		$this->dompdf->stream("petongangaji.pdf",array('Attachment'=>0));
		//atau jika tidak ingin menampilkan (tanpa) preview di halaman browser
		//$this->dompdf->stream("welcome.pdf");

 	}


}

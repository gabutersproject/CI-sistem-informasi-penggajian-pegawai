<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rekappembayaran extends CI_Controller {

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
 		$this->load->view('head/dash/index');
 		$this->load->view('konten/rekappembayaran/index',$data);
 		$this->load->view('footer/dash/index');
 	}

 	public function laporan(){
		$data['divisi'] = $this->global_model->find_by('divisi', array('kode_divisi' => $this->input->post('divisi')));
 		$data['bulan'] = $this->input->post('bulan');
 		$data['tahun'] = $this->input->post('tahun');

		//kumpulkan data karyawan berdasarkan golongan,jabatan,divisi
		$sqlkaryawan = "select karyawan.kode_karyawan,nip,nama,jabatan.kode_jabatan,
		jabatan.nama_jabatan,divisi.kode_divisi,divisi.nama_divisi,golongan.kode_golongan,
		golongan.nama_golongan,jabatan.insjabatan,jabatan.tjabatan,golongan.gajipokok,
		golongan.uangmakan,golongan.tperumahan,golongan.tkesehatan,golongan.ttransport
		from karyawan inner join jabatan on karyawan.kode_jabatan = jabatan.kode_jabatan
		inner join golongan on karyawan.kode_golongan = golongan.kode_golongan inner join
		divisi on jabatan.kode_divisi = divisi.kode_divisi where divisi.kode_divisi='".$this->input->post('divisi')."'";

		$data['karyawan'] = $this->global_model->query($sqlkaryawan);

 		$this->load->view('head/laporan/index');
 		$this->load->view('konten/laporan/pembayarangaji',$data);
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
		$this->dompdf->stream("pembayarangaji.pdf",array('Attachment'=>0));
		//atau jika tidak ingin menampilkan (tanpa) preview di halaman browser
		//$this->dompdf->stream("welcome.pdf");

 	}

}

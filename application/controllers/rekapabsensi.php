<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rekapabsensi extends CI_Controller {

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

 		// mengambil data dari database
 		$this->load->view('head/dash/index');
 		$this->load->view('konten/rekapabsensi/index');
 		$this->load->view('footer/dash/index');
 	}

 	public function detaildata(){

 		// mengambil data dari database
 		$this->load->view('head/dash/index');
 		$this->load->view('konten/rekapabsensi/detaildata');
 		$this->load->view('footer/dash/index');
 	}
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
 	{
 		parent::__construct();
 		$this->load->model('global_model');
 		$this->load->helper('url');
 		$this->load->library('session');
 	}

 	//fungsi ini untuk generate message
 	public function message($mode,$text,$active)
 	{
 		//generate message
 		$messagesession = array(
 			'messagemode' => $mode,
 			'messagetext' => $text,
 			'messageactive' => $active);

 		$this->session->set_flashdata($messagesession);
 	}

 	public function index(){

 		if($this->input->post('masuk')){

 			$username = $this->input->post('username');
 			$password = $this->input->post('password');
 			$passwordhash = md5($password);

 			$redirect = "dash";

 			$sql = $this->global_model->find_by('user', array('username' => $username, 'password' => $passwordhash));

 			if($username == "" || $password == ""){
 				$this->message('danger','field tidak boleh kosong','login');
 				$redirect = "/";
 			}else if($sql == Null){
 				$this->message('danger','username atau password tidak valid','login');
 				$redirect = "/";
 			}else{
 				//set session
 				$sessiondata = array(
	 					'namalengkap' => $sql['nama_lengkap'],
	 					'namauser' => $sql['username'],
	 					'status' => $sql['status']);

	 				$this->session->set_userdata($sessiondata);
 			}

 			redirect(site_url($redirect));

 		}

 		// mengambil data dari database
 		$this->load->view('head/login/index');
 		$this->load->view('konten/login/index');
 		$this->load->view('footer/login/index');
 	}
 	
 	public function logout(){
 		
 		$this->session->sess_destroy();
 		redirect(site_url('/'));

 	}
}
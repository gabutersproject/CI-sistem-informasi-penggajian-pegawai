<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Divisi extends CI_Controller {

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

 		$data['divisi'] =  $this->global_model->find_all('divisi');
 		//load tampilan html
 		$this->load->view('head/dash/index');
 		$this->load->view('konten/divisi/index', $data);
 		$this->load->view('footer/dash/index');

 	}

 	public function tambah(){
 		if($this->input->post('simpandata')){

 			$kode = $this->input->post('kode_divisi');
 			$nama = $this->input->post('nama_divisi');

 			//variable untuk cek
 			$listfield = array('kode_divisi', 'nama_divisi');

 			$listdata = array($kode,$nama);

 			$listtext = array('kode','nama');

 			//variable untuk texterror
 			$texterror = "";

 			if($kode == "" || $nama == ""){
 				$this->message('danger','kode atau nama divisi tidak boleh kosong','indexdivisi');
 			}else{
 				//cek data sama atau tidak
 				for($i = 0; $i < count($listfield); $i++){
 					$sql = $this->global_model->find_all_by('divisi', array($listfield[$i] => $listdata[$i]));
 					if(count($sql) > 0){
 						$texterror = $texterror." ".$listtext[$i];
 					}
 				}

 				if($texterror != ""){
 					$this->message('danger',$texterror.' divisi sudah tersedia','indexdivisi');

 				}else if($texterror == ""){
 					//simpan ke dalam database
 					$data = $this->input->post();
 					unset($data['simpandata']);

 					$this->global_model->create('divisi', $data);

 					$this->message('success','data berhasil di tambah','indexdivisi');
 				}
 			}

 		}

 		redirect(site_url('divisi'));
 	}

 	public function edit($id){
 		if($this->input->post('editdata')){

 			$kode = $this->input->post('kode_divisi');
 			$nama = $this->input->post('nama_divisi');

 			$data = $this->input->post();

 			//variable untuk cek
 			$listfield = array('kode_divisi', 'nama_divisi');

 			$listdata = array($kode,$nama);

 			$listtext = array('kode','nama');

 			//variable untuk texterror
 			$texterror = "";

 			$getdata = $this->global_model->find_by('divisi', array('kode_divisi' => $id));

 			if($kode == "" || $nama == ""){
 				$this->message('danger','kode atau nama divisi tidak boleh kosong','indexdivisi');
 			}else{
 				//cek data sama atau tidak
 				for($i = 0; $i < count($listfield); $i++){
 					$sql = $this->global_model->find_by('divisi', array($listfield[$i] => $listdata[$i]));
 					if(count($sql) > 0 && $sql['kode_divisi'] != $id && $sql['nama_divisi'] != $getdata['nama_divisi']){
 						$texterror = $texterror." ".$listtext[$i];
 					}
 				}

 				if($texterror != ""){
 					$this->message('danger',$texterror.' divisi sudah tersedia','indexdivisi');

 				}else if($texterror == ""){
 					//simpan ke dalam database
 					$data = $this->input->post();
 					unset($data['editdata']);
 					$data['kode_divisi'] = strtoupper($kode);

 					$this->global_model->update('divisi', $data, array('kode_divisi' => $id));

 					$this->message('success','data berhasil di edit','indexdivisi');
 				}
 			}

 		}

 		redirect(site_url('divisi'));
 	}

 	public function tampil($id){
 		$sql = $this->global_model->find_by('divisi', array('kode_divisi' => $id));
 		echo json_encode($sql);

 	}

 	public function hapus(){
 		$chkbox = $this->input->post('check');
 		if(is_array($chkbox)){
 			for($i = 0; $i < count($chkbox); $i++){
 				$this->global_model->delete('divisi', array('kode_divisi' => $chkbox[$i]));

 			}

 			$this->message('success','data berhasil di hapus','indexdivisi');
 		}

 		redirect(site_url('divisi'));
 	}
}

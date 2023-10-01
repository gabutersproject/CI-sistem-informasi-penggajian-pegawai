<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jenissubpembayaran extends CI_Controller {

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

 		$data['jenissubpembayaran'] = $this->global_model->find_all('jenissubpembayaran');
 		$data['jenispembayaran'] = $this->global_model->find_all('jenispembayaran');
 		//load tampilan html
 		$this->load->view('head/dash/index');
 		$this->load->view('konten/jenissubpembayaran/index', $data);
 		$this->load->view('footer/dash/index');

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

 	public function tambah(){
 		if($this->input->post('simpandata')){
 			$kode = $this->input->post('kode_jenissubpembayaran');
 			$nama = $this->input->post('nama_jenissubpembayaran');

 			$data = $this->input->post();

 			//variable untuk cek
 			$listfield = array('kode_jenissubpembayaran', 'nama_jenissubpembayaran');

 			$listdata = array($kode,$nama);

 			$listtext = array('kode','nama');

 			//variable untuk texterror
 			$texterror = "";

 			if($kode == "" || $nama == ""){
 				$this->message('danger','kode atau nama jenis sub pembayaran tidak boleh kosong','indexjenissubpembayaran');
 			}else{
 				//cek data sama atau tidak
 				for($i = 0; $i < count($listfield); $i++){
 					$sql = $this->global_model->find_all_by('jenissubpembayaran', array($listfield[$i] => $listdata[$i]));
 					if(count($sql) > 0){
 						$texterror = $texterror." ".$listtext[$i];
 					}
 				}

 				if($texterror != ""){
 					$this->message('danger',$texterror.' jenis sub pembayaran sudah tersedia','indexjenissubpembayaran');

 				}else if($texterror == ""){
 					//simpan ke dalam database
 					$data = $this->input->post();
 					unset($data['simpandata']);
 					$data['kode_jenissubpembayaran'] = strtoupper($kode);

 					$this->global_model->create('jenissubpembayaran', $data);

 					$this->message('success','data berhasil di tambah','indexjenissubpembayaran');
 				}
 			}
 		}

 		redirect(site_url('jenissubpembayaran'));

 	}

 	public function edit($id){
 		if($this->input->post('editdata')){
 			$kode = $this->input->post('kode_jenissubpembayaran');
 			$nama = $this->input->post('nama_jenissubpembayaran');

 			$data = $this->input->post();

 			//variable untuk cek
 			$listfield = array('kode_jenissubpembayaran', 'nama_jenissubpembayaran');

 			$listdata = array($kode,$nama);

 			$listtext = array('kode','nama');

 			//variable untuk texterror
 			$texterror = "";

 			$getdata = $this->global_model->find_by('jenissubpembayaran', array('kode_jenissubpembayaran' => $id));

 			if($kode == "" || $nama == ""){
 				$this->message('danger','kode atau nama jenis sub pembayaran tidak boleh kosong','indexjenissubpembayaran');
 			}else{
 				//cek data sama atau tidak
 				for($i = 0; $i < count($listfield); $i++){
 					$sql = $this->global_model->find_by('jenissubpembayaran', array($listfield[$i] => $listdata[$i]));
 					if(count($sql) > 0 && $sql['kode_jenissubpembayaran'] != $id && $sql['nama_jenissubpembayaran'] != $getdata['nama_jenissubpembayaran']){
 						$texterror = $texterror." ".$listtext[$i];
 					}
 				}

 				if($texterror != ""){
 					$this->message('danger',$texterror.' jenis sub pembayaran sudah tersedia','indexjenissubpembayaran');

 				}else if($texterror == ""){
 					//simpan ke dalam database
 					$data = $this->input->post();
 					unset($data['editdata']);
 					$data['kode_jenissubpembayaran'] = strtoupper($kode);

 					$this->global_model->update('jenissubpembayaran', $data, array('kode_jenissubpembayaran' => $id));

 					$this->message('success','data berhasil di edit','indexjenissubpembayaran');
 				}
 			}
 		}

 		redirect(site_url('jenissubpembayaran'));

 	}

 	public function tampil($id){
 		$sql = $this->global_model->find_by('jenissubpembayaran', array('kode_jenissubpembayaran' => $id));
 		echo json_encode($sql);
 	}

 	public function hapus(){
 		$chkbox = $this->input->post('check');
		if(is_array($chkbox)){
 			for($i = 0; $i < count($chkbox); $i++){
 				$this->global_model->delete('jenissubpembayaran', array('kode_jenissubpembayaran' => $chkbox[$i]));
 			}

 			$this->message('success','data berhasil di hapus','indexjenissubpembayaran');
 		}

 		redirect(site_url('jenissubpembayaran'));

 	}
}

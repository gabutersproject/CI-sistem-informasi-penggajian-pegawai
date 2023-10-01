<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jenissubpotongan extends CI_Controller {

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

 		$data['jenissubpotongan'] = $this->global_model->find_all('jenissubpotongan');
 		$data['jenispotongan']	= $this->global_model->find_all('jenispotongan');
 		//load tampilan html
 		$this->load->view('head/dash/index');
 		$this->load->view('konten/jenissubpotongan/index', $data);
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

 			$kode = $this->input->post('kode_jenissubpotongan');
 			$nama = $this->input->post('nama_jenissubpotongan');

 			$data = $this->input->post();

 			//variable untuk cek
 			$listfield = array('kode_jenissubpotongan', 'nama_jenissubpotongan');

 			$listdata = array($kode,$nama);

 			$listtext = array('kode','nama');

 			//variable untuk texterror
 			$texterror = "";

 			if($kode == "" || $nama == ""){
 				$this->message('danger','kode atau nama jenis sub potongan tidak boleh kosong','indexjenissubpotongan');
 			}else{
 				//cek data sama atau tidak
 				for($i = 0; $i < count($listfield); $i++){
 					$sql = $this->global_model->find_all_by('jenissubpotongan', array($listfield[$i] => $listdata[$i]));
 					if(count($sql) > 0){
 						$texterror = $texterror." ".$listtext[$i];
 					}
 				}

 				if($texterror != ""){
 					$this->message('danger',$texterror.' jenis sub potongan sudah tersedia','indexjenissubpotongan');

 				}else if($texterror == ""){
 					//simpan ke dalam database
 					$data = $this->input->post();
 					unset($data['simpandata']);
 					$data['kode_jenissubpotongan'] = strtoupper($kode);

 					$this->global_model->create('jenissubpotongan', $data);

 					$this->message('success','data berhasil di tambah','indexjenissubpotongan');
 				}
 			}

 		}

 		redirect(site_url('jenissubpotongan'));

 	}

 	public function edit($id){
 		if($this->input->post('editdata')){

 			$kode = $this->input->post('kode_jenissubpotongan');
 			$nama = $this->input->post('nama_jenissubpotongan');

 			$data = $this->input->post();

 			//variable untuk cek
 			$listfield = array('kode_jenissubpotongan', 'nama_jenissubpotongan');

 			$listdata = array($kode,$nama);

 			$listtext = array('kode','nama');

 			//variable untuk texterror
 			$texterror = "";

 			$getdata = $this->global_model->find_by('jenissubpotongan', array('kode_jenissubpotongan' => $id));

 			if($kode == "" || $nama == ""){
 				$this->message('danger','kode atau nama jenis sub potongan tidak boleh kosong','indexjenissubpotongan');
 			}else{
 				//cek data sama atau tidak
 				for($i = 0; $i < count($listfield); $i++){
 					$sql = $this->global_model->find_by('jenissubpotongan', array($listfield[$i] => $listdata[$i]));
 					if(count($sql) > 0 && $sql['kode_jenissubpotongan'] != $id && $sql['nama_jenissubpotongan'] != $getdata['nama_jenissubpotongan']){
 						$texterror = $texterror." ".$listtext[$i];
 					}
 				}

 				if($texterror != ""){
 					$this->message('danger',$texterror.' jenis sub potongan sudah tersedia','indexjenissubpotongan');

 				}else if($texterror == ""){
 					//simpan ke dalam database
 					$data = $this->input->post();
 					unset($data['editdata']);
 					$data['kode_jenissubpotongan'] = strtoupper($kode);

 					$this->global_model->update('jenissubpotongan', $data, array('kode_jenissubpotongan' => $id));

 					$this->message('success','data berhasil di edit','indexjenissubpotongan');
 				}
 			}
 		}

 		redirect(site_url('jenissubpotongan'));

 	}

 	public function tampil($id){
 		$sql = $this->global_model->find_by('jenissubpotongan', array('kode_jenissubpotongan' => $id));
 		echo json_encode($sql);
 	}

 	public function hapus(){
 		$chkbox = $this->input->post('check');
 		if(is_array($chkbox)){
 			for($i = 0; $i < count($chkbox); $i++){
 				$this->global_model->delete('jenissubpotongan', array('kode_jenissubpotongan' => $chkbox[$i]));
	 		}

	 		$this->message('success','data berhasil di hapus','indexjenissubpotongan');
	 	}

	 	redirect(site_url('jenissubpotongan'));

	}
}

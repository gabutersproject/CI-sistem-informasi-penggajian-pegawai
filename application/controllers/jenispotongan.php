<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jenispotongan extends CI_Controller {

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

 		$data['jenispotongan'] = $this->global_model->find_all('jenispotongan');
 		//load tampilan html
 		$this->load->view('head/dash/index');
 		$this->load->view('konten/jenispotongan/index', $data);
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

 			$kode = $this->input->post('kode_jenispotongan');
 			$nama = $this->input->post('nama_jenispotongan');

 			$data = $this->input->post();

 			//variable untuk cek
 			$listfield = array('kode_jenispotongan', 'nama_jenispotongan');

 			$listdata = array($kode,$nama);

 			$listtext = array('kode','nama');

 			//variable untuk texterror
 			$texterror = "";

 			if($kode == "" || $nama == ""){
 				$this->message('danger','kode atau nama jenis potongan tidak boleh kosong','indexjenispotongan');
 			}else{
 				//cek data sama atau tidak
 				for($i = 0; $i < count($listfield); $i++){
 					$sql = $this->global_model->find_all_by('jenispotongan', array($listfield[$i] => $listdata[$i]));
 					if(count($sql) > 0){
 						$texterror = $texterror." ".$listtext[$i];
 					}
 				}

 				if($texterror != ""){
 					$this->message('danger',$texterror.' jenis potongan sudah tersedia','indexjenispotongan');

 				}else if($texterror == ""){
 					//simpan ke dalam database
 					$data = $this->input->post();
 					unset($data['simpandata']);
 					$data['kode_jenispotongan'] = strtoupper($kode);

 					$this->global_model->create('jenispotongan', $data);

 					$this->message('success','data berhasil di tambah','indexjenispotongan');
 				}
 			}

 		}

 		redirect(site_url('jenispotongan'));

 	}

 	public function edit($id){

 		if($this->input->post('editdata')){

 			$kode = $this->input->post('kode_jenispotongan');
 			$nama = $this->input->post('nama_jenispotongan');

 			$data = $this->input->post();

 			//variable untuk cek
 			$listfield = array('kode_jenispotongan', 'nama_jenispotongan');

 			$listdata = array($kode,$nama);

 			$listtext = array('kode','nama');

 			//variable untuk texterror
 			$texterror = "";

 			$getdata = $this->global_model->find_by('jenispotongan', array('kode_jenispotongan' => $id));

 			if($kode == "" || $nama == ""){
 				$this->message('danger','kode atau nama jenis potongan tidak boleh kosong','indexjenispotongan');
 			}else{
 				//cek data sama atau tidak
 				for($i = 0; $i < count($listfield); $i++){
 					$sql = $this->global_model->find_by('jenispotongan', array($listfield[$i] => $listdata[$i]));
 					if(count($sql) > 0 && $sql['kode_jenispotongan'] != $id && $sql['nama_jenispotongan'] != $getdata['nama_jenispotongan']){
 						$texterror = $texterror." ".$listtext[$i];
 					}
 				}

 				if($texterror != ""){
 					$this->message('danger',$texterror.' jenis potongan sudah tersedia','indexjenispotongan');

 				}else if($texterror == ""){
 					//simpan ke dalam database
 					$data = $this->input->post();
 					unset($data['editdata']);
 					$data['kode_jenispotongan'] = strtoupper($kode);

 					$this->global_model->update('jenispotongan', $data, array('kode_jenispotongan' => $id));

 					$this->message('success','data berhasil di edit','indexjenispotongan');
 				}
 			}
 		}

 		redirect(site_url('jenispotongan'));

 	}

 	public function tampil($id){
 		$sql = $this->global_model->find_by('jenispotongan', array('kode_jenispotongan' => $id));
 		echo json_encode($sql);
 	}

 	public function hapus(){
 		$chkbox = $this->input->post('check');
 		if(is_array($chkbox)){
 			for($i = 0; $i < count($chkbox); $i++){
 				$this->global_model->delete('jenispotongan', array('kode_jenispotongan' => $chkbox[$i]));
 			}

 			$this->message('success','data berhasil di hapus','indexjenispotongan');
 		}

 		redirect(site_url('jenispotongan'));
 	}
}

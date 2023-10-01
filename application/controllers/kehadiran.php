<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kehadiran extends CI_Controller {

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

 		$data['kehadiran'] = $this->global_model->find_all('kehadiran');
 		//load tampilan html
 		$this->load->view('head/dash/index');
 		$this->load->view('konten/kehadiran/index', $data);
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

 			$kode = $this->input->post('kode_kehadiran');
 			$nama = $this->input->post('nama_kehadiran');

 			$data = $this->input->post();

 			//variable untuk cek
 			$listfield = array('kode_kehadiran', 'nama_kehadiran');

 			$listdata = array($kode,$nama);

 			$listtext = array('kode','nama');

 			//variable untuk texterror
 			$texterror = "";

 			if($kode == "" || $nama == ""){
 				$this->message('danger','kode atau nama kehadiran tidak boleh kosong','indexkehadiran');
 			}else{
 				//cek data sama atau tidak
 				for($i = 0; $i < count($listfield); $i++){
 					$sql = $this->global_model->find_all_by('kehadiran', array($listfield[$i] => $listdata[$i]));
 					if(count($sql) > 0){
 						$texterror = $texterror." ".$listtext[$i];
 					}
 				}

 				if($texterror != ""){
 					$this->message('danger',$texterror.' kehadiran sudah tersedia','indexkehadiran');

 				}else if($texterror == ""){
 					//simpan ke dalam database
 					$data = $this->input->post();
 					unset($data['simpandata']);
 					$data['kode_kehadiran'] = strtoupper($kode);

 					$this->global_model->create('kehadiran', $data);

 					$this->message('success','data berhasil di tambah','indexkehadiran');
 				}
 			}
 		}

 		redirect(site_url('kehadiran'));

 	}

 	public function edit($id){
 		if($this->input->post('editdata')){

 			$kode = $this->input->post('kode_kehadiran');
 			$nama = $this->input->post('nama_kehadiran');

 			$data = $this->input->post();

 			//variable untuk cek
 			$listfield = array('kode_kehadiran', 'nama_kehadiran');

 			$listdata = array($kode,$nama);

 			$listtext = array('kode','nama');

 			//variable untuk texterror
 			$texterror = "";

 			$getdata = $this->global_model->find_by('kehadiran', array('kode_kehadiran' => $id));

 			if($kode == "" || $nama == ""){
 				$this->message('danger','kode atau nama kehadiran tidak boleh kosong','indexkehadiran');
 			}else{
 				//cek data sama atau tidak
 				for($i = 0; $i < count($listfield); $i++){
 					$sql = $this->global_model->find_by('kehadiran', array($listfield[$i] => $listdata[$i]));
 					if(count($sql) > 0 && $sql['kode_kehadiran'] != $id && $sql['nama_kehadiran'] != $getdata['nama_kehadiran']){
 						$texterror = $texterror." ".$listtext[$i];
 					}
 				}

 				if($texterror != ""){
 					$this->message('danger',$texterror.' kehadiran sudah tersedia','indexkehadiran');

 				}else if($texterror == ""){
 					//simpan ke dalam database
 					$data = $this->input->post();
 					unset($data['editdata']);
 					$data['kode_kehadiran'] = strtoupper($kode);

 					$this->global_model->update('kehadiran', $data, array('kode_kehadiran' => $id));

 					$this->message('success','data berhasil di edit','indexkehadiran');
 				}
 			}
 		}

 		redirect(site_url('kehadiran'));

 	}

 	public function tampil($id){
 		$sql = $this->global_model->find_by('kehadiran', array('kode_kehadiran' => $id));
 		echo json_encode($sql);
 	}

 	public function hapus(){
 		$chkbox = $this->input->post('check');
 		if(is_array($chkbox)){
 			for($i = 0; $i < count($chkbox); $i++){
 				$this->global_model->delete('kehadiran', array('kode_kehadiran' => $chkbox[$i]));
 			}

 			$this->message('success','data berhasil di hapus','indexkehadiran');
 		}

 		redirect(site_url('kehadiran'));

 	}
}

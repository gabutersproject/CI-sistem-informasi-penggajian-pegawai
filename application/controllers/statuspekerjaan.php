<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Statuspekerjaan extends CI_Controller {

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

 		$data['statuspekerjaan'] =  $this->global_model->find_all('statuspekerjaan');

 		//load tampilan html
 		$this->load->view('head/dash/index');
 		$this->load->view('konten/statuspekerjaan/index', $data);
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

 			$kode = $this->input->post('kode_statuskerja');
 			$nama = $this->input->post('nama_statuskerja');

 			$data = $this->input->post();

 			//variable untuk cek
 			$listfield = array('kode_statuskerja', 'nama_statuskerja');

 			$listdata = array($kode,$nama);

 			$listtext = array('kode','nama');

 			//variable untuk texterror
 			$texterror = "";

 			if($kode == "" || $nama == ""){
 				$this->message('danger','kode atau nama status pekerjaan tidak boleh kosong','indexstatuspekerjaan');
 			}else{
 				//cek data sama atau tidak
 				for($i = 0; $i < count($listfield); $i++){
 					$sql = $this->global_model->find_all_by('statuspekerjaan', array($listfield[$i] => $listdata[$i]));
 					if(count($sql) > 0){
 						$texterror = $texterror." ".$listtext[$i];
 					}
 				}

 				if($texterror != ""){
 					$this->message('danger',$texterror.' status pekerjaan sudah tersedia','indexstatuspekerjaan');

 				}else if($texterror == ""){
 					//simpan ke dalam database
 					$data = $this->input->post();
 					unset($data['simpandata']);
 					$data['kode_statuskerja'] = strtoupper($kode);

 					$this->global_model->create('statuspekerjaan', $data);

 					$this->message('success','data berhasil di tambah','indexstatuspekerjaan');
 				}
 			}

 		}

 		redirect(site_url('statuspekerjaan'));

 	}

 	public function edit($id){
 		if($this->input->post('editdata')){

 			$kode = $this->input->post('kode_statuskerja');
 			$nama = $this->input->post('nama_statuskerja');

 			$data = $this->input->post();

 			//variable untuk cek
 			$listfield = array('kode_statuskerja', 'nama_statuskerja');

 			$listdata = array($kode,$nama);

 			$listtext = array('kode','nama');

 			//variable untuk texterror
 			$texterror = "";

 			$getdata = $this->global_model->find_by('statuspekerjaan', array('kode_statuskerja' => $id));

 			if($kode == "" || $nama == ""){
 				$this->message('danger','kode atau nama status pekerjaan tidak boleh kosong','indexstatuspekerjaan');
 			}else{
 				//cek data sama atau tidak
 				for($i = 0; $i < count($listfield); $i++){
 					$sql = $this->global_model->find_by('statuspekerjaan', array($listfield[$i] => $listdata[$i]));
 					if(count($sql) > 0 && $sql['kode_statuskerja'] != $id && $sql['nama_statuskerja'] != $getdata['nama_statuskerja']){
 						$texterror = $texterror." ".$listtext[$i];
 					}
 				}

 				if($texterror != ""){
 					$this->message('danger',$texterror.' status pekerjaan sudah tersedia','indexstatuspekerjaan');

 				}else if($texterror == ""){
 					//simpan ke dalam database
 					$data = $this->input->post();
 					unset($data['editdata']);
 					$data['kode_statuskerja'] = strtoupper($kode);

 					$this->global_model->update('statuspekerjaan', $data, array('kode_statuskerja' => $id));

 					$this->message('success','data berhasil di edit','indexstatuspekerjaan');
 				}
 			}

 		}

 		redirect(site_url('statuspekerjaan'));

 	}

 	public function tampil($id){
 		$sql = $this->global_model->find_by('statuspekerjaan', array('kode_statuskerja' => $id));
 		echo json_encode($sql);
 	}

 	public function hapus(){
 		$chkbox = $this->input->post('check');
 		if(is_array($chkbox)){
 			for($i = 0; $i < count($chkbox); $i++){
 				$this->global_model->delete('statuspekerjaan', array('kode_statuskerja' => $chkbox[$i]));
 			}

 			$this->message('success','data berhasil di hapus','indexstatuspekerjaan');
 		}

 		redirect(site_url('statuspekerjaan'));

 	}
}

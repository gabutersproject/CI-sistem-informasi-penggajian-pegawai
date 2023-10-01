<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengaturaninput extends CI_Controller {

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

 		$data['pengaturaninput'] = $this->global_model->find_all('pengaturaninput');

 		//load tampilan html
 		$this->load->view('head/dash/index');
 		$this->load->view('konten/pengaturaninput/index', $data);
 		$this->load->view('footer/dash/index');

 	}

 	public function tambah(){
 		if($this->input->post('simpandata')){

 			$master = $this->input->post('master');
 			$datamaster = $this->input->post('data_master');
 			$submaster = $this->input->post('sub_master');

 			if($master == "" || $datamaster == "" | $submaster == ""){
 				$this->message('danger','data tidak boleh kosong','indexpengaturaninput');
 			}else{
 				$cari = array(
 					'master' => $master,
 					'data_master' => $datamaster,
 					'sub_master' => $submaster);
 				$sql = $this->global_model->find_by('pengaturaninput', $cari);

 				if($sql != Null){
 					$this->message('danger','pengaturan sudah tersedia','indexpengaturaninput');
 				}else{
 					$data = $this->input->post();
		 			unset($data['simpandata']);
		 			$this->global_model->create('pengaturaninput', $data);

		 			$this->message('success','data berhasil di tambah','indexpengaturaninput');
 				}
 			}
 		}

 		redirect(site_url('pengaturaninput'));

 	}

 	public function hapus(){
 		$chkbox = $this->input->post('check');
 		if(is_array($chkbox)){
 			for($i = 0; $i < count($chkbox); $i++){
 				$check = $this->global_model->find_by('pengaturaninput', array('kode_pengaturan' => $chkbox[$i]));
 				$this->global_model->delete('gaji', array('sub_master' => $check['sub_master'], 'master' => $check['master'], 'data_master' => $check['data_master']));
 				$this->global_model->delete('pengaturaninput', array('kode_pengaturan' => $chkbox[$i]));
 			}

 			$this->message('success','data berhasil di hapus','indexpengaturaninput');
 		}

 		redirect(site_url('pengaturaninput'));
 	}

 	public function ajaxshowmaster($id){
 		if($id == "POG"){
 			echo "<option></option>";
 			foreach ($this->global_model->find_all('jenispotongan') as $row) {
 				echo "<option value='".$row['kode_jenispotongan']."'>".$row['nama_jenispotongan']."</option>";
 			}
 		}else if($id == "PEG"){
 			echo "<option></option>";
 			foreach ($this->global_model->find_all('jenispembayaran') as $row) {
 				echo "<option value='".$row['kode_jenispembayaran']."'>".$row['nama_jenispembayaran']."</option>";
 			}
 		}
 	}

 	public function ajaxshowdata($id){
 		$sql = $this->global_model->find_all_by('jenissubpembayaran', array('kode_jenispembayaran' => $id));

 		if(!$sql){
 			echo"<option></option>";
 			foreach ($this->global_model->find_all_by('jenissubpotongan', array('kode_jenispotongan' => $id)) as $row) {
 				echo "<option value='".$row['kode_jenissubpotongan']."'>".$row['nama_jenissubpotongan']."</option>";
 			}
 		}else{
 			echo"<option></option>";
 			foreach ($this->global_model->find_all_by('jenissubpembayaran', array('kode_jenispembayaran' => $id)) as $row) {
 				echo "<option value='".$row['kode_jenissubpembayaran']."'>".$row['nama_jenissubpembayaran']."</option>";
 			}
 		}
 	}

 	public function selectoptionmaster($id){
 		$sql = $this->global_model->find_by('pengaturan', array('id' => $id));

 		$getmaster = $sql['master'];

 		if($getmaster == "POG"){
 			$data = $this->global_model->find_all('jenispotongan');
 		}else if($getmaster == "PEG"){
 			$data = $this->global_model->find_all('jenispembayaran');
 		}

 		echo json_encode($data);
 	}
}

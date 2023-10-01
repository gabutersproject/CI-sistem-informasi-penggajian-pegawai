<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jamkerja extends CI_Controller {

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

 		$data['eventkehadiran'] = $this->global_model->find_all('eventkehadiran');
 		$data['kehadiran'] = $this->global_model->find_all('kehadiran');
 		//load tampilan html
 		$this->load->view('head/dash/index');
 		$this->load->view('konten/jamkerja/index', $data);
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

 	public function editjamkerja(){
 		if($this->input->post('editjamkerja')){

			if($this->input->post('masukkerja') == "" && $this->input->post('pulangkerja')){
				$this->message('danger','Data tidak boleh ada yang kosong','indexjamkerja');
			}else{
				$data = $this->input->post();
	 			unset($data['editjamkerja']);

	 			$input = array(
	 				'pulangkerja' => date('H:i A', strtotime($data['pulangkerja'])),
	 				'masukkerja' => date('H:i A', strtotime($data['masukkerja']))
	 				);

	 			$this->global_model->update('jamkerja', $input, array('id' => 1));

	 			$this->message('success','jam kerja berhasil di edit','indexjamkerja');
			}
 		}

 		redirect(site_url('jamkerja'));
 	}

 	public function tampiljamkerja(){
 		$tmpl = $this->global_model->find_by('jamkerja', array('id' => 1));
 		$masuk = $tmpl['masukkerja'];
 		$pisahmasuk = explode(" ", $masuk);
 		$pulang = $tmpl['pulangkerja'];
 		$pisahpulang = explode(" ", $pulang);
 		$tmpl['masukkerja']  = date('h:i A', strtotime($pisahmasuk[0]));
 		$tmpl['pulangkerja']  = date('h:i A', strtotime($pisahpulang[0]));		
 		echo json_encode($tmpl);
 	}

 	public function tambah(){
 		if($this->input->post('simpandata')){

 			/*generate kode event*/
 			$sql = $this->global_model->query("select *from eventkehadiran order by kode_event desc");
 			$kode = "EV";

 			if($sql != Null){
 				$pisah = explode('-', $sql[0]['kode_event']);

 				$number =  (int) $pisah[1];
 				$digit = intval($number) + 1;

 				if ($digit >= 1 and $digit <= 9){
					$a = $kode."-00".$digit;
	 			}else if($digit >= 10 and $digit <= 99){
	 				$a = $kode."-0".$digit;
	 			}else{
	 				$a = $kode."-".$digit;
	 			}

 			}else{
 				$kodedefault = "EV-001";
 				$a = $kodedefault;
 			}

 			$kodehadir = $this->input->post('kode_kehadiran');
 			$satuan = $this->input->post('satuan');
 			$batasan = $this->input->post('batasan');
 			$keterangan = $this->input->post('keterangan');
 			$denda = $this->input->post('denda');

 			if($kodehadir == "" || $satuan == "" || $batasan == "" || $keterangan == "" || $denda == ""){
 				$this->message('danger','data tidak boleh ada yang kosong','indexjamkerja');
 			}else{
 				$post = array(
 					'kode_kehadiran' => $kodehadir,
 					'satuan' => $satuan,
 					'batasan' => $batasan,
 					'keterangan' => $keterangan);

 				$check = $this->global_model->find_by('eventkehadiran', $post);

 				if($check != Null){
 					$this->message('danger','event kehadiran sudah tersedia','indexjamkerja');
 				}else{
 					$data = $this->input->post();

		 			unset($data['simpandata']);
		 			$data['kode_event'] = $a;

		 			$this->global_model->create('eventkehadiran', $data);

		 			$this->message('success','data berhasil di tambah','indexjamkerja');
 				}
 			}
 		}

 		redirect(site_url('jamkerja'));
 	}

 	public function edit($id){
 		if($this->input->post('editdata')){

 			$kodehadir = $this->input->post('kode_kehadiran');
 			$satuan = $this->input->post('satuan');
 			$batasan = $this->input->post('batasan');
 			$keterangan = $this->input->post('keterangan');
 			$denda = $this->input->post('denda');

 			$checkpertama = $this->global_model->find_by('eventkehadiran', array('kode_event' => $id));

 			if($kodehadir == "" || $satuan == "" || $batasan == "" || $keterangan == "" || $denda == ""){
 				$this->message('danger','data tidak boleh ada yang kosong','indexjamkerja');
 			}else{
 				$post = array(
 					'kode_kehadiran' => $kodehadir,
 					'satuan' => $satuan,
 					'batasan' => $batasan,
 					'keterangan' => $keterangan);

 				$check = $this->global_model->find_by('eventkehadiran', $post);

 				//ambil dari variable check
 				$isicheck1 = $check['kode_kehadiran'];
 				$isicheck2 = $check['satuan'];
 				$isicheck3 = $check['batasan'];
 				$isicheck4 = $check['keterangan'];

 				//ambil dari variable checkpertama
 				$isicheckpertama1 = $checkpertama['kode_kehadiran'];
 				$isicheckpertama2 = $checkpertama['satuan'];
 				$isicheckpertama3 = $checkpertama['batasan'];
 				$isicheckpertama4 = $checkpertama['keterangan'];

 				if($check != Null && $isicheck1 != $isicheckpertama1 &&
 					$isicheck2 != $isicheckpertama2 && $isicheck3 != $isicheckpertama3 &&
 					$isicheck4 != $isicheckpertama4){

 					$this->message('danger','event kehadiran sudah tersedia','indexjamkerja');

 				}else{

 					$data = $this->input->post();

		 			unset($data['editdata']);

		 			$this->global_model->update('eventkehadiran', $data, array('kode_event' => $id));
 					$data = $this->input->post();

		 			$this->message('success','data berhasil di edit','indexjamkerja');
 				}
 			}

 		}

 		redirect(site_url('jamkerja'));
 	}

 	public function tampil($id){
 		$sql = $this->global_model->find_by('eventkehadiran', array('kode_event' => $id));
 		echo json_encode($sql);

 	}

 	public function hapus(){
 		$chkbox = $this->input->post('check');
 		if(is_array($chkbox)){
 			for($i = 0; $i < count($chkbox); $i++){
 				$this->global_model->delete('eventkehadiran', array('kode_event' => $chkbox[$i]));

 			}
 		}

 		redirect(site_url('jamkerja'));
 	}
}

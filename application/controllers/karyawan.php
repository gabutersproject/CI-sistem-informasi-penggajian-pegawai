<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Karyawan extends CI_Controller {

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

 		$data['karyawan'] = $this->global_model->find_all('karyawan');
 		$data['jabatan'] = $this->global_model->find_all('jabatan');
 		$data['golongan'] = $this->global_model->find_all('golongan');
 		$data['statuspekerjaan'] = $this->global_model->find_all('statuspekerjaan');
 		//load tampilan html
 		$this->load->view('head/dash/index');
 		$this->load->view('konten/karyawan/index', $data);
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

 			/*generate kode karyawan */
 			$sql = $this->global_model->query("select *from karyawan order by kode_karyawan desc");
 			$kode = "KR";

 			if($sql != Null){
 				$pisah = explode('-', $sql[0]['kode_karyawan']);

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
 				$kodedefault = "KR-001";
 				$a = $kodedefault;
 			}

 			$nip = $this->input->post('nip');
 			$nama = $this->input->post('nama');
 			list($bulan,$tanggal,$tahun) = explode('/', $this->input->post('tanggal_lahir'));
 			$tanggallahir = $tahun."-".$bulan."-".$tanggal;
 			$statuskawin = $this->input->post('status_kawin');
 			$jumlahanak = "0";

 			if($statuskawin == "bk"){
 				$jumlah = "0";
 			}else{
 				$jumlah = $this->input->post('jumlah_anak');
 				if($jumlah == ""){
 					$jumlah = "0";
 				}
 			}

 			//variable untuk cek
 			$listfield = array('nip');

 			$listdata = array($nip);

 			$listtext = array('nip');

 			//variable untuk texterror
 			$texterror = "";

 			if($nip == "" || $nama == ""){
 				$this->message('danger','nip atau nama karyawan tidak boleh kosong','indexkaryawan');
 			}else{
 				//cek data sama atau tidak
 				for($i = 0; $i < count($listfield); $i++){
 					$sql = $this->global_model->find_all_by('karyawan', array($listfield[$i] => $listdata[$i]));
 					if(count($sql) > 0){
 						$texterror = $texterror." ".$listtext[$i];
 					}
 				}

 				if($texterror != ""){
 					$this->message('danger',$texterror.' karyawan sudah tersedia','indexkaryawan');

 				}else if($texterror == ""){
 					//simpan ke dalam database
 					$data = $this->input->post();
 					unset($data['simpandata']);
 					$data['kode_karyawan'] = $a;
 					$data['tanggal_lahir'] = $tanggallahir;
 					$data['jumlah_anak'] = $jumlah;
 					$this->global_model->create('karyawan', $data);

 					$this->message('success','data berhasil di tambah','indexkaryawan');
 				}
 			}

 		}

 		redirect(site_url('karyawan'));

 	}

 	public function edit($id){
 		if($this->input->post('editdata')){

 			$nip = $this->input->post('nip');
 			$nama = $this->input->post('nama');
 			list($bulan,$tanggal,$tahun) = explode('/', $this->input->post('tanggal_lahir'));
 			$tanggallahir = $tahun."-".$bulan."-".$tanggal;
 			$statuskawin = $this->input->post('status_kawin');
 			$jumlahanak = "0";

 			if($statuskawin == "bk"){
 				$jumlah = "0";
 			}else{
 				$jumlah = $this->input->post('jumlah_anak');
 				if($jumlah == ""){
 					$jumlah = "0";
 				}
 			}

 			//variable untuk cek
 			$listfield = array('nip');

 			$listdata = array($nip);

 			$listtext = array('nip');

 			//variable untuk texterror
 			$texterror = "";

 			$getdata = $this->global_model->find_by('karyawan', array('kode_karyawan' => $id));

 			if($nip == "" || $nama == ""){
 				$this->message('danger','kode atau nama karyawan tidak boleh kosong','indexkaryawan');
 			}else{
 				//cek data sama atau tidak
 				for($i = 0; $i < count($listfield); $i++){
 					$sql = $this->global_model->find_by('karyawan', array($listfield[$i] => $listdata[$i]));
 					if(count($sql) > 0 && $sql['nip'] != $getdata['nip']){
 						$texterror = $texterror." ".$listtext[$i];
 					}
 				}

 				if($texterror != ""){
 					$this->message('danger',$texterror.' karyawan sudah tersedia','indexkaryawan');

 				}else if($texterror == ""){
 					//simpan ke dalam database
 					$data = $this->input->post();
 					unset($data['editdata']);
 					$data['tanggal_lahir'] = $tanggallahir;
 					$data['jumlah_anak'] = $jumlah;

 					$this->global_model->update('karyawan', $data, array('kode_karyawan' => $id));

 					$this->message('success','data berhasil di edit','indexkaryawan');
 				}
 			}
 		}

 		redirect(site_url('karyawan'));

 	}

 	public function tampil($id){
 		$sql = $this->global_model->find_by('karyawan', array('kode_karyawan' => $id));

 		$a = $sql['tanggal_lahir'];
 		list($tahun,$bulan,$tanggal) = explode('-', $a);
 		$sql['tanggal_lahir'] = $bulan."/".$tanggal."/".$tahun;
 		echo json_encode($sql);
 	}

 	public function hapus(){
 		$chkbox = $this->input->post('check');
	 		if(is_array($chkbox)){
	 			for($i = 0; $i < count($chkbox); $i++){
	 				$this->global_model->delete('karyawan', array('kode_karyawan' => $chkbox[$i]));

	 			}

	 			$this->message('success','data berhasil di hapus','indexkaryawan');
	 		}

	 		redirect(site_url('karyawan'));
 	}
}

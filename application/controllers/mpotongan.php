<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mpotongan extends CI_Controller {

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
 		//load data
 		$data['gaji'] = $this->global_model->query("select kode_gaji,kode_karyawan,id,bulan,tahun,sum(nilai) as jumlah from gaji where master='POG' group by id");
 		//load tampilan html
 		$this->load->view('head/dash/index');
 		$this->load->view('konten/mpotongan/index', $data);
 		$this->load->view('footer/dash/index');

 	}

 	public function tambah(){

 		if($this->input->post('simpandata')){

 			$kodekaryawan = $this->input->post('kode_karyawan');

 			/*generate id gaji */
 			$sql = $this->global_model->query("select *from gaji where id like 'POG%' order by id desc");
 			$kodes = "POG";

 			if($sql != Null){
 				$pisah = explode('-', $sql[0]['id']);

 				$number =  (int) $pisah[1];
 				$digit = intval($number) + 1;

 				if ($digit >= 1 and $digit <= 9){
					$a = $kodes."-00".$digit;
	 			}else if($digit >= 10 and $digit <= 99){
	 				$a = $kodes."-0".$digit;
	 			}else{
	 				$a = $kodes."-".$digit;
	 			}

 			}else{
 				$kodedefault = "POG-001";
 				$a = $kodedefault;
 			}

 			$text = $this->input->post('text');
 			$nilai = $this->input->post('nilai');
 			$tahun = $this->input->post('tahun');
 			$bulan = $this->input->post('bulan');

 			if(is_array($nilai) && is_array($text) && $tahun != ""){

 				$checkkode = $this->global_model->find_by('gaji', array('kode_karyawan' => $kodekaryawan,'master' => 'POG','bulan' => $bulan, 'tahun' => $tahun));
 				if($checkkode != NUll){
 					$this->message('danger','data tersebut sudah tersedia','indexmpotongantambah');
 				}else{
 					for ($i=0; $i < count($text); $i++) {

 						$getdata = $this->global_model->find_by('pengaturaninput', array('sub_master' => $text[$i]));

 						$kumpuldata = array(
	 					'kode_karyawan' => $kodekaryawan,
	 					'master' =>	'POG',
	 					'data_master' => $getdata['data_master'],
	 					'sub_master' => $text[$i],
	 					'bulan' => $this->input->post('bulan'),
	 					'tahun' => $this->input->post('tahun'),
	 					'nilai' => $nilai[$i],
	 					'id' => $a);

	 					$this->global_model->create('gaji', $kumpuldata);
 					}

 					$this->message('success','data berhasil di tambah','indexmpotongantambah');
 				}
 			}else{
 				$this->message('danger','data tidak boleh ada yang kosong','indexmpotongantambah');
 			}

	 		redirect(site_url('mpotongan/tambah'));

 		}

 		//load data dari database
 		$data['karyawan'] = $this->global_model->find_all('karyawan');
 		$data['datamaster'] = $this->global_model->query("select distinct data_master from pengaturaninput where master='POG'");
 		//load tampilan html
 		$this->load->view('head/dash/index');
 		$this->load->view('konten/mpotongan/tambah',$data);
 		$this->load->view('footer/dash/index');

 	}

 	public function ubah($id){

 		if($this->input->post('simpandata')){
 			$kodekaryawan = $this->input->post('kode_karyawan');
 			$text = $this->input->post('text');
 			$nilai = $this->input->post('nilai');
 			$tahun = $this->input->post('tahun');
 			$bulan = $this->input->post('bulan');
 			$banyak = $this->global_model->find_all_by('gaji', array('id' => $id));
 			$cari = $this->global_model->find_by('gaji', array('id' => $id));
 			$jumlahtext = count($text);
 			$awal = intval(count($text)+1);
 			$batas = count($banyak);

 			$banding1 = $kodekaryawan.$bulan.$tahun;
 			$banding2 = $cari['kode_karyawan'].$cari['bulan'].$cari['tahun'];

 			if(is_array($nilai) && is_array($text) && $tahun != ""){

 				$checkkode = $this->global_model->find_by('gaji', array('kode_karyawan' => $kodekaryawan,'master' => 'POG', 'bulan' => $bulan, 'tahun' => $tahun));
 				if($checkkode != NUll && $banding1 != $banding2){
 					$this->message('danger','data tersebut sudah tersedia','indexmpotongan');
 				}else{
 					//tambah data jika ada input baru
 					if($batas < $jumlahtext){
 						for ($i=$batas; $i <=$jumlahtext-1; $i++) {
 							$sql = $this->global_model->find_by('pengaturaninput', array('sub_master' => $text[$i]));
 							$insert = array(
 								'kode_karyawan' => $kodekaryawan,
 								'master' => 'POG',
 								'data_master' => $sql['data_master'],
 								'sub_master' => $text[$i],
	 							'bulan' => $this->input->post('bulan'),
	 							'tahun' => $this->input->post('tahun'),
 								'nilai' => $nilai[$i],
 								'id' => $id);

 							$this->global_model->create('gaji', $insert);
 						}

 					}

 					//update data
 					for ($k=0; $k < $jumlahtext; $k++) {
 						$kumpuldata = array(
	 					'nilai' => $nilai[$k],
	 					'bulan' => $bulan,
	 					'tahun' => $tahun,
	 					'kode_karyawan' => $kodekaryawan);

	 					$this->global_model->update('gaji', $kumpuldata, array('id' => $id, 'sub_master' => $text[$k]));
 					}

 					$this->message('success','data berhasil di edit','indexmpotongan');
 				}
 			}else{
 				$this->message('danger','data tidak boleh ada yang kosong','indexmpotongan');
 			}

	 		redirect(site_url('mpotongan'));
 		}

 		//load data dari database
 		$data['karyawan'] = $this->global_model->find_all('karyawan');
 		$data['datamaster'] = $this->global_model->query("select distinct data_master from pengaturaninput where master='POG'");
 		$get = $this->global_model->find_by('gaji', array('id' => $id));
 		$data['datas'] = array(
 			'bulan' => $get['bulan'],
 			'tahun' => $get['tahun'],
 			'kode_karyawan' => $get['kode_karyawan']);

 		//load tampilan html
 		$this->load->view('head/dash/index');
 		$this->load->view('konten/mpotongan/ubah',$data);
 		$this->load->view('footer/dash/index');
 	}

 	public function hapus(){
 		$chkbox = $this->input->post('check');
 		if(is_array($chkbox)){
 			for($i= 0; $i < count($chkbox);$i++){
 				$this->global_model->delete('gaji', array('id' => $chkbox[$i]));
 			}

 			$this->message('success','data berhasil di hapus','indexmpotongan');
 		}

 		redirect(site_url('mpotongan'));
 	}
}

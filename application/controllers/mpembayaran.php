<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mpembayaran extends CI_Controller {

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
 		$data['header'] = $this->global_model->find_all('koppembayaran');
 		//load tampilan html
 		$this->load->view('head/dash/index');
 		$this->load->view('konten/mpembayaran/index', $data);
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

 			$kodekaryawan = $this->input->post('kode_karyawan');

 			/*generate id gaji */
 			$sql = $this->global_model->query("select *from gaji where id like 'PEG%' order by id desc");
 			$kodes = "PEG";

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
 				$kodedefault = "PEG-001";
 				$a = $kodedefault;
 			}

 			$text = $this->input->post('text');
 			$nilai = $this->input->post('nilai');
 			$tahun = $this->input->post('tahun');
 			$bulan = $this->input->post('bulan');

 			if($tahun != ""){

 				$checkkode = $this->global_model->find_by('koppembayaran', array('kode' => $kodekaryawan,'bulan' => $bulan, 'tahun' => $tahun));
 				if($checkkode != NUll){
 					$this->message('danger','data tersebut sudah tersedia','indexmpembayarantambah');
 				}else{
 					//insert ke koppembayaran
 					$insertkop = array(
 						'kode' => $kodekaryawan,
 						'bulan' => $this->input->post('bulan'),
 						'tahun' => $tahun,
 						'id_kop' => $a);

 					$this->global_model->create('koppembayaran', $insertkop);

 					if(is_array($text) && is_array($nilai)){
	 					for ($i=0; $i < count($text); $i++) {

	 						$getdata = $this->global_model->find_by('pengaturaninput', array('sub_master' => $text[$i]));

	 						$kumpuldata = array(
		 					'kode_karyawan' => $kodekaryawan,
		 					'master' =>	'PEG',
		 					'data_master' => $getdata['data_master'],
		 					'sub_master' => $text[$i],
		 					'bulan' => $this->input->post('bulan'),
		 					'tahun' => $this->input->post('tahun'),
		 					'nilai' => $nilai[$i],
		 					'id' => $a);

		 					$this->global_model->create('gaji', $kumpuldata);
	 					}
 					}

 					$this->message('success','data berhasil di tambah','indexmpembayarantambah');
 				}
 			}else{
 				$this->message('danger','data tidak boleh ada yang kosong','indexmpembayarantambah');
 			}

	 		redirect(site_url('mpembayaran/tambah'));

 		}

 		//load data dari database
 		$data['karyawan'] = $this->global_model->find_all('karyawan');
 		$data['datamaster'] = $this->global_model->query("select distinct data_master from pengaturaninput where master='PEG'");
 		//load tampilan html
 		$this->load->view('head/dash/index');
 		$this->load->view('konten/mpembayaran/tambah',$data);
 		$this->load->view('footer/dash/index');

 	}

 	public function tampilstatis($id){
 		$karyawan = $this->global_model->find_by('karyawan',array('kode_karyawan' => $id));
 		$get = $this->global_model->find_by('golongan', array('kode_golongan' => $karyawan['kode_golongan']));
 		$get2 = $this->global_model->find_by('jabatan', array('kode_jabatan' => $karyawan['kode_jabatan']));
 		$data = array(
 			'gajipokok' => $get['gajipokok'],
 			'tperumahan' => $get['tperumahan'],
 			'tkesehatan' => $get['tkesehatan'],
 			'ttransport' => $get['ttransport'],
 			'insjabatan' => $get2['insjabatan'],
 			'tjabatan' => $get2['tjabatan'],
 			'uangmakan' => $get['uangmakan'],);

 		echo json_encode($data);
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
 			$get = $this->global_model->find_by('koppembayaran',array('id_kop' => $id));
 			$jumlahtext = count($text);
 			$awal = intval(count($text)+1);
 			$batas = count($banyak);

 			$banding1 = $kodekaryawan.$bulan.$tahun;
 			$banding2 = $get['kode'].$get['bulan'].$get['tahun'];

 			if($tahun != ""){

 				$checkkode = $this->global_model->find_by('koppembayaran', array('kode' => $kodekaryawan,'bulan' => $bulan, 'tahun' => $tahun));
 				if($checkkode != NUll && $banding1 != $banding2){
 					$this->message('danger','data tersebut sudah tersedia','indexmpembayaran');
 				}else{
 					//update di koppembayaran
 					$ubahkop = array(
 						'kode' => $kodekaryawan,
 						'bulan' => $bulan,
 						'tahun' => $tahun);

 					$this->global_model->update('koppembayaran', $ubahkop, array('id_kop' => $get['id_kop']));

 					if(is_array($nilai) && is_array($text)){
	 					//tambah data jika ada input baru
	 					if($batas < $jumlahtext){
	 						for ($i=$batas; $i <=$jumlahtext-1; $i++) {
	 							$sql = $this->global_model->find_by('pengaturaninput', array('sub_master' => $text[$i]));
	 							$insert = array(
	 								'kode_karyawan' => $kodekaryawan,
	 								'master' => 'PEG',
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
	 				}

 					$this->message('success','data berhasil di edit','indexmpembayaran');
 				}
 			}else{
 				$this->message('danger','data tidak boleh ada yang kosong','indexmpembayaran');
 			}

	 		redirect(site_url('mpembayaran'));
 		}

 		//load data dari database
 		$data['karyawan'] = $this->global_model->find_all('karyawan');
 		$data['datamaster'] = $this->global_model->query("select distinct data_master from pengaturaninput where master='PEG'");
 		$get = $this->global_model->find_by('koppembayaran', array('id_kop' => $id));
 		$kodenih = $this->global_model->find_by('karyawan', array('kode_karyawan' => $get['kode']));
 		$getgolongan = $this->global_model->find_by('golongan', array('kode_golongan' => $kodenih['kode_golongan']));
 		$getjabatan = $this->global_model->find_by('jabatan', array('kode_jabatan' => $kodenih['kode_jabatan']));
 		$data['datas'] = array(
 			'bulan' => $get['bulan'],
 			'tahun' => $get['tahun'],
 			'kode_karyawan' => $get['kode'],
 			'gajipokok' => $getgolongan['gajipokok'],
 			'tperumahan' => $getgolongan['tperumahan'],
 			'tkesehatan' => $getgolongan['tkesehatan'],
 			'ttransport' => $getgolongan['ttransport'],
 			'uangmakan' => $getgolongan['uangmakan'],
 			'insjabatan' => $getjabatan['insjabatan'],
 			'tjabatan' => $getjabatan['tjabatan']);

 		//load tampilan html
 		$this->load->view('head/dash/index');
 		$this->load->view('konten/mpembayaran/ubah', $data);
 		$this->load->view('footer/dash/index');
 	}

 	public function hapus(){
 		$chkbox = $this->input->post('check');
 		if(is_array($chkbox)){
 			for($i= 0; $i < count($chkbox);$i++){
 				$this->global_model->delete('gaji', array('id' => $chkbox[$i]));
 				$this->global_model->delete('koppembayaran', array('id_kop' => $chkbox[$i]));
 			}

 			$this->message('success','data berhasil di hapus','indexmpembayaran');
 		}

 		redirect(site_url('mpembayaran'));
 	}
}

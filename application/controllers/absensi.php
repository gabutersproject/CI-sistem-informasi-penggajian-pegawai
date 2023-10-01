<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Absensi extends CI_Controller {

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
 		$data['karyawan'] = $this->global_model->find_all('karyawan');
 		$data['absensi'] = $this->global_model->find_all('absensi','kode_absensi DESC');
 		$data['kehadiran'] =  $this->global_model->query("select *from kehadiran where nama_kehadiran != 'Terlambat'");
 		$data['jumlahdata'] = count($data['absensi']);
 		//load tampilan html
 		$this->load->view('head/dash/index');
 		$this->load->view('konten/absensi/index', $data);
 		$this->load->view('footer/dash/index');
 	}

 	public function tambah(){
 		if($this->input->post('simpandata')){

 			//format set waktu absen
 			date_default_timezone_set('Asia/Jakarta');
 			$getdatetime = date('m/d/Y H:i:s',time());

 			$pisah = explode(' ',$getdatetime);

 			list($bulan,$tanggal,$tahun) = explode('/', $pisah[0]);

 			$tanggalinput = $tahun."-".$bulan."-".$tanggal;

 			$waktuinput = date('H:i A', strtotime($getdatetime));

			$namaBulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");

 			//ambil dari form
 			$nip = $this->input->post('nip');
 			$getkode = $this->global_model->find_by('karyawan', array('nip' => $nip));
 			$kodekaryawan = $getkode['kode_karyawan'];
 			$kehadiran = $this->input->post('kode_kehadiran');

			//dijam sendiri
			$potongwaktuinput = explode(' ', $waktuinput);
			$pisahjam = explode(':',$potongwaktuinput[0]);
			$totalmenit1 = intval($pisahjam[0]*60 + $pisahjam[1]);

			//cek di jam kerja
			$jamkerja = $this->global_model->find_by('jamkerja',array('id' => 1));
			$k = $jamkerja['masukkerja'];
			$potongjamkerja = explode(' ', $k);
			$pisahjam2 = explode(':',$potongjamkerja[0]);
			$totalmenit2 = intval($pisahjam2[0]*60 + $pisahjam2[1]);

			//ambilevent
			$batasancuyy = array();
			$kodecuyy = array();
			$b1 = $this->global_model->find_all_by('eventkehadiran',array('satuan' => 'Menit'));
			foreach ($b1 as $key) {
				$batasancuyy[] = $key['batasan'];
				$kodecuyy[] = $key['kode_event'];
			}

 			if($nip == ""){
 				$this->message('danger','Masukan NIP karyawan anda','indexabsensi');
 			}else if($getkode == Null){
 				$this->message('danger','NIP Karyawan yang dimasukan salah','indexabsensi');
 			}else{

 				$check = $this->global_model->find_by('absensi', array('kode_karyawan' => $kodekaryawan, 'tanggal' => $tanggalinput));
 				if($check != Null && $kehadiran != "PLG"){
	 				$this->message('danger','Maaf, anda telah absen sebelumnya','indexabsensi');
 				}else if($check != Null && $kehadiran == "PLG" && $check['kode_kehadiran'] == "MSK"){
 						$u = array(
 						'pulang' => $waktuinput);

	 					$this->global_model->update('absensi', $u,array('kode_karyawan' => $kodekaryawan, 'tanggal' => $tanggalinput));

	 					$this->message('success','terima kasih anda telah absen','indexabsensi');

 				}else{
 					$kumpuldata = array(
 						'kode_karyawan' => $kodekaryawan,
 						'kode_kehadiran' => $kehadiran,
 						'tanggal' => $tanggalinput,
						'bulan' => $namaBulan[intval($bulan-1)],
						'tahun' => $tahun,
 						'masuk' => '-',
 						'pulang' => '-');

 					if($kehadiran == "MSK"){
 						$kumpuldata['masuk'] = $waktuinput;
 						$this->global_model->create('absensi', $kumpuldata);

						if($totalmenit1 > $totalmenit2){
							$selisihmenit = $totalmenit1 - $totalmenit2;
							$batasakhirjam = 0;
							$getakhirkode = intval(count($kodecuyy)-1);
							$kodeevents = $kodecuyy[$getakhirkode];
							for ($i=0; $i < count($kodecuyy); $i++) {
								$batasan = intval($batasakhirjam+$batasancuyy[$i]);
								if($batasan > $selisihmenit && $i < count($kodecuyy)){
									$kodeevents = $kodecuyy[$i];
									break;
								}else{
									$batasakhirjam = $batasakhirjam+$batasancuyy[$i];
								}
							}

							$kumpulrekam = array(
								'id' => $tanggalinput,
								'kode_karyawan' => $kodekaryawan,
								'bulan' => $namaBulan[intval($bulan-1)],
								'tahun' => $tahun,
								'kode_event' => $kodeevents
							);

							$this->global_model->create('rekamabsensi', $kumpulrekam);

						}

 						$this->message('success','terima kasih anda telah absen','indexabsensi');
 					}else if($kehadiran == "PLG"){
 						$this->message('danger','anda harus absen masuk dahulu','indexabsensi');
 					}else{
 						$this->global_model->create('absensi', $kumpuldata);
 						$this->message('success','terima kasih anda telah absen','indexabsensi');
 					}

 				}
 			}
 		}

 		redirect(site_url('absensi'));
 	}

 	public function hapus(){
 		$chkbox = $this->input->post('check');
 		if(is_array($chkbox)){
 			for($i = 0; $i < count($chkbox); $i++){
				$cari = $this->global_model->find_by('absensi', array('kode_absensi' => $chkbox[$i]));
 				$this->global_model->delete('absensi', array('kode_absensi' => $chkbox[$i]));
				$this->global_model->delete('rekamabsensi', array('id' => $cari['tanggal'],'kode_karyawan' => $cari['kode_karyawan']));
 			}
 		}

 		redirect(site_url('absensi'));
 	}


 	public function dataload(){
 		$sql = count($this->global_model->find_all('absensi'));
 		echo $sql;
 	}

}

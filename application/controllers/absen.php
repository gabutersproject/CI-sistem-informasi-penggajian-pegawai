<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Absen extends CI_Controller {

	function __construct()
 	{
 		parent::__construct();
 		$this->load->model('global_model');
 		$this->load->helper('url');
 		$this->load->library('session');
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

 		$data['absensi'] =  $this->global_model->find_all('absensi');
 		$data['kehadiran'] =  $this->global_model->query("select *from kehadiran where nama_kehadiran != 'Terlambat'");
 		// mengambil data dari database
 		$this->load->view('head/absen/index');
 		$this->load->view('konten/absen/index', $data);
 		$this->load->view('footer/absen/index');
 	}

 	public function masuk(){
 		if($this->input->post('masuk')){

 			//format set waktu absen
 			date_default_timezone_set('Asia/Jakarta');
 			$getdatetime = date('m/d/Y H:i:s',time());

 			$pisah = explode(' ',$getdatetime);

 			list($bulan,$tanggal,$tahun) = explode('/', $pisah[0]);

 			$tanggalinput = $tahun."-".$bulan."-".$tanggal;

 			$waktuinput = date('h:i A', strtotime($getdatetime));

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
 				$this->message('danger','Masukan NIP karyawan anda','indexabsen');
 			}else if($getkode == Null){
 				$this->message('danger','NIP Karyawan yang dimasukan salah','indexabsen');
 			}else{

 				$check = $this->global_model->find_by('absensi', array('kode_karyawan' => $kodekaryawan, 'tanggal' => $tanggalinput));
 				if($check != Null && $kehadiran != "PLG"){
	 				$this->message('danger','Maaf, anda telah absen sebelumnya','indexabsen');
 				}else if($check != Null && $kehadiran == "PLG" && $check['kode_kehadiran'] == "MSK"){
 						$u = array(
 						'pulang' => $waktuinput);

	 					$this->global_model->update('absensi', $u,array('kode_karyawan' => $kodekaryawan, 'tanggal' => $tanggalinput));

	 					$this->message('success','terima kasih anda telah absen','indexabsen');

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

 						$this->message('success','terima kasih anda telah absen','indexabsen');
 					}else if($kehadiran == "PLG"){
 						$this->message('danger','anda harus absen masuk dahulu','indexabsen');
 					}else{
 						$this->global_model->create('absensi', $kumpuldata);
 						$this->message('success','terima kasih anda telah absen','indexabsen');
 					}

 				}
 			}

 		}

 		redirect(site_url('absen'));
 	}
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rekapstruk extends CI_Controller {

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
 		// mengambil data dari database
 		$this->load->view('head/dash/index');
 		$this->load->view('konten/rekapstruk/index', $data);
 		$this->load->view('footer/dash/index');
 	}

	public function laporan(){
		$data['nip'] = $this->global_model->find_by('karyawan', array('nip' => $this->input->post('nip')));
 		$data['bulan'] = $this->input->post('bulan');
 		$data['tahun'] = $this->input->post('tahun');

		//kumpulkan data karyawan berdasarkan golongan,jabatan,divisi
		$sqlkaryawan = "select karyawan.kode_karyawan,nip,nama,jabatan.kode_jabatan,
		jabatan.nama_jabatan,divisi.kode_divisi,divisi.nama_divisi,golongan.kode_golongan,
		golongan.nama_golongan,jabatan.insjabatan,jabatan.tjabatan,golongan.gajipokok,
		golongan.uangmakan,golongan.tperumahan,golongan.tkesehatan,golongan.ttransport,
		statuspekerjaan.nama_statuskerja from karyawan inner join jabatan on karyawan.kode_jabatan = jabatan.kode_jabatan
		inner join golongan on karyawan.kode_golongan = golongan.kode_golongan inner join
		divisi on jabatan.kode_divisi = divisi.kode_divisi inner join statuspekerjaan on
		statuspekerjaan.kode_statuskerja = karyawan.kode_statuskerja where
		karyawan.nip='".$this->input->post('nip')."'";

		$query = $this->db->query($sqlkaryawan);
		$row = $query->row();

		//menghitung jumlah premi karyawan
		$premi1 = array();
		foreach ($this->global_model->query("select count(*) * eventkehadiran.denda as jumlah from rekamabsensi inner join eventkehadiran on rekamabsensi.kode_event = eventkehadiran.kode_event where kode_karyawan='".$row->kode_karyawan."' and bulan='".$this->input->post('bulan')."' and tahun='".$this->input->post('tahun')."' group by rekamabsensi.kode_event") as $key) {
			$premi1[] = $key['jumlah'];
		}

		$premi = array_sum($premi1);
		$totalpremi = intval(880000-$premi);

		//menghitung pembayaran lain - lain
		$querylain = $this->db->query("select sum(nilai) as jumlah from gaji where master='PEG' and kode_karyawan='".$row->kode_karyawan."' and bulan='".$this->input->post('bulan')."' and tahun='".$this->input->post('tahun')."'");
		$rowlain = $querylain->row();

		//menghitung jumlah potongan
		$querypotongan = $this->db->query("select sum(nilai) as jumlah from gaji where master='POG' and kode_karyawan='".$row->kode_karyawan."' and bulan='".$this->input->post('bulan')."' and tahun='".$this->input->post('tahun')."'");
		$rowpotongan = $querypotongan->row();

		//jumlah penghasilan tetap
		$jumlahphslnttp = intval($row->gajipokok+$row->tperumahan+$row->tkesehatan+$row->ttransport+$row->tjabatan);
		//jumlah penerimaan (jumlah kotor)
		$jumlahpenerimaan = intval($jumlahphslnttp + $row->uangmakan + $row->insjabatan + $totalpremi + $rowlain->jumlah);
		//jumlah keseluruhan
		$jumlahseluruh = intval($jumlahpenerimaan - $rowpotongan->jumlah);

		$data['fetchdata'] = array(
			'kodekaryawan' => strtoupper($row->kode_karyawan),
			'namakaryawan' => strtoupper($row->nama),
			'divisi' => strtoupper($row->nama_divisi),
			'golongan' => strtoupper($row->kode_golongan),
			'status' => strtoupper($row->nama_statuskerja),
			'gajipokok' => number_format ($row->gajipokok, 2, ',', '.'),
			'tperumahan' => number_format ($row->tperumahan, 2, ',', '.'),
			'tkesehatan' => number_format ($row->tkesehatan, 2, ',', '.'),
			'ttransport' => number_format ($row->ttransport, 2, ',', '.'),
			'tjabatan' => number_format ($row->tjabatan, 2, ',', '.'),
			'jumlahphslnttp' => number_format ($jumlahphslnttp, 2, ',', '.'),
			'insjabatan' => number_format ($row->insjabatan, 2, ',', '.'),
			'uangmakan' => number_format ($row->uangmakan, 2, ',', '.'),
			'premi' => number_format ($totalpremi, 2, ',', '.'),
			'pembayaranlain' => number_format ($rowlain->jumlah, 2, ',', '.'),
			'jumlahpenerimaan' => number_format ($jumlahpenerimaan, 2, ',', '.'),
			'jumlahseluruh' => number_format ($jumlahseluruh, 2, ',', '.')
		);

 		$this->load->view('head/laporan/index');
 		$this->load->view('konten/laporan/strukgaji', $data);
 		$this->load->view('footer/laporan/index');

 		//dompdf convert html to pdf
		$html = $this->output->get_output();

		// Load/panggil library dompdfnya
		$this->load->library('dompdf_gen');

		// Convert to PDF
		$this->dompdf->load_html($html);
		$this->dompdf->set_paper(array(0, 0, 800, 800),'potrait');
		$this->dompdf->render();
		//utk menampilkan preview pdf
		$this->dompdf->stream("strukgaji.pdf",array('Attachment'=>0));
		//atau jika tidak ingin menampilkan (tanpa) preview di halaman browser
		//$this->dompdf->stream("welcome.pdf");*/

 	}


}

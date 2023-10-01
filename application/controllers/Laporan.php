<?php

Class Laporan extends CI_Controller{
    
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('Model_laporan','Model_pegawai'));
    }
    
    function laporan_data_golongan()
    {
        $pdf = new FPDF("P","mm","A4");
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(195,0.5,"LAPORAN DATA GOLONGAN",0,0.7,'C');
        $pdf->Line(10,21,200,21);
        $pdf->SetLineWidth(1);
        $pdf->Line(10, 22, 200, 22);
        $pdf->SetLineWidth(0);
        $pdf->Ln(20);
        
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(60, 7, 'Dicetak pada : '.tgl_indo(date("Y-m-d")),0,0,'C');
        $pdf->Ln(10);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(30, 8, 'Golongan', 1, 0, 'C');
        $pdf->Cell(50, 8, 'Tj. Suami/Istri', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Tj. Anak', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Uang Makan', 1, 0, 'C');
        $pdf->Cell(25, 8, 'Uang Lembur', 1, 0, 'C');
        $pdf->Cell(25, 8, 'Askes', 1, 1, 'C');
        
        $pdf->SetFont('Times','','10');
        $golongan = $this->Model_laporan->ambil_data_golongan();
        foreach ($golongan->result() as $b)
        {
            $pdf->Cell(30, 8, $b->golongan, 1, 0, 'C');
            $pdf->Cell(50, 8, $b->tj_suami_istri, 1, 0, 'C');
            $pdf->Cell(30, 8, $b->tj_anak, 1, 0, 'C');
            $pdf->Cell(30, 8, $b->uang_makan, 1, 0, 'C');
            $pdf->Cell(25, 8, $b->uang_lembur, 1, 0, 'C');
            $pdf->Cell(25, 8, $b->askes, 1, 1, 'C');
        }
        $pdf->Output("laporan_data_golongan.pdf","I");
    }
    
    function laporan_data_jabatan()
    {
        $pdf = new FPDF("P","mm","A4");
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(195,0.5,"LAPORAN DATA JABATAN",0,0.7,'C');
        $pdf->Line(10,21,200,21);
        $pdf->SetLineWidth(1);
        $pdf->Line(10, 22, 200, 22);
        $pdf->SetLineWidth(0);
        $pdf->Ln(20);
        
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(60, 7, 'Dicetak pada : '.tgl_indo(date("Y-m-d")),0,0,'C');
        $pdf->Ln(10);
        $pdf->SetFont('Arial','B',10);
        
        $pdf->Cell(20, 8, 'No.', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Kode Jabatan', 1, 0, 'C');
        $pdf->Cell(50, 8, 'Nama Jabatan', 1, 0, 'C');
        $pdf->Cell(45, 8, 'Gaji Pokok', 1, 0, 'C');
        $pdf->Cell(45, 8, 'Tj. Jabatan', 1, 1, 'C');
        
        $pdf->SetFont('Times','','10');
        $no=1;
        $jabatan = $this->Model_laporan->ambil_data_jabatan();
        foreach ($jabatan->result() as $j)
        {
            $pdf->Cell(20, 8, $no++, 1, 0, 'C');
            $pdf->Cell(30, 8, $j->kd_jabatan, 1, 0, 'C');
            $pdf->Cell(50, 8, $j->nm_jabatan, 1, 0, 'C');
            $pdf->Cell(45, 8, $j->gapok, 1, 0, 'C');
            $pdf->Cell(45, 8, $j->tj_jabatan, 1, 1, 'C');
        }
        $pdf->Output("laporan_data_jabatan.pdf","I");
    }
    
    function laporan_data_potongan()
    {
        $pdf = new FPDF("P","mm","A4");
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(195,0.5,"LAPORAN DATA POTONGAN",0,0.7,'C');
        $pdf->Line(10,21,200,21);
        $pdf->SetLineWidth(1);
        $pdf->Line(10, 22, 200, 22);
        $pdf->SetLineWidth(0);
        $pdf->Ln(20);
        
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(60, 7, 'Dicetak pada : '.tgl_indo(date("Y-m-d")),0,0,'C');
        $pdf->Ln(10);
        $pdf->SetFont('Arial','B',10);
        
        $pdf->Cell(20, 8, 'No.', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Kode Potongan', 1, 0, 'C');
        $pdf->Cell(50, 8, 'Nama Potongan', 1, 1, 'C');
        
        $pdf->SetFont('Times','','10');
        $no=1;
        $potongan = $this->Model_laporan->ambil_data_potongan();
        foreach ($potongan->result() as $p)
        {
            $pdf->Cell(20, 8, $no++, 1, 0, 'C');
            $pdf->Cell(30, 8, $p->kd_potongan, 1, 0, 'C');
            $pdf->Cell(50, 8, $p->nm_potongan, 1, 1, 'C');
        }
        $pdf->Output("laporana_data_potongan","I");
    }
    
    function laporan_data_pegawai()
    {
        $pdf = new FPDF("P","mm","A4");
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(195,0.5,"LAPORAN DATA PEGAWAI",0,0.7,'C');
        $pdf->Line(10,21,200,21);
        $pdf->SetLineWidth(1);
        $pdf->Line(10, 22, 200, 22);
        $pdf->SetLineWidth(0);
        $pdf->Ln(20);
        
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(60, 7, 'Dicetak pada : '.tgl_indo(date("Y-m-d")),0,0,'C');
        $pdf->Ln(10);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(30, 8, 'NIP', 1, 0, 'C');
        $pdf->Cell(50, 8, 'Nama Pegawai', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Kode Jabatan', 1, 0, 'C');
        $pdf->Cell(25, 8, 'Golongan', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Status', 1, 0, 'C');
        $pdf->Cell(25, 8, 'Jumlah Anak', 1, 1, 'C');
        
        $pdf->SetFont('Times','','10');
        $pegawai = $this->Model_pegawai->tampilkan_pegawai();
        foreach ($pegawai->result() as $pg)
        {
            $pdf->Cell(30, 8, $pg->nip, 1, 0, 'C');
            $pdf->Cell(50, 8, $pg->nm_pegawai, 1, 0, 'C');
            $pdf->Cell(30, 8, $pg->kd_jabatan, 1, 0, 'C');
            $pdf->Cell(25, 8, $pg->golongan, 1, 0, 'C');
            
            if($pg->status_nikah == 1)
            {
                $pdf->Cell(30, 8, 'Menikah', 1, 0, 'C');
            }
            else if($pg->status_nikah == 2)
            {
                $pdf->Cell(30, 8, 'Belum Menikah', 1, 0, 'C');
            }
            else if($pg->status_nikah == 3)
            {
                $pdf->Cell(30, 8, 'Duda', 1, 0, 'C');
            }
            else if($pg->status_nikah == 4)
            {
                $pdf->Cell(30, 8, 'Janda', 1, 0, 'C');
            }
            $pdf->Cell(25, 8, $pg->jml_anak, 1, 1, 'C');
        }
        $pdf->Output("laporan_data_pegawai.pdf","I");
    }
    
    function laporan_data_petugas()
    {
        $pdf = new FPDF("P","mm","A4");
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(195,0.5,"LAPORAN DATA PETUGAS",0,0.7,'C');
        $pdf->Line(10,21,200,21);
        $pdf->SetLineWidth(1);
        $pdf->Line(10, 22, 200, 22);
        $pdf->SetLineWidth(0);
        $pdf->Ln(20);
        
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(195, 7, 'Dicetak pada : '.tgl_indo(date("Y-m-d")),0,0,'C');
        $pdf->Ln(10);
        $pdf->SetFont('Arial','B',10);
        
        $pdf->Cell(45);
        $pdf->Cell(20, 8, 'No.', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Kode Petugas', 1, 0, 'C');
        $pdf->Cell(50, 8, 'Nama Petugas', 1, 1, 'C');
        
        $pdf->SetFont('Times','','10');
        $no=1;
        $admin = $this->Model_laporan->ambil_data_petugas();
        foreach ($admin->result() as $a)
        {
            $pdf->Cell(45);
            $pdf->Cell(20, 8, $no++, 1, 0, 'C');
            $pdf->Cell(30, 8, $a->kd_admin, 1, 0, 'C');
            $pdf->Cell(50, 8, $a->nm_admin, 1, 1, 'C');
        }
        $pdf->Output("laporana_data_admin","I");
    }
    
    function laporan_data_penggajian()
    {
        $data['tahun'] = $this->Model_laporan->ambil_data_penggajian();
        
        $this->template->load('Template','laporan_penggajian/view_form_laporan',$data);
    }
    
    function cari_bulan()
    {
        $thnn = $_GET['tahun'];
        $tagl = $this->Model_laporan->ambil_data_bulan($thnn)->result();
        
        echo "<td>Bulan";
        echo "<div><select class='form-control' id='idbln'>";
            foreach ($tagl as $t)
            {
                echo "<option value='". substr($t->tgl, 5,2)."'>". get_bulan(substr($t->tgl, 5,2))."</option>";
            }
        echo "</select></div></td>";
    }
    
    function laporan_per_bulan()
    {
        
        $parameter  = $_GET['thn']."-".$_GET['bln'];
        $data       = $this->Model_laporan->ambil_data_perbulan($parameter)->result();
        
        $tot_pendapatan = 0;
        $tot_potongan   = 0;
        $tot_gjbersih   = 0;
        foreach ($data as $d)
        {
            echo "<tr>"
                    . "<td>$d->no_slip</td>"
                    . "<td>". tgl_indo($d->tgl)."</td>"
                    . "<td>$d->nip</td>"
                    . "<td>$d->pendapatan</td>"
                    . "<td>$d->potongan</td>"
                    . "<td>$d->gaji_bersih</td>"
                    . "<td><a href='".site_url('laporan/laporan_detil_perorang/')."$parameter/$d->no_slip' class='btn btn-info btn-sm'>"
                        . "<i class='fa fa-print'></i> PRINT</a></td>"
                    . "</tr>";
            $tot_pendapatan = $d->pendapatan+$tot_pendapatan;
            $tot_potongan   = $d->potongan+$tot_potongan;
            $tot_gjbersih   = $d->gaji_bersih+$tot_gjbersih;
        }
        echo "<tr>"
                . "<td colspan='3'><label>Total</label></td>"
                . "<td><label>$tot_pendapatan</label></td>"
                . "<td><label>$tot_potongan</label></td>"
                . "<td><label>$tot_gjbersih</label></td>"
                . "<td><a href='".site_url('laporan/laporan_detil_perbulan/')."$parameter' class='btn btn-primary btn-sm'>"
                    . "<i class='glyphicon glyphicon-print'></i> Print /bulan</a></td>"
                . "</tr>";
    }
    
    function laporan_detil_perorang()
    {
        $thn        = $this->uri->segment(3);
        $no_slip    = $this->uri->segment(4);
        
        $pdf = new FPDF("P","mm","A4");
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(195,0,"LAPORAN PENGGAJIAN",0,0,'L');
        $pdf->Line(10,15,200,15);
        $pdf->SetLineWidth(1);
        $pdf->Line(10, 16, 200, 16);
        $pdf->SetLineWidth(0);
        $pdf->Ln(10);
        
        
        $pdf->SetFont('Arial','B',10);
        $pdf->Ln(10);
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(40,8,"BULAN",0,0);
        $pdf->Cell(40,8, get_bulan(substr($thn, 5,2)),0,1);
        $pdf->Cell(40,8,"TAHUN",0,0);
        $pdf->Cell(40,8, substr($thn, 0,4),0,1);
        $pdf->Ln(6);
        
        
        
        $pdf->SetFont('Times','','12');
        $pdf->Cell(40,8,"No. Slip",0,0);
        $pdf->Cell(40,8,$no_slip,0,1);
        
        $data = $this->Model_laporan->ambil_data_detil_pertahun($no_slip,$thn)->row_array();
        $pdf->Cell(40,8,"Tanggal",0,0);
        $pdf->Cell(40,8, tgl_indo($data['tgl']),0,1);
        $pdf->Cell(40,8,"Nip",0,0);
        $pdf->Cell(40,8,$data['nip'],0,1);
        $pdf->Cell(40,8,"Nama Pegawai",0,0);
        $pdf->Cell(40,8,$data['nm_pegawai'],0,1);
        $pdf->Cell(40,8,"Pendapatan",0,0);
        $pdf->Cell(40,8,$data['pendapatan'],0,1);
        $pdf->Ln(3);
        //$pdf->Cell($w, $h, $txt, $border, $ln, $align)
        
        $pdf->SetFont('Times','B',12);
        $pdf->Cell(10, 8, 'NO', 1, 0, 'C');
        $pdf->Cell(50, 8, 'Nama Potongan', 1, 0, 'C');
        $pdf->Cell(40, 8, 'Jumlah', 1, 1, 'C');
        
        
        
        $pdf->SetFont('Times','','12');
        $no = 1;
        $total_potongan = 0;
        $potongan = $this->Model_laporan->tampil_potongan($no_slip)->result();
        foreach ($potongan as $p)
        {
            $pdf->Cell(10, 8, $no++, 1, 0, 'C');
            $pdf->Cell(50, 8, $p->nm_potongan, 1, 0, 'L');
            $pdf->Cell(40, 8, $p->jml_potongan, 1, 1, 'C');
            $total_potongan = $total_potongan + $p->jml_potongan;
        }
        $gaji_bersih = $data['pendapatan'] - $total_potongan;
        $pdf->Ln(3);
        
        $pdf->SetFont('Times','B',12);
        $pdf->Cell(60, 8, 'Total Potongan', 0, 0, 'R');
        $pdf->SetFont('Times','',12);
        $pdf->Cell(40, 8, $total_potongan, 0, 1, 'R');
        $pdf->SetFont('Times','B',12);
        $pdf->Cell(60, 8, 'Gaji Bersih', 0, 0, 'R');
        $pdf->SetFont('Times','',12);
        $pdf->Cell(40, 8, $gaji_bersih, 0, 1, 'R');
        $pdf->Output("Slip Gaji.pdf","I");
    }
    
    function laporan_detil_perbulan()
    {
        $pmt = $this->uri->segment(3);
        $pdf = new FPDF("P","mm","A4");
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(195,0.5,"LAPORAN DATA PENGGAJIAN",0,0.7,'C');
        $pdf->Line(10,15,200,15);
        $pdf->SetLineWidth(1);
        $pdf->Line(10, 16, 200, 16);
        $pdf->SetLineWidth(0);
        $pdf->Ln(15);


        //$pdf->Cell($w, $h, $txt, $border, $ln, $align);
        //$pdf->Line($x1, $y1, $x2, $y2);
        $pdf->SetFont('Times','',12);
        $pdf->Cell(22, 8,'Periode :', 0, 0, 'L');
        $pdf->Cell(15, 8, get_bulan(substr($pmt, 5,2)), 0, 0, 'L');
        $pdf->Cell(25, 8,tgl_indo(substr($pmt, 0,4)), 0, 1,'L');
        //$pdf->Ln(8);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(20, 8, 'No. Slip', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Tanggal', 1, 0, 'C');
        $pdf->Cell(25, 8, 'Nip', 1, 0, 'C');
        $pdf->Cell(35, 8, 'Nama Pegawai', 1, 0, 'C');
        $pdf->Cell(25, 8, 'Pendapatan', 1, 0, 'C');
        $pdf->Cell(25, 8, 'Potongan', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Gaji Bersih', 1, 1, 'C');
        
        $pdf->SetFont('Times','','10');
        
        $t_pendapatan = 0;
        $t_potongan   = 0;
        $t_gjbersih   = 0;
        $gaji = $this->Model_laporan->data_penggajian($pmt);
        foreach ($gaji->result() as $b)
        {
            $pdf->Cell(20, 8, $b->no_slip, 1, 0, 'C');
            $pdf->Cell(30, 8, tgl_indo($b->tgl), 1, 0, 'C');
            $pdf->Cell(25, 8, $b->nip, 1, 0, 'C');
            $pdf->Cell(35, 8, $b->nm_pegawai, 1, 0, 'C');
            $pdf->Cell(25, 8, $b->pendapatan, 1, 0, 'C');
            $pdf->Cell(25, 8, $b->potongan, 1, 0, 'C');
            $pdf->Cell(30, 8, $b->gaji_bersih, 1, 1, 'C');
            $t_pendapatan = $b->pendapatan+$t_pendapatan;
            $t_potongan   = $b->potongan+$t_potongan;
            $t_gjbersih   = $b->gaji_bersih+$t_gjbersih;
        }
        $pdf->SetFont('Times','B',10);
        $pdf->Cell(110, 8, 'Total', 0, 0, 'C');
        $pdf->Cell(25, 8, $t_pendapatan, 0, 0, 'C');
        $pdf->Cell(25, 8, $t_potongan, 0, 0, 'C');
        $pdf->Cell(30, 8, $t_gjbersih, 0, 1, 'C');
        $pdf->Output("laporan_data_golongan.pdf","I");
    }
}

<?php
Class Model_laporan extends CI_Model{
    
    function ambil_data_golongan()
    {
        $this->db->select('*');
        $this->db->from('golongan');
        $this->db->order_by('id_golongan','DESC');
        $sql = $this->db->get();
        return $sql;
    }
    
    function ambil_data_jabatan()
    {
        return $this->db->get('jabatan');
    }
    
    function ambil_data_potongan()
    {
        $this->db->select('*');
        $this->db->from('potongan');
        $this->db->order_by('id_potongan','ASC');
        $sql = $this->db->get();
        return $sql;
    }
    
    function ambil_data_petugas()
    {
        return $this->db->get('admin');
    }
    
    function ambil_data_penggajian()
    {
        $sql = $this->db->query("SELECT tgl FROM gaji GROUP BY LEFT(tgl ,4)")->result();
        return $sql;
    }
    
    function ambil_data_bulan($thn)
    {
        $sql = $this->db->query("SELECT tgl FROM gaji WHERE SUBSTR(tgl,1,4)='".$thn."' GROUP BY SUBSTRING(tgl,6,2)");
        return $sql;
    }
    
    function ambil_data_perbulan($parameter)
    {
        $sql = $this->db->query("SELECT * FROM gaji WHERE SUBSTRING(tgl,1,7)='$parameter'");
        return $sql;
    }
    
    function ambil_data_detil_pertahun($no_slip,$thn)
    {
        $ambil_nip  = $this->db->query('SELECT * FROM gaji WHERE no_slip='.$no_slip)->row_array();
        $nip        = $ambil_nip['nip'];
        
        $query      = "SELECT * FROM gaji AS g JOIN pegawai AS p ON p.nip=g.nip
                       WHERE SUBSTRING(tgl,1,7)='$thn' AND no_slip='$no_slip' AND g.nip='$nip'";
        $sql        = $this->db->query($query);
        return $sql;
    }
    
    function tampil_potongan($no_slip)
    {
        $this->db->select('*');
        $this->db->from('potongan as pt');
        $this->db->join('detil_gaji as dg','pt.id_potongan=dg.id_potongan');
        $this->db->where('dg.no_slip',$no_slip);
        $sql = $this->db->get();
        return $sql;
    }
    
    function data_penggajian($pmt)
    {
        $this->db->select("*");
        $this->db->from("gaji as g");
        $this->db->join("pegawai as pg","g.nip=pg.nip");
        $this->db->where("SUBSTRING(g.tgl,1,7)='$pmt'");
        $sql = $this->db->get();
        return $sql;
    }
}

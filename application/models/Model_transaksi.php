<?php

Class Model_transaksi extends CI_Model{
    
    
    function tampil_data_tabel($table)
    {
        $sql = $this->db->get($table);
        return $sql;
    }
    
    function get_gaji($id)
    {
        //SELECT * FROM gaji WHERE SUBSTRING(tgl,1,7)=DATE_FORMAT(now(), '%Y-%m')
        
        $sql = $this->db->query("SELECT * FROM gaji WHERE SUBSTRING(tgl,1,7)=DATE_FORMAT(now(), '%Y-%m') AND nip=".$id);
        return $sql;
    }
    
    function get_tanggal()
    {
        $sql = $this->db->query("SELECT DATE_FORMAT(now(), '%Y-%m-%d') as tanggal");
        return $sql;
    }
    
    function get_detail_pegawai($id)
    {
        $this->db->select('*');
        $this->db->from('pegawai as pg');
        $this->db->join('jabatan as jb','pg.kd_jabatan=jb.kd_jabatan');
        $this->db->join('golongan as gl','gl.id_golongan=pg.id_golongan');
        $this->db->where('nip',$id);
        $sql = $this->db->get();
        return $sql;
    }
    
    function insert_to_table($tbl,$data)
    {
        $sql = $this->db->insert($tbl,$data);
        return $sql;
    }
    
    
    
    function tampil_potongan($nip,$nos)
    {
        //$param = $this->get_gaji($nip)->row_array();
        $this->db->select('*');
        $this->db->from('potongan as pt');
        $this->db->join('detil_gaji as dg','pt.id_potongan=dg.id_potongan');
        $this->db->join('pegawai as p','p.nip=dg.nip');
        $this->db->where('p.nip',$nip);
        $this->db->where('dg.no_slip',$nos);
        $sql = $this->db->get();
        return $sql;
    }
    
    function hapus_potongan($idpot)
    {
        $this->db->where('id_detil_gaji',$idpot);
        $this->db->delete('detil_gaji');
    }
    
    function total_potongan($idnip)
    {
        $this->db->select_sum('jml_potongan');
        $this->db->from('detil_gaji');
        $this->db->where('nip',$idnip);
        $query = $this->db->get();
        return $query;
    }
}
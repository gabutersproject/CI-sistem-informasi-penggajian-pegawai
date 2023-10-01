<?php


Class Model_pegawai extends CI_Model{
  
    function tampilkan_pegawai()
    {
        $this->db->select('*');
        $this->db->from('pegawai as pg');
        $this->db->join('jabatan as jb','pg.kd_jabatan=jb.kd_jabatan');
        $this->db->join('golongan as gl','gl.id_golongan=pg.id_golongan');
        $sql = $this->db->get();
        return $sql;
    }
    
    function tampil_isi_tabel($table)
    {
        $sql = $this->db->get($table);
        return $sql;
    }
    
    function get_row_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('pegawai as pg');
        $this->db->join('jabatan as jb','pg.kd_jabatan=jb.kd_jabatan');
        $this->db->join('golongan as gl','gl.id_golongan=pg.id_golongan');
        $this->db->where('id_pegawai',$id);
        $sql = $this->db->get();
        return $sql;
    }
}
<?php

Class Model_utama extends CI_Model
{
    
    private $table;
    private $id_table;
            
    function set_table($tbl)
    {
        $this->table = $tbl;
    }
    
    function get_table()
    {
        return $this->table;
    }
    
    function set_id_table($id_tbl)
    {
        $this->id_table = $id_tbl;
    }
    
    function get_id_table()
    {
        return $this->id_table;
    }
    
    function to_show_table()
    {
        $sql = $this->db->get($this->get_table());
        return $sql;
    }
    
    function get_row_by_id($id)
    {
        $sql = $this->db->get_where($this->table,array($this->id_table => $id));
        return $sql;
    }
    
    function insert_to_table($data)
    {
        $sql = $this->db->insert($this->get_table(),$data);
        return $sql;
    }
    
    function to_update($data,$id)
    {
        $this->db->where($this->get_id_table(), $id);
        $this->db->update($this->get_table(), $data);
    }
    
    function to_delete($id)
    {
        $this->db->where($this->get_id_table(), $id);
        $this->db->delete($this->get_table());
    }
}
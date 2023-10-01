<?php

Class Model_dashboard extends CI_Model{
    
    
    function nm_jabatan()
    {
        $this->db->select('*');
        $this->db->from('jabatan');
        $sql = $this->db->get();
        return $sql;
    }
}

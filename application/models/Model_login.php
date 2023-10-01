<?php

Class Model_login extends CI_Model{
    
    function get_users($username, $pass)
    {
        $this->db->where('username',$username);
        $this->db->where('password',sha1($pass));
        $sql = $this->db->get('admin');
        return $sql;
    }
}
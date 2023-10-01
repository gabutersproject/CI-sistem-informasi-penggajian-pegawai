<?php

Class Dashboard extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        harus_login();
        $this->load->model('Model_dashboard');
    }


    public function index()
    {
        $data['jabatan']  = $this->Model_dashboard->nm_jabatan();
        $data ['jml_jbt'] = $this->Model_dashboard->nm_jabatan()->num_rows();
        $this->load->view('dashboard',$data);
    }
    
}

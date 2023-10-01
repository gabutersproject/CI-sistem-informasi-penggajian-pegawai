<?php

Class Auth extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('Model_login');
        
    }
    
    function index()
    {
        harus_logout();
        $this->load->view('login');
    }
    
    function login() {
        //memberi validasi pada username dan password
        harus_logout();
        $this->form_validation->set_rules('username', '', 'required',
               array(
                   'required' => '<div class="alert alert-danger text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                  Username tidak boleh kosong</div>'));
        $this->form_validation->set_rules('password', '', 'required',
               array(
                   'required' => '<div class="alert alert-danger text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                  Password tidak boleh kosong</div>'));

        $username = $this->input->post('username',TRUE);
        $pass     = $this->input->post('password',TRUE);

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('login');
        } else {
            $cek = $this->Model_login->get_users($username, $pass);
            if ($cek->num_rows() !== 0) {
                $this->session->set_userdata(array('username'=>$username,'status'=>'login'));
                redirect('Dashboard');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-info text-center">Tidak bisa login username atau password salah</div>');
                $this->load->view('login');
            }
        }
    }
    
    function logout()
    {
        $this->session->sess_destroy();
        redirect('Auth');
    }

}


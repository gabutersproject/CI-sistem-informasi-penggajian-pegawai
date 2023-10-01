<?php

Class Potongan extends CI_Controller{
    
    
    function __construct() {
        parent::__construct();
        $this->load->model('Model_utama');
        $this->Model_utama->set_table('potongan');
        $this->Model_utama->get_table();
        $this->Model_utama->set_id_table('id_potongan');
        $this->Model_utama->get_id_table();
        harus_login();
    }
    
    function index()
    {
        $data['potongan'] = $this->Model_utama->to_show_table();
        $this->template->load('Template','potongan/view_potongan',$data);
    }
    
    function add_potongan()
    {
        if(isset($_POST['submit']))
        {
            $this->form_validation->set_rules('kd_potongan', '', 'required', array('required' => 'Kode Potongan tidak boleh kosong'));
            $this->form_validation->set_rules('nm_potongan', '', 'required', array('required' => 'Nama Potongan tidak boleh kosong'));
            
            if ($this->form_validation->run() == FALSE) {
                $this->template->load('Template', 'potongan/form_add_potongan');
            }
            else
            {
                $kd_potongan = $this->input->post('kd_potongan');
                $nm_potongan = $this->input->post('nm_potongan');
                $data = array(
                               'kd_potongan' => $kd_potongan,
                               'nm_potongan' => $nm_potongan
                );
                $this->Model_utama->insert_to_table($data);
                redirect('potongan');
            }
        }
        else
        {
            $this->template->load('Template','potongan/form_add_potongan');
        }
    }
    
    function edit_potongan()
    {
        if(isset($_POST['submit']))
        {
            $kd_potongan = $this->input->post('kd_potongan');
            $nm_potongan = $this->input->post('nm_potongan');
            $id_potongan = $this->input->post('id_potongan');
            $data = array(
                           'kd_potongan' => $kd_potongan,
                           'nm_potongan' => $nm_potongan
            );
            $this->Model_utama->to_update($data,$id_potongan);
            redirect('potongan');
        }
        else
        {
            $id = $this->uri->segment(3);
            $data['pot'] = $this->Model_utama->get_row_by_id($id)->row_array();
            $this->template->load('Template', 'potongan/form_edit_potongan', $data);
        }
    }
    
    function hapus_potongan()
    {
        $id = $this->uri->segment(3);
        $this->Model_utama->to_delete($id);
        redirect('potongan');
    }
}

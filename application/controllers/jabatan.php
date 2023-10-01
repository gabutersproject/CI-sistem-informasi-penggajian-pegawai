<?php

Class Jabatan extends CI_Controller{
    
    
    function __construct() {
        parent::__construct();
        $this->load->model('Model_utama');
        $this->Model_utama->set_table('jabatan');
        $this->Model_utama->get_table();
        $this->Model_utama->set_id_table('kd_jabatan');
        $this->Model_utama->get_id_table();
        harus_login();
    }
    
    function index()
    {
        $data['jabatan'] = $this->Model_utama->to_show_table();
        $this->template->load('Template','jabatan/view_jabatan',$data);
    }
    
    function add_jabatan()
    {
        $this->template->load('Template','jabatan/form_add_jabatan');
    }
    
    function simpan_jabatan()
    {
        $this->form_validation->set_rules('kd_jabatan', '', 'required', array('required' => 'Kode Jabatan tidak boleh kosong'));
        $this->form_validation->set_rules('nm_jabatan', '', 'required', array('required' => 'Nama Jabatan tidak boleh kosong'));
        $this->form_validation->set_rules('gapok', '', 'required', array('required' => 'Gaji Pokok tidak boleh kosong'));
        $this->form_validation->set_rules('tj_jabatan', '', 'required', array('required' => 'Tunjangan Jabatan tidak boleh kosong'));
        
        if($this->form_validation->run() == FALSE)
        {
            $this->template->load('Template','jabatan/form_add_jabatan');
        }
        else
        {
            $kd_jabatan = $this->input->post('kd_jabatan');
            $gapok      = $this->input->post('gapok');
            $nm_jabatan = $this->input->post('nm_jabatan');
            $tj_jabatan = $this->input->post('tj_jabatan');

            $data       = array(
                                'kd_jabatan' => $kd_jabatan,
                                'nm_jabatan' => $nm_jabatan,
                                'gapok'      => $gapok,
                                'tj_jabatan' => $tj_jabatan
            );
            $this->Model_utama->insert_to_table($data);
            redirect('jabatan');
        }
    }
    
    function edit_jabatan()
    {
        $id = $this->uri->segment(3);
        $data['gol'] = $this->Model_utama->get_row_by_id($id)->row_array();
        $this->template->load('Template','jabatan/form_edit_jabatan',$data);
    }
    
    function update_jabatan()
    {
        $kd_jabatan = $this->input->post('kd_jabatan');
        $gapok      = $this->input->post('gapok');
        $nm_jabatan = $this->input->post('nm_jabatan');
        $tj_jabatan = $this->input->post('tj_jabatan');
        $id         = $this->input->post('kode');
        
        $data       = array(
                            'kd_jabatan' => $kd_jabatan,
                            'nm_jabatan' => $nm_jabatan,
                            'gapok'      => $gapok,
                            'tj_jabatan' => $tj_jabatan
        );
        $this->Model_utama->to_update($data,$id);
        redirect('jabatan');
    }
    
    function hapus_jabatan()
    {
        $this->Model_utama->to_delete($this->uri->segment(3));
        redirect('jabatan');
    }
}

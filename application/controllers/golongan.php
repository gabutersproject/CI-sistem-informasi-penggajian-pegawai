<?php

Class Golongan extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('Model_utama');
        $this->Model_utama->set_table('golongan');
        $this->Model_utama->get_table();
        $this->Model_utama->set_id_table('id_golongan');
        $this->Model_utama->get_id_table();
        $this->load->library('form_validation');
        harus_login();
    }
    
    function index()
    {
        $data['golongan'] = $this->Model_utama->to_show_table(); 
        $this->template->load('Template','golongan/view_golongan',$data);
    }
    
    function add_golongan()
    {
        $this->template->load('Template','golongan/form_add_golongan');
    }
    
    function simpan_golongan()
    {
        $this->form_validation->set_rules('golongan', '', 'required', array('required' => 'Golongan tidak boleh kosong'));
        $this->form_validation->set_rules('tj_sutri', '', 'required', array('required' => 'Tunjangan suami istri tidak boleh kosong'));
        $this->form_validation->set_rules('tj_anak', '', 'required', array('required' => 'Tunjangan Anak tidak boleh kosong'));
        $this->form_validation->set_rules('uang_makan', '', 'required', array('required' => 'Uang Makan tidak boleh kosong'));
        $this->form_validation->set_rules('uang_lembur', '', 'required', array('required' => 'Uang Lembur tidak boleh kosong'));
        $this->form_validation->set_rules('askes', '', 'required', array('required' => 'Askes tidak boleh kosong'));
        if($this->form_validation->run() == FALSE)
        {
            $this->template->load('Template','golongan/form_add_golongan');
        }
        else
        {
            $golongan = $this->input->post('golongan');
            $tj_sutri = $this->input->post('tj_sutri');
            $tj_anak  = $this->input->post('tj_anak');
            $u_makan  = $this->input->post('uang_makan');
            $u_lembur = $this->input->post('uang_lembur');
            $askes    = $this->input->post('askes');
            $data     = array(
                        'golongan'          => $golongan,
                        'tj_suami_istri'    => $tj_sutri,
                        'tj_anak'           => $tj_anak,
                        'uang_makan'        => $u_makan,
                        'uang_lembur'       => $u_lembur,
                        'askes'             => $askes
            );
            $cek = $this->Model_utama->insert_to_table($data);
            if($cek)
            {
                $pesan =  'Data berhasil disimpan';
                redirect('golongan?pesan='.$pesan);
            }
        }
    }
    
    function edit_golongan()
    {
        $id             = $this->uri->segment(3);
        $data['gol']    = $this->Model_utama->get_row_by_id($id)->row_array();
        $this->template->load('Template','golongan/form_edit_golongan',$data);
    }
    
    function hapus_golongan()
    {
        $id = $this->uri->segment(3);
        $this->Model_utama->to_delete($id);
        redirect('golongan');
    }
    
    function update_golongan()
    {
        $id_gol     = $this->input->post('id_golongan');
        $golongan   = $this->input->post('golongan');
        $tj_sutri   = $this->input->post('tj_sutri');
        $tj_anak    = $this->input->post('tj_anak');
        $u_makan    = $this->input->post('uang_makan');
        $u_lembur   = $this->input->post('uang_lembur');
        $askes      = $this->input->post('askes');
        $data       = array(
                      'golongan'        => $golongan,
                      'tj_suami_istri'  => $tj_sutri,
                      'tj_anak'         => $tj_anak,
                      'uang_makan'      => $u_makan,
                      'uang_lembur'     => $u_lembur,
                      'askes'           => $askes
        );
        
        $this->Model_utama->to_update($data,$id_gol);
        redirect('golongan');
    }
}
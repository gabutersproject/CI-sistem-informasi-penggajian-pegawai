<?php

Class Petugas extends CI_Controller
{
    function __construct() 
    {
        parent::__construct();
        $this->load->model('Model_utama');
        $this->Model_utama->set_table('admin');
        $this->Model_utama->get_table();
        $this->Model_utama->set_id_table('id_admin');
        $this->Model_utama->get_id_table();
        harus_login();
    }
    
    function index()
    {
        $data['petugas'] = $this->Model_utama->to_show_table(); 
        $this->template->load('Template','petugas/view_petugas',$data);
    }
    function add_petugas()
    {
        $this->template->load('Template','petugas/add_petugas');
    }
    
    function simpan_add()
    {
        $config['upload_path']          = 'uploads/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 2048; //set max size allowed in Kilobyte
        $config['max_width']            = 1024; // set max width image allowed
        $config['max_height']           = 1000; // set max height allowed
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

        $this->load->library('upload', $config);
        if (!empty($_FILES['foto']['name'])) {
            if (!$this->upload->do_upload('foto')) { //upload and validate
                $error = array('error' => $this->upload->display_errors());
                $this->template->load('Template', 'petugas/add_petugas', $error);
            }
            else
            {
                $kd_petugas = kode_admin();
                $nm_petugas = $this->input->post('nm_petugas');
                $username   = $this->input->post('username');
                $password   = $this->input->post('password');

                $data = array(
                    'kd_admin' => $kd_petugas,
                    'nm_admin' => $nm_petugas,
                    'username' => $username,
                    'password' => sha1($password),
                    'photo'    => $this->upload->data('file_name')
                );
                $this->Model_utama->insert_to_table($data);
                redirect('petugas');
            }
        }
        else
        {
            $kd_petugas = kode_admin();
            $nm_petugas = $this->input->post('nm_petugas');
            $username   = $this->input->post('username');
            $password   = $this->input->post('password');

            $data = array(
                'kd_admin' => $kd_petugas,
                'nm_admin' => $nm_petugas,
                'username' => $username,
                'password' => sha1($password)
            );
            $this->Model_utama->insert_to_table($data);
            redirect('petugas');
        }
    }
    
    function edit_petugas()
    {
        $id             = $this->uri->segment(3);
        $data['p_edit'] = $this->Model_utama->get_row_by_id($id)->row_array();
        return $this->template->load('Template','petugas/edit_petugas',$data);
    }
    function simpan_edit()
    {
        
        $config['upload_path']          = 'uploads/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 2048; //set max size allowed in Kilobyte
        $config['max_width']            = 1024; // set max width image allowed
        $config['max_height']           = 1000; // set max height allowed
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

        
        //$id         = $this->uri->segment(3);
        $nm_petugas = $this->input->post('nm_petugas');
        $username   = $this->input->post('username');
        $password   = $this->input->post('password');
        $id_admin   = $this->input->post('id');
        
        
        $this->load->library('upload', $config);
        if(!empty($_FILES['foto']['name']) && !empty($this->input->post('password')))
        {
            if (!$this->upload->do_upload('foto')) { //upload and validate
                $error  = array('error' => $this->upload->display_errors());
                $this->template->load('Template', 'petugas/form_error', $error);
            }
            else
            {
                
                $data = array(
                    'nm_admin' => $nm_petugas,
                    'username' => $username,
                    'password' => sha1($password),
                    'photo'    => $this->upload->data('file_name')
                );
                $person = $this->Model_utama->get_row_by_id($id_admin)->row_array();
                unlink('uploads/' . $person['photo']);
                $this->Model_utama->to_update($data,$id_admin);
                redirect('petugas');
            }
        }
        else if(!empty($_FILES['foto']['name']) && empty($this->input->post('password')))
        {
            if (!$this->upload->do_upload('foto')) { //upload and validate
                $error  = array('error' => $this->upload->display_errors());
                $this->template->load('Template', 'petugas/form_error', $error);
            }
            else
            {   
                $data = array(
                    'nm_admin' => $nm_petugas,
                    'username' => $username,
                    'photo'    => $this->upload->data('file_name')
                );
                $person = $this->Model_utama->get_row_by_id($id_admin)->row_array();
                unlink('uploads/' . $person['photo']);
                $this->Model_utama->to_update($data,$id_admin);
                redirect('petugas');
            }
        }
        else if(empty($_FILES['foto']['name']) && !empty($this->input->post('password')))
        {
            $data = array(
                'nm_admin' => $nm_petugas,
                'username' => $username,
                'password' => sha1($password)
            );
            $this->Model_utama->to_update($data,$id_admin);
            redirect('petugas');
        }
        else if(empty($_FILES['foto']['name']) && empty($this->input->post('password')))
        {

            $data = array(
                'nm_admin' => $nm_petugas,
                'username' => $username
            );
            $this->Model_utama->to_update($data,$id_admin);
            redirect('petugas');
        }
    }
    
    function hapus_petugas()
    {
        $id     = $this->uri->segment(3);
        $person = $this->Model_utama->get_row_by_id($id)->row_array();
        
        unlink('uploads/'.$person['photo']); 
        $this->Model_utama->to_delete($id);
        redirect('petugas');
    }
    
    function info_petugas()
    {
        $id     = $_GET['idptg'];
        $pgw    = $this->Model_utama->get_row_by_id($id)->row_array();
        
        echo '<div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" aria-hidden="true" type="button">x</button>
                        <h4 class="title" id="myModalLabel">Profile Petugas</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered table-responsive" width="50%">
                            <tr class="text-center">
                                <td>';
                                    if($pgw['photo'])
                                    {
                                        echo "<img src='" . base_url('uploads/' . $pgw['photo']) . "' class='img-circle img-bordered' style='width : 200px; height: 200px;'>";
                                    } else {
                                        echo "<img src='" . base_url('uploads/no_user.jpg') . "' class='img-circle img-bordered' style='width : 200px; height: 200px;'>";
                                    }
                           echo '</td>
                            </tr>
                            <tr>
                                <td>
                                    <table width="100%" class="table table-bordered table-striped">
                                        <tr>
                                            <td width="200"><label>Kode Petugas</label></td>
                                            <td><label>'.$pgw['kd_admin'].'</label></td>
                                        </tr>
                                        <tr>
                                            <td><label>Nama</label></td>
                                            <td><label>'.$pgw['nm_admin'].'</label></td>
                                        </tr>
                                        <tr>
                                            <td><label>Username</label></td>
                                            <td><label>'.$pgw['username'].'</label></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" aria-hidden="true" data-dismiss="modal" class="btn btn-danger" >Tutup</button>
                    </div>
                </div>
            </div>';
    }
}

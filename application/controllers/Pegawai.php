<?php

Class Pegawai extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('Model_pegawai','Model_utama'));
        $this->Model_utama->set_table('pegawai');
        $this->Model_utama->get_table();
        $this->Model_utama->set_id_table('id_pegawai');
        $this->Model_utama->get_id_table();
        harus_login();
        
    }
    
    function index()
    {
        $data['pegawai'] = $this->Model_pegawai->tampilkan_pegawai();
        $this->template->load('Template','pegawai/view_pegawai',$data);
    }
    
    function add_pegawai()
    {
        if(isset($_POST['submit']))
        {
            $this->form_validation->set_rules('golongan', '', 'required', array('required' => 'Silahkan Pilih golongan dahulu'));
            $this->form_validation->set_rules('nip', '', 'required', array('required' => 'Nip istri tidak boleh kosong'));
            $this->form_validation->set_rules('sts_nikah', '', 'required', array('required' => 'Silahkan Pilih status nikah dahulu'));
            $this->form_validation->set_rules('jabatan', '', 'required', array('required' => 'Silahkan Pilih Kode Jabatan dahulu'));
            $this->form_validation->set_rules('nm_pegawai', '', 'required', array('required' => 'Nama pegawai tidak boleh kosong'));
            $this->form_validation->set_rules('jml_anak', '', 'required', array('required' => 'Jumlah anak tidak boleh kosong'));
            if ($this->form_validation->run() == FALSE) {
                $data['golongan'] = $this->Model_pegawai->tampil_isi_tabel('golongan')->result();
                $data['jabatan']  = $this->Model_pegawai->tampil_isi_tabel('jabatan')->result();
                $this->template->load('Template', 'pegawai/form_add_pegawai',$data);
            }
            else 
            {
                $nip            = $this->input->post('nip');
                $kd_golongan    = $this->input->post('golongan');
                $nm_pegawai     = $this->input->post('nm_pegawai');
                $sts_nikah      = $this->input->post('sts_nikah');
                $kd_jabatan     = $this->input->post('jabatan');
                $jml_anak       = $this->input->post('jml_anak');
                $data           = array(
                                  'nip'          => $nip,
                                  'nm_pegawai'   => $nm_pegawai,
                                  'kd_jabatan'   => $kd_jabatan,
                                  'id_golongan'  => $kd_golongan,
                                  'status_nikah' => $sts_nikah,
                                  'jml_anak'     => $jml_anak
                );
                $this->Model_utama->insert_to_table($data);
                redirect('pegawai');
            }
        }
        else
        {
            $data['golongan'] = $this->Model_pegawai->tampil_isi_tabel('golongan')->result();
            $data['jabatan']  = $this->Model_pegawai->tampil_isi_tabel('jabatan')->result();
            $this->template->load('Template', 'pegawai/form_add_pegawai', $data);
        }
    }
    
    function edit_pegawai()
    {
        if(isset($_POST['submit']))
        {
            $nip            = $this->input->post('nip');
            $kd_golongan    = $this->input->post('golongan');
            $nm_pegawai     = $this->input->post('nm_pegawai');
            $sts_nikah      = $this->input->post('sts_nikah');
            $kd_jabatan     = $this->input->post('jabatan');
            $jml_anak       = $this->input->post('jml_anak');
            $id_pegawai     = $this->input->post('id');
            $data           = array(
                              'nip'          => $nip,
                              'nm_pegawai'   => $nm_pegawai,
                              'kd_jabatan'   => $kd_jabatan,
                              'id_golongan'  => $kd_golongan,
                              'status_nikah' => $sts_nikah,
                              'jml_anak'     => $jml_anak
            );
            $this->Model_utama->to_update($data,$id_pegawai);
            redirect('pegawai');
        }
        else
        {
            $id = $this->uri->segment(3);
            $data['golongan'] = $this->Model_pegawai->tampil_isi_tabel('golongan')->result();
            $data['jabatan']  = $this->Model_pegawai->tampil_isi_tabel('jabatan')->result();
            $data['pgw']      = $this->Model_pegawai->get_row_by_id($id)->row_array();
            $this->template->load('Template','pegawai/form_edit_pegawai',$data);
        }
    }
    
    function hapus_pegawai()
    {
        $id = $this->uri->segment(3);
        $this->Model_utama->to_delete($id);
        redirect('pegawai');
    }
    
    function info_pegawai()
    {
        $id     = $_GET['idpgw'];
        $pgw    = $this->Model_pegawai->get_row_by_id($id)->row_array();
        
        echo '<div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" aria-hidden="true" type="button">x</button>
                        <h4 class="title" id="myModalLabel">Profile Karyawan</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered table-responsive" width="50%">
                            <tr>
                                <td>
                                    <table width="100%" class="table table-bordered table-striped">
                                        <tr>
                                            <td>NIP</td>
                                            <td>'.$pgw['nip'].'</td>
                                        </tr>
                                        <tr>
                                            <td>Nama</td>
                                            <td>'.$pgw['nm_pegawai'].'</td>
                                        </tr>
                                        <tr>
                                            <td>Jabatan</td>
                                            <td>'.$pgw['nm_jabatan'].'</td>
                                        </tr>
                                        <tr>
                                            <td>Golongan</td>
                                            <td>'.$pgw['golongan'].'</td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td>';
                                            if($pgw['status_nikah'] == 1)
                                            {
                                                echo "Menikah";
                                            }
                                            else if($pgw['status_nikah'] == 2)
                                            {
                                                echo "Belum Menikah";
                                            }
                                            else if($pgw['status_nikah'] == 3)
                                            {
                                                echo "Duda";
                                            }
                                            else if($pgw['status_nikah'] == 4)
                                            {
                                                echo "Janda";
                                            }
                                        echo '</td>
                                        </tr>
                                        <tr>
                                            <td>Jumlah Anak</td>
                                            <td>';
                                                if($pgw['jml_anak'] == 0 or $pgw['jml_anak'] == "")
                                                {
                                                    echo $pgw['jml_anak'] == "-";
                                                }
                                                else
                                                {
                                                    echo $pgw['jml_anak'];
                                                }
                                        echo '</td>
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
<?php

Class Transaksi_penggajian extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('Model_transaksi','Model_pegawai'));
        harus_login();
    }
    
    function index()
    {
        $data['pegawai']    = $this->Model_transaksi->tampil_data_tabel('pegawai');
        $this->template->load('Template','transaksi_penggajian/view_transaksi_penggajian',$data);
    }
    
    function tampil_load_data()
    {
        echo '<tr>
                    <td><label>Nomor</label></td>
                    <td>
                        <input type="text" 
                               disabled name="nomor" 
                               id="idslip" class="form-control" 
                               value="'.nomor_slip().'">
                    </td>
                    <td><label>Tanggal</label></td>
                    <td>
                        <input type="text" disabled id="idtanggal"
                               value="'. tgl_indo(date("Y-m-d")).'" 
                               name="tgl" class="form-control">
                    </td>
                    
                </tr>
                <tr>
                    <td><label>NIP</label></td>
                    <td colspan="2">
                        <input list="nip" id="idnip" name="nip" class="form-control">
                        
                    </td>
                    <td>
                        <a href="#" id="idpilih" class="btn btn-success btn-sm">Pilih</a>
                    </td>
                </tr>';
    }
    
    function tampil_detail()
    {
        $nip   = $_GET['nip'];
        $hasil = $this->Model_transaksi->get_gaji($nip)->num_rows(); // utk memeriksa karyawan yg belum gajian.
        //$total = $this->Model_transaksi->total_potongan($nip)->row_array();
        
        $get_detil = $this->Model_transaksi->get_tanggal()->row_array();
        if(substr($get_detil['tanggal'], 8,2) <= 20)
        {
            echo "<h4>Hari ini tanggal ". tgl_indo($get_detil['tanggal'])." dan belum waktunya gajian.</h4>";
        }
        else
        {
            if($hasil == 0)
            {
                $dt  = $this->Model_transaksi->get_detail_pegawai($nip)->row_array();
                if($dt['nip'] != $nip)
                {
                    echo "<h4>Tidak data karyawan dengan NIP ".$nip.".</h4>";
                }
                else
                {
                    echo "<form>";
                    echo '<table class="table table-bordered">
                    <tr>
                        <td><label>Nama Pegawai</label></td>
                        <td>
                            <input type="text" disabled class="form-control" name="nm_pegawai" value="' . $dt['nm_pegawai'] . '">
                        </td>
                        <td><label>Jabatan</label></td>
                        <td>
                            <input type="text" disabled class="form-control" name="jabatan" value="' . $dt['nm_jabatan'] . '">
                        </td>
                        <td><label>Golongan</label></td>
                        <td>
                            <input type="text" disabled name="golongan" value="' . $dt['golongan'] . '" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <td><label>Status Pernikahan</label></td>
                        <td>
                            <input type="text" disabled class="form-control" name="sts_nikah" value="';

                            if($dt['status_nikah'] == 1)
                            {
                                echo "Menikah";
                            }
                            else if($dt['status_nikah'] == 2)
                            {
                                echo "Belum Menikah";
                            }
                            else if($dt['status_nikah'] == 3)
                            {
                                echo "Duda";
                            }
                            else if($dt['status_nikah'] == 4)
                            {
                                echo "Janda";
                            }

                echo        '">
                        </td>
                        <td><label>Jumlah Anak</label></td>
                        <td>
                            <input type="text" disabled class="form-control" name="jml_anak" value="' . $dt['jml_anak'] . '">
                        </td>
                        <td>
                            <label>Tj.Suami/Istri</label>
                        </td>
                        <td>
                            <input type="text" disabled name="tj_sutri" id="idtjsutri" class="form-control" value="' . $dt['tj_suami_istri'] . '">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label>Gaji Pokok</label>
                        </td>
                        <td>
                            <input type="text" disabled id="idgapok" name="gapok" class="form-control" value="' . $dt['gapok'] . '">
                        </td>
                        <td><label>Tj.Jabatan</label></td>
                        <td>
                            <input type="text" disabled class="form-control" id="idjabatan" name="tj_jabatan" value="' . $dt['tj_jabatan'] . '">
                        </td>
                        <td><label>Tj.Anak</label></td>
                        <td>
                            <input type="text" disabled class="form-control" name="tj_anak" id="idtjanak" value="' . $dt['tj_anak'] . '">
                        </td>
                    </tr>

                    <tr>

                        <td>
                            <label>Uang Makan</label>
                        </td>
                        <td>
                            <input type="text" disabled name="uang_makan" id="iduangmakan" class="form-control" value="' . $dt['uang_makan'] . '">
                        </td>
                        <td><label>Uang Lembur</label></td>
                        <td>
                            <input type="text" id="iduang_lembur" disabled class="form-control" name="uang_lembur" value="' . $dt['uang_lembur'] . '">
                        </td>
                        <td>
                            <label>Askes</label>
                        </td>
                        <td>
                            <input type="text" disabled name="askes" id="idaskes" class="form-control" value="' . $dt['askes'] . '">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label>Jml. jam lembur</label>
                        </td>
                        <td colspan="5">
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="jml_jam_lembur">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" disabled class="form-control" id="jml_lembur">
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td><label>Potongan</label></td>
                        <td colspan="5">
                            <div class="col-sm-3">
                                <select name="potongan" class="form-control" id="idpotongan">';
                                foreach ($this->Model_transaksi->tampil_data_tabel('potongan')->result() as $pot)
                                {
                                    echo "<option value=".$pot->id_potongan.">".$pot->nm_potongan."</option>";
                                }
                    echo        '</select>
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="jumlah">
                            </div>
                            <div class="col-sm-2">
                                <a href="javascript:void(0)" id="idadd" class="btn btn-danger btn-sm form-control">Add</a>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="6">
                            <h4>Preview Potongan</h4>
                            <table class="table table-bordered tabled striped">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Potongan</th>
                                    <th>Nama Potongan</th>
                                    <th>Jumlah Potongan</th>
                                    <th>Cancel</th>
                                </tr></thead>';
                            echo '<tbody id="view_potongan">';    
                            echo $this->tampil_preview_potongan();

                            echo '</tbody>'; 
                    echo    '</table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <label>Pendapatan</label>
                        </td>
                        <td>
                            <input type="text" class="form-control" disabled id="idpendapatan">
                        </td>
                        <td>
                        <label>Total Potongan</label>
                        </td>
                        <td>
                            <input type="text" class="form-control" value="" 
                                   disabled id="idtot_potongan">
                        </td>
                        <td>
                        <label>Gaji Bersih</label>
                        </td>
                        <td>
                            <input type="text" class="form-control" disabled id="idgajibersih">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            <a href="javascript:void(0)"
                                id="idlihat_gaji" class="btn btn-default">Lihat Gaji</a>
                                <a href="#"
                                id="id_selesai" class="btn btn-info">Simpan</a>
                        </td>
                    </tr>
                </table>'; 
                echo "</form>";
                }
            }
            else if($hasil == 1)
            {
                echo "<h4>Karyawan atau pegawai dengan NIP ".$_GET['nip']." sudah menerima gaji.</h4>";
            }
        }
    }
    
    function tampil_preview_potongan()
    {
        $no  = 1;
        $nip = $_GET['nip'];
        $nos = $_GET['noslip'];
        $ptn = $this->Model_transaksi->tampil_potongan($nip,$nos);
        foreach ($ptn->result() as $p) {
            echo '<tr>'
            . '<td>' . $no++ . '</td>'
            . '<td>' . $p->kd_potongan . '</td>'
            . '<td>' . $p->nm_potongan . '</td>'
            . '<td>' . $p->jml_potongan . '</td>'
            . '<td>'
                    . '<label>'
                        . '<a href="javascript:void(0)"
                              id="cancel" data-id="'.$p->id_detil_gaji.'" data-class="'.$p->jml_potongan.'"
                              class="btn btn-warning btn-sm">Cancel</a>
                       </label>
               </td>'
            . '</tr>';
        }
    }
    
    function add_potongan()
    {
        
        $idpot      = $this->input->post('idpot');
        $jmpot      = $this->input->post('jmlpot');
        $nip        = $this->input->post('nip');
        $data       = array(
                        'nip'             => $nip,
                        'no_slip'         => $this->input->post('noslip'),
                        'id_potongan'     => $idpot,
                        'jml_potongan'    => $jmpot
        );
        $this->Model_transaksi->insert_to_table('detil_gaji',$data);
       
    }
    
    function cancel_potongan()
    {
        $idpot = $this->input->post('idpot');
        $this->Model_transaksi->hapus_potongan($idpot); 
    }
    
    function simpan_gaji()
    {
        $noslip             = $_GET['no_slip'];
        $nip                = $_GET['nip'];
        $tgl                = date("Y-m-d");
        $jm_lembur          = $_GET['jam_lembur'];
        $total_potongan     = $_GET['total_potongan'];
        $total_pendapatan   = $_GET['total_pendapatan'];
        $gaji_bersih        = $_GET['gaji_bersih'];
        
        $data = array(
                      'no_slip'         => $noslip,
                      'tgl'             => $tgl,
                      'pendapatan'      => $total_pendapatan,
                      'potongan'        => $total_potongan,
                      'gaji_bersih'     => $gaji_bersih,
                      'jml_jam_lembur'  => $jm_lembur,
                      'nip'             => $nip,
                      'id_admin'        => '1'
        );
        $this->Model_transaksi->insert_to_table('gaji',$data);
    }
}
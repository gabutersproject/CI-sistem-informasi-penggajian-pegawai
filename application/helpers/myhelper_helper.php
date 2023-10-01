<?php


if(!function_exists('myhelper'))
{
    function kode_admin()
    {
        $CI = & get_instance();
        $CI->db->select('kd_admin');
        $CI->db->from('admin');
        $CI->db->order_by('id_admin','DESC');
        $cek = $CI->db->get();
        if($cek->num_rows() > 0)
        {
            $ambil      = $cek->row_array();
            $getlast    = $ambil['kd_admin'];
            $get_code   = substr($getlast, 2,3)+1;
            $new_code   = "AD".sprintf("%03s",$get_code);
            return $new_code;
        }
        else 
        {
            return "AD001";
        }
    }
    
    function jumlah_pegawai()
    {
        $CI = & get_instance();
        $pegawai = $CI->db->get('pegawai');
        $jml_pegawai = $pegawai->num_rows();
        return $jml_pegawai;
    }
    function jumlah_petugas()
    {
        $CI = & get_instance();
        $petugas = $CI->db->get('admin');
        $jml_petugas = $petugas->num_rows();
        return $jml_petugas;
    }
    function get_user_aktif()
    {
        $CI     = & get_instance();
        $user   = $CI->session->userdata('username');
        $sql    = $CI->db->get_where('admin',array('username'=>$user))->row_array();
        return $sql;
    }
    
    function tgl_indo($tgl)
    {
        //2017-07-19
        $tanggal = substr($tgl, 8,2);
        $bulan   = get_bulan(substr($tgl, 5,2));
        $tahun   = substr($tgl, 0,4);
        return $tanggal." ".$bulan." ".$tahun;
    }
    
    function get_bulan($bulan)
    {
        switch ($bulan) {
            case 01 : return "Januari";
                break;
            case 02 : return "Februari";
                break;
            case 03 : return "Maret";
                break;
            case 04 : return "April";
                break;
            case 05 : return "Mei";
                break;
            case 06 : return "Juni";
                break;
            case 07 : return "Juli";
                break;
            case 8 : return "Agustus";
                break;
            case 9 : return "September";
                break;
            case 10 : return "Oktober";
                break;
            case 11 : return "November";
                break;
            case 12 : return "Desember";
                break;
        }
    }
    
    function ambil_tanggal()
    {
        $tgl = substr(date("Y-m-d"), 8,2);
        return $tgl;
    }
    
    function ambil_bulan()
    {
        $bln = substr(date("Y-m-d"), 5,2);
        return $bln;
    }
    
    function ambil_tahun()
    {
        $thn = substr(date("Y-m-d"), 2,2);
        return $thn;
    }
    
    
    
    function nomor_slip()
    {
        $CI = & get_instance();
        $CI->db->select('*');
        $CI->db->from('gaji');
        $CI->db->order_by('id_gaji','DESC');
        $cek = $CI->db->get();
        if($cek->num_rows() > 0)
        {
            //190717001
            
            $ambil      = $cek->row_array();
            $get_thn    = substr($ambil['tgl'], 2,2);
            $get_bln    = substr($ambil['tgl'], 5,2);
            
            
            if($get_thn == substr(date("Y"), 2,2)) //cek tahun
            {
                if($get_bln == substr(date("Y-m"), 5,2))
                {
                    $lastkode = $ambil['no_slip'];
                    $get_code = substr($lastkode, 6,3)+1;
                    $code_br  = ambil_tanggal(). ambil_bulan(). ambil_tahun(). sprintf("%03s",$get_code);
                    return $code_br;
                }
                else if($get_bln < substr(date("Y-m"), 5,2))
                {
                    $blan    = ambil_bulan()+1 ;
                    $g_code = ambil_tanggal().$blan.$get_thn."001";
                    return $g_code;
                }
            }
            else if($get_thn < substr(date("Y"), 2,2))
            {
                $kd = ambil_tanggal().ambil_bulan().ambil_tahun()."001";
                return $kd;
            }
        }
        else 
        {
            $kode = ambil_tanggal().ambil_bulan().ambil_tahun()."001";
            return $kode;
        }
    }
    
    function harus_login()
    {
        $ci = & get_instance();
        if ($ci->session->userdata('status') != 'login') {
            redirect('auth');
        }
    }
    
    function harus_logout()
    {
        $ci = & get_instance();
        if ($ci->session->userdata('status') == 'login') {
            echo "<script type='text/javascript'>alert('Anda harus Log Out terlebih dahulu!!!')</script>";
            echo "<script type='text/javascript'>window.location.href='".site_url('dashboard')."'</script>";
        }
    }
    
}

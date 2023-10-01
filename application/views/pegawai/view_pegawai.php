<?php
$this->load->view('template/jsnya');
?>
<script type="text/javascript">
    $(document).ready(function(){
        
    });
    $(document).on('click','#infopegawai',function(){
        var idpgw = $(this).data('id');
        $.ajax({
            url : "<?php echo site_url('pegawai/info_pegawai');?>",
            type: "GET",
            data: "idpgw="+idpgw,
            success : function (html)
            {
                $("#detilpgw").html(html);
                $("#detilpgw").modal('show',{backdrop: 'true'});
            }
        });
    });
</script>
<section class="content-header">
    <h1>
        Pegawai
        <small>Daftar Pegawai</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <a href="<?php echo site_url('pegawai/add_pegawai');?>" class="btn btn-success">
                <i class="glyphicon glyphicon-plus-sign"></i> Add Pegawai</a>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-striped example1" width="100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>NIP</th>
                        <th>Nama Pegawai</th>
                        <th>Kode Jabatan</th>
                        <th>Golongan</th>      
                        <th>Status Nikah</th>
                        <th>Jml. Anak</th>
                        <th>Operasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($pegawai->result() as $p)
                    {
                        echo "<tr>"
                                . "<td>".$no++."</td>"
                                . "<td>".$p->nip."</td>"
                                . "<td>".$p->nm_pegawai."</td>"
                                . "<td>".$p->kd_jabatan."</td>"
                                . "<td>".$p->golongan."</td>"
                                . "<td>";
                                
                                if($p->status_nikah == 1)
                                {
                                    echo "Menikah";
                                }
                                else if($p->status_nikah == 2)
                                {
                                    echo "Belum Menikah";
                                }
                                else if($p->status_nikah == 3)
                                {
                                    echo "Duda";
                                }
                                else if($p->status_nikah == 4)
                                {
                                    echo "Janda";
                                }
                        
                        echo      "</td>"
                                . "<td>".$p->jml_anak."</td>"
                                . "<td>"
                                    . "<label><a href='#' id='infopegawai' data-id='".$p->id_pegawai."' class='btn btn-success btn-sm'>Detail</a></label>&nbsp"
                                    . "<label><a href='". site_url('pegawai/edit_pegawai/').$p->id_pegawai."' class='btn btn-info btn-sm'>Edit</a></label>&nbsp"
                                    . "<label><a href='". site_url('pegawai/hapus_pegawai/').$p->id_pegawai."'  class='btn btn-danger btn-sm'>Hapus</a></label>"
                                    
                                . "</td>"
                                . "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<div id="detilpgw" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModelLabel" aria-hidden="true">
    
</div>
    

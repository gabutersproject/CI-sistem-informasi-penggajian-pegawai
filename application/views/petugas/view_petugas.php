<section class="content-header">
    <h1>
        Petugas
        <small>Daftar Petugas</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <a href="<?php echo site_url('petugas/add_petugas');?>" class="btn btn-success">
                <i class="glyphicon glyphicon-plus-sign"></i> Add Petugas</a>
                <span>
                        <?php if(isset($error)){echo $error;}?>
                </span>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-bordered table-striped example1" width="100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Petugas</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Foto</th>
                        <th>Operasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                        foreach ($petugas->result() as $p)
                        {
                            echo "<tr>"
                                    . "<td>".$no++."</td>"
                                    . "<td>".$p->kd_admin."</td>"
                                    . "<td>".$p->nm_admin."</td>"
                                    . "<td>".$p->username."</td>"
                                    . "<td>";
                                    if($p->photo)
                                    {
                                        echo "<img src='". base_url('uploads/'.$p->photo)."' style='width : 80px; height: 80px;'>";
                                    }
                                    else
                                    {
                                        echo "<img src='". base_url('uploads/no_user.jpg')."' style='width : 80px; height: 80px;'>";
                                    }
                            echo      "</td>"
                                    . "<td>"
                                        ."<a href='#' data-id='".$p->id_admin."' class='btn btn-success btn-sm idpetugas'>Detil</a>&nbsp"
                                        ."<a href='".site_url('petugas/edit_petugas/'.$p->id_admin)."' class='btn btn-info btn-sm'>Edit</a>&nbsp"
                                        ."<a href='".site_url('petugas/hapus_petugas/'.$p->id_admin)."' class='btn btn-danger btn-sm'>Hapus</a>"
                                    . "</td>"
                                    . "</tr>";
                        }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6">
                            <div class="alert alert-warning col-sm-5">
                                <i class="glyphicon glyphicon-info-sign"></i><span> -Klik Detil untuk melihat profile petugas.</span>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</section>
<div id="detilptg" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModelLabel" aria-hidden="true">
    
</div>
<?php
$this->load->view('template/jsnya');
?>
<script type="text/javascript">
    $(document).ready(function(){
        
    });
    $(document).on('click','#idpetugas',function(){
        var idptg = $(this).data('id');
        $.ajax({
            url : "<?php echo site_url('petugas/info_petugas');?>",
            type: "GET",
            data: "idptg="+idptg,
            success : function (html)
            {
                $("#detilptg").html(html);
                $("#detilptg").modal('show',{backdrop: 'true'});
            }
        });
    });
</script>
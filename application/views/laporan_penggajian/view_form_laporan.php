<?php
    $this->load->view('template/jsnya');
?>
<script type="text/javascript">
    $(document).ready(function(){
        
    });
    
    function view_bythn()
    {
        var thn = $("#idtahun").val();
        $.ajax({
            url : "<?php echo site_url('laporan/cari_bulan');?>",
            type: "GET",
            data : "tahun="+thn,
            success : function (html)
            {
                $("#bulan").html(html);
            }
        });
    }
    $(document).on('click','#id_pilih',function (){
        var thn = $("#idtahun").val();
        var bln = $("#idbln").val();
            $.ajax({
                url : "<?php echo site_url('laporan/laporan_per_bulan');?>",
                type: "GET",
                data: "thn="+thn+"&bln="+bln,
                success : function (html)
                {
                    $("#idhasil").html(html);
                }
            });
    } );
    
    
</script>
<section class="content-header">
    <h1>
        Form Laporan Penggajian
        <small>Laporan Penggajian</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
        </div>
        <div class="box-body">
            <div class="col-sm-3">
                <table class="table table-bordered">
                    <tr>
                        <td>
                            <h4>Tampil Berdasarkan: </h4>
                            <table class="table table-bordered table-striped">
                               
                                <tr>
                                    <td>Tahun
                                        <div>
                                            <select class="form-control" id="idtahun" onchange="view_bythn()">
                                                <option value="0">--Silahkan Pilih</option>
                                                <?php
                                                
                                                    foreach ($tahun as $t)
                                                    {
                                                        echo "<option value='". substr($t->tgl, 0,4)."'>". substr($t->tgl, 0,4)."</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr id="bulan">
                                    
                                </tr>
                                
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a href="#" id="id_pilih"
                               class="btn btn-danger btn-block btn-flat btn-sm">Pilih</a> 
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-lg-9">
                <table id="table" class="table table-bordered table-striped">
                    <div class="box-header with-border">
                    </div>
                    <thead>
                        <tr class="success">
                            <th>No. Slip</th>
                            <th>Tanggal</th>
                            <th>NIP</th>
                            <th>Pendapatan</th>
                            <th>Potongan</th>
                            <th>Gaji Bersih</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="idhasil">
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
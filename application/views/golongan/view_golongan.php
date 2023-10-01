<section class="content-header">
    <h1>
        Golongan
        <small>Daftar Golongan</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <a href="<?php echo site_url('golongan/add_golongan');?>" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i> Add Golongan</a>
        </div>
        <div class="box-body" >
            <?php
            if (isset($_GET['pesan'])) {
                $pesan = $_GET['pesan'];
                echo '<div class="alert alert-success">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                echo $pesan;
                echo '</div>';
                ?>
                <meta http-equiv="refresh" content="2;url=<?php echo site_url('golongan'); ?>">    
                <?php
            }
            ?>
            <table class="table table-bordered table-striped example1" width="100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Golongan</th>
                        <th>Tunjanagn Suami/Istri</th>
                        <th>Tunjangan Anak</th>
                        <th>Uang Makan</th>
                        <th>Uang Lembur</th>
                        <th>Askes</th>
                        <th>Operasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($golongan->result() as $g)
                    {
                        echo "<tr>"
                                . "<td>".$no++."</td>"
                                . "<td>".$g->golongan."</td>"
                                . "<td>".$g->tj_suami_istri."</td>"
                                . "<td>".$g->tj_anak."</td>"
                                . "<td>".$g->uang_makan."</td>"
                                . "<td>".$g->uang_lembur."</td>"
                                . "<td>".$g->askes."</td>"
                                . "<td style='text-align : center;'>"
                                    . "<label><a href='". site_url('golongan/edit_golongan/').$g->id_golongan."'
                                                 class='btn btn-info btn-sm'
                                                 >Edit</a></label>&nbsp"
                                    . "<label><a href='". site_url('golongan/hapus_golongan/').$g->id_golongan."'
                                                 class='btn btn-danger btn-sm'
                                                 >Hapus</a></label>&nbsp"
                                . "</td>"
                                . "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
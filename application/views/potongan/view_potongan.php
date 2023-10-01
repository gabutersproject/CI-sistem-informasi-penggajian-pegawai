<section class="content-header">
    <h1>
        Potongan
        <small>Daftar Potongan</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <a href="<?php echo site_url('potongan/add_potongan');?>" class="btn btn-success">
                <i class="glyphicon glyphicon-plus-sign"></i> Add Potongan</a>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-striped example1" width="100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kode Potongan</th>
                        <th>Nama Pabatan</th>                        
                        <th>Operasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($potongan->result() as $p)
                    {
                        echo "<tr>"
                                . "<td>".$no++."</td>"
                                . "<td>".$p->kd_potongan."</td>"
                                . "<td>".$p->nm_potongan."</td>"                               
                                . "<td>"
                                    . "<label><a href='". site_url('potongan/edit_potongan/').$p->id_potongan."' class='btn btn-info btn-sm'>Edit</a></label>&nbsp"
                                    . "<label><a href='". site_url('potongan/hapus_potongan/').$p->id_potongan."' class='btn btn-danger btn-sm'>Hapus</a></label>"
                                . "</td>"
                                . "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
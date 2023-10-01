<section class="content-header">
    <h1>
        Jabatan
        <small>Daftar Jabatan</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <a href="<?php echo site_url('jabatan/add_jabatan');?>" class="btn btn-success">
                <i class="glyphicon glyphicon-plus-sign"></i> Add Jabatan</a>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-striped example1" width="100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kode Jabatan</th>
                        <th>Nama Jabatan</th>
                        <th>Gaji Pokok</th>
                        <th>Tunjangan Jabatan</th>                        
                        <th>Operasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($jabatan->result() as $j)
                    {
                        echo "<tr>"
                                . "<td>".$no++."</td>"
                                . "<td>".$j->kd_jabatan."</td>"
                                . "<td>".$j->nm_jabatan."</td>"
                                . "<td>".$j->gapok."</td>"
                                . "<td>".$j->tj_jabatan."</td>"                                
                                . "<td style='text-align : center;'>"
                                    . "<label><a href='". site_url('jabatan/edit_jabatan/').$j->kd_jabatan."' class='btn btn-info btn-sm'>Edit</a></label>&nbsp"
                                    . "<label><a href='". site_url('jabatan/hapus_jabatan/').$j->kd_jabatan."' class='btn btn-danger btn-sm'>Hapus</a></label>"
                                . "</td>"
                                . "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
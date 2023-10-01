<section class="content-header">
    <h1>Jabatan
        <small>Edit Jabatan</small>
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
            <?php echo form_open('jabatan/update_jabatan');?>
            <table class="table table-bordered">
                <tr>
                    <td colspan="4">
                        <input type="hidden" value="<?php echo $gol['kd_jabatan'];?>" name="kode">
                    </td>
                </tr>
                <tr>
                    <td><label>Kode Jabatan</label></td>
                    <td>
                        <input type="text" value="<?php echo $gol['kd_jabatan'];?>" name="kd_jabatan" class="form-control">
                    </td>
                    <td><label>Gaji Pokok</label></td>
                    <td>
                        <input type="text" name="gapok" value="<?php echo $gol['gapok'];?>" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td><label>Nama Jabatan</label></td>
                    <td>
                        <input type="text" name="nm_jabatan" class="form-control" value="<?php echo $gol['nm_jabatan'];?>">
                    </td>
                    <td><label>Tunjangan Jabatan</label></td>
                    <td>
                        <input type="text" name="tj_jabatan" class="form-control" value="<?php echo $gol['tj_jabatan'];?>">
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <button class="btn btn-info btn-sm">Simpan</button>
                        <label><a href="<?php echo site_url('jabatan')?>" class="btn btn-default btn-sm">Kembali</a></label>
                    </td>
                </tr>
            </table>
            <?php echo form_close();?>
        </div>
    </div>
</section>

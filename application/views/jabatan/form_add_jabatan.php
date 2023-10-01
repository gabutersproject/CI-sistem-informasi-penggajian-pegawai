<section class="content-header">
    <h1>Jabatan
        <small>Add Jabatan</small>
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
            <?php echo form_open('jabatan/simpan_jabatan');?>
            <table class="table table-bordered">
                <tr>
                    <td><label>Kode Jabatan</label></td>
                    <td>
                        <input type="text" name="kd_jabatan" class="form-control">
                        <span class="text-danger">
                            <?php echo form_error('kd_jabatan')?>
                        </span>
                    </td>
                    <td><label>Gaji Pokok</label></td>
                    <td>
                        <input type="text" name="gapok" class="form-control">
                        <span class="text-danger">
                            <?php echo form_error('gapok')?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td><label>Nama Jabatan</label></td>
                    <td>
                        <input type="text" name="nm_jabatan" class="form-control">
                        <span class="text-danger">
                            <?php echo form_error('nm_jabatan')?>
                        </span>
                    </td>
                    <td><label>Tunjangan Jabatan</label></td>
                    <td>
                        <input type="text" name="tj_jabatan" class="form-control">
                        <span class="text-danger">
                            <?php echo form_error('tj_jabatan')?>
                        </span>
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

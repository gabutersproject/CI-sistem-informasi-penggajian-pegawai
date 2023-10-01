<section class="content-header">
    <h1>Golongan
        <small>Add Golongan</small>
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
            <?php echo form_open('golongan/simpan_golongan');?>
            <table class="table table-bordered">
                <tr>
                    <td><label>Golongan</label></td>
                    <td>
                        <input type="text" name="golongan" class="form-control">
                        <span class="text-danger">
                            <?php echo form_error('golongan')?>
                        </span>
                    </td>
                    <td><label>Uang Makan</label></td>
                    <td>
                        <input type="text" name="uang_makan" class="form-control">
                        <span class="text-danger">
                            <?php echo form_error('uang_makan')?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td><label>Tunjangan Suami/Istri</label></td>
                    <td>
                        <input type="text" name="tj_sutri" class="form-control">
                        <span class="text-danger">
                            <?php echo form_error('tj_sutri')?>
                        </span>
                    </td>
                    <td><label>Uang Lembur</label></td>
                    <td>
                        <input type="text" name="uang_lembur" class="form-control">
                        <span class="text-danger">
                            <?php echo form_error('uang_lembur')?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td><label>Tunjangan Anak</label></td>
                    <td>
                        <input type="text" name="tj_anak" class="form-control">
                        <span class="text-danger">
                            <?php echo form_error('tj_anak')?>
                        </span>
                    </td>
                    <td><label>Askes</label></td>
                    <td>
                        <input type="text" name="askes" class="form-control">
                        <span class="text-danger">
                            <?php echo form_error('askes')?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <button class="btn btn-info btn-sm">Simpan</button>
                        <label><a href="<?php echo site_url('golongan')?>" class="btn btn-default btn-sm">Kembali</a></label>
                    </td>
                </tr>
            </table>
            <?php echo form_close();?>
        </div>
    </div>
</section>

<section class="content-header">
    <h1>Potongan
        <small>Add Potongan</small>
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
            <?php echo form_open('potongan/add_potongan');?>
            <table class="table table-bordered">
                <tr>
                    <td><label>Kode Potongan</label></td>
                    <td>
                        <input type="text" name="kd_potongan" class="form-control">
                        <span class="text-danger">
                            <?php echo form_error('kd_potongan')?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td><label>Nama Potongan</label></td>
                    <td>
                        <input type="text" name="nm_potongan" class="form-control">
                        <span class="text-danger">
                            <?php echo form_error('nm_potongan')?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button class="btn btn-info btn-sm" name="submit">Simpan</button>
                        <label><a href="<?php echo site_url('potongan')?>" class="btn btn-default btn-sm">Kembali</a></label>
                    </td>
                </tr>
            </table>
            <?php echo form_close();?>
        </div>
    </div>
</section>

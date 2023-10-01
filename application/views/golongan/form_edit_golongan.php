<section class="content-header">
    <h1>Golongan
        <small>Edit Golongan</small>
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
            <?php echo form_open('golongan/update_golongan');?>
            <table class="table table-bordered">
                <tr>
                    <td>
                        <input type="hidden" value="<?php echo $gol['id_golongan']?>" name="id_golongan">
                    </td>
                </tr>
                <tr>
                    <td><label>Golongan</label></td>
                    <td>
                        <input type="text" name="golongan" value="<?php echo $gol['golongan']?>" class="form-control">
                    </td>
                    <td><label>Uang Makan</label></td>
                    <td>
                        <input type="text" name="uang_makan" value="<?php echo $gol['uang_makan'];?>" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td><label>Tunjangan Suami/Istri</label></td>
                    <td>
                        <input type="text" name="tj_sutri" value="<?php echo $gol['tj_suami_istri'];?>" class="form-control">
                    </td>
                    <td><label>Uang Lembur</label></td>
                    <td>
                        <input type="text" name="uang_lembur" value="<?php echo $gol['uang_lembur'];?>" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td><label>Tunjangan Anak</label></td>
                    <td>
                        <input type="text" name="tj_anak" value="<?php echo $gol['tj_anak'];?>" class="form-control">
                    </td>
                    <td><label>Askes</label></td>
                    <td>
                        <input type="text" name="askes" class="form-control" value="<?php echo $gol['askes'];?>">
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

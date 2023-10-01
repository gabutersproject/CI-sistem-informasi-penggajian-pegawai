<section class="content-header">
    <h1>Pegawai
        <small>Add Pegawai</small>
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
            <?php echo form_open('pegawai/add_pegawai');?>
            <table class="table table-bordered">
                <tr>
                    <td><label>NIP</label></td>
                    <td>
                        <input type="text" class="form-control" name="nip">
                        <span class="text-danger">
                            <?php echo form_error('nip')?>
                        </span>
                    </td>
                    <td><label>Golongan</label></td>
                    <td>
                        <select class="form-control" name="golongan">
                            <option value="">--Silahkan Pilih</option>
                        <?php
                        foreach ($golongan as $g) {
                            echo "<option value='" . $g->id_golongan . "'>" . $g->golongan . "</option>";
                        }
                        ?>
                        </select>
                        <span class="text-danger">
                            <?php echo form_error('golongan')?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td><label>Nama Pegawai</label></td>
                    <td>
                        <input type="text" name="nm_pegawai" class="form-control">
                        <span class="text-danger">
                            <?php echo form_error('nm_pegawai')?>
                        </span>
                    </td>
                    <td><label>Status Pernikahan</label></td>
                    <td>
                        <select class="form-control" name="sts_nikah">
                            <option value="">--Silahkan Pilih</option>
                        <?php
                            $sts = array('1'=>'Menikah','2'=>'Belum Menikah','3'=>'Duda','4'=>'Janda');
                            foreach ($sts as $no => $nm)
                            {
                                echo "<option value='".$no."'>".$nm."</option>";
                            }
                        ?>
                        </select>
                        <span class="text-danger">
                            <?php echo form_error('sts_nikah')?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td><label>Kode Jabatan</label></td>
                    <td>
                        <select name="jabatan" class="form-control">
                            <option value="">--Silahkan Pilih</option>
                            <?php
                                foreach($jabatan as $j)
                                {
                                    echo "<option value='".$j->kd_jabatan."'>".$j->nm_jabatan."</option>";
                                }
                            ?>
                        </select>
                        <span class="text-danger">
                            <?php echo form_error('jabatan')?>
                        </span>
                    </td>
                    <td>
                        <label>Jumlah Anak</label>
                    </td>
                    <td>
                        <input type="text" name="jml_anak" class="form-control">
                        <span class="text-danger">
                            <?php echo form_error('jml_anak')?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button class="btn btn-info btn-sm" name="submit">Simpan</button>
                        <label><a href="<?php echo site_url('pegawai')?>" class="btn btn-default btn-sm">Kembali</a></label>
                    </td>
                </tr>
            </table>
            <?php echo form_close();?>
        </div>
    </div>
</section>

<section class="content-header">
    <h1>Pegawai
        <small>Edit Pegawai</small>
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
            <?php echo form_open('pegawai/edit_pegawai');?>
            <table class="table table-bordered">
                <tr>
                    <td colspan="4">
                        <input type="hidden" name="id" value="<?php echo $pgw['id_pegawai']?>">
                    </td>
                </tr>
                <tr>
                    <td><label>NIP</label></td>
                    <td>
                        <input type="text" class="form-control" name="nip" value="<?php echo $pgw['nip']?>">
                    </td>
                    <td><label>Golongan</label></td>
                    <td>
                        <select class="form-control" name="golongan">
                        <?php
                        foreach ($golongan as $g) {
                            echo "<option value='".$g->id_golongan ."'";
                            echo $g->id_golongan == $pgw['id_golongan'] ? 'selected' : '';
                            echo ">" . $g->golongan . "</option>";
                        }
                        ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label>Nama Pegawai</label></td>
                    <td>
                        <input type="text" name="nm_pegawai" class="form-control" value="<?php echo $pgw['nm_pegawai']?>">
                    </td>
                    <td><label>Status Pernikahan</label></td>
                    <td>
                        <select class="form-control" name="sts_nikah">
                        <?php
                            $sts = array('1'=>'Menikah','2'=>'Belum Menikah','3'=>'Duda','4'=>'Janda');
                            foreach ($sts as $no => $nm)
                            {
                                echo "<option value='".$no."'";
                                echo $no == $pgw['status_nikah'] ? 'selected' : '';
                                echo ">".$nm."</option>";
                            }
                        ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label>Kode Jabatan</label></td>
                    <td>
                        <select name="jabatan" class="form-control">
                            <?php
                                foreach($jabatan as $j)
                                {
                                    echo "<option value='".$j->kd_jabatan."'";
                                    echo $j->kd_jabatan == $pgw['kd_jabatan'] ? 'selected' : '';
                                    echo ">".$j->nm_jabatan."</option>";
                                }
                            ?>
                        </select>
                    </td>
                    <td>
                        <label>Jumlah Anak</label>
                    </td>
                    <td>
                        <input type="text" name="jml_anak" class="form-control" value="<?php echo $pgw['jml_anak']?>">
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

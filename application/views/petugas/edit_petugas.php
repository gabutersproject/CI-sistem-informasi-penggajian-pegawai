<section class="content-header">
    <h1>Petugas
        <small>Edit Petugas</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
        </div>
        <?php echo form_open_multipart('petugas/simpan_edit');?>
            <div class="box-body">
                <input type="hidden" name="id" value="<?php echo $p_edit['id_admin']?>">
                <table class="table table-bordered">
                    <tr>
                        <td><label>Kode Petugas</label></td>
                        <td>
                            <input type="text" disabled class="form-control" name="kd_petugas" 
                                   value="<?php 
                                                echo $p_edit['kd_admin'];
                                            ?>">
                        </td>
                    </tr>
                    <tr>
                        <td><label>Nama Petugas</label></td>
                        <td>
                            <input type="text" class="form-control" name="nm_petugas" value="<?php echo $p_edit['nm_admin']?>">
                        </td>
                    </tr>
                    <tr>
                        <td><label>Username</label></td>
                        <td>
                            <input type="text" class="form-control" name="username" value="<?php echo $p_edit['username']?>">
                        </td>
                    </tr>
                    <tr>
                        <td><label>Password</label></td>
                        <td>
                            <input type="password" class="form-control" name="password">
                            <span style="color: red; size: 12px;">-Jika password tidak diubah, maka kosongkan saja.</span>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2"><label>Foto</label></td>
                        <td>
                            <input type="file" class="form-control" name="foto" value="">
                            <span class="text-danger"><?php
                                    if(isset($error))
                                    {
                                        //$error = $_GET['error'];
                                        echo $error;
                                    }
                                   ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                            if($p_edit['photo']){
                                echo "<img src='". base_url('uploads/'.$p_edit['photo'])."' style='width: 100px; height: 100px;'>";
                            }else{
                                echo "<img src='". base_url('uploads/no_user.jpg')."' style='width: 100px; height: 100px;'>";
                            }
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="box-footer">
                <button class="btn btn-primary">Simpan</button>
                <a href="<?php echo site_url('petugas');?>" class="btn btn-default">Kembali</a>
            </div>
        <?php echo form_close();?>
        
    </div>
</section>

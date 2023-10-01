<section class="content-header">
    <h1>Petugas
        <small>Add Petugas</small>
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
        <?php echo form_open_multipart('petugas/simpan_add');?>
            <div class="box-body">
                <table class="table table-bordered">
                    
                    <tr>
                        <td><label>Nama Petugas</label></td>
                        <td>
                            <input type="text" class="form-control" required name="nm_petugas">
                            <span class="text-danger"><?php echo form_error('nm_petugas');?></span>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Username</label></td>
                        <td>
                            <input type="text" class="form-control" required name="username">
                            <span class="text-danger"><?php echo form_error('username');?></span>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Password</label></td>
                        <td>
                            <input type="password" required class="form-control" name="password" value="">
                            <span class="text-danger"><?php echo form_error('password');?></span>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Foto</label></td>
                        <td>
                            <input type="file" class="form-control" name="foto">
                            <span class="text-danger"><?php
                                    if(isset($error))
                                    {
                                        //$error = $_GET['error'];
                                        echo $error;
                                    }
                                   ?></span>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="box-footer">
                <button class="btn btn-primary" name="submit">Simpan</button>
                <a href="<?php echo site_url('petugas');?>" class="btn btn-default">Kembali</a>
            </div>
        <?php echo form_close();?>
        
    </div>
</section>


<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <?php
            $data = get_user_aktif();
        ?>
        <div class="user-panel">
            <div class="pull-left image">
                <img 
                    <?php
                        if($data['photo'])
                        {
                            echo 'src="'. base_url('uploads/'.$data['photo']).'"';
                        }
                        else
                        {
                            echo 'src="'. base_url('uploads/'.$data['no_user.jpg']).'"';
                        }
                    ?>
                    class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo $data['nm_admin']?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="active treeview">
                <a href="<?php echo site_url('dashboard');?>">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('golongan');?>">
                    <i class="fa fa-th"></i> <span>Golongan</span>
                </a>
            </li>
            
            <li>
                <a href="<?php echo site_url('jabatan');?>">
                    <i class="fa fa-vcard"></i> <span>Jabatan</span>
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('potongan');?>">
                    <i class="fa fa-cut"></i> <span>Potongan</span>
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('pegawai');?>">
                    <i class="fa fa-user-plus"></i> <span>Pegawai</span>
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('transaksi_penggajian');?>">
                    <i class="fa fa-tasks"></i> <span>Transaksi Penggajian</span>
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('petugas');?>">
                    <i class="fa fa-user"></i> <span>Petugas</span>
                </a>
            </li>
            
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-print"></i>
                    <span>Laporan</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo site_url('laporan/laporan_data_golongan');?>"><i class="fa fa-circle-o"></i> Lap. Data Golongan</a></li>
                    <li><a href="<?php echo site_url('laporan/laporan_data_jabatan');?>"><i class="fa fa-circle-o"></i> Lap. Data Jabatan</a></li>
                    <li><a href="<?php echo site_url('laporan/laporan_data_potongan');?>"><i class="fa fa-circle-o"></i> Lap. Data Potongan</a></li>
                    <li><a href="<?php echo site_url('laporan/laporan_data_pegawai');?>"><i class="fa fa-circle-o"></i> Lap. Data Pegawai</a></li>
                    <li><a href="<?php echo site_url('laporan/laporan_data_petugas');?>"><i class="fa fa-circle-o"></i> Lap. Data Petugas</a></li>
                    <li><a href="<?php echo site_url('laporan/laporan_data_penggajian');?>"><i class="fa fa-circle-o"></i> Lap. Data Penggajian</a></li>
                </ul>
            </li>
            
            
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
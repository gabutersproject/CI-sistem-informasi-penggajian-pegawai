<?php
$this->load->view('template/head');
?>
<link rel="stylesheet" href="<?php echo base_url('assets/adminlte/plugins/iCheck/flat/blue.css'); ?>">
<!-- Morris chart -->
<link rel="stylesheet" href="<?php echo base_url('assets/adminlte/plugins/morris/morris.css'); ?>">
<!-- jvectormap -->
<link rel="stylesheet" href="<?php echo base_url('assets/adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.css'); ?>">
<!-- Date Picker -->
<link rel="stylesheet" href="<?php echo base_url('assets/adminlte/plugins/datepicker/datepicker3.css'); ?>">
<!-- Daterange picker -->
<link rel="stylesheet" href="<?php echo base_url('assets/adminlte/plugins/daterangepicker/daterangepicker.css'); ?>">
<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="<?php echo base_url('assets/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css'); ?>">
<script type="text/javascript" src="<?php echo base_url('assets/adminlte/plugins/highchart/code/highcharts.js'); ?>"></script>
<?php
$this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>


<!-- =======Content Header (Page header)======== -->

<section class="content-header">
    <h1>
        Dashboard
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>2</h3>

                    <p>Data Golongan</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person"></i>
                </div>
                <a href="#" class="small-box-footer">Lihat Golongan <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3><?php echo jumlah_petugas(); ?></h3>

                    <p>Petugas</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person"></i>
                </div>
                <a href="<?php echo site_url('petugas'); ?>" class="small-box-footer">Lihat Petugas <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3><?php echo jumlah_pegawai(); ?></h3>

                    <p>Pegawai</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="<?php echo site_url('pegawai'); ?>" class="small-box-footer">Lihat Pegawai <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>5</h3>

                    <p>Data Jabatan</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">Lihat Jabatan <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">


        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-danger">
                        <div id="idcontainer" >
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

</section>

<!-- /.content -->
<?php
$this->load->view('template/js');
?>
<script type="text/javascript">
    $(document).ready(function (){
        var chart = new Highcharts.Chart({
            chart : {
                renderTo : 'idcontainer',
                type     : 'areaspline'
            },
            title : {
                text: 'Perbandingan Gaji Pokok dan Tunjangan Jabatan'
            },
            subtitle : {
                text: 'PT. KUMPULAN KODE'
            },
            legend : {
              layout : 'vertical',
              align  : 'left',
              verticalAlign : 'top',
              x : 100,
              y : 90,
              floating : true,
              borderWidth : 1,
              backgroundColor : (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF' 
            },
            xAxis : {
                categories : [
                    <?php
                    foreach ($jabatan->result() as $j)
                    {
                        echo '"'.$j->nm_jabatan.'",';
                    }
                    ?>
                ]
            },
            yAxis : {
                title : {
                    text : 'Gaji /Bulan'
                },
                labels: {
                    formatter: function () {
                        return this.value / 1000000 + ' jt';
                    }
                }
            },
            tooltip : {
                shared : true
                
            },
            credits : {
                enabled : false
            },
            plotOptions : {
                areaspline : {
                    fillOpacity : 0.5
                }
            },
            series: [
            {
                name: 'Gaji Pokok',
                data: [<?php
                    foreach ($jabatan->result() as $gp)
                    {
                        echo $gp->gapok.',';
                    }
                ?>]
            }, 
            {
                name: 'Tj. Jabatan',
                data: [<?php
                foreach ($jabatan->result() as $tj)
                {
                    echo $tj->tj_jabatan.',';
                }
                ?>]
            }]
        });
    });
</script>

<script src="<?php echo base_url('assets/js/jquery-ui.min.js?>') ?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<script src="<?php echo base_url('assets/adminlte/plugins/chartjs/Chart.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/raphael-min.js'); ?>"></script>
<script src="<?php echo base_url('assets/adminlte/plugins/morris/morris.min.js'); ?>"></script>
<!-- Sparkline -->
<script src="<?php echo base_url('assets/adminlte/plugins/sparkline/jquery.sparkline.min.js'); ?>"></script>
<!-- jvectormap -->
<script src="<?php echo base_url('assets/adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js'); ?>"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url('assets/adminlte/plugins/knob/jquery.knob.js'); ?>"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="<?php echo base_url('assets/adminlte/plugins/daterangepicker/daterangepicker.js'); ?>"></script>
<!-- datepicker -->
<script src="<?php echo base_url('assets/adminlte/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url('assets/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'); ?>"></script>

<script src="<?php echo base_url('assets/adminlte/dist/js/pages/dashboard.js'); ?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url('assets/adminlte/dist/js/demo.js'); ?>"></script>
<?php
$this->load->view('template/foot');
?>
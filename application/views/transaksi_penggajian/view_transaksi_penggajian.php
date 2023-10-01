<?php
$this->load->view('template/jsnya');
?>
<script type="text/javascript">
    $(document).ready(function(){
        $("#list").hide();
        load_data();
        
        $(document).on('click','#idpilih',function (){
           var nip     = $("#idnip").val();
           var no_slip = $("#idslip").val();
           if(nip === "" || nip === 0)
           {
               swal({
                    title : 'Opss !',
                    text  : '<h4>Anda belum memasukan NIP.</h4>',
                    type  : 'warning'
                }).then(function (){
                    $("#idnip").focus();
                });
                return false;
           }
           else
           {
               $.ajax({
               url  : "<?php echo site_url('transaksi_penggajian/tampil_detail');?>",
               type : "GET",
               data : "nip="+nip+"&noslip="+no_slip,
               success : function (html)
               {
                   $("#list").html(html);
                   $("#list").show( "drop" ,{direction:"up"},900);
                   
               }
               });
           } 
        });
        
        $(document).on('click','#idnip',function (){
            $("#list").hide("drop" ,{direction:"right"},900);
        });
    });
    
    
    $(document).on('keyup','#jml_jam_lembur',function(){
        var jml_jam     = $("#jml_jam_lembur").val();
        var uang_lembur = $("#iduang_lembur").val();
        var hasil       = parseInt(jml_jam)*parseInt(uang_lembur);
        if(isNaN(jml_jam))
        {
            swal({
                title : 'Opss !',
                text  : 'Inputan salah, hanya angka atau bilangan.',
                type  : 'warning'
            }).then(function (){
                $('#jml_jam_lembur').focus();
            });
        }
        else if(jml_jam === "" || jml_jam === 0)
        {
            $("#jml_lembur").val(0);
        }
        else
        {
            $("#jml_lembur").val(hasil);
            //total_pendapatan();
        }
    });
    
    $(document).on('click','#idadd',function(){
        var idpot   = $("#idpotongan").val();
        var jmlpot  = $("#jumlah").val();
        var nip     = $("#idnip").val();
        var no_slip = $("#idslip").val();
        var bsr     = $("#idtot_potongan").val();
        if(jmlpot === "")
        {
             swal({
                    title : 'Opss !',
                    text  : '<h4>Jika tidak ada potongan, maka lewati dan klik lihat gaji.</h4>',
                    type  : 'warning'
                });
                return false;
        }
        else
        {
            $.ajax({
            url  : "<?php echo site_url('transaksi_penggajian/add_potongan');?>",
            type : "POST",
            data : "idpot="+idpot+"&jmlpot="+jmlpot+"&nip="+nip+"&noslip="+no_slip,
            success : function (html)
            {
                tampil_preview();
                if(bsr === "")
                {
                    bsr = 0;
                    var hslbsr = parseInt(bsr)+parseInt(jmlpot);
                    $("#idtot_potongan").val(hslbsr);
                    $("#jumlah").val("");
                    $("#idgajibersih").val("");
                    $("#idpendapatan").val("");
                    total_pendapatan();
                }
                else
                {
                    var hasilakhr = parseInt(bsr)+parseInt(jmlpot);
                    $("#idtot_potongan").val(hasilakhr);
                    $("#jumlah").val("");
                    $("#idgajibersih").val("");
                    $("#idpendapatan").val("");
                    //total_pendapatan();
                }
                
            }
        });
        }
    });
    
    $(document).on('click','#cancel',function(){
        var idpot = $(this).data('id');
        var jmpot = $(this).data('class');
        var topot = $("#idtot_potongan").val();
        var hasil = parseInt(topot)-parseInt(jmpot);
        $.ajax({
            url : "<?php echo site_url('transaksi_penggajian/cancel_potongan');?>",
            type : "POST",
            data : "idpot="+idpot,
            success : function ()
            {
                tampil_preview();
                $("#idtot_potongan").val(hasil);
                $("#idgajibersih").val("");
                $("#idpendapatan").val("");
            }
        });
    });
    
    function total_pendapatan()
    {
        var tj_sutri        = $("#idtjsutri").val();
        var gapok           = $("#idgapok").val();
        var tj_jabatan      = $("#idjabatan").val();
        var tj_anak         = $("#idtjanak").val();
        var uang_makan      = $("#iduangmakan").val();
        var askes           = $("#idaskes").val();
        var jml_lembur      = $("#jml_lembur").val();
        //var jmlpotngan      = $("#idjml_potongan").val();
        
        if(jml_lembur === "")
        {
            jml_lembur = 0;
            var total_pendapatan = parseInt(tj_sutri)+parseInt(gapok)+parseInt(tj_jabatan)+parseInt(tj_anak)+parseInt(uang_makan)+
                                   parseInt(askes)+parseInt(jml_lembur);
            $("#idpendapatan").val(total_pendapatan);
        }
        else
        {
            var total_pendapatan = parseInt(tj_sutri)+parseInt(gapok)+parseInt(tj_jabatan)+parseInt(tj_anak)+parseInt(uang_makan)+
                                   parseInt(askes)+parseInt(jml_lembur);
            $("#idpendapatan").val(total_pendapatan);
        }
    }
    
    function tampil_preview()
    {
        var nip = $("#idnip").val();
        var no_slip = $("#idslip").val();
        $.ajax({
            url  : "<?php echo site_url('transaksi_penggajian/tampil_preview_potongan');?>",
            type : "GET",
            data : "nip="+nip+"&noslip="+no_slip,
            success : function (html)
            {
                $("#view_potongan").html(html);
            }
        });
    }
    
    $(document).on('click','#idlihat_gaji',function(){
        var jam_lembur = $("#jml_jam_lembur").val();
        if(jam_lembur === "")
        {
            swal({
                    title : 'Opss !',
                    text  : '<h4>Anda belum memasukan jumlah jam lembur.</h4>',
                    type  : 'warning'
                }).then(function (){
                    $("#jml_jam_lembur").focus();
                });
                return false;
        }
        else
        {
            total_pendapatan();
            var to_potongan     = $("#idtot_potongan").val();
            var to_pendapatan   = $("#idpendapatan").val();
            if(to_potongan === "")
            {
                to_potongan = 0;
                var gaji_bersih     = parseInt(to_pendapatan)-parseInt(to_potongan);
                $("#idgajibersih").val(gaji_bersih);
            }
            else
            {
                var gaji_bersih     = parseInt(to_pendapatan)-parseInt(to_potongan);
                $("#idgajibersih").val(gaji_bersih);
            }
            
        }
    });
    
    $(document).on('click','#id_selesai',function (){
        
        var jam_lembur      = $("#jml_jam_lembur").val();
        var no_slip         = $("#idslip").val();
        var tanggal         = $("#idtanggal").val();
        var nip             = $("#idnip").val();
        var to_potongan     = $("#idtot_potongan").val();
        var to_pendapatan   = $("#idpendapatan").val();
        var gaji_bersih     = $("#idgajibersih").val();
        
        if(jam_lembur === "")
        {
            swal({
                    title : 'Opss !',
                    text  : '<h4>Anda belum memasukan jumlah jam lembur.</h4>',
                    type  : 'warning'
                }).then(function (){
                    $("#jml_jam_lembur").focus();
                });
                return false;
        }
        else
        {
            $.ajax({
                url : "<?php echo site_url('transaksi_penggajian/simpan_gaji');?>",
                type: "GET",
                data: "jam_lembur="+jam_lembur+"&no_slip="+no_slip+"&tanggal="+tanggal+"&nip="+nip+"&total_potongan="+to_potongan
                       +"&total_pendapatan="+to_pendapatan+"&gaji_bersih="+gaji_bersih,
                success : function (html)
                {
                    $("#list").hide("drop" ,{direction:"right"},900);
                    load_data();
                }
            });
        }
        
    });
    
    function load_data()
    {
        $.ajax({
            url  : "<?php echo site_url('transaksi_penggajian/tampil_load_data');?>",
            type : "GET",
            data : "",
            success : function (html)
            {
                $("#idtable").html(html);
            }
        });
    }
    
</script>
<section class="content-header">
    <h1>Transaksi Penggajian
        <small>Form Transaksi Penggajian</small>
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
            <form id="form" action="#">
                <table class="table table-bordered" onload="load_data()" id="idtable">
                
                </table>
            <div id="list">
                
            </div>
            </form>
        </div>
    </div>
</section>

<div id="mymodal" class="modal fade" tabindex="-1"
     role="dialog" aria-labelledby="myModelLabel" aria-hidden="true">

</div>

<datalist id="nip">
    <?php
        foreach ($pegawai->result() as $p)
        {
            echo "<option value='".$p->nip."'>";
        }
    ?>
</datalist>



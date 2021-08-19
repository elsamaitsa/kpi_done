<style type="text/css">
    #patern{
       /*background:url(<?php echo base_url();?>assets/images/kayu/tileable-wood-texture-veins-knots.jpg);
        border: 3px solid #ff5d00 */
        background: #E4E4E4;
        border-radius: 7px 7px;
    }
</style>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/chosen.css">


<div class="animate-dropdown">
    <div id="breadcrumb-alt">
        <div class="container">
            <div class="breadcrumb-nav-holder minimal">
                <ul>
                    <li class="breadcrumb-item">
                        <a href="<?php echo base_url();?>welcome" ><i class="fa fa-home" style="color:#3d3d3d"></i> Beranda</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?php echo base_url();?>welcome" >Hasil Industri Kayu</a>
                    </li>
                    <li class="breadcrumb-item current">
                        <a href="#">Retail</a>
                    </li>
                    <!--
                    <li class="breadcrumb-item current">
                        <a href="#"></a>
                    </li>
                    -->
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="col-xs-12 col-sm-12  wide" id="patern" style="margin-top: 15px; margin-bottom: 10px; ">
        <div class="grid-list-products">
            <main id="authentication" class="register-form cf-style-1" style="padding-top: 15px">
                <!--<div class="col-xs-3 col-sm-3" style="padding:2px">
                        <a href=""><img class="img-responsive" style="max-width:50%;"  src="<?php echo base_url();?>assets/images/retail.png"></a>
                </div>
                <div class="col-xs-3 col-sm-3" style="padding:2px">
                        <a href=""><img class="img-responsive" style="max-width:50%;" src="<?php echo base_url();?>assets/images/order.png"></a>
                </div>
                <div class="col-xs-3 col-sm-3" style="padding:2px">
                        <a href=""><img class="img-responsive" style="max-width:50%;" src="<?php echo base_url();?>assets/images/kontrak.png"></a>
                </div> -->

                <form action="<?php echo base_url();?>beranda/searching" method="post">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <div class="col-xs-3 col-sm-3" style="padding:2px">
                        <?php
                            $idMember        = $this->session->userdata('id_member');
                            $checkTrolley = $this->db->query("SELECT * from temp_trolley where id_member ='".$idMember."' group by id_member");

                            $rowCheckTrolley =  $checkTrolley->row();

                            @$dataIDMember   =  $rowCheckTrolley->id_member;

                            if ($dataIDMember !="" and $idMember !="" ){
                        ?>

                        <select  class="le-input" id="wilayah" name="wilayah" style="margin-top: 0px; border: 1px solid tomato">
                            <option value="<?php echo $rowCheckTrolley->kode_gm;?>"><?php echo $rowCheckTrolley->nama_gm;?></option>
                        </select>
                       <?php
                            }else{
                       ?>
                        <div id="gm">
                            <select  class="le-input" id="wilayah" required name="wilayah" style="margin-top: 0px; border: 1px solid tomato">
                                <option value="">-PILIH WILAYAH-</option>
                                <option value="4120100">JAWA TENGAH</option>
                                <option value="4130100">JAWA TIMUR</option>
                                <option value="4140100">JAWA BARAT & BANTEN</option>
                            </select>
                        </div>
                       <?php
                            }
                       ?>

                        <select  class="le-input" name="jenis_kayu" style="margin-top: 4px;">
                            <option value="semua-jenis-kayu">-SEMUA JENIS KAYU-</option>
                            <?php
                            for ( $i = 0, $length = count($jenisKayu); $i < $length; $i++ ) {
                                $dataKayu = $jenisKayu[$i];
                            ?>
                                <option value="<?php echo $dataKayu['id_jns_kayu'];?>"><?php echo $dataKayu['jns_kayu'];?></option>
                            <?php
                            }
                            ?>
                        </select>

                        <select  class="le-input" name="mutu" style="margin-top: 4px;">
                            <option value="semua-mutu">-SEMUA MUTU-</option>
                            <?php
                            for ( $i = 0, $length = count($mutu); $i < $length; $i++ ) {
                                $dataMutu = $mutu[$i];
                            ?>
                                <option value="<?php echo $dataMutu['id_mutu'];?>"><?php echo $dataMutu['nama_mutu'];?></option>
                            <?php
                            }
                            ?>
                        </select>

                    </div>

                    <div class="col-xs-3 col-sm-3" style="padding:2px">
                        <?php
                            if ($dataIDMember !="" and $idMember !="" ){
                        ?>

                        <select class="le-input" name="kota" style="border: 1px solid tomato">
                            <option value="<?php echo $rowCheckTrolley->kode_manager;?>"><?php echo $rowCheckTrolley->nama_manager;?></option>
                        </select>
                       <?php
                            }else{
                       ?>
                        <div id="manager">
                            <span id="select_kota">
                                <select class="le-input" required name="kota" style="cursor: no-drop; border: 1px solid tomato; margin-top: 0px;">
                                    <option value="">-PILIH MANAGER/KOTA-</option>
                                </select>
                            </span>
                        </div>
                        <?php
                            }
                        ?>

                        <select  name="sortimen" class="le-input" style="margin-top: 4px;">
                            <option value="semua-sortimen">-SEMUA SORTIMEN-</option>
                            <?php
                            for ( $i = 0, $length = count($sortimen); $i < $length; $i++ ) {
                                $dataSortimen = $sortimen[$i];
                            ?>
                                <option value="<?php echo $dataSortimen['kd_sortimen'];?>"><?php echo $dataSortimen['nama_sortimen'];?></option>
                            <?php
                            }
                            ?>
                        </select>

                        <select  class="le-input" name="jenis_tebangan" style="margin-top: 4px;">
                            <option value="semua-jenis-tebangan">-SEMUA JENIS TEBANGAN-</option>
                            <?php
                            for ( $i = 0, $length = count($jenisTebangan); $i < $length; $i++ ) {
                                $dataJenisTebangan = $jenisTebangan[$i];
                            ?>
                                <option value="<?php echo $dataJenisTebangan['id_asal_kayu'];?>"><?php echo $dataJenisTebangan['asal_kayu'];?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-xs-3 col-sm-3" style="padding:2px">
                        <?php
                            if ($dataIDMember !="" and $idMember !="" ){
                        ?>

                        <select class="le-input" id="type_pembeli" name="tpk" style="border: 1px solid tomato">
                            <option value="<?php echo $rowCheckTrolley->kode_lokasi;?>"><?php echo $rowCheckTrolley->nama_tpk;?></option>
                        </select>
                       <?php
                            }else{
                       ?>
                        <div id="tpk">
                            <span id="select_tpk">
                                <select class="le-input" required id="type_pembeli" name="tpk" style="cursor: no-drop; border: 1px solid tomato; margin-top: 0px;">
                                    <option value="">-PILIH TPK-</option>
                                </select>
                            </span>
                        </div>
                       <?php
                            }
                        ?>

                        <select  class="le-input" name="status" style="margin-top: 4px;">
                            <option value="semua-status">-SEMUA STATUS-</option>
                            <?php
                            for ( $i = 0, $length = count($status); $i < $length; $i++ ) {
                                $dataStatus = $status[$i];
                            ?>
                                <option value="<?php echo $dataStatus['status'];?>"><?php echo $dataStatus['status_ky_logs'];?></option>
                            <?php
                            }
                            ?>
                        </select>

                        <select  class="le-input" name="cacat" style="margin-top: 4px;">
                            <option value="semua-cacat-kayu">-SEMUA CACAT KAYU-</option>
                            <?php
                            for ( $i = 0, $length = count($cacadKayu); $i < $length; $i++ ) {
                                $dataCacadKayu = $cacadKayu[$i];
                            ?>
                                <option value="<?php echo $dataCacadKayu['cacad_ky'];?>"><?php echo $dataCacadKayu['nama_cacad'];?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-xs-3 col-sm-3" style="padding:2px 2px 15px 2px">
                        <button id="i_submit" class="ke-button col-sm-3" style="background: #ff5d00; border-radius: 0px;" type="submit"><i class="fa fa-search" style="color: #ffffff"></i> Cari</button>
                        <?php
                            /*
                            if($this->session->userdata('status')==2){
                                $buttonSearch = '<button id="i_submit" class="ke-button col-sm-3" style="background: #ff5d00; border-radius: 0px;" type="submit"><i class="fa fa-search" style="color: #ffffff"></i> Cari</button>';
                            }
                            if($this->session->userdata('status')==3){
                                $buttonSearch = '<button id="i_submit" onclick="modalSusspend()" class="ke-button col-sm-3" style="background: #ff5d00; border-radius: 0px;"><i class="fa fa-search" style="color: #ffffff"></i> Cari</button>';
                            }else{
                                $buttonSearch = '<button id="i_submit" class="ke-button col-sm-3" style="background: #ff5d00; border-radius: 0px;" type="submit"><i class="fa fa-search" style="color: #ffffff"></i> Cari</button>';
                            }
                            echo $buttonSearch;
                            */
                        ?>




                    </div>

                    <!--<div class="col-xs-12 col-sm-12" style="padding-right: 0px; padding-left: 0px; padding-bottom: 15px">

                    </div>-->
                </form>
            </main>
        </div>
    </div>
</div>


    <section id="" class="color-bg wow fadeInUp animated">
        <h1 class="text-center">Rekapitulasi Ketersediaan Kapling Kayu Retail</h1>
        <div class="container">
            <div class="row">


                <div class="tab-holder">
                    <ul class="nav nav-tabs">

                        <li class="active">
                            <a data-toggle="tab" href="#4120100" aria-expanded="true">Jawa Tengah</a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#4130100" aria-expanded="false">Jawa Timur</a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#4140100" aria-expanded="false">Jawa Barat & Banten</a>
                        </li>

                        <li class="pull-right">

                            <div class="control-group">
                                <ul class="categories-filter">
                                    <li class="dropdown">
                                        <?php
                                            $uriSegment = $this->uri->segment(3);

                                            if($uriSegment ==""){
                                                $whereKayu = "id_jns_kayu = 010";
                                            }else{
                                                $whereKayu = "id_jns_kayu = $uriSegment";
                                            }

                                            $checkKayu  = $this->db->query("SELECT jns_kayu from kode_jenis_kayu where $whereKayu");
                                            $rowKayu    = $checkKayu->row();
                                        ?>
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="" style="padding-top: 11px; padding-bottom: 11px; width: 322px; background: #0CC243">Pilih Jenis Kayu: <?php echo $rowKayu->jns_kayu;?></a>
                                        <ul class="dropdown-menu" role="menu">
                                        <?php
                                            for ( $i = 0, $length = count($jenisKayuRekap); $i < $length; $i++ ) {
                                                $dataKayu = $jenisKayuRekap[$i];
                                        ?>
                                                <li role="presentation">
                                                    <a role="menuitem" href="<?php echo base_url();?>beranda/filter/<?php echo $dataKayu['kd_jns_kayu'];?>" style="width: 322px">
                                                        <?php echo $dataKayu['nama_kayu'];?>
                                                    </a>
                                                </li>
                                        <?php
                                            }
                                        ?>


                                        </ul>
                                    </li>
                                </ul>
                            </div>

                        </li>

                    </ul>
                    <div class="tab-content" style="background: white;  border: 1px solid #ddd; margin-top:-1px ">
                    <?php
                        $dataAlokasi = json_decode($checkAlokasi);
                        foreach($dataAlokasi as $rowGM){
                            if($rowGM->kode == 4120100){
                                $isActive = "active";
                            }else{
                                $isActive = "";
                            }
                    ?>
                        <div id="<?php echo $rowGM->kode;?>" class="tab-pane <?php echo $isActive;?>">

                            <section id="recently-reviewd" style="margin-left: -2px; padding-top: 10px;">
                                <div class="container">

                                    <div class="carousel-holder hover">
                                    <?php
                                        foreach($rowGM->detailManager as $rowManager){
                                            if(count($rowManager->detailTPK) > 0){
                                    ?>
                                        <div class="title-nav" style="margin-top: 0px; margin-bottom: 0px;">
                                            <h2 class="h1" style="margin-top: 10px; font-size: 20px"><?php echo str_replace("KANTOR MANAGER","MANAGER WIL",$rowManager->namaManager);?></h2>
                                            <div class="nav-holder" style="margin-top: 10px;">
                                                <a href="#prev" data-target="#owl-recently-viewed<?php echo $rowManager->kode;?>" class="slider-prev btn-prev fa fa-angle-left"></a>
                                                <a href="#next" data-target="#owl-recently-viewed<?php echo $rowManager->kode;?>" class="slider-next btn-next fa fa-angle-right"></a>
                                            </div>
                                        </div>
                                        <div id="owl-recently-viewed<?php echo $rowManager->kode;?>" class="owl-carousel product-grid-holder">
                                            <?php
                                                foreach($rowManager->detailTPK as $rowTPK){
                                            ?>
                                            <div class="no-margin carousel-item product-item-holder size-small hover">
                                                <div class="product-item">
                                                    <div class="image" style="margin-top: 5px;">
                                                       <?php echo $rowTPK->namaTPK;?>
                                                    </div>
                                                    <div class="body" style="min-height: 30px; margin-top: 15px">
                                                        <div class="title" style="font-size: 30px">
                                                            <a href="<?php echo base_url();?>beranda/searchFromRecap/<?php echo $rowGM->kode;?>/<?php echo $rowManager->kode;?>/<?php echo $rowTPK->kode;?>/010"><?php echo $rowTPK->jumlahKapling;?></a>
                                                        </div>
                                                        <!--<div class="brand">Sharp</div>-->
                                                    </div>

                                                    <div class="prices">
                                                        <div class="" style="margin-top: -1px;"><?php echo $rowTPK->namaKayu;?></div>
                                                    </div>


                                                    <div class="hover-area" style="margin-top: -51px; height: 52px">
                                                        <div class="add-cart-button">
                                                            <a href="<?php echo base_url();?>beranda/searchFromRecap/<?php echo $rowGM->kode;?>/<?php echo $rowManager->kode;?>/<?php echo $rowTPK->kode;?>/010" class="le-button">
                                                                Belanja Sekarang
                                                            </a>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    <?php

                                            }
                                        }
                                    ?>



                                    </div>
                                </div>
                            </section>



                        </div>
                    <?php
                        }
                    ?>

                   </div>
                </div>



            </div>
        </div>
    </section>



    <!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" tabindex="1" role="dialog" aria-labelledby="smallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Pemberitahuan</h4>
        </div>
        <div class="modal-body">
            <p>Akun anda sedang di blokir</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

<script src="<?php echo base_url();?>assets/js/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript">
    $("#chosen-select1").chosen({width: "100%"});
</script>

<script>

function modalSusspend(){
    $('#modal_form').modal('show');
}

$("#wilayah").change(function(){
        //var x = "";
        var dt={wilayah:$("#wilayah").val(),<?php echo $this->security->get_csrf_token_name(); ?> : '<?php echo $this->security->get_csrf_hash(); ?>'}

        $.ajax({
            type:"POST",
            url:"<?php echo base_url(); ?>beranda/select_kota",
            data:dt,
            success:function(msg){
                 $("#select_kota").html(msg);
                //alert(msg)
            }
        })
    });

    $("#select_kota").change(function(){
        var dt={kota:$("#kota").val(),<?php echo $this->security->get_csrf_token_name(); ?> : '<?php echo $this->security->get_csrf_hash(); ?>'}
        $.ajax({
            type:"POST",
            url:"<?php echo base_url(); ?>beranda/select_tpk",
            data:dt,
            success:function(msg){
                $("#select_tpk").html(msg);

            }
        })
    });

</script>

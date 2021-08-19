<div class="content-w100">
    <!-- <img src="<?php echo base_url(); ?>assets/images/pepohonan.jpg" class="img-page1"> -->
    <div class="container container-row">
        <div class="breadcrumbs">
            <div class="container container-row">
                <div class="row">
                    <div class="col-xs-12">
                        <ul>
                            <li class="home"> <a href="<?php echo base_url() ?>">Home</a> <span>/</span>
                            </li>
                            <li class="active">Log Kayu</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="card-content card-layout" style="margin:-50px 0px 0px -50px;">
            <h5 class="font-weight-bold font-20 mb-2"><i class="fa fa-cart-plus mr-1"></i>Retail</h5>
            <form action="<?php echo base_url(); ?>beranda/searching" method="post">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                <div class="row mb-1">
                    <div class="col-sm-4 pl-pr-7">
                        <div class="card-retail">
                            <label class="wrap-retail input" style="margin-top: 15px;">
                                <?php
                                $idMember       = $this->session->userdata('id_member');
                                $checkTrolley   = $this->db->query("SELECT kode_gm, nama_gm, kode_lokasi, nama_tpk, kode_manager, nama_manager, id_jns_kayu, nama_kayu, id_member FROM  temp_trolley a
                                            LEFT JOIN kode_jenis_kayu b ON a.nama_kayu = b.jns_kayu
                                            WHERE id_member ='" . $idMember . "' group by id_member");
                                $rowCheckTrolley =  $checkTrolley->row();
                                @$dataIDMember   =  $rowCheckTrolley->id_member;

                                if ($dataIDMember != "" and $idMember != "") {
                                    ?>
                                    <select id="wilayah" name="wilayah" class="dropdown-retail2">
                                        <option value="<?php echo $rowCheckTrolley->kode_gm; ?>"><?php echo $rowCheckTrolley->nama_gm; ?></option>
                                    </select>
                                <?php
                                } else {
                                    ?>
                                    <div id="gm">
                                        <select id="wilayah" required name="wilayah" class="dropdown-retail2">
                                            <option value="">-PILIH WILAYAH-</option>
                                            <option value="4120100">JAWA TENGAH</option>
                                            <option value="4130100">JAWA TIMUR</option>
                                            <option value="4140100">JAWA BARAT & BANTEN</option>
                                        </select>
                                    </div>
                                <?php
                                }
                                ?>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-4 pl-pr-7">
                        <div class="card-retail">
                            <label class="wrap-retail input" style="margin-top: 15px;">
                                <?php
                                if ($dataIDMember != "" and $idMember != "") {
                                    ?>
                                    <select class="dropdown-retail2" name="kota">
                                        <option value="<?php echo $rowCheckTrolley->kode_manager; ?>"><?php echo $rowCheckTrolley->nama_manager; ?></option>
                                    </select>
                                <?php
                                } else {
                                    ?>
                                    <div id="manager">
                                        <span id="select_kota">
                                            <select class="dropdown-retail2" required name="kota">
                                                <option value="">-PILIH MANAGER/KOTA-</option>
                                            </select>
                                        </span>
                                    </div>
                                <?php
                                }
                                ?>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-4 pl-pr-7">
                        <div class="card-retail">
                            <label class="wrap-retail input" style="margin-top: 15px;">
                                <?php
                                if ($dataIDMember != "" and $idMember != "") {
                                    ?>

                                    <select class="dropdown-retail2" id="type_pembeli" name="tpk">
                                        <option value="<?php echo $rowCheckTrolley->kode_lokasi; ?>"><?php echo $rowCheckTrolley->nama_tpk; ?></option>
                                    </select>
                                <?php
                                } else {
                                    ?>
                                    <div id="tpk">
                                        <span id="select_tpk">
                                            <select class="dropdown-retail2" required id="type_pembeli" name="tpk">
                                                <option value="">-PILIH TPK-</option>
                                            </select>
                                        </span>
                                    </div>
                                <?php
                                }
                                ?>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-sm-4 pl-pr-7">
                        <div class="card-retail">
                            <h6 class="required font-12 text-muted">Pilih Jenis Kayu</h6>
                            <label class="wrap-retail input">
                                <?php
                                if ($dataIDMember != "" and $idMember != "") {
                                    ?>
                                    <select class="dropdown-retail1" name="jenis_kayu">
                                        <option value="<?php echo $rowCheckTrolley->id_jns_kayu; ?>"><?php echo $rowCheckTrolley->nama_kayu; ?></option>
                                    </select>
                                <?php
                                } else {
                                    ?>
                                    <div id="kayu">
                                        <select class="dropdown-retail1" name="jenis_kayu">
                                            <?php
                                                for ($i = 0, $length = count($jenisKayu); $i < $length; $i++) {
                                                    $dataKayu = $jenisKayu[$i];
                                                    ?>
                                                <option value="<?php echo $dataKayu['id_jns_kayu']; ?>"><?php echo $dataKayu['jns_kayu']; ?></option>
                                            <?php
                                                }
                                                ?>
                                        </select>
                                    </div>
                                <?php
                                }
                                ?>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-4 pl-pr-7">
                        <div class="card-retail">
                            <h6 class="required font-12 text-muted">Pilih Sortimen</h6>
                            <label class="wrap-retail input">
                                <select name="sortimen" class="dropdown-retail1">
                                    <option value="semua-sortimen">SEMUA SORTIMEN</option>
                                    <?php
                                    for ($i = 0, $length = count($sortimen); $i < $length; $i++) {
                                        $dataSortimen = $sortimen[$i];
                                        ?>
                                        <option value="<?php echo $dataSortimen['kd_sortimen']; ?>"><?php echo $dataSortimen['nama_sortimen']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-4 pl-pr-7">
                        <div class="card-retail">
                            <h6 class="required font-12 text-muted">Pilih Status</h6>
                            <label class="wrap-retail input">
                                <select class="dropdown-retail1" name="status">
                                    <option value="semua-status">SEMUA STATUS</option>
                                    <?php
                                    for ($i = 0, $length = count($status); $i < $length; $i++) {
                                        $dataStatus = $status[$i];
                                        ?>
                                        <option value="<?php echo $dataStatus['status']; ?>"><?php echo $dataStatus['status_ky_logs']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-sm-4 pl-pr-7">
                        <div class="card-retail">
                            <h6 class="required font-12 text-muted">Pilih Mutu Kayu</h6>
                            <label class="wrap-retail input">
                                <select class="dropdown-retail1" name="mutu">
                                    <option value="semua-mutu">SEMUA MUTU</option>
                                    <?php
                                    for ($i = 0, $length = count($mutu); $i < $length; $i++) {
                                        $dataMutu = $mutu[$i];
                                        ?>
                                        <option value="<?php echo $dataMutu['id_mutu']; ?>"><?php echo $dataMutu['nama_mutu']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-4 pl-pr-7">
                        <div class="card-retail">
                            <h6 class="required font-12 text-muted">Pilih Jenis Tebangan</h6>
                            <label class="wrap-retail input">
                                <select class="dropdown-retail1" name="jenis_tebangan">
                                    <option value="semua-jenis-tebangan">SEMUA JENIS TEBANGAN</option>
                                    <?php
                                    for ($i = 0, $length = count($jenisTebangan); $i < $length; $i++) {
                                        $dataJenisTebangan = $jenisTebangan[$i];
                                        ?>
                                        <option value="<?php echo $dataJenisTebangan['id_asal_kayu']; ?>"><?php echo $dataJenisTebangan['asal_kayu']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-4 pl-pr-7">
                        <div class="card-retail">
                            <h6 class="required font-12 text-muted">Pilih Cacat Kayu</h6>
                            <label class="wrap-retail input">
                                <select class="dropdown-retail1" name="cacat">
                                    <option value="semua-cacat-kayu">SEMUA CACAT KAYU</option>
                                    <?php
                                    for ($i = 0, $length = count($cacadKayu); $i < $length; $i++) {
                                        $dataCacadKayu = $cacadKayu[$i];
                                        ?>
                                        <option value="<?php echo $dataCacadKayu['cacad_ky']; ?>"><?php echo $dataCacadKayu['nama_cacad']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="mt-2 mb-5">
                    <button id="i_submit" type="submit" class="btn btn-main float-right" id="cariKayu">Cari Kayu</button>
                </div>
            </form>
        </div> -->

        <div class="container container-row">
            <div class="box sd-box mt-2 mb-2">
                <div class="box-header d-flex" style="padding:1px 5px 6px 5px">
                    <h6 class="v-middle ml-1"><i class="icon-filter-3 mr-1"></i><span class="font-weight-bold font-14">Filter</span></h6>
                    <h6 class="v-middle ml-3"><i class="icon-sort mr-1" id="click_guest" style="cursor: pointer;"></i><span class="font-weight-bold font-14">Sort</span></h6>
                </div>
                <div id="content_2">
                    <div class="header-row">
                        <h5 class="font-weight-bold text-left" style="margin-left:10px; margin-top:5px;">Sorting</h5>
                    </div>
                    <div style="padding: 3px 12px;">
                        <div class="mt-1">
                            <input type="checkbox" class="checkbox-sm" id="checkbox1"><span class="ml-1 text-black1" id="text1">Masa Aktif
                                Kontrak</span>
                        </div>
                        <div class="mt-1">
                            <input type="checkbox" class="checkbox-sm" id="checkbox2"><span class="ml-1 text-black1">Berakhir
                                Kontrak</span>
                        </div>
                        <div class="mt-1">
                            <input type="checkbox" class="checkbox-sm" id="checkbox3"><span class="ml-1 text-black1">Sortimen</span>
                        </div>
                        <div class="mt-1">
                            <input type="checkbox" class="checkbox-sm" id="checkbox4"><span class="ml-1 text-black1">Dif</span>
                        </div>
                        <div class="mt-1">
                            <input type="checkbox" class="checkbox-sm" id="checkbox5"><span class="ml-1 text-black1">Tahun
                                tebangan</span>
                        </div>
                        <div class="mt-1">
                            <input type="checkbox" class="checkbox-sm" id="checkbox6"><span class="ml-1 text-black1">Nomor
                                Kapling</span>
                        </div>
                        <div class="mt-1">
                            <input type="checkbox" class="checkbox-sm" id="checkbox7"><span class="ml-1 text-black1">Invoice</span>
                        </div>
                    </div>
                    <div class="text-center mt-1 mb-1">
                        <button class="btn btn-sm btn-green" id="btn_pilih">Pilih</button>
                    </div>
                </div>
                <div class="box-body" style="margin: 15px 1em;">
                    <form action="<?php echo base_url(); ?>beranda/searching" method="post">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="csrf" style="width: 500px;">
                        <div class="row mb-1">
                            <div class="col-sm-4 pl-pr-7">
                                <div class="card-retail">
                                    <label class="wrap-retail input">
                                        <?php if ($dataIDMember != "" and $idMember != "") { ?>
                                            <select id="wilayah" name="wilayah" class="dropdown-retail2">
                                                <option value="<?php echo $rowCheckTrolley->kode_gm; ?>"><?php echo $rowCheckTrolley->nama_gm; ?></option>
                                            </select>
                                            <!-- <select class="dropdown-retail2">
                                                <option>Jawa Tengah</option>
                                            </select> -->
                                        <?php } else { ?>
                                            <div id="gm">
                                                <select id="wilayah" required name="wilayah" class="dropdown-retail2">
                                                    <option selected="selected" disabled>Pilih Wilayah</option>
                                                    <option value="4120100">JAWA TENGAH</option>
                                                    <option value="4130100">JAWA TIMUR</option>
                                                    <option value="4140100">JAWA BARAT & BANTEN</option>
                                                </select>
                                            </div>
                                        <?php } ?>
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-4 pl-pr-7">
                                <div class="card-retail">
                                    <label class="wrap-retail input">
                                        <?php if ($dataIDMember != "" and $idMember != "") { ?>
                                            <select class="dropdown-retail2" name="kota">
                                                <option value="<?php echo $rowCheckTrolley->kode_manager; ?>"><?php echo $rowCheckTrolley->nama_manager; ?></option>
                                            </select>
                                        <?php } else { ?>
                                            <div id="manager">
                                                <span id="select_kota">
                                                    <select class="dropdown-retail2" required name="kota">
                                                        <option selected="selected" disabled>Pilih Manager/Kota</option>
                                                    </select>
                                                </span>
                                            </div>
                                        <?php } ?>


                                        <!-- <select class="dropdown-retail2">
                                            <option>Manager Cepu</option>
                                        </select> -->
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-4 pl-pr-7">
                                <div class="card-retail">
                                    <label class="wrap-retail input">
                                        <?php if ($dataIDMember != "" and $idMember != "") { ?>
                                            <select class="dropdown-retail2" id="type_pembeli" name="tpk">
                                                <option value="<?php echo $rowCheckTrolley->kode_lokasi; ?>"><?php echo $rowCheckTrolley->nama_tpk; ?></option>
                                            </select>
                                        <?php } else { ?>
                                            <div id="tpk">
                                                <span id="select_tpk">
                                                    <select class="dropdown-retail2" required id="type_pembeli" name="tpk">
                                                        <option selected="selected" disabled>Pilih TPK</option>
                                                    </select>
                                                </span>
                                            </div>
                                        <?php } ?>

                                        <!-- <select class="dropdown-retail2">
                                            <option>TPK Sale</option>
                                        </select> -->
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-sm-4 pl-pr-7">
                                <h6 class="required font-12 text-muted">Pilih Jenis Kayu</h6>
                                <div class="card-retail">
                                    <label class="wrap-retail input">
                                        <?php if ($dataIDMember != "" and $idMember != "") { ?>
                                            <select class="dropdown-retail2" name="jenis_kayu">
                                                <option value="<?php echo $rowCheckTrolley->id_jns_kayu; ?>"><?php echo $rowCheckTrolley->nama_kayu; ?></option>
                                            </select>
                                        <?php } else { ?>
                                            <div id="kayu">
                                                <select class="dropdown-retail2" name="jenis_kayu">
                                                    <?php
                                                        for ($i = 0, $length = count($jenisKayu); $i < $length; $i++) {
                                                            $dataKayu = $jenisKayu[$i];
                                                            ?>
                                                        <option value="<?php echo $dataKayu['id_jns_kayu']; ?>"><?php echo $dataKayu['jns_kayu']; ?></option>
                                                    <?php
                                                        }
                                                        ?>
                                                </select>
                                            </div>
                                        <?php } ?>

                                        <!-- <select class="dropdown-retail2">
                                            <option>Jati</option>
                                        </select> -->
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-4 pl-pr-7">
                                <h6 class="required font-12 text-muted">Pilih Sortimen</h6>
                                <div class="card-retail">
                                    <label class="wrap-retail input">

                                        <label class="wrap-retail input">
                                            <select name="sortimen" class="dropdown-retail2">
                                                <option value="semua-sortimen">Semua Sortimen</option>
                                                <?php
                                                for ($i = 0, $length = count($sortimen); $i < $length; $i++) {
                                                    $dataSortimen = $sortimen[$i];
                                                    ?>
                                                    <option value="<?php echo $dataSortimen['kd_sortimen']; ?>"><?php echo $dataSortimen['nama_sortimen']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </label>
                                        <!-- <select class="dropdown-retail2">
                                            <option>Semua Status</option>
                                        </select> -->
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-4 pl-pr-7">
                                <h6 class="required font-12 text-muted">Pilih Status</h6>
                                <div class="card-retail">
                                    <label class="wrap-retail input">
                                        <select class="dropdown-retail2" name="status">
                                            <option value="semua-status">Semua Status</option>
                                            <?php
                                            for ($i = 0, $length = count($status); $i < $length; $i++) {
                                                $dataStatus = $status[$i];
                                                ?>
                                                <option value="<?php echo $dataStatus['status']; ?>"><?php echo $dataStatus['status_ky_logs']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-sm-4 pl-pr-7">
                                <h6 class="required font-12 text-muted">Pilih Mutu Kayu</h6>
                                <div class="card-retail">
                                    <label class="wrap-retail input">
                                        <select class="dropdown-retail2" name="mutu">
                                            <option value="semua-mutu">Semua Mutu</option>
                                            <?php
                                            for ($i = 0, $length = count($mutu); $i < $length; $i++) {
                                                $dataMutu = $mutu[$i];
                                                ?>
                                                <option value="<?php echo $dataMutu['id_mutu']; ?>"><?php echo $dataMutu['nama_mutu']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </label>
                                    <!-- <label class="wrap-retail input">
                                        <select class="dropdown-retail2">
                                            <option>Semua Mutu Kayu</option>
                                        </select>
                                    </label> -->
                                </div>
                            </div>
                            <div class="col-sm-4 pl-pr-7">
                                <h6 class="required font-12 text-muted">Pilih Jenis Tebangan</h6>
                                <div class="card-retail">
                                    <label class="wrap-retail input">
                                        <select class="dropdown-retail2" name="jenis_tebangan">
                                            <option value="semua-jenis-tebangan">Semua Jenis Tebangan</option>
                                            <?php
                                            for ($i = 0, $length = count($jenisTebangan); $i < $length; $i++) {
                                                $dataJenisTebangan = $jenisTebangan[$i];
                                                ?>
                                                <option value="<?php echo $dataJenisTebangan['id_asal_kayu']; ?>"><?php echo $dataJenisTebangan['asal_kayu']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </label>
                                    <!-- <label class="wrap-retail input">
                                        <select class="dropdown-retail2">
                                            <option>Semua Tebangan</option>
                                        </select>
                                    </label> -->
                                </div>
                            </div>
                            <div class="col-sm-4 pl-pr-7">
                                <h6 class="required font-12 text-muted">Pilih Cacat Kayu</h6>
                                <div class="card-retail">
                                    <label class="wrap-retail input">
                                        <select class="dropdown-retail2" name="cacat">
                                            <option value="semua-cacat-kayu">Semua Cacat Kayu</option>
                                            <?php
                                            for ($i = 0, $length = count($cacadKayu); $i < $length; $i++) {
                                                $dataCacadKayu = $cacadKayu[$i];
                                                ?>
                                                <option value="<?php echo $dataCacadKayu['cacad_ky']; ?>"><?php echo $dataCacadKayu['nama_cacad']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </label>
                                    <!-- <label class="wrap-retail input">
                                        <select class="dropdown-retail2">
                                            <option>Semua Catat Kayu</option>
                                        </select>
                                    </label> -->
                                </div>
                            </div>
                        </div>
                        <div class="mt-2 d-flex" style="width:100%">
                            <button id="i_submit" type="submit" class="btn btn-main ml-auto" id="cariKayu">Cari Kayu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="divCardEmpty">
            <div class="row">
                <div class="col-sm-6">
                    <h6 class="font-weight-bold font-13 mt-1">Rekapitulasi Ketersediaan Kayu Retail</h6>
                </div>
                <div class="col-sm-3 float-right">
                    <label class="wrap-small-retail input">
                        <select class="dropdown-small-retail font-12" onchange="getKayu(this)">
                            <option class="text-muted">Pilih Jenis Kayu</option>
                            <?php
                            $uriSegment = $this->uri->segment(3);

                            if ($uriSegment == "") {
                                $whereKayu = "id_jns_kayu = 010";
                            } else {
                                $whereKayu = "id_jns_kayu = $uriSegment";
                            }

                            $checkKayu  = $this->db->query("SELECT jns_kayu from kode_jenis_kayu where $whereKayu");
                            $rowKayu    = $checkKayu->row();
                            ?>

                            <?php
                            for ($i = 0, $length = count($jenisKayuRekap); $i < $length; $i++) {
                                $dataKayu = $jenisKayuRekap[$i];
                                ?>
                                <option class="text-muted" value="<?php echo $dataKayu['kd_jns_kayu']; ?>" <?php if ($uriSegment == $dataKayu['kd_jns_kayu']) {
                                                                                                                    echo 'selected';
                                                                                                                } ?>><?php echo $dataKayu['nama_kayu']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </label>
                </div>
            </div>
            <div class="card-tab" style="padding:16px 0px;">
                <div class="row tab_button_wil" id="tab">
                    <div class="col-sm-4">
                        <!-- <button class=""> -->
                            <a href="#4120100" data-tab="4120100" class="tablinks_mini obj-middle font-weight-bold ">Jawa
                                Tengah</a>
                            <!-- </button> -->
                        </div>
                    <div class="col-sm-4">
                        <!-- <button class=""> -->
                            <a href="#4130100" data-tab="4130100" class="tablinks_mini obj-middle font-weight-bold">Jawa
                                Timur</a>
                            </button>
                            </div>
                    <div class="col-sm-4">
                        <!-- <button class=""> -->
                            <a href="#4140100" data-tab="4140100" class="tablinks_mini obj-middle font-weight-bold">Jawa Barat &
                                Banten</a>
                            <!-- </button> -->
                    </div>
                </div>
            </div>
            <div id="tabs">
                <?php
                $dataAlokasi = json_decode($checkAlokasi);
                foreach ($dataAlokasi as $rowGM) {
                    if ($rowGM->kode == 4120100) {
                        $isActive = "tab";
                    } else {
                        $isActive = "tab hide";
                    }
                    ?>
                    <div id="<?php echo $rowGM->kode; ?>" class=" tab text-center <?php echo $isActive; ?>" data-tab="<?php echo $rowGM->kode; ?>">
                        <?php
                            foreach ($rowGM->detailManager as $rowManager) {
                                if (count($rowManager->detailTPK) > 0) {
                                    ?>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h5 class="font-weight-bold text-left"><?php echo str_replace("KANTOR MANAGER", "MANAGER WIL", $rowManager->namaManager); ?></h5>
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <?php $no = 0; ?>
                                    <?php foreach ($rowManager->detailTPK as $rowTPK) { ?>
                                        <?php if ($no == 4) { ?>
                                            <?php $no = 0; ?>
                                        <?php } ?>
                                        <?php $no++; ?>
                                        <div class="col-sm-3 mb-2" style="height:130px">
                                            <a href="<?php echo base_url(); ?>beranda/searchFromRecap/<?php echo $rowGM->kode; ?>/<?php echo $rowManager->kode; ?>/<?php echo $rowTPK->kode; ?>/<?php echo $this->uri->segment(3); ?>" style="text-transform: none;cursor:pointer">
                                                <div class="box-card4">
                                                    <h6 class="font-weight-bold text-muted" style="text-align: start;"><?php echo $rowTPK->namaTPK; ?></h6>
                                                    <h6 class="text-muted1" style="text-align: start; font-weight:700"><?php echo $rowTPK->jumlahKapling; ?></h6>
                                                    <h6 class="text-main v-middle" style="text-align: start;"><?php echo $rowTPK->namaKayu; ?></h6>
                                                </div>
                                            </a>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content card-login">
            <div class="modal-header" style="border-bottom: 0px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="mt-3 text-center">
                    <i class="fa fa-exclamation mr-1 font-20 text-main"></i><span class="font-weight-bold text-main">Pemberitahuan</span>
                </div>
            </div>
            <div class="modal-body text-center" style="padding:0px 45px 30px 45px">
                <p>Akun anda sedang di blokir.</p>
            </div>
            <div class="modal-footer no-margin-top">
                <button class="btn btn-block btn-outline-main" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        $('#tab div a[href^="#"]').on('click', function(e) {
            e.preventDefault()
            var tab = $(this).data('tab');
            $('#tab div a[href^="#"]').removeClass('active');
            $(this).addClass('active');
            $("#tabs .tab:not('.hide')").stop().fadeOut('fast', function() {
                $(this).addClass('hide');
                $('#tabs .tab[data-tab="' + tab + '"]').fadeIn('slow').removeClass('hide');
            });
        });

        $("#wilayah").change(function() {
            //var x = "";
            var dt = {
                wilayah: $("#wilayah").val(),
                <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
            }

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>beranda/select_kota",
                data: dt,
                success: function(msg) {
                    var data = JSON.parse(msg);
                    $("#select_kota").html(data.combo);
                }
            })
        });

        $("#select_kota").change(function() {
            var dt = {
                kota: $("#kota").val(),
                <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
            }
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>beranda/select_tpk",
                data: dt,
                success: function(msg) {
                    var data = JSON.parse(msg);
                    $("#select_tpk").html(data.combo);

                }
            })
        });
    });

    function modalSusspend() {
        $('#modal_form').modal('show');
    }

    function getKayu(x) {
        var value = x.value;
        window.location.assign("<?php echo base_url(); ?>beranda/filter/" + value);
    }
</script>
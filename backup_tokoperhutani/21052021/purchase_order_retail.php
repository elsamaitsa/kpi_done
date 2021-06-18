<body>
    <!-- BREADCRUMB -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <ul>
                        </li>
                        <li> <?php foreach ($detail_produk->result() as $result2) { ?>
                                <a href="<?php echo base_url(); ?>detail_produk?id=<?php echo $result2->id; ?>" title="">Detail
                                    <?php echo $result2->nama_kategori; ?>
                                </a> <span>/ </span>
                            <?php } ?>
                        </li>
                        <li class="active">Order</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container container-row mt-3 mb-3">
        <div class="row" style="padding: 30px 0; align-items:center; background-color: #27AE60; border-radius: 8px;">
            <div class="col-sm-2">
                <img class="ml-2" src="./assets/images/ic_shopping_cart.png" alt="">
            </div>
            <div class="col-sm-10">
                <label class="fw-5 mt-1" style="color: white; font-size: 18px; text-align:center;">Ini halaman terakhir proses belanja
                    anda, pastikan semua sudah benar</label>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mt-3 mb-3">
                <span class="fw-7 fs-18 ">Produk yang dibeli</span>
            </div>
        </div>

        <?php foreach ($detail_produk->result_array() as $result) { ?>
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    <?php if ($detail_produk->result_array()[0]['url_foto'] != '') { ?>
                        <img src="<?php echo base_url(); ?>produk_retail/<?php echo $detail_produk->result_array()[0]['url_foto'] ?>" alt="Foto Produk" style="width: 250px; height:250px;">

                    <?php } else { ?>
                        <img src="<?php echo base_url(); ?>assets/images/products/default.png" alt="Foto Produk" style="width: 250px; height:250px;">

                    <?php } ?>

                </div>
                <div class="col-md-9 col-sm-12">
                    <div style="display: flex; flex-direction: column;">
                        <span class="fw-6 mt-1" style="font-size: 24px;"><?php echo $result['nama_kategori'] ?></span>
                        <span class="fw-4 fs-14 mt-1"><?php echo substr($result['deskripsi_produk'], 0, 100) . '...' ?>
                        </span>
                        <span class="fw-7 mt-1" style="font-size: 24px;">IDR <?php echo number_format(($result['price_dn']), 0, '.', '.'); ?></span>
                        <input value="<?php echo $result['price_dn'] ?>" hidden id="harga_produk">
                        <input value="<?php echo $result['id'] ?>" hidden id="id_produk_kategori">
                        <div class="d-flex mt-2">
                            <button class="fw-6 fs-14" id="btn_minus" style="color: white; border:none; height: 24px; width: 24px; border-radius: 12px; display: flex; justify-content: center; align-items: center; background-color: #27AE60;">-</button>
                            <label id="quantity_label" class="fw-6 fs-14 text-center" style="border: none; border-bottom: 1px solid #E0E0E0; background-color: #F6F6F6; width: 40px;">1</label>
                            <input id="quantity_hidden" value="1" class="hidden">
                            <button class="fw-6 fs-14" id="btn_plus" style="color: white; border:none; height: 24px; width: 24px; border-radius: 12px; display: flex; justify-content: center; align-items: center; background-color: #27AE60;">+</button>
                            <span class="fw-6 fs-14 ml-1 mr-3"><?php echo $result['nama_unit']; ?></span>
                            <input value="<?php echo $result['singkatan']; ?>" class="hidden" id="satuan_produk">
                            <input value="<?php echo $result['product_weight']; ?>" class="hidden" id="berat_produk">
                            <input value="<?php echo $result['gram_multiplier']; ?>" class="hidden" id="gram_multiplier">
                            <input value="<?php echo $result['stok']; ?>" class="hidden" id="sisa_stok">
                            <input value="<?php echo $checkKeranjang[0]['total_quantity'] ?>" class="hidden" id="stok_keranjang">
                        </div>
                        <div class="mt-2" style="padding: 10px 20px; background-color: #F6F6F6; border-radius: 8px; display: flex; align-items: center;">
                            <img src="./assets/images/ic_edit.png" height="23px" alt="">
                            <input placeholder="Tambahkan Catatan" id="catatan" class="fw-4 fs-12 ml-1 tambah_catatan" style="border-bottom: 1px solid #828282; color: #828282; background:transparent; border-top:none; border-right:none; border-left:none;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mt-4">
                    <span class="fw-7 fs-18">Pengiriman</span>
                </div>
            </div>

            <div class="row">
                <a href="javascript:void()" id="pilih_alamat_toko" class="col-md-12 mt-2" style="padding: 12px 24px; background-color: #F6F6F6; border-radius: 8px; display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center;">
                        <img src="./assets/images/ic_location.png" class="mr-1" height="32px" alt="">
                        <div style="display: flex; flex-direction: column; justify-content: center;">
                            <span class="fw-4 fs-12">Pengiriman Dari</span>

                            <?php foreach ($detail_toko->result_array() as $key => $result_alamat_toko) { ?>
                                <?php if ($key < 1) { ?>
                                    <span class="fw-5 fs-14" style="color: #27AE60;"><span id="selected_id_toko" class="hidden"><?php echo $result_alamat_toko['id'] ?></span><span id="selected_provinsi_toko"><?php echo $result_alamat_toko['nama_provinsi'] ?></span>, <span id="selected_kota_toko"><?php echo $result_alamat_toko['nama_kota'] ?></span><span id="selected_id_kota_toko" hidden><?php echo $result_alamat_toko['id_city'] ?></span>, <span id="selected_id_kecamatan_toko" hidden><?php echo $result_alamat_toko['id_subdisctrict'] ?></span><span id="selected_kecamatan_toko"><?php echo $result_alamat_toko['nama_kecamatan'] ?></span>, <span id="selected_kode_pos_toko"><?php echo $result_alamat['kode_pos'] ?></span></span>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                    <img src="./assets/images/entypo_chevron-right.png" alt="">
                </a>
            </div>

            <div class="row">
                <a href="javascript:void()" id="pilih_alamat" class="col-md-12 mt-2" style="padding: 12px 24px; background-color: #F6F6F6; border-radius: 8px; display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center;">
                        <img src="./assets/images/ic_location.png" class="mr-1" height="32px" alt="">
                        <div style="display: flex; flex-direction: column; justify-content: center;">
                            <span class="fw-4 fs-12">Tujuan Pengiriman</span>

                            <?php foreach ($alamat->result_array() as $key => $result_alamat) { ?>
                                <?php if ($key < 1) { ?>
                                    <span class="fw-5 fs-14" style="color: #27AE60;"><span id="selected_id" class="hidden"><?php echo $result_alamat['id'] ?></span><span id="selected_alamat"><?php echo $result_alamat['alamat'] ?></span>, <span id="selected_provinsi"><?php echo $result_alamat['province_name'] ?></span>, <span id="selected_kota"><?php echo $result_alamat['city_name'] ?></span><span id="selected_id_kota" hidden><?php echo $result_alamat['id_city'] ?></span>, <span id="selected_id_kecamatan" hidden><?php echo $result_alamat['id_subdisctrict'] ?></span><span id="selected_kecamatan"><?php echo $result_alamat['subdistrict_name'] ?></span>, <span id="selected_kode_pos"><?php echo $result_alamat['kode_pos'] ?></span></span>
                                <?php } ?>
                            <?php } ?>
                            <?php if (count($alamat->result_array()) == 0) { ?>
                                <span class="fw-5 fs-14" style="color: #27AE60;"><span id="selected_id" class="hidden"></span><span id="selected_alamat"></span><span id="selected_provinsi"></span><span id="selected_kota"></span><span id="selected_id_kota" hidden></span><span id="selected_id_kecamatan"></span><span id="selected_kecamatan"></span><span id="selected_kode_pos"></span></span>

                            <?php } ?>
                        </div>
                    </div>
                    <img src="./assets/images/entypo_chevron-right.png" alt="">
                </a>
            </div>

            <div class="row">
                <a href="javascript:void()" id="pilih_kurir" class="col-sm-6 mt-2" style="padding: 24px; background-color: #F6F6F6; border-radius: 8px; display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center;">
                        <img class="mr-1" src="./assets/images/ic_shipping.png" height="23px" alt="">
                        <div style="display: flex; flex-direction: column; justify-content: center;">
                            <span class="fw-4 fs-12">Pilihan Kurir</span>
                            <span class="fw-5 fs-14" style="color: #27AE60;" id="selected_kurir"></span>
                            <span class="fw-5 fs-14" style="color: #27AE60;" id="selected_id_kurir" hidden></span>
                        </div>
                    </div>
                    <img src="./assets/images/entypo_chevron-right.png" alt="">
                </a>

                <a href="javascript:void()" id="pilih_pengiriman" class="col-sm-6 mt-2" style="padding: 24px; background-color: #F6F6F6; border-radius: 8px; display: flex; justify-content: space-between; align-items: center;">
                    <div id="toggle-" style="display: flex; align-items: center;">
                        <img class="mr-1" src="./assets/images/ic_timer.png" height="23px" alt="">
                        <div style="display: flex; flex-direction: column; justify-content: center;">
                            <span class="fw-4 fs-12">Pilihan Pengiriman</span>
                            <div style="display: flex; justify-content: center;">
                                <span class="fw-5 fs-14 mr-1" style="color: #27AE60;" id="nama_pengiriman"></span><span style="color: #27AE60;" id="estimasi_pengiriman"></span><span id="harga_pengiriman" hidden></span>

                            </div>
                        </div>
                    </div>
                    <img src="./assets/images/entypo_chevron-right.png" alt="">
                </a>
            </div>

            <div class="row">
                <div class="col-md-12 mt-4">
                    <span class="fw-7 fs-18">Metode Pembayaran</span>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-12" style="background-color: #F6F6F6; border-radius: 8px; padding: 10px 20px;">
                    <a href="javascript:void()" id="ganti_pembayaran">
                        <div id="after_pilihan_pembayaran" style="display: flex; justify-content: space-between; align-content: center;">
                            <div style="display: flex; flex-direction:column;">
                                <span>Pilihan Pembayaran</span>
                                <div style="display: flex;">
                                    <span id="selected_image_bank" class="mr-1"></span>
                                    <span class="fw-5 fs-14" id="selected_nama_bank"></span>
                                </div>

                            </div>
                            <div>
                                <span class="ml-2 fw-5 fs-14" style="color: #219653;">Ganti Metode Pembayaran</span>
                                <img src="<?php echo base_url(); ?>assets/images/entypo_chevron-right.png" alt="">
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mt-4">
                    <span class="fw-7 fs-18">Ringkasan Belanja</span>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mt-2" style="display: flex; flex-direction: column; flex: 2; background-color: #F6F6F6; padding: 20px; border-radius: 8px;">
                    <div>
                        <div style="display: flex; justify-content: space-between;">
                            <span class="fw-4 fs-14">Total Harga (<span id="total_barang">1</span> Barang)</span>
                            <span class="fw-4 fs-14">IDR <span id="total_harga"><?php echo number_format(($result['price_dn']), 0, '.', '.'); ?></span></span>
                            <input hidden value="<?php echo $result['price_dn'] ?>" id="total_harga_hidden">
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span class="fw-4 fs-14">Total Ongkos Kirim</span>
                            <span class="fw-4 fs-14">IDR <span id="total_ongkos_kirim">0</span></span>
                            <input hidden value="0" id="total_ongkos_kirim_hidden">
                        </div>
                        <!-- <div style="display: flex; justify-content: space-between;">
                                    <div>
                                        <input type="checkbox" class="mr-1"> <span class="fw-4 fs-14 ">Asuransi
                                            Pengiriman</span>
                                    </div>
                                    <span class="fw-4 fs-14 ">Rp -</span>
                                </div> -->
                        <hr style="margin: 18px 0;">
                        <div style="display: flex; justify-content: space-between;">
                            <span class="fw-7 fs-14">Total Tagihan</span>
                            <span class="fw-7 fs-14" style="color: #F2994A;">IDR <span id="total_tagihan"><?php echo number_format(($result['price_dn']), 0, '.', '.'); ?></span></span>
                            <input hidden value="<?php echo $result['price_dn'] ?>" id="total_tagihan_hidden">
                        </div>
                    </div>

                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-9"></div>
                <div class="col-md-3">
                    <button id="btn_bayar" style="border: none; width: 100%; background-color: #27AE60; border-radius: 8px; padding: 12px 0; color: white;">
                        Bayar
                    </button>
                </div>
            </div>
        <?php } ?>

    </div>

    <div class="modal fade" id="pilih_pembayaran_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="fw-6 fs-14">Pilih Pembayaran</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <input type="hidden" name="p" value="" id="p">
                <div class="modal-body">
                    <span class="fw-5 fs-14" style="margin: 18px 32px;">Transfer</span>
                    <div style="display: flex; flex-direction:column">
                        <?php foreach ($bankRetail as $bankResult) { ?>
                            <a href="javascript:void()" class="mt-1">
                                <div style="display: flex; margin: 5px 32px; align-items: center; background-color: #F6F6F6; border-radius: 8px; padding: 20px 30px;">
                                    <input type="radio" id="dataPembayaran" class="mr-1" name="dataPembayaran" value="<?php echo $bankResult['name'] ?>" data-image="<?php echo $bankResult['url_image'] ?>" data-id="<?php echo $bankResult['id'] ?>" data-cbankid="<?php echo $bankResult['c_bank_id'] ?>" data-accountno="<?php echo $bankResult['account_no'] ?>">
                                    <!-- <img class="mr-2" src="./assets/images/checkmark-circle-2 1.png" height="20px" alt=""> -->
                                    <img src="./assets/images/bank/<?php echo $bankResult['url_image'] ?>" height="20px" style="margin-right: 10px;" alt="">
                                    <span class="fw-4 fs-14"><?php echo $bankResult['name'] ?></span>
                                </div>
                            </a>
                        <?php } ?>

                    </div>


                    <div class="mt-5" style="display: flex; justify-content: flex-end; margin: 0 32px;">
                        <button class="fw-5 fs-18" id="btn_simpan_pembayaran" style="border: none; background-color: transparent; padding: 12px 0; width: 40%; background-color: #27AE60; border-radius: 8px; color: white;">
                            Simpan
                        </button>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:0px;">
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="pilih_pengiriman_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="fw-6 fs-14">Pilih Pengiriman</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <input type="hidden" name="p" value="" id="p">
                <div class="modal-body">
                    <div id="rajaongkir_pengiriman_modal">

                    </div>

                    <div class="mt-5" style="display: flex; justify-content: flex-end; margin: 0 32px;">
                        <button class="fw-5 fs-18" id="btn_simpan_pengiriman" style="border: none; background-color: transparent; padding: 12px 0; width: 40%; background-color: #27AE60; border-radius: 8px; color: white;">
                            Simpan
                        </button>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:0px;">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="pilih_kurir_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="fw-6 fs-14">Pilih Kurir</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <input type="hidden" name="p" value="" id="p">
                <div class="modal-body">
                    <!-- <a href="javascript:void()">
                        <div style="display: flex; align-items: center; background-color: #F6F6F6; border-radius: 8px; padding: 20px 30px;">
                            <img class="mr-2" src="./assets/images/checkmark-circle-2 1.png" height="20px" alt="">
                            <span class="fw-6 fs-14">Anter Aja</span>
                        </div>
                    </a>
                    <a href="javascript:void()">
                        <div style="display: flex; align-items: center; background-color: #F6F6F6; border-radius: 8px; padding: 20px 30px;">
                            <img class="mr-2" src="./assets/images/checkmark-circle-2 2.png" height="20px" alt="">
                            <span class="fw-6 fs-14">SiCepat Reg</span>
                        </div>
                    </a>
                    <a href="javascript:void()">
                        <div style="display: flex; align-items: center; background-color: #F6F6F6; border-radius: 8px; padding: 20px 30px;">
                            <img class="mr-2" src="./assets/images/checkmark-circle-2 2.png" height="20px" alt="">
                            <span class="fw-6 fs-14">J&T</span>
                        </div>
                    </a> -->
                    <div style="display:flex; flex-direction:column;">
                        <?php foreach ($kurir as $resultKurir) { ?>
                            <a href="javascript:void()" class="mt-2">
                                <div style="display: flex; align-items: center; background-color: #F6F6F6; border-radius: 8px; padding: 20px 30px;">
                                    <input type="radio" id="dataKurir" name="dataKurir" value="<?php echo $resultKurir['nama_kurir'] ?>" data-kurir="<?php echo $resultKurir['id_kurir'] ?>">

                                    <!-- <img class="mr-2" src="./assets/images/checkmark-circle-2 2.png" height="20px" alt=""> -->
                                    <span class="fw-6 fs-14 ml-2"><?php echo $resultKurir['nama_kurir'] ?></span>

                                </div>
                            </a>
                        <?php } ?>

                    </div>

                    <div class="mt-5" style="display: flex; justify-content: flex-end; ">
                        <button class="fw-5 fs-18" id="simpan_kurir" style="border: none; background-color: transparent; padding: 10px 0; width: 40%; background-color: #27AE60; border-radius: 8px; color: white;">
                            Simpan
                        </button>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:0px;">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="pilih_alamat_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="fw-6 fs-14">Pilih Alamat Pengiriman</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <input type="hidden" name="p" value="" id="p">
                <div class="modal-body">
                    <a id="tambah_alamat" style=" color: #BDBDBD;">
                        <div style="display: flex; justify-content: center; align-items: center; background-color: #F6F6F6; border-radius: 8px; padding: 20px 30px; border: 1px solid #BDBDBD;">
                            <div style="display: flex;">
                                <span class="fw-6 fs-14">Tambah Alamat Baru</span>
                                <span class="ml-1 fw-7 fs-18">+</span>
                            </div>
                        </div>
                    </a>
                    <div style="overflow-y: scroll; overflow-x: hidden; width: 100%; min-height:500px; max-height:500px;">
                        <?php foreach ($alamat->result_array() as $resultAlamat) { ?>
                            <a href="javascript:void()">
                                <div style="margin-top:10px; display: flex; justify-content: space-between; align-items: center; background-color: #F6F6F6; border-radius: 8px; padding: 20px 30px; border: 1px solid #27AE60;">
                                    <div style="display: flex; align-items: start;">
                                        <input type="radio" id="dataAlamat" name="dataAlamat" value="<?php echo $resultAlamat['id']; ?>" data-idkecamatan="<?php echo $resultAlamat['id_subdisctrict'] ?>" data-idkota="<?php echo $resultAlamat['id_city'] ?>" data-alamat="<?php echo $resultAlamat['alamat'] ?>" data-kecamatan="<?php echo $resultAlamat['subdistrict_name'] ?>" data-kota="<?php echo $resultAlamat['city_name'] ?>" data-provinsi="<?php echo $resultAlamat['province_name'] ?>" data-kodepos="<?php echo $resultAlamat['kode_pos'] ?>">

                                        <!-- <img class="mr-2" src="./assets/images/checkmark-circle-2 1.png" height="20px" alt=""> -->
                                        <div style="display: flex; flex-direction: column;" class="ml-1">
                                            <div class="fw-6 fs-14"><?php echo $resultAlamat['nama_penerima'] ?> <div class="fw-4">(<?php echo $resultAlamat['label'] ?>)</div>
                                            </div>
                                            <div class="fw-4 fs-12"><?php echo $resultAlamat['no_telepon'] ?></div>
                                            <span class="fw-4 fs-12"><?php echo $resultAlamat['alamat'] ?>, <?php echo $resultAlamat['province_name'] ?>, <?php echo $resultAlamat['city_name'] ?>, <?php echo $resultAlamat['subdistrict_name'] ?>, <?php echo $resultAlamat['kode_pos'] ?></span>
                                            <a href="javascript:void()" style="color: #27AE60;" class="fw-6 fs-12 mt-1">Ubah Alamat</a>

                                        </div>
                                    </div>
                                </div>
                            </a>
                        <?php } ?>
                        <?php if (count($alamat->result_array()) > 0) { ?>
                            <div class="mt-2" style="display: flex; justify-content: flex-end;">
                                <button class="fw-5 fs-18" id="btn_pilih_alamat" style="border: none; background-color: transparent; padding: 12px 0; width: 40%; background-color: #27AE60; border-radius: 8px; color: white;">
                                    Simpan
                                </button>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:0px;">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tambah_alamat_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="fw-6 fs-14">Alamat Pengiriman</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <input type="hidden" name="p" value="" id="p">
                <div class="modal-body">
                    <div style="overflow-y: scroll; overflow-x: hidden; width: 100%; min-height:500px; max-height:500px;">
                        <div style="">
                            <div class="form-group">
                                <label for="label-alamat-rumah" class="fw-4 fs-14">Label Alamat</label>
                                <input type="text" class="form-control" id="label_alamat" placeholder="Label Alamat">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama-penerima" class="fw-4 fs-14">Nama Penerima</label>
                                        <input type="text" class="form-control" id="nama_penerima" placeholder="Nama Penerima">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nomor-telepon" class="fw-4 fs-14">Nomor Telepon</label>
                                        <input type="number" class="form-control" id="nomor_telepon" placeholder="Nomor Telepon">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="kota-kecamatan" class="fw-4 fs-14">Provinsi</label>
                                        <select class="input form-control mb-2" name="provinsi" id="provinsi">
                                            <option selected disabled>Pilih Provinsi</option>
                                            <?php foreach ($provinsi->result() as $result) { ?>
                                                <option value="<?php echo $result->id; ?>"><?php echo $result->name; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="kota-kecamatan" class="fw-4 fs-14">Kota</label>
                                        <select class="input form-control mb-2" name="kota" id="kota">
                                            <option selected disabled>Pilih Kota/Kabupaten</option>

                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="kota-kecamatan" class="fw-4 fs-14">Kecamatan</label>
                                        <select class="input form-control mb-2" name="kecamatan" id="kecamatan">
                                            <option selected disabled>Pilih Kecamatan</option>


                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="kode-pos" class="fw-4 fs-14">Kode POS</label>
                                        <input type="number" class="form-control" id="kode_pos" placeholder="Kode POS">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="kota-kecamatan" class="fw-4 fs-14">Alamat</label>
                                <textarea class="form-control" name="alamat" id="alamat" rows="3" placeholder="Alamat"></textarea>
                            </div>
                        </div>

                        <div class="mt-2" style="display: flex; justify-content: flex-end;">
                            <button class="fw-5 fs-14" id="btn_simpan_alamat" style="border: none; background-color: transparent; padding: 12px 0; width: 40%; background-color: #27AE60; border-radius: 8px; color: white;">
                                Simpan
                            </button>
                        </div>
                    </div>

                </div>
                <div class="modal-footer" style="border-top:0px;">

                </div>

            </div>
        </div>
    </div>
</body>

<script>
    // $("#pilih_pembayaran_modal").modal("show");

    $('#pilih_kurir').on('click', function() {
        var id_alamat = $('#selected_id').html();
        var selected_alamat = $('#selected_alamat').html();

        if (selected_alamat == '') {
            swal({
                title: "Perhatian !",
                text: "Harap pilih alamat terlebih dahulu",
                confirmButtonColor: "#ff5d00",
                confirmButtonText: "OK",
                closeOnConfirm: false
            });
            return false;
        }

        $("#pilih_kurir_modal").modal("show");
    });

    $('#ganti_pembayaran').on('click', function() {
        var namapengiriman = $('#nama_pengiriman').html();

        if (namapengiriman == '') {
            swal({
                title: "Perhatian !",
                text: "Harap pilih pengiriman terlebih dahulu",
                confirmButtonColor: "#ff5d00",
                confirmButtonText: "OK",
                closeOnConfirm: false
            });
            return false;
        }

        $("#pilih_pembayaran_modal").modal("show");
    });

    $('#btn_simpan_pembayaran').on('click', function() {

        var selected_nama_bank = $('#selected_nama_bank').html();
        var selected_image_bank = $('#selected_image_bank').html();
        var nama_bank = $('input[name="dataPembayaran"]:checked').val();
        var bank_image = $('input[name="dataPembayaran"]:checked').data('image');

        var gambar_bank = '<img src="<?php echo base_url(); ?>assets/images/bank/' + bank_image + '" height="14px" alt="">';

        $('#selected_nama_bank').html(nama_bank)
        $('#selected_image_bank').html(gambar_bank)


        $("#pilih_pembayaran_modal").modal("hide");
    });



    $('#pilih_pengiriman').on('click', function() {
        var kurir = $('#selected_kurir').html();

        if (kurir == '') {
            swal({
                title: "Perhatian !",
                text: "Harap pilih kurir terlebih dahulu",
                confirmButtonColor: "#ff5d00",
                confirmButtonText: "OK",
                closeOnConfirm: false
            });
            return false;
        }

        $("#pilih_pengiriman_modal").modal("show");
    });

    $('#pilih_alamat').on('click', function() {
        $("#pilih_alamat_modal").modal("show");
    });

    $('#tambah_alamat').on('click', function() {
        $("#tambah_alamat_modal").modal("show");
        $("#pilih_alamat_modal").modal("hide");

    });

    $('#btn_bayar').on('click', function() {
        var selected_alamat = $('#selected_alamat').html();
        var id_alamat_pengiriman = $('#selected_id').html();
        var nama_kurir = $('#selected_kurir').html();
        var id_kurir = $('#selected_id_kurir').html();
        var catatan = $('#catatan').val();
        var nama_jenis_pengiriman = $('#nama_pengiriman').html();
        var nama_bank = $('#selected_nama_bank').html()
        var nomor_bank = $('input[name="dataPembayaran"]:checked').data('accountno');
        var id_bank_retail = $('input[name="dataPembayaran"]:checked').data('id');
        var c_bank_id = $('input[name="dataPembayaran"]:checked').data('cbankid');
        var total_pembayaran = $('#total_tagihan_hidden').val();
        var total_ongkir = $('#total_ongkos_kirim_hidden').val();
        var total_quantity = $('#quantity_hidden').val();
        var id_produk_kategori = $('#id_produk_kategori').val();
        var total_harga = $('#total_harga_hidden').val();
        var id_toko = $('#selected_id_toko').html();


        // console.log(id_produk_kategori)

        if (nama_kurir == '') {
            swal({
                title: "Perhatian !",
                text: "Harap pilih kurir terlebih dahulu",
                confirmButtonColor: "#ff5d00",
                confirmButtonText: "OK",
                closeOnConfirm: false
            });
            return false;
        }

        if (nama_jenis_pengiriman == '') {
            swal({
                title: "Perhatian !",
                text: "Harap pilih jenis pengiriman terlebih dahulu",
                confirmButtonColor: "#ff5d00",
                confirmButtonText: "OK",
                closeOnConfirm: false
            });
            return false;
        }

        if (selected_alamat == '') {
            swal({
                title: "Perhatian !",
                text: "Harap pilih alamat terlebih dahulu",
                confirmButtonColor: "#ff5d00",
                confirmButtonText: "OK",
                closeOnConfirm: false
            });
            return false;
        }

        if (nama_bank == '') {
            swal({
                title: "Perhatian !",
                text: "Harap pilih opsi pembayaran terlebih dahulu",
                confirmButtonColor: "#ff5d00",
                confirmButtonText: "OK",
                closeOnConfirm: false
            });
            return false;
        }

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>purchase_order_retail/save_purchase_order_retail",
            data: {
                'id_alamat_pengiriman': id_alamat_pengiriman,
                'id_toko': id_toko,
                'id_kurir': id_kurir,
                'nama_kurir': nama_kurir,
                'catatan': catatan,
                'nama_jenis_pengiriman': nama_jenis_pengiriman,
                'nama_bank': nama_bank,
                'nomor_bank': nomor_bank,
                'c_bank_id': c_bank_id,
                'total_pembayaran': total_pembayaran,
                'total_harga': total_harga,
                'total_ongkir': total_ongkir,
                'total_quantity': total_quantity,
                'id_produk_kategori': id_produk_kategori,
                'id_bank_retail': id_bank_retail
            },
            cache: false,
            beforeSend: function() {
                $("#indicator").modal("show");
            },
            success: function(data) {
                // $("#tambah_alamat_modal").modal("hide");
                $("#indicator").modal("hide");

                var dt = JSON.parse(data);
                // var landing_page = dt.landing_page;
                // console.log(landing_page);
                // window.location.href = landing_page;
                if (dt.status == 'success') {
                    var dt_payment = JSON.parse(dt.payment);
                    var landing_page = dt_payment.redirect_url;
                    // window.location.href = landing_page;
                    swal({
                        title: "Berhasil !",
                        text: dt.value,
                        confirmButtonColor: "#ff5d00",
                        confirmButtonText: "OK",
                        closeOnConfirm: false
                    }, function() {
                        if (nama_bank == 'Credit Card') {
                            window.location.href = landing_page;
                            // $("#tambah_alamat_modal").modal("show");
                            // $('.modal').on('shown.bs.modal', function() { //correct here use 'shown.bs.modal' event which comes in bootstrap3
                            //     $(this).find('iframe').attr('src', landing_page)
                            // })
                        } else {
                            window.location.href = "<?php echo base_url(); ?>pembayaran?id=" + dt.id_po_retail;
                        }

                        // location.reload(true);
                    });
                } else if (dt.status == 'failed') {
                    swal({
                        title: "Gagal !",
                        text: dt.value,
                        confirmButtonColor: "#ff5d00",
                        confirmButtonText: "OK",
                        closeOnConfirm: false
                    }, function() {
                        location.reload(true);
                    });
                }
                console.log(data)
            }
        })

    });

    $('#simpan_kurir').on('click', function() {
        var kurir = $('input[name="dataKurir"]:checked').val();
        var id_kurir = $('input[name="dataKurir"]:checked').data('kurir');
        var id_kota = $("#selected_id_kota").html();
        var berat_produk = $("#berat_produk").val();
        var gram_multiplier = $("#gram_multiplier").val();
        var weight = parseInt($("#quantity_label").html()) * parseInt(berat_produk) * parseInt(gram_multiplier);
        var id_kecamatan_toko = $("#selected_id_kecamatan_toko").html();
        var id_kecamatan = $("#selected_id_kecamatan").html();

        $("#btn_simpan_pengiriman").attr("hidden", true);

        console.log(weight)
        console.log(id_kota)
        console.log(id_kurir)

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>purchase_order_retail/getOngkir",
            data: {
                'id_kurir': id_kurir,
                'id_kota': id_kota,
                'weight': weight,
                'id_kecamatan_toko': id_kecamatan_toko,
                'id_kecamatan': id_kecamatan,
            },
            cache: false,
            beforeSend: function() {
                $("#indicator").modal("show");
                $("#pilih_kurir_modal").modal("hide");
            },
            success: function(data) {
                // $("#tambah_alamat_modal").modal("hide");
                $('.rajaongkir_pengiriman_modal_row').remove();
                $('#selected_kurir').html(kurir);
                $('#selected_id_kurir').html(id_kurir);

                $("#pilih_kurir_modal").modal("hide");
                $("#indicator").modal("hide");

                var dt = JSON.parse(data);

                var option = '';
                var option2 = '';
                console.log(dt);


                $("#btn_simpan_pengiriman").attr("hidden", false);

                $.each(dt, function(index, value) {
                    option += '<div class="rajaongkir_pengiriman_modal_row"><a href="javascript:void()"><div style="display: flex; justify-content: space-between; margin: 5px 32px; align-items: center; background-color: #F6F6F6; border-radius: 8px; padding: 20px 30px;"><div style="display: flex;"><input type="radio" id="dataPengiriman" class="mr-1" name="dataPengiriman" value="' + value.cost[0].value + '" data-estimasi="' + value.cost[0].etd + '" data-namapengiriman="' + value.service + '"><span class="fw-6 fs-14">' + value.service + ' ( ' + value.cost[0].etd + ' Hari ) </span></div><span class="fw-6 fs-14">IDR ' + formatRupiah(value.cost[0].value) + '</span></div></a></div>'
                    // alert(value.description)
                });

                if (dt.length == 0) {
                    option += '<div class="rajaongkir_pengiriman_modal_row">Jenis pengiriman untuk kurir ini belum tersedia atau barang terlalu berat! Silahkan ganti kurir pengiriman!</div>'
                    swal({
                        title: "Perhatian !",
                        text: 'Jenis pengiriman untuk kurir ini belum tersedia atau barang terlalu berat! Silahkan ganti kurir pengiriman!',
                        confirmButtonColor: "#ff5d00",
                        confirmButtonText: "OK",
                        closeOnConfirm: false
                    });
                    $("#btn_simpan_pengiriman").attr("hidden", true);
                }

                $('#rajaongkir_pengiriman_modal').append(option);

                $('#nama_pengiriman').html('');
                $('#estimasi_pengiriman').html('');
                $('#harga_pengiriman').html('');

                // var dt = JSON.parse(data);
                // if (dt.status == 'success') {
                //     swal({
                //         title: "Berhasil !",
                //         text: dt.value,
                //         confirmButtonColor: "#ff5d00",
                //         confirmButtonText: "OK",
                //         closeOnConfirm: false
                //     }, function() {
                //         location.reload(true);
                //     });
                // } else if (dt.status == 'failed') {
                //     swal({
                //         title: "Gagal !",
                //         text: dt.value,
                //         confirmButtonColor: "#ff5d00",
                //         confirmButtonText: "OK",
                //         closeOnConfirm: false
                //     }, function() {
                //         location.reload(true);
                //     });
                // }
                // console.log(data)
            }
        })

    });

    $('#btn_simpan_pengiriman').on('click', function() {
        var harga_ongkir = $('input[name="dataPengiriman"]:checked').val();
        var estimasi = $('input[name="dataPengiriman"]:checked').data('estimasi');
        var nama = $('input[name="dataPengiriman"]:checked').data('namapengiriman');
        var total_harga = $('#total_harga_hidden').val();
        var total_tagihan = parseInt(total_harga) + parseInt(harga_ongkir);
        console.log(estimasi)

        $('#nama_pengiriman').html(nama);
        $('#estimasi_pengiriman').html('(' + estimasi + ' Hari)');
        $('#harga_pengiriman').html(harga_ongkir);

        $('#total_ongkos_kirim').html(formatRupiah(harga_ongkir));
        $('#total_ongkos_kirim_hidden').val(harga_ongkir);

        $('#total_tagihan').html(formatRupiah(total_tagihan));
        $('#total_tagihan_hidden').val(total_tagihan);

        $("#pilih_pengiriman_modal").modal("hide");
    });

    $('#btn_pilih_alamat').on('click', function() {
        var id_alamat = $('input[name="dataAlamat"]:checked').val();
        var alamat = $('input[name="dataAlamat"]:checked').data('alamat');
        var kecamatan = $('input[name="dataAlamat"]:checked').data('kecamatan');
        var kota = $('input[name="dataAlamat"]:checked').data('kota');
        var id_kota = $('input[name="dataAlamat"]:checked').data('idkota');
        var id_kecamatan = $('input[name="dataAlamat"]:checked').data('idkecamatan');
        var provinsi = $('input[name="dataAlamat"]:checked').data('provinsi');
        var kode_pos = $('input[name="dataAlamat"]:checked').data('kodepos');


        $('#selected_id').html(id_alamat);
        $('#selected_alamat').html(alamat);
        $('#selected_provinsi').html(provinsi);
        $('#selected_kota').html(kota);
        $('#selected_id_kota').html(id_kota);
        $('#selected_id_kecamatan').html(id_kecamatan);
        $('#selected_kecamatan').html(kecamatan);
        $('#selected_kode_pos').html(kode_pos);

        $('#nama_pengiriman').html('');
        $('#estimasi_pengiriman').html('');
        $('#harga_pengiriman').html('');

        $('#selected_kurir').html('');
        $('#selected_id_kurir').html('');

        $("#pilih_alamat_modal").modal("hide");
    });


    $('#btn_simpan_alamat').on('click', function() {
        var id_provinsi = $('#provinsi option:selected').val();
        var id_kota = $('#kota option:selected').val();
        var id_kecamatan = $('#kecamatan option:selected').val();
        var label_alamat = $('#label_alamat').val();
        var nama_penerima = $('#nama_penerima').val();
        var no_telepon = $('#nomor_telepon').val();
        var kode_pos = $('#kode_pos').val();
        var alamat = $('#alamat').val();

        console.log(label_alamat)

        if (label_alamat == '') {
            swal({
                title: "Perhatian !",
                text: "Harap isi label alamat terlebih dahulu!",
                confirmButtonColor: "#ff5d00",
                confirmButtonText: "OK",
                closeOnConfirm: false
            });
            return false;
        }

        if (nama_penerima == '') {
            swal({
                title: "Perhatian !",
                text: "Harap isi nama penerima terlebih dahulu!",
                confirmButtonColor: "#ff5d00",
                confirmButtonText: "OK",
                closeOnConfirm: false
            });
            return false;
        }

        if (no_telepon == '') {
            swal({
                title: "Perhatian !",
                text: "Harap isi nomor telepon terlebih dahulu!",
                confirmButtonColor: "#ff5d00",
                confirmButtonText: "OK",
                closeOnConfirm: false
            });
            return false;
        }

        if (no_telepon.length > 15) {
            swal({
                title: "Perhatian !",
                text: "Nomor telepon maksimal 15 digit!",
                confirmButtonColor: "#ff5d00",
                confirmButtonText: "OK",
                closeOnConfirm: false
            });
            return false;
        }

        if (kode_pos == '') {
            swal({
                title: "Perhatian !",
                text: "Harap isi kode pos terlebih dahulu!",
                confirmButtonColor: "#ff5d00",
                confirmButtonText: "OK",
                closeOnConfirm: false
            });
            return false;
        }

        if (alamat == '') {
            swal({
                title: "Perhatian !",
                text: "Harap isi alamat terlebih dahulu!",
                confirmButtonColor: "#ff5d00",
                confirmButtonText: "OK",
                closeOnConfirm: false
            });
            return false;
        }

        if (id_provinsi == 'Pilih Provinsi') {
            swal({
                title: "Perhatian !",
                text: "Harap pilih provinsi terlebih dahulu!",
                confirmButtonColor: "#ff5d00",
                confirmButtonText: "OK",
                closeOnConfirm: false
            });
            return false;
        }

        if (id_kota == 'Pilih Kota/Kabupaten') {
            swal({
                title: "Perhatian !",
                text: "Harap pilih kota terlebih dahulu!",
                confirmButtonColor: "#ff5d00",
                confirmButtonText: "OK",
                closeOnConfirm: false
            });
            return false;
        }

        if (id_kecamatan == 'Pilih Kecamatan') {
            swal({
                title: "Perhatian !",
                text: "Harap pilih kecamatan terlebih dahulu!",
                confirmButtonColor: "#ff5d00",
                confirmButtonText: "OK",
                closeOnConfirm: false
            });
            return false;
        }

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>purchase_order_retail/save_alamat",
            data: {
                'id_provinsi': id_provinsi,
                'id_kota': id_kota,
                'id_kecamatan': id_kecamatan,
                'label_alamat': label_alamat,
                'nama_penerima': nama_penerima,
                'no_telepon': no_telepon,
                'kode_pos': kode_pos,
                'alamat': alamat,
            },
            cache: false,
            beforeSend: function() {
                $("#indicator").modal("show");
            },
            success: function(data) {
                $("#tambah_alamat_modal").modal("hide");
                $("#indicator").modal("hide");
                var dt = JSON.parse(data);
                if (dt.status == 'success') {
                    swal({
                        title: "Berhasil !",
                        text: dt.value,
                        confirmButtonColor: "#ff5d00",
                        confirmButtonText: "OK",
                        closeOnConfirm: false
                    }, function() {
                        location.reload(true);
                    });
                } else if (dt.status == 'failed') {
                    swal({
                        title: "Gagal !",
                        text: dt.value,
                        confirmButtonColor: "#ff5d00",
                        confirmButtonText: "OK",
                        closeOnConfirm: false
                    }, function() {
                        location.reload(true);
                    });
                }
                // console.log(data)
            }
        })
    });

    $('#btn_plus').on('click', function() {
        $("#indicator").modal("show");

        var quantity_label = $('#quantity_label').html();
        var quantity_hidden = $('#quantity_hidden').val();
        var harga_produk = $('#harga_produk').val();

        var sisa_stok = $('#sisa_stok').val();
        var stok_keranjang = $('#stok_keranjang').val();
        var stok_available = parseInt(sisa_stok) - parseInt(stok_keranjang);
        console.log(quantity_label);

        if (parseInt(quantity_hidden) >= parseInt(sisa_stok)) {
            swal({
                title: "Perhatian !",
                text: "Jumlah barang melebihi stok!",
                confirmButtonColor: "#ff5d00",
                confirmButtonText: "OK",
                closeOnConfirm: false
            });

            return false;
        }

        var total_quantity = parseInt(quantity_hidden) + 1;
        var total_harga = total_quantity * parseInt(harga_produk);

        var total_harga_rupiah = formatRupiah(total_harga);

        $('#total_barang').html(parseInt(quantity_label) + 1);
        $('#total_harga').html(total_harga_rupiah);
        $('#total_harga_hidden').val(total_harga);
        $('#total_ongkos_kirim').html(0);
        $('#total_ongkos_kirim_hidden').val(0);
        $('#total_tagihan').html(total_harga_rupiah);
        $('#total_tagihan_hidden').val(total_harga);
        $('#quantity_label').html(parseInt(quantity_label) + 1);
        $('#quantity_hidden').val(parseInt(quantity_hidden) + 1);

        $('#nama_pengiriman').html('');
        $('#estimasi_pengiriman').html('');
        $('#harga_pengiriman').html('');
        $('#selected_kurir').html('');
        $('#selected_id_kurir').html('');

        $("#indicator").modal("hide");

    });

    $('#btn_minus').on('click', function() {
        $("#indicator").modal("show");

        var quantity_label = $('#quantity_label').html();
        var sisa_stok = $('#sisa_stok').val();
        var quantity_hidden = $('#quantity_hidden').val();
        var harga_produk = $('#harga_produk').val();

        if (quantity_label == '1') {
            $("#indicator").modal("hide");
            swal({
                title: "Perhatian !",
                text: "Minimal barang adalah 1!",
                confirmButtonColor: "#ff5d00",
                confirmButtonText: "OK",
                closeOnConfirm: false
            });

            return false;
        }

        var total_quantity = parseInt(quantity_hidden) - 1;
        var total_harga = total_quantity * parseInt(harga_produk);

        var total_harga_rupiah = formatRupiah(total_harga);

        $('#total_barang').html(parseInt(quantity_label) - 1);
        $('#total_harga').html(total_harga_rupiah);
        $('#total_harga_hidden').val(total_harga);
        $('#total_ongkos_kirim').html(0);
        $('#total_ongkos_kirim_hidden').val(0);
        $('#total_tagihan').html(total_harga_rupiah);
        $('#total_tagihan_hidden').val(total_harga);
        $('#quantity_label').html(parseInt(quantity_label) - 1);
        $('#quantity_hidden').val(parseInt(quantity_hidden) - 1);

        $('#nama_pengiriman').html('');
        $('#estimasi_pengiriman').html('');
        $('#harga_pengiriman').html('');
        $('#selected_kurir').html('');
        $('#selected_id_kurir').html('');

        $("#indicator").modal("hide");


    });

    $("#provinsi").change(function() {
        var id_provinsi = $('#provinsi option:selected').val();
        console.log(id_provinsi)
        $('#kota')
            .find('option')
            .remove()
            .end();

        $.ajax({
            type: "GET",
            url: "<?php echo base_url(); ?>auth/getKota/" + id_provinsi,
            // data: {
            //     'id_provinsi': id_provinsi,
            // },
            success: function(data) {
                var dt = JSON.parse(data);
                console.log(dt);
                var option = '';
                $.each(dt, function(index, value) {
                    option += '<option value="' + value.id + '">' + value.name + '</option>';
                });
                $('#kota').append(option);

            }
        })
    });

    $("#kota").change(function() {
        var id_kota = $('#kota option:selected').val();
        $('#kecamatan')
            .find('option')
            .remove()
            .end();

        $.ajax({
            type: "GET",
            url: "<?php echo base_url(); ?>auth/getKecamatan/" + id_kota,
            // data: {
            //     'id_provinsi': id_provinsi,
            // },
            success: function(data) {
                var dt = JSON.parse(data);
                console.log(dt);
                var option = '';
                $.each(dt, function(index, value) {
                    option += '<option value="' + value.id + '">' + value.name + '</option>';
                });
                $('#kecamatan').append(option);

            }
        })
    });


    function formatRupiah(nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + '.' + '$2');
        }
        return x1 + x2;
    }
</script>
<?php if ($this->session->flashdata("result")) { ?>
    <!--<div style="border: 1px solid #999999; background: none repeat scroll 0% 0% tomato; padding: 4px 4px 0px; margin-bottom: 6px;">-->
    <script type="text/javascript">
        swal({
            title: "<?php echo $this->session->flashdata("result_title"); ?>",
            text: "<?php echo $this->session->flashdata("result"); ?>",
            confirmButtonColor: "#27AE60",
            confirmButtonText: "OK",
            closeOnConfirm: false
        });
    </script>
    <!--<label><?php //echo $this->session->flashdata("result"); 
                    ?></label>
</div>-->
<?php } ?>

<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet" />

<!-- jquery js -->
<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<style>
    .flow {
        list-style-type: none;
        margin: 25px 0 0 0;
        padding: 0;
    }

    .flow li {
        float: left;
        width: 50%;
        padding: 2em 2em;
        position: relative;
        height: 20px;
        background-color: #F2F2F2;
        border-radius: 8px;
    }

    .flow label {
        color: #BDBDBD;
        border-radius: 8px;
        text-align: center;
        padding: 26px 0;
        line-height: 3px;
    }

    .flow label,
    .flow input {
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    }

    .flow input[type="radio"] {
        opacity: 0.011;
        z-index: 100;
    }

    .flow input[type="radio"]:checked+label {
        background: #C8F2DA;
        border: 1px solid #27AE60;
        color: #27AE60;
    }
</style>
<!-- <?php print_r($detail_produk) ?> -->
<div class="container mt-3 mb-3">
    <div class="row">
        <div class="col-sm-5 col-md-5">
            <?php foreach ($produk_foto->result_array() as $result_foto) { ?>
                <div class="mySlides">
                    <img src="assets/images/products/<?php echo $result_foto['url_foto'] ?>" class="img-gallery">
                </div>
            <?php } ?>

                    <a class="prev" onclick="plusSlides(-1)">❮</a>
                    <a class="next" onclick="plusSlides(1)">❯</a>

                    <div class="row" style="margin:0px;">
                        <?php foreach ($produk_foto->result_array() as $key => $result_foto) { ?>
                            <div class="column">
                                <img class="demo cursor img-col-gallery" src="assets/images/products/<?php echo $result_foto['url_foto'] ?>" onclick="currentSlide($key + 1)">
                            </div>
                        <?php } ?>

                    </div>
        </div>
        <div class="col-sm-7 col-md-7">
            <div class="box-detail">
                <?php foreach ($detail_produk as $result) { ?>
                    <div class="title-detail d-flex">
                        <h3 class="font-weight-bold nama-produk" data-idproduk="<?= $result['id']; ?>"><?php echo $result['nama_kategori']; ?></h3>
                        <!--                        <button class="btn btn-green btn-sm ml-auto">Non Kayu</button> -->
                    </div>
                    <div class="bs-example">
                        <div class="panel-group" id="accordion">
                            <div class="panel panel-default panel-no-br">
                                <div id="collapseOne" class=" mt-1 mb-1 ml-1 panel-collapse addReadMore showlesscontent">
                                    <div class="panel-body">
                                        <p><?php echo $result['deskripsi_produk']; ?></p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php } ?>

                <?php if ($this->session->userdata('level_user') == 'Member') { ?>
                    <div class="mt-2 box-notif">
                        <p class="font-11 v-middle obj-middle text-notif">Harap mendaftar sebagai agent dengan melengkapi data agent untuk membeli produk ini.</h6>
                    </div>
                <?php } ?>


                <?php if ($this->session->userdata('level_user') == 'Agent') { ?>

                    <?php if (count($orderProcess) == 0) { ?>
                        <?php if ($jumlah_waiting == 0) { ?>
                            <div style="text-align: right;">
                                <a class="btn btn-green mb-2 text-right" type="button" href="<?php echo base_url(); ?>stok?id=<?= bin2hex($result['id']) ?>">Request for Allocation</a>
                            </div>
                        <?php } ?>
                    <?php } ?>
                <?php } else if ($this->session->userdata('level_user') == 'Key Account') { ?>
                    <div style="margin: 0">
                        <ul class="flow d-flex" style="justify-content: space-between;">
                            <li class="mr-2 mb-2">
                                <input type="radio" name="flow" id="flow-dn" value="dn">
                                <label for="flow-dn">Domestik</label>
                            </li>
                            <li class="ml-2 mb-2">
                                <input type="radio" name="flow" id="flow-ln" value="ln">
                                <label for="flow-ln">Internasional</label>
                            </li>
                        </ul>
                    </div>
                    <div style="text-align: right;">
                        <!-- <a class="btn btn-gray mr-2 mb-2 text-right btn-po" type="button">Purchase Order</a> -->
                        <a class="btn btn-green mb-2 text-right btn-ra" type="button">Request for Allocation</a>
                    </div>
                <?php } ?>

                <?php if ($this->session->userdata('id_member') != '') { ?>
                    <?php if (count($orderProcess) > 0) { ?>
                        <div class="box">
                            <div class="box-header">
                                <h5 class="label-header-2">Order Process</h5>
                            </div>
                            <div class="box-body" style="padding: 0;">
                                <?php if ($this->session->userdata('level_user') === 'Key Account') { ?>
                                    <div class=" row mb-2 mt-1" style="padding: 10px 15px 0 15px;">
                                        <div class="col-sm-3 col-md-3 d-flex">
                                            <button type="button" class="btn btn-gray2 mr-1 w-50" data-toggle="modal" data-target="#FilterModal"><i class="icon-filter-3 mr-1"></i>Filter</button>
                                            <button type="button" class="btn btn-gray2 w-50" data-toggle="modal" data-target="#SortModal"><i class="icon-sort mr-1"></i>Sort</button>
                                        </div>
                                        <!-- <div class="col-sm-9 col-md-9 d-flex">
                                            <input type="text" class="form-control custom-input-2" id="input_pencarian" list="produk_list" placeholder="Cari produk pesanan kamu"><button class="btn btn-sm btn-green btn_pencarian" id="btn_pencarian" style="border-radius: 0px 50px 50px 0px;"><i class="icon-search"></i></button>
                                        </div> -->
                                    </div>
                                <?php } ?>
                                <div class="list-order" style="<?= ($this->session->userdata('level_user') === 'Key Account') ?  'overflow-y: scroll; height: 500px;' : '' ?>">
                                    <?php foreach ($orderProcess as $resultOrder) { ?>
                                        <div class="box bg-gray2 mt-1 mr-1 ml-1">
                                            <div class="box-header d-flex" style="justify-content: space-between;">
                                                <h5 class="label-header-2 ml-2 text-grey"><?php echo $resultOrder['no_cos'] ?></h5>
                                                <?php if ($this->session->userdata('level_user') === 'Key Account') { ?>
                                                    <h5 class="label-header-2 text-grey text-right">Agent: <?php echo $resultOrder['nama'] . ' (' . strtoupper($resultOrder['ra_from']) . ')' ?> </h5>
                                                <?php } ?>
                                            </div>
                                            <div class="box-body" style="padding: 10px 15px;">
                                                <?php if ($resultOrder['status_ra'] == 'RA') { ?>
                                                    <ul id="progressbar_3" class="mg-0">
                                                        <li class="active">
                                                            <p>Request Allocation </p>
                                                        </li>
                                                        <li class="">Confirmation of Sales</li>
                                                        <li>Purchase Order</li>
                                                        <li>Performa Invoice</li>
                                                        <li>Invoice</li>
                                                    </ul>
                                                    <?php if ($resultOrder['status_document_ra'] === 'waiting approval tandon') { ?>
                                                        <div class="mt-2 box-notif">
                                                            <p class="font-11 v-middle obj-middle text-center text-notif">Lakukan proses pembayaran uang tandon segera pada page request allocation sebelum menuju tahap
                                                                selanjutnya</h6>
                                                        </div>
                                                        <div class="text-right mt-2 d-flex">
                                                            <a class="btn btn-outline-green btn-sm d-flex mr-1" href="<?= base_url() ?>/list_request_allocation?id=<?= bin2hex($result['id']); ?>">Request Allocation <div class="numbering v-middle ml-1">1</div></a>
                                                            <a class="btn btn-green btn-sm" href="<?php echo base_url(); ?>stok?id=<?= bin2hex($result['id']) ?>&id_ra=<?= bin2hex($resultOrder['id_ra']) ?>">Bayar Tandon</a>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="mt-2 box-notif">
                                                            <p class="font-11 v-middle obj-middle text-notif">Pengajuan Request Allocation menunggu approval perhutani, mohon menunggu beberapa saat.</h6>
                                                        </div>
                                                        <div class="text-right mt-2 d-flex">
                                                            <a class="btn btn-outline-green btn-sm d-flex ml-1" href="<?php echo base_url(); ?>list_request_allocation?id=<?php echo bin2hex($result['id']); ?>">Request Allocation <div class="numbering v-middle ml-1">1</div></a>
                                                        </div>
                                                    <?php } ?>
                                                <?php } else if ($resultOrder['status_ra'] == 'COS') { ?>
                                                    <ul id="progressbar_3" class="mg-0">
                                                        <li class="active">Request Allocation</li>
                                                        <li class="active">Confirmation of Sales
                                                        </li>
                                                        <li class="active">
                                                            <?php if ($resultOrder['total_po'] > 0) { ?>
                                                                <div style="display: flex; flex-direction:column; align-items:center;">
                                                                    <p>Purchase Order </p>
                                                                    <!-- <div class="numbering v-middle"><a class="numbering" href="<?= base_url() ?>/list_purchase_order?id=<?= $result['id']; ?>"><?php echo $resultOrder['total_po'] ?></a></div> -->
                                                                </div>
                                                            <?php } else { ?>
                                                                Purchase Order
                                                            <?php } ?>
                                                        </li>
                                                        <?php if ($resultOrder['total_pi'] > 0) { ?>
                                                            <li class="active">
                                                                <div style="display: flex; flex-direction:column; align-items:center;">
                                                                    <p>Proforma Invoice </p>
                                                                </div>
                                                            </li>
                                                        <?php } else { ?>
                                                            <li>Proforma Invoice</li>
                                                        <?php } ?>

                                                        <?php if ($resultOrder['total_invoice'] > 0) { ?>
                                                            <li class="active">
                                                                <div style="display: flex; flex-direction:column; align-items:center;">
                                                                    <p>Invoice</p>
                                                                </div>
                                                            </li>
                                                        <?php } else { ?>
                                                            <li>Invoice</li>
                                                        <?php } ?>
                                                    </ul>
                                                    <?php if ($resultOrder['total_invoice'] > 0) { ?>
                                                        <div class="mt-2 box-notif">
                                                            <p class="font-9 v-middle obj-middle text-notif">Invoice anda sudah terbit, silahkan lakukan pembayaran sesuai waktu yang telah di tentukan</h6>
                                                        </div>
                                                        <div class="mt-2 d-flex">
                                                            <a class="btn btn-outline-green btn-sm" href="<?php echo base_url(); ?>confirmation_of_sales?id=<?php echo bin2hex($result['id']); ?>">Confirmation of Sales</a>
                                                            <a class="btn btn-outline-green btn-sm ml-1 d-flex" href="<?php echo base_url(); ?>list_purchase_order?id=<?php echo bin2hex($result['id']); ?>&id_cos=<?= bin2hex($resultOrder['id_ra']); ?>">Purchase Order <?php if ($resultOrder['total_po'] > 0) { ?><div class="numbering v-middle"><?= $resultOrder['total_po']; ?></div><?php } ?></a>
                                                            <a class="btn btn-outline-green btn-sm ml-1 d-flex" href="<?php echo base_url(); ?>proforma_invoice?id=<?php echo bin2hex($result['id']); ?>">Proforma Invoice</a>
                                                            <a class="btn btn-green btn-sm ml-1 d-flex" href="<?php echo base_url(); ?>invoice?id=<?php echo bin2hex($result['id']); ?>&id_si=<?php echo bin2hex($resultOrder['id_shipping_instruction']); ?>">Invoice <div class="numbering v-middle"><?php echo $resultOrder['total_invoice'] ?></div></a>
                                                        </div>
                                                    <?php } else if ($resultOrder['total_pi'] > 0) { ?>
                                                        <div class="mt-2 d-flex">
                                                            <a class="btn btn-outline-green btn-sm mr-1" href="<?php echo base_url(); ?>confirmation_of_sales?id=<?php echo bin2hex($result['id']); ?>">Confirmation of Sales</a>
                                                            <a class="btn btn-outline-green btn-sm d-flex mr-1" href="<?php echo base_url(); ?>list_purchase_order?id=<?php echo bin2hex($result['id']); ?>&id_cos=<?= bin2hex($resultOrder['id_ra']); ?>">Purchase Order <?php if ($resultOrder['total_po'] > 0) { ?><div class="numbering v-middle ml-1"><?= $resultOrder['total_po']; ?></div><?php } ?></a>
                                                            <a class="btn btn-outline-green btn-sm d-flex" href="<?php echo base_url(); ?>proforma_invoice?id=<?php echo bin2hex($result['id']); ?>">Proforma Invoice <div class="numbering v-middle ml-1"><?php echo $resultOrder['total_pi'] ?></div></a>
                                                        </div>
                                                    <?php } else if ($resultOrder['total_pi'] == 0) { ?>
                                                        <div class="mt-2 box-notif">
                                                            <p class="font-11 v-middle obj-middle text-notif">Request allocation anda sudah di approve, silahkan ajukan Purchase Order </h6>
                                                        </div>
                                                        <div class="mt-2 d-flex">
                                                            <a class="btn btn-outline-green btn-sm mr-1" href="<?php echo base_url(); ?>confirmation_of_sales?id=<?php echo bin2hex($result['id']); ?>">Confirmation of Sales</a>
                                                            <a class="btn btn-outline-green btn-sm mr-1 d-flex" href="<?php echo base_url(); ?>list_purchase_order?id=<?php echo bin2hex($result['id']) ?>&id_cos=<?= bin2hex($resultOrder['id_ra']); ?>">Purchase Order <?php if ($resultOrder['total_po'] > 0) { ?><div class="numbering v-middle"><?= $resultOrder['total_po']; ?></div><?php } ?></a>
                                                        </div>
                                                    <?php } ?>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="mt-2 box-notif">
                        <p class="font-11 v-middle obj-middle text-notif">Harap login terlebih dahulu untuk melakukan transaksi.</h6>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!-- Filter Modal -->
<div class="modal fade" id="FilterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-cust">
            <div class="modal-header d-flex">
                <h5 class="font-weight-bold">Filter</h5>
                <button type="button" class="close ml-auto" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label class="font-12">Tipe Agent</label>
                <select data-placeholder="Pilih Tipe Agent" multiple class="chosen-select" name="tipe_agent" id="tipe_agent">
                    <option value=""></option>
                    <option value="dn">Lokal</option>
                    <option value="ln">Internasional</option>
                </select>


                <label class="font-12 mt-2">Created RA</label>
                <input type="date" name="tgl_ra" id="tgl_ra" class="input-custom form-control">
                <!-- <i class="icon-select pos-drop"></i> -->


                <label class="font-12 mt-2">Status</label>
                <select data-placeholder="Pilih Lokasi" class="chosen-select" name="status_ra" id="status_ra">
                    <option value=""></option>
                    <option value="RA">Request for Allocation</option>
                    <option value="COS">Confirmation of Sales</option>
                    <option value="PO">Purchase Order</option>
                    <option value="PI">Proforma Invoice</option>
                    <option value="In">Invoice</option>
                </select>
            </div>
            <div class="modal-footer mt-0" style="border-top: 0 none;">
                <button type="button" class="btn btn-green btn-sm float-right btn-filter" data-dismiss="modal" aria-label="Close">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Sort Modal -->
<div class="modal fade" id="SortModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-cust">
            <div class="modal-header d-flex">
                <h5 class="font-weight-bold">Sort By</h5>
                <button type="button" class="close ml-auto" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="post">
                    <div class="font-12 v-middle mb-1">
                        <input type="radio" name="radiogroup" class="mr-1" value="last"> RA Terbaru
                    </div>
                    <div class="font-12 v-middle mb-1">
                        <input type="radio" name="radiogroup" class="mr-1" value="first"> RA Terlama
                    </div>

                </form>
            </div>
            <div class="modal-footer mt-0" style="border-top: 0 none;">
                <button type="button" class="btn btn-green btn-sm float-right btn-sort" data-dismiss="modal" aria-label="Close">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->


<script>
    $(document).ready(function() {
        // Add minus icon for collapse element which is open by default
        $('.btn-stok').on('click', function() {
            var idmember = "<?php echo $this->session->userdata('id_member'); ?>";
            var leveluser = "<?php echo $this->session->userdata('level_user'); ?>";
            var jumlah_adendum = "<?php echo $jumlah_adendum; ?>";
            var jumlah_waiting = "<?php echo $jumlah_waiting; ?>";
            var nama_produk = "<?php echo $nama_produk; ?>";
            var id = $(this).data('id');

            if (idmember != '') {
                if (leveluser == 'Agent' && jumlah_adendum == 0) {
                    // if (jumlah_waiting > 0) {
                    //     swal({
                    //         title: "Perhatian!",
                    //         text: "Anda sudah mengajukan RA dan sedang menunggu approval RA",
                    //         confirmButtonColor: "#ff5d00",
                    //         confirmButtonText: "OK"
                    //     });
                    // } else {
                    //     window.location.href = '<?php echo base_url(); ?>stok?id=' + id;
                    // }

                    window.location.href = '<?php echo base_url(); ?>stok?id=' + id;

                } else if (leveluser == 'Key Account') {
                    window.location.href = '<?php echo base_url(); ?>stok?id=' + id;
                } else {
                    swal({
                        title: "Perhatian!",
                        text: "Anda masih mempunyai cos yang belum selesai untuk produk " + nama_produk + "! Silahkan pilih menu adendum untuk mengajukan adendum",
                        confirmButtonColor: "#27AE60",
                        confirmButtonText: "OK"
                    });
                }

            } else {
                swal({
                    title: "Perhatian!",
                    text: "Harap login terlebih dahulu!",
                    confirmButtonColor: "#27AE60",
                    confirmButtonText: "OK"
                }, function() {
                    $("#LoginModal").modal("toggle");

                });
            }
            // $("#modal_view").modal("show");

        });

        $('.btn-po').on('click', function() {
            var idmember = "<?php echo $this->session->userdata('id_member'); ?>";
            var leveluser = "<?php echo $this->session->userdata('level_user'); ?>";
            var jumlah_cos = "<?php echo $jumlah_cos; ?>";
            var nama_produk = "<?php echo $nama_produk; ?>";

            var id = $(this).data('id');
            if (leveluser == 'Agent') {
                if (idmember != '') {
                    if (parseInt(jumlah_cos) > 0) {
                        window.location.href = '<?php echo base_url(); ?>purchase_order?id=' + id;
                    } else {
                        swal({
                            title: "Perhatian!",
                            text: "Anda belum mempunyai stok untuk produk " + nama_produk + ", silahkan ajukan Stok terlebih dahulu!",
                            confirmButtonColor: "#27AE60",
                            confirmButtonText: "OK",
                            closeOnConfirm: false
                        });
                    }
                } else {
                    swal({
                        title: "Perhatian!",
                        text: "Harap login terlebih dahulu!",
                        confirmButtonColor: "#27AE60",
                        confirmButtonText: "OK"
                    }, function() {
                        $("#LoginModal").modal("toggle");

                    });
                }
            } else if (leveluser == 'Key Account') {
                window.location.href = '<?php echo base_url(); ?>purchase_order?id=' + id;
            }

            // $("#modal_view").modal("show");

        });

        $('.btn-adendum').on('click', function() {
            var idmember = "<?php echo $this->session->userdata('id_member'); ?>";
            var id = $(this).data('id');
            if (idmember != '') {
                window.location.href = '<?php echo base_url(); ?>adendum?id=' + id;
            } else {
                swal({
                    title: "Perhatian!",
                    text: "Harap login terlebih dahulu!",
                    confirmButtonColor: "#27AE60",
                    confirmButtonText: "OK"
                }, function() {
                    $("#LoginModal").modal("toggle");

                });
            }
            // $("#modal_view").modal("show");

        });



        $(".collapse.in").each(function() {
            $(this)
                .siblings(".panel-heading")
                .find(".fa")
                .addClass("rotate");
        });

        // Toggle plus minus icon on show hide of collapse element
        $(".collapse").on("show.bs.collapse", function() {
            $(this)
                .parent()
                .find(".fa")
                .addClass("rotate");
        }).on("hide.bs.collapse", function() {
            $(this)
                .parent()
                .find(".fa")
                .removeClass("rotate");
        });
        $(".chosen-select").chosen({
            no_results_text: "Tidak ditemukan"
        });
    });

    $("input[name=flow]").on('click change', function() {
        // $(".btn-ra").removeClass('btn-gray');
        // $(".btn-po").removeClass('btn-gray');
        // $(".btn-ra").addClass('btn-green');
        // $(".btn-po").addClass('btn-green');
        let flow = $(this).val();
        $(".btn-ra").attr("href", "<?= base_url(); ?>stok?id=<?= $this->input->get('id', TRUE); ?>&asal=" + flow);
        $(".btn-po").attr("href", "<?= base_url(); ?>purchase_order?id=<?= $this->input->get('id', TRUE); ?>&asal=" + flow);
    });

    $('#btn_pencarian').on('click', function() {
        var query = $('#input_pencarian').val()
        // window.location.href = "<?php echo base_url(); ?>history?q=" + query;
    });

    $(".btn-filter").on('click', function() {
        let agent = $('#tipe_agent').val();
        let tgl = $('#tgl_ra').val();
        let status = $('#status_ra').val()
        let produk = $('.nama-produk').html();
        let id_produk = $('.nama-produk').data('idproduk');
        //alert(id_produk);
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>detail_produk/filterOrderProcess",
            data: {
                'agent': agent,
                'tanggalRA': tgl,
                'status': status,
                'produk': produk,
                'id_produk': id_produk
            },
            success: function(data) {
                // alert(data);
                $('.list-order').html(data);
            }
        })
    });

    $(".btn-sort").on('click', function() {
        let cos = $("input[name=radiogroup]:checked").val();
        let produk = $('.nama-produk').html();
        let id_produk = $('.nama-produk').data('idproduk');
        //alert(cos);
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>detail_produk/sortOrderProcess",
            data: {
                'sortby': cos,
                'produk': produk,
                'id_produk': id_produk
            },
            success: function(data) {
                // alert(data);
                $('.list-order').html(data);
            }
        });
    })

    var slideIndex = 1;
    showSlides(slideIndex);

    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        var dots = document.getElementsByClassName("demo");
        if (n > slides.length) {
            slideIndex = 1
        }
        if (n < 1) {
            slideIndex = slides.length
        }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].className += " active";
        // captionText.innerHTML = dots[slideIndex - 1].alt;
    }

    function AddReadMore() {
        //This limit you can set after how much characters you want to show Read More.
        var carLmt = 280;
        // Text to show when text is collapsed
        var readMoreTxt = " ... Read More";
        // Text to show when text is expanded
        var readLessTxt = " Read Less";


        //Traverse all selectors with this class and manupulate HTML part to show Read More
        $(".addReadMore").each(function() {
            if ($(this).find(".firstSec").length)
                return;

            var allstr = $(this).text();
            if (allstr.length > carLmt) {
                var firstSet = allstr.substring(0, carLmt);
                var secdHalf = allstr.substring(carLmt, allstr.length);
                var strtoadd = firstSet + "<span class='SecSec'>" + secdHalf +
                    "</span><span class='readMore'  title='Click to Show More'>" + readMoreTxt +
                    "</span><span class='readLess' title='Click to Show Less'>" + readLessTxt + "</span>";
                $(this).html(strtoadd);
            }

        });
        //Read More and Read Less Click Event binding
        $(document).on("click", ".readMore,.readLess", function() {
            $(this).closest(".addReadMore").toggleClass("showlesscontent showmorecontent");
        });
    }

    $(function() {
        //Calling function after Page Load
        AddReadMore();
    });
</script>
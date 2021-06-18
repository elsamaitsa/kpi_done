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
<div class="container mt-3 mb-3">
    <div class="row">
        <div class="col-sm-5 col-md-5">
            <?php if (count($produk_foto->result_array()) > 0) { ?>
                <?php foreach ($produk_foto->result_array() as $result_foto) { ?>
                    <div class="mySlides">
                        <img src="<?= base_url(); ?>product_retail/<?php echo $result_foto['url_foto'] ?>" class="img-gallery">
                    </div>
                <?php } ?>
            <?php } else { ?>
                <img src="<?= base_url(); ?>assets/images/products/default.png" class="img-gallery">
            <?php } ?>

            <a class="prev" onclick="plusSlides(-1)">❮</a>
            <a class="next" onclick="plusSlides(1)">❯</a>

            <div class="row" style="margin:0px;">
                <?php if (count($produk_foto->result_array()) > 0) { ?>
                    <?php foreach ($produk_foto->result_array() as $key => $result_foto) { ?>
                        <div class="column">
                            <img class="demo cursor img-col-gallery" src="<?= base_url(); ?>product_retail/<?php echo $result_foto['url_foto'] ?>" onclick="currentSlide($key + 1)">
                        </div>
                    <?php } ?>
                <?php }  ?>

            </div>
        </div>
        <div class="col-sm-7 col-md-7">
            <div class="box-detail">
                <?php foreach ($detail_produk as $result) { ?>
                    <div class="title-detail d-flex">
                        <h3 class="font-weight-bold"><?php echo $result['nama_kategori']; ?></h3>
                        <button class="btn btn-green btn-sm ml-auto"><?php echo $result['tipe']; ?></button>
                    </div>
                    <label class="fw-7 fs-18 mt-1 mb-1" style="margin-left: 15px;">IDR <?php echo number_format(($result['price_dn']), 0, '.', '.'); ?></label>
                    <div class="bs-example">
                        <div class="panel-group" id="accordion">
                            <div class="panel panel-default panel-no-br">
                                <div id="collapseOne" class=" mt-1 mb-1 ml-1 panel-collapse addReadMore showlesscontent">
                                    <div class="panel-body">
                                        <p><?php echo $result['deskripsi_produk']; ?></p>
                                        <p>Berat : <?php echo $result['product_weight']; ?> <?php echo $result['singkatan']; ?></p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <?php if ($this->session->userdata('id_member') != '') { ?>
                        <div class="mt-2">
                            <span class="fw-7 fs-14" style="margin-left: 15px;">Nama Toko</span>
                            <div class="mt-1" style="display: flex; padding: 7px 24px; background-color: #F6F6F6; border-radius: 8px; align-items: center;">
                                <img class="mr-1" src="assets/images/ic_store.png" style="width: 20px;" alt="">
                                <span class="fw-6 fs-14 mr-3"><?php echo $result['nama_toko']; ?></span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <span class="fw-7 fs-14" style="margin-left: 15px;">Detail Pembelian</span>
                            <div class="mt-1" style="display: flex; padding: 7px 24px; background-color: #F6F6F6; border-radius: 8px; align-items: center;">
                                <div class="d-flex">
                                    <button class="fw-6 fs-14" id="btn_minus" style="color: white; border:none; height: 24px; width: 24px; border-radius: 12px; display: flex; justify-content: center; align-items: center; background-color: #27AE60;">-</button>
                                    <label id="quantity_label" class="fw-6 fs-14 text-center" style="border: none; border-bottom: 1px solid #E0E0E0; background-color: #F6F6F6; width: 40px;">1</label>
                                    <input id="quantity_hidden" value="1" class="hidden">
                                    <button class="fw-6 fs-14" id="btn_plus" style="color: white; border:none; height: 24px; width: 24px; border-radius: 12px; display: flex; justify-content: center; align-items: center; background-color: #27AE60;">+</button>
                                    <span class="fw-6 fs-14 ml-1 mr-3"></span>
                                </div>
                                <div style="display: flex; align-items:center;">
                                    <img class="mr-1" src="assets/images/ic_box_open.png" style="width: 28px;" alt="">
                                    <div class="mr-3" style="display: flex; flex-direction: column;">
                                        <span class="fw-4 " style="font-size: 10px;">Stok Tersedia</span>
                                        <span class="fw-6 fs-14" style="color: #27AE60;"><?php echo $result['stok']; ?></span>
                                        <input value="<?php echo $result['stok']; ?>" class="hidden" id="sisa_stok">
                                        <input value="<?php echo $checkKeranjang[0]['total_quantity'] ?>" class="hidden" id="stok_keranjang">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-2" style="flex: 1; display: flex; align-items: flex-end; flex-direction: column;">
                            <button class="fw-4 fs-14 mb-1" id="btn_tambah_keranjang" style="color: #27AE60; border: 1px solid #27AE60; border-radius: 8px; background-color: white; padding: 12px; width:100%; max-width:200px;" data-id="<?php echo $result['id']; ?>">+ Keranjang</button>
                            <a class="fw-4 fs-14" style="color: white; border: none; border-radius: 8px; background-color: #27AE60; padding: 12px; width:100%; max-width:200px; text-align:center;" href="<?= base_url(); ?>purchase_order_retail?id=<?= $this->input->get('id', TRUE); ?>">Beli Produk</a>
                        </div>
                    <?php } else { ?>
                        <div class="mt-2 box-notif">
                            <p class="font-11 v-middle obj-middle text-notif">Harap login terlebih dahulu untuk melakukan transaksi.</h6>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="indicator" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content card-login">
            <div class="modal-body text-center" style="padding:0px 45px 30px 45px">
                <img src="<?php echo base_url('assets/images/AjaxLoader.gif'); ?>" alt="" />
                <br />
                <br />
                Loading...
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        // Add minus icon for collapse element which is open by default
        $('#btn_tambah_keranjang').on('click', function() {
            var quantity_label = $('#quantity_label').html();
            var id = $(this).data('id');

            var sisa_stok = $('#sisa_stok').val();
            var stok_keranjang = $('#stok_keranjang').val();

            if (sisa_stok == stok_keranjang) {
                swal({
                    title: "Perhatian !",
                    text: "Jumlah barang tidak dapat melebihi stok keranjang! Stok di keranjang saat ini " + stok_keranjang,
                    confirmButtonColor: "#ff5d00",
                    confirmButtonText: "OK",
                    closeOnConfirm: false
                });

                return false;
            }

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>detail_produk/save_keranjang",
                data: {
                    'total_quantity': quantity_label,
                    'id_produk': id
                },
                cache: false,
                beforeSend: function() {
                    $("#indicator").modal("show");
                },
                success: function(data) {
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
            var quantity_label = $('#quantity_label').html();
            var quantity_hidden = $('#quantity_hidden').val();
            var sisa_stok = $('#sisa_stok').val();
            var stok_keranjang = $('#stok_keranjang').val();
            var stok_available = parseInt(sisa_stok) - parseInt(stok_keranjang);
            console.log(quantity_label);

            if (quantity_label >= stok_available) {
                swal({
                    title: "Perhatian !",
                    text: "Jumlah barang tidak dapat melebihi stok keranjang! Stok di keranjang saat ini " + stok_keranjang,
                    confirmButtonColor: "#ff5d00",
                    confirmButtonText: "OK",
                    closeOnConfirm: false
                });

                return false;
            }

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

            $('#quantity_label').html(parseInt(quantity_label) + 1);
            $('#quantity_hidden').val(parseInt(quantity_hidden) + 1);

        });

        $('#btn_minus').on('click', function() {
            var quantity_label = $('#quantity_label').html();
            var quantity_hidden = $('#quantity_hidden').val();
            var sisa_stok = $('#sisa_stok').val();

            if (quantity_label == '1') {
                swal({
                    title: "Perhatian !",
                    text: "Minimal barang adalah 1!",
                    confirmButtonColor: "#ff5d00",
                    confirmButtonText: "OK",
                    closeOnConfirm: false
                });

                return false;
            }

            $('#quantity_label').html(parseInt(quantity_label) - 1);
            $('#quantity_hidden').val(parseInt(quantity_hidden) - 1);
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
                            confirmButtonColor: "#ff5d00",
                            confirmButtonText: "OK",
                            closeOnConfirm: false
                        });
                    }
                } else {
                    swal({
                        title: "Perhatian!",
                        text: "Harap login terlebih dahulu!",
                        confirmButtonColor: "#ff5d00",
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
                    confirmButtonColor: "#ff5d00",
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
    });

    $("input[name=flow]").on('click change', function() {
        $(".btn-ra").removeClass('btn-gray');
        // $(".btn-po").removeClass('btn-gray');
        $(".btn-ra").addClass('btn-green');
        // $(".btn-po").addClass('btn-green');
        let flow = $(this).val();
        $(".btn-ra").attr("href", "<?= base_url(); ?>stok?id=<?= $this->input->get('id', TRUE); ?>&asal=" + flow);
        // $(".btn-po").attr("href", "<?= base_url(); ?>purchase_order?id=<?= $this->input->get('id', TRUE); ?>&asal=" + flow);
    });

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
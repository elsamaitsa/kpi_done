<?php
function getDateFormat($time)
{
    // $date = '2021-03-21 11:09:59';
    $d = date_parse_from_format("Y-m-d H:i:s", $time);
    $monthName = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];
    $month = '';
    for ($i = 0; $i < count($monthName); $i++) {
        if ($d['month'] == ($i + 1)) {
            $month = $monthName[$i];
        }
    }

    $result = $d['day'] . ' ' . $month . ' ' . $d['year'] . ', ' . $d['hour'] . ':' . $d['minute'];

    return $result;
    // print_r($result);
}
?>

<?php if ($this->session->flashdata("result")) { ?>
    <!--<div style="border: 1px solid #999999; background: none repeat scroll 0% 0% tomato; padding: 4px 4px 0px; margin-bottom: 6px;">-->
    <script type="text/javascript">
        swal({
            title: "<?php echo $this->session->flashdata("result_title"); ?>",
            text: "<?php echo $this->session->flashdata("result"); ?>",
            confirmButtonColor: "#ff5d00",
            confirmButtonText: "OK",
            closeOnConfirm: false
        });
    </script>
    <!--<label><?php //echo $this->session->flashdata("result"); 
                    ?></label>
</div>-->
<?php } ?>

<div class="container container-row container-content">
    <div class="box mt-4 mb-4">
        <div class="box-header d-flex">
            <h5 class="label-header-2">Selesaikan Pembayaran</h5>
            <div class="numbering v-middle"><?php echo count($listPembayaran->result_array()) ?></div>
        </div>
        <div class="box-body" style="margin: 10px;">
            <!-- <div class="box" style="padding: 10px 0px 10px 10px ;">
                <div class="d-flex">
                    <div class="row">
                        <div class="col-sm-3">
                            <img src="../assets/images/new_img/Rectangle 1449.png" style="width: 150px;">
                        </div>
                        <div class="col-sm-9">
                            <div class="d-flex">
                                <h5 class="v-middle">Minyak Kayu Putih</h5>
                                <div class="label-main-2 ml-auto">Invoice</div>
                                <p class="text-muted font-10 v-middle mr-2">1233344433</p>
                            </div>
                            <h6 class="text-orange font-weight-bold">Rp 300.000</h6>
                            <p class="font-9">Pembelian pada Tanggal 19 Maret</p>
                            <div class="box-item ml-0">
                                <div class="v-middle">
                                    <i class="icon-notif-pending mr-1"></i>
                                    <h6 class="text-main">Bayar Sebelum 1 Apr 2021, 12:12 WIB</h6>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="font-10 text-muted">Metode Pembayaran</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="font-10 font-weight-bold-bold">: Mandiri Vitrual
                                            Account</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="font-10 text-muted">Nomor Virtual Account</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="font-10 font-weight-bold-bold">:
                                            881281273781712193719</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-30 text-center" style="border-left: 1px solid #E0E0E0;">
                        <img src="../assets/images/new_img/bank-mandiri.png" class="middle-txt" style="width: 70%;">
                        <button class="btn btn-outline-green mt-3">Lanjutkan Pembayaran</button>
                    </div>
                </div>

            </div> -->

            <!-- <div class="box mt-1" style="padding: 10px 0px 10px 10px ;">
                <div class="d-flex">
                    <div class="row">
                        <div class="col-sm-3">
                            <img src="../assets/images/new_img/Rectangle 1449.png" style="width: 150px;">
                        </div>
                        <div class="col-sm-9">
                            <div class="d-flex">
                                <h5 class="v-middle">Minyak Kayu Putih</h5>
                                <div class="label-main-2 ml-auto">Invoice</div>
                                <p class="text-muted font-10 v-middle mr-2">1233344433</p>
                            </div>
                            <h6 class="text-orange font-weight-bold">Rp 300.000</h6>
                            <p class="font-9">Pembelian pada Tanggal 19 Maret</p>
                            <div class="box-item ml-0">
                                <div class="v-middle">
                                    <i class="icon-notif-pending mr-1"></i>
                                    <h6 class="text-main">Bayar Sebelum 1 Apr 2021, 12:12 WIB</h6>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="font-10 text-muted">Metode Pembayaran</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="font-10 font-weight-bold-bold">: Mandiri Vitrual
                                            Account</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="font-10 text-muted">Nomor Virtual Account</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="font-10 font-weight-bold-bold">:
                                            881281273781712193719</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-30 text-center" style="border-left: 1px solid #E0E0E0;">
                        <img src="../assets/images/new_img/bank-mandiri.png" class="middle-txt" style="width: 70%;">
                        <button class="btn btn-outline-green mt-4" disabled>Cara Pembayaran</button>
                    </div>
                </div>

            </div> -->
            <?php foreach ($listPembayaran->result_array() as $resultPembayaran) { ?>
                <div class="box mt-1" style="padding: 10px 0px 10px 10px ;">
                    <div class="d-flex">
                        <div class="row">
                            <div class="col-sm-3">
                                <img src="<?php echo base_url(); ?>assets/images/products/<?php echo $resultPembayaran['url_foto_produk'] ?>" style="width: 150px;">
                            </div>
                            <div class="col-sm-9">
                                <div class="d-flex">
                                    <h5 class="v-middle"><?php echo $resultPembayaran['nama_kategori'] ?></h5>
                                    <div class="label-main-2 ml-auto mr-1">Invoice</div>
                                    <p class="text-muted font-10 v-middle mr-2"><?php echo $resultPembayaran['nomor_order'] ?></p>
                                </div>
                                <h6 class="text-orange font-weight-bold">IDR <?php echo number_format($resultPembayaran['total_pembayaran'], '0', '.', '.') ?></h6>
                                <p class="font-9">Pembelian pada Tanggal <?php echo getDateFormat($resultPembayaran['created_at']) ?></p>
                                <div class="box-item ml-0">
                                    <div class="v-middle">
                                        <i class="icon-notif-pending mr-1"></i>
                                        <?php if ($resultPembayaran['status_pembayaran'] == '') { ?>
                                            <h6 class="text-main">Bayar Sebelum <?php echo getDateFormat($resultPembayaran['batas_pembayaran']) ?> WIB</h6>
                                        <?php } else if ($resultPembayaran['status_pembayaran'] == 'Success') { ?>
                                            <h6 class="text-main">Pembayaran Berhasil</h6>
                                        <?php } else if ($resultPembayaran['status_pembayaran'] == 'Failed') { ?>
                                            <h6 class="text-main">Pembayaran Gagal</h6>
                                        <?php } ?>
                                    </div>
                                    <?php if ($resultPembayaran['status_pembayaran'] == '') { ?>
                                        <?php if ($resultPembayaran['sof_id'] != 'cc') { ?>
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <p class="font-10 text-muted">Metode Pembayaran</p>
                                                </div>
                                                <div class="col-sm-7">
                                                    <p class="font-10 font-weight-bold-bold">: <?php echo $resultPembayaran['nama_bank'] ?></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <p class="font-10 text-muted">Nomor Virtual Account</p>
                                                </div>
                                                <div class="col-sm-7">
                                                    <p class="font-10 font-weight-bold-bold">:
                                                        <?php echo $resultPembayaran['payment_code'] ?></p>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                        <div class="w-30 text-center" style="border-left: 1px solid #E0E0E0;">
                            <?php if ($resultPembayaran['status_pembayaran'] == '') { ?>
                                <img src="<?php echo base_url() ?>assets/images/bank/<?php echo $resultPembayaran['bank_image'] ?>" class="middle-txt" style="width: 30%;">
                                <?php if ($resultPembayaran['sof_id'] == 'cc') { ?>
                                    <a href="<?php echo $resultPembayaran['url_landing_page'] ?>" class="btn btn-outline-green mt-3">Lanjutkan Pembayaran</a>
                                <?php } else { ?>
                                    <a href="<?php echo base_url() ?>pembayaran?id=<?php echo $resultPembayaran['id_orders'] ?>" class="btn btn-outline-green mt-3">Lanjutkan Pembayaran</a>
                                <?php } ?>
                            <?php } else if ($resultPembayaran['status_pembayaran'] == 'Success') { ?>
                                <a href="<?php echo base_url() ?>rincian_pesanan?id=<?php echo $resultPembayaran['id_orders'] ?>" class="btn btn-outline-green mt-3">Lihat Riwayat Pesanan</a>
                            <?php } else if ($resultPembayaran['status_pembayaran'] == 'Failed') { ?>
                                <a href="<?php echo base_url() ?>rincian_pesanan?id=<?php echo $resultPembayaran['id_orders'] ?>" class="btn btn-outline-green mt-3">Lihat Riwayat Pesanan</a>
                            <?php } ?>

                        </div>
                    </div>

                </div>

                <!-- <div class="box mt-1" style="padding: 10px;">
                    <div class="row">
                        <div class="col-sm-2">
                            <img src="<?php echo base_url(); ?>assets/images/products/<?php echo $resultPembayaran['url_foto_produk'] ?>" style="width: 150px;">
                        </div>
                        <div class="col-sm-10">
                            <div class="d-flex w-70">
                                <h5 class="v-middle"><?php echo $resultPembayaran['nama_kategori'] ?></h5>
                                <div class="label-main-2 ml-auto">Invoice</div>
                                <p class="text-muted font-10 v-middle mr-2">1233344433</p>
                            </div>
                            <h6 class="text-orange font-weight-bold">IDR <?php echo number_format($resultPembayaran['total_pembayaran'], '0', '.', '.') ?></h6>
                            <div class="d-flex">
                                <p class="font-9 v-middle">Pembelian pada Tanggal <?php echo getDateFormat($resultPembayaran['created_at']) ?></p>
                                <i class="icon-notif-pending mr-1 ml-auto"></i>
                                <h6 class="text-main font-9 v-middle">Bayar Sebelum <?php echo getDateFormat($resultPembayaran['batas_pembayaran']) ?> WIB</h6>
                            </div>
                            <div class="box-item ml-0">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="font-10 text-muted">Please Transfer To</p>
                                    </div>
                                    <div class="col-sm-8">
                                        <p class="font-10 font-weight-bold-bold">: <?php echo $resultPembayaran['account_name'] ?></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="font-10 text-muted">Bank Receiver</p>
                                    </div>
                                    <div class="col-sm-8">
                                        <p class="font-10 font-weight-bold-bold">: <?php echo $resultPembayaran['nama_bank'] ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="font-10 text-muted">SWIFT Code</p>
                                    </div>
                                    <div class="col-sm-8">
                                        <p class="font-10 font-weight-bold-bold">: <?php echo $resultPembayaran['swiftcode'] ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="font-10 text-muted">Account Name</p>
                                    </div>
                                    <div class="col-sm-8">
                                        <p class="font-10 font-weight-bold-bold">: <?php echo $resultPembayaran['account_name'] ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="font-10 text-muted">Account Number</p>
                                    </div>
                                    <div class="col-sm-8">
                                        <p class="font-10 font-weight-bold-bold">: <?php echo $resultPembayaran['nomor_bank'] ?>
                                        </p>
                                    </div>
                                </div>
                                <form method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>list_pembayaran/insert_transfer?id=<?php echo $resultPembayaran['id_orders']; ?>">
                                    <?php if ($resultPembayaran['status_payment'] == 'decline') { ?>
                                        <div class="alert alert-danger" role="alert">
                                            Your payment is decline, please reupload your payment details.
                                            Reason : <?php echo $resultPembayaran['reason_decline'] ?>
                                        </div>
                                    <?php } else if ($resultPembayaran['status_payment'] == 'approve') { ?>
                                        <div class="alert alert-success" role="alert">
                                            Your payment is approve
                                        </div>
                                    <?php } else if ($resultPembayaran['status_payment'] == 'waiting approval') { ?>
                                        <div class="alert alert-warning" role="alert">
                                            Your payment is being review
                                        </div>
                                    <?php } ?>
                                    <div class="row mt-1">
                                        <div class="col-sm-6 mb-1">
                                            <h6 class="font-9">Total Transfer</h6>
                                            <?php if ($resultPembayaran['total_transfer'] != ''  && $resultPembayaran['status_payment'] != 'decline') { ?>
                                                <input readonly type="text" value="<?php echo $resultPembayaran['total_transfer'] ?>" class="form-control uang" id="total_transfer<?php echo $result2['id'] ?>" name="total_transfer<?php echo $result2['id'] ?>">

                                            <?php } else { ?>
                                                <input type="text" class="form-control b-0 uang" id="total_transfer<?php echo $resultPembayaran['id_orders']; ?>" name="total_transfer<?php echo $resultPembayaran['id_orders']; ?>">
                                                <input type="text" class="form-control b-0 uang hidden" value="<?php echo $resultPembayaran['total_pembayaran']; ?>" id="total_pay<?php echo $resultPembayaran['id_orders']; ?>" name="total_pay<?php echo $resultPembayaran['id_orders']; ?>">
                                            <?php } ?>


                                        </div>
                                        <div class="col-sm-6 mb-1">
                                            <h6 class="font-9">Transfer Date</h6>
                                            <?php if ($resultPembayaran['transfer_date'] != ''  && $resultPembayaran['status_payment'] != 'decline') { ?>
                                                <input readonly value="<?php echo $resultPembayaran['transfer_date']; ?>" id="transfer_date<?php echo $resultPembayaran['id_orders']; ?>" class="form-control b-0 transfer_date" name="transfer_date<?php echo $resultPembayaran['id_orders']; ?>">

                                            <?php } else { ?>
                                                <input id="transfer_date<?php echo $resultPembayaran['id_orders']; ?>" class="form-control b-0 transfer_date" name="transfer_date<?php echo $resultPembayaran['id_orders']; ?>">

                                            <?php } ?>

                                        </div>
                                        <div class="col-sm-6 mb-1">
                                            <h6 class="font-9">Account Number</h6>
                                            <?php if ($resultPembayaran['account_number'] != ''  && $resultPembayaran['status_payment'] != 'decline') { ?>
                                                <input readonly value="<?php echo $resultPembayaran['account_number']; ?>" type="number" class="form-control b-0" id="account_number<?php echo $resultPembayaran['id_orders']; ?>" name="account_number<?php echo $resultPembayaran['id_orders']; ?>">

                                            <?php } else { ?>
                                                <input type="number" class="form-control b-0" id="account_number<?php echo $resultPembayaran['id_orders']; ?>" name="account_number<?php echo $resultPembayaran['id_orders']; ?>">

                                            <?php } ?>

                                        </div>
                                        <div class="col-sm-6 mb-1">
                                            <?php if ($resultPembayaran['url_invoice_retail'] != '' && $resultPembayaran['status_payment'] != 'decline') { ?>
                                                <div class="box-fileup-green col-sm-9">
                                                    <label for="file-upload" class="custom-file-upload">
                                                        <i class="fileup-icon icon-lay"></i>
                                                    </label>
                                                    <label style="color: #219653;">Document Uploaded</label>
                                                </div>
                                                <div class="box-fileup-1 mt-2">
                                                    <h6 class="text-main v-middle font-11">Upload Success</h6>
                                                    <i class="icon-check ml-auto"></i>
                                                </div>

                                            <?php } else { ?>
                                                <h6 class="font-9">Upload Payment Slip</h6>

                                                <div class="box-fileup">
                                                    <i class="fileup-icon icon-lay" style="width:35px !important;"></i>
                                                    <input type="file" class="form-control b-0" id="upload_transfer<?php echo $resultPembayaran['id_orders']; ?>" name="upload_transfer<?php echo $resultPembayaran['id_orders']; ?>" style="border: none;">
                                                </div>

                                            <?php } ?>


                                        </div>
                                    </div>

                                    <div class="d-flex mt-1">
                                        <h6 class="ml-auto font-10 v-middle mr-1">Upload Payment Slip</h6>
                                        <div class="box-fileup w-30">
                                            <label for="file-upload" class="custom-file-upload">
                                                <i class="fileup-icon icon-lay" style="width:35px !important;"></i>
                                            </label>
                                            <input id="file-upload" name='upload_cont_img' type="file" style="display:none;">
                                            <input id="uploadFile" placeholder="Upload Payment Slip" disabled="disabled" style="background: transparent; font-size: 9px;" />
                                        </div>
                                    </div>
                                    <?php if ($resultPembayaran['status_payment'] == 'decline' || $resultPembayaran['status_payment'] == '') { ?>
                                        <div class="text-right mt-1 mb-2">
                                            <button class="btn btn-green btn-sm" type="submit">Upload</button>
                                        </div>
                                    <?php } ?>

                                </form>

                            </div>
                        </div>
                    </div>
                </div> -->
            <?php } ?>
        </div>
    </div>
</div>

<script>
    $('.uang').keyup(function(event) {

        // skip for arrow keys
        if (event.which >= 37 && event.which <= 40) return;

        // format number
        $(this).val(function(index, value) {
            return value
                .replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        });

        console.log($(this).val())
    });
    $(document).ready(function() {
        $('.transfer_date').datepicker();

    });
</script>
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

<div class="container container-row mt-3 mb-3">
    <?php foreach ($detailPembayaran->result_array() as $resultPembayaran) { ?>
        <div class="row">
            <div class="col-md-12" style="border:1px solid #BDBDBD; padding: 32px 80px; border-radius: 8px;">
                <div style="text-align: center; font-size: 24px;" class="fw-7">Selesaikan Pembayaran</div>
                <hr style="margin:32px 0;">
                <div class="mb-4" style="display: flex;align-items: center; justify-content: space-between;">
                    <span class="fw-5 fs-18">Batas Akhir Pembayaran</span>
                    <span class="fw-4 fs-18" style="color: #27AE60;"><?php echo getDateFormat($resultPembayaran['batas_pembayaran']) ?></span>
                </div>
                <div class="mb-4" style="display: flex; justify-content: space-between;">
                    <span class="fw-5 fs-18"><?php echo $resultPembayaran['nama_bank'] ?></span>
                    <img src="<?php echo base_url(); ?>assets/images/bank/<?php echo $resultPembayaran['url_image'] ?>" height="40px" alt="">
                </div>
                <div class="mb-4" style="display: flex; justify-content: space-between;">
                    <div style="display: flex; flex-direction: column;">

                        <span class="fw-5 fs-18" id="nomor_bank"><?php echo $resultPembayaran['nomor_bank'] ?></span>
                        <span class="fw-5 fs-14 mb-1" style="color: #828282;">Account Name : <?php echo $resultPembayaran['account_name'] ?></span>
                    </div>
                    <a href="#" class="fw-4 fs-18" style="color: #27AE60;" id="salin_account_number">Salin</a href="#">
                </div>
                <div class="mb-3" style="display: flex; justify-content: space-between;">
                    <div style="display: flex; flex-direction: column;">
                        <span class="fw-5 fs-18">IDR <?php echo number_format($resultPembayaran['total_pembayaran'], '0', '.', '.') ?></span>
                    </div>
                    <a href="#collapseDetail" data-toggle="collapse" data-parent="#accordion" class="fw-4 fs-18" style="color: #27AE60; align-self: flex-end;">Lihat Detail</a href="#">
                </div>
                <div id="collapseDetail" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="mb-3" style="display: flex; flex-direction: column;">
                            <div style="display: flex; justify-content: space-between;">
                                <span class="fw-4 fs-14">Total Harga (<?php echo $totalQuantity[0]['total_quantity'] ?> Barang)</span>
                                <span class="fw-4 fs-14">IDR <?php echo number_format($resultPembayaran['total_harga'], '0', '.', '.') ?></span>
                            </div>
                            <div class="mt-1" style="display: flex; justify-content: space-between;">
                                <span class="fw-4 fs-14">Total Ongkos Kirim</span>
                                <span class="fw-4 fs-14">IDR <?php echo number_format($resultPembayaran['total_ongkir'], '0', '.', '.') ?></span>
                            </div>
                            <!-- <div class="mt-1" style="display: flex; justify-content: space-between;">
                                <div style="display: flex;">
                                    <input class="mr-1" type="checkbox" name="" id="">
                                    <span class="fw-4 fs-14">Asuransi Pengiriman</span>
                                </div>
                                <span class="fw-4 fs-14">Rp -</span>
                            </div> -->
                        </div>
                        <hr>
                        <div class="mt-1" style="display: flex; justify-content: space-between;">
                            <span class="fw-7 fs-14">Total Tagihan</span>
                            <span class="fw-7 fs-14" style="color: #F2994A;">IDR <?php echo number_format($resultPembayaran['total_pembayaran'], '0', '.', '.') ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <div class="row mt-3">
        <div class="col-sm-6">
            <label>Pastikan pembayaran anda sudah berhasil dan unggah bukti untuk mempercepat proses verifikasi</label>
        </div>
        <div class="col-sm-6" style="text-align: right;">
            <a href="<?php echo base_url(); ?>list_pembayaran" style="border: none; width: 100%; background-color: #27AE60; border-radius: 8px; padding: 12px; color: white;">
                Upload Bukti Pembayaran
            </a>
        </div>

    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            <span class="fw-6" style="font-size: 24px;">Panduan Pembayaran</span>
        </div>
    </div>

    <div class="row mt-3">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
            <div class="col-md-12" style="display: flex; justify-content: space-between;">
                <span style="color: #219653;" class="fw-5 fs-18">ATM Mandiri</span>
                <img src="../assets/images/arrow-down.png" height="12px" alt="">
            </div>
        </a>
        <div class="col-md-12">
            <hr>
        </div>

        <div id="collapseOne" class="col-md-12 panel-collapse collapse">
            <div class="panel-body" style="display: flex; flex-direction: column;">
                <span class="fw-4 fs-18">1. Masukkan kartu ATM dan PIN</span>
                <span class="fw-4 fs-18 mt-1">2. Pilih menu "Bayar/Beli"</span>
                <span class="fw-4 fs-18 mt-1">3. Pilih menu "Lainnya", hingga menemukan menu "Multipayment"</span>
                <span class="fw-4 fs-18 mt-1">4. Masukkan Kode Biller Tokopedia (88708), lalu pilih Benar</span>
                <span class="fw-4 fs-18 mt-1">5. Masukkan "Nomor Virtual Account" Tokopedia, lalu pilih tombol Benar</span>
                <span class="fw-4 fs-18 mt-1">6. Masukkan Angka "1" untuk memilih tagihan, lalu pilih tombol Ya</span>
                <span class="fw-4 fs-18 mt-1">7. Akan muncul konfirmasi pembayaran, lalu pilih tombol Ya</span>
                <span class="fw-4 fs-18 mt-1">8. Simpan struk sebagai bukti pembayaran Anda</span>
            </div>
        </div>

    </div>

    <div class="row mt-3 mb-7">

        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
            <div class="col-md-12" style="display: flex; justify-content: space-between;">
                <span style="color: #219653;" class="fw-5 fs-18">Internet Banking / Mandiri Online</span>
                <img src="../assets/images/arrow-down.png" height="12px" alt="">
            </div>
        </a>
        <div class="col-md-12">
            <hr>
        </div>

        <div id="collapseTwo" class="col-md-12 panel-collapse collapse">
            <div class="panel-body" style="display: flex; flex-direction: column;">
                <span class="fw-4 fs-18">1. Masukkan kartu ATM dan PIN</span>
                <span class="fw-4 fs-18 mt-1">2. Pilih menu "Bayar/Beli"</span>
                <span class="fw-4 fs-18 mt-1">3. Pilih menu "Lainnya", hingga menemukan menu "Multipayment"</span>
                <span class="fw-4 fs-18 mt-1">4. Masukkan Kode Biller Tokopedia (88708), lalu pilih Benar</span>
                <span class="fw-4 fs-18 mt-1">5. Masukkan "Nomor Virtual Account" Tokopedia, lalu pilih tombol Benar</span>
                <span class="fw-4 fs-18 mt-1">6. Masukkan Angka "1" untuk memilih tagihan, lalu pilih tombol Ya</span>
                <span class="fw-4 fs-18 mt-1">7. Akan muncul konfirmasi pembayaran, lalu pilih tombol Ya</span>
                <span class="fw-4 fs-18 mt-1">8. Simpan struk sebagai bukti pembayaran Anda</span>
            </div>
        </div>

    </div>


</div>

<script>
    $('#salin_account_number').on('click', function() {
        var copyText = document.getElementById("nomor_bank");
        var textArea = document.createElement("textarea");
        textArea.value = copyText.textContent;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand("Copy");
        textArea.remove();

        swal({
            title: "Berhasil !",
            text: "Berhasil menyalin nomor akun!",
            confirmButtonColor: "#ff5d00",
            confirmButtonText: "OK",
            closeOnConfirm: false
        });

    });
</script>
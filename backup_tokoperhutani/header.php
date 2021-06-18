<?php
header('X-Frame-Options: DENY');
header("X-XSS-Protection: 1; mode=block");
//$this->session->set_userdata('changepassword', '');
$changepassword = $this->session->userdata['changepassword'];

//echo $this->aesencrypt->encrypt("infomedia");
?>

<?php
$id_member = $this->session->userdata('id_member');

if ($this->session->userdata('level_user') == 'Agent') {
  $id = 'a.id_member';
} else {
  $id = 'a.id_keyaccount';
}

$month = date('m');
$year = date('Y');

//Keranjang
$notif_pesan = $this->db->query("SELECT title,message,tipe,node,status,created_at FROM pesan_notifikasi");



$keranjang = $this->db->query("SELECT a.id, a.id_produk_kategori, a.total_quantity, a.status, b.price_dn, b.total_price, c.url_foto, d.nama_kategori FROM keranjang a
LEFT JOIN (SELECT a.id, b.price_dn, (b.price_dn * a.total_quantity) as total_price  
FROM keranjang a 
LEFT JOIN produk_kategori b ON b.id = a.id_produk_kategori
GROUP BY a.id) b ON b.id = a.id
LEFT JOIN produk_kategori_foto c ON c.id_produk_kategori = a.id_produk_kategori
LEFT JOIN produk_kategori d ON d.id = a.id_produk_kategori
WHERE a.id_member = '$id_member'");



// Notifikasi
$orderProcessCOS = $this->db->query("SELECT a.id as id_ra, d.id_shipping_instruction, a.id_member, a.no_cos, a.id_keyaccount, e.nama, a.status as status_ra, a.jenis_produk, a.ra_from, a.status_document as status_document_ra, b.total_po, c.total_pi, d.total_invoice
			FROM request_allocation a
			LEFT JOIN (SELECT id_request_allocation, COUNT(id) as total_po FROM purchase_order 
			WHERE status = 'PO'
			GROUP BY id_request_allocation) b ON b.id_request_allocation = a.id
			LEFT JOIN (SELECT id_request_allocation, COUNT(id) as total_pi FROM purchase_order 
			WHERE status = 'PI'
			GROUP BY id_request_allocation) c ON c.id_request_allocation = a.id
			LEFT JOIN (SELECT a.id_shipping_instruction, c.id_request_allocation, COUNT(a.id) as total_invoice
			FROM invoice_shipping_instruction a
			LEFT JOIN shipping_instruction b ON b.id = a.id_shipping_instruction
			LEFT JOIN purchase_order c ON c.id = b.id_purchase_order
			GROUP BY c.id_request_allocation) d ON d.id_request_allocation = a.id
			LEFT JOIN member_new e ON e.id_member = a.id_member
			WHERE $id = '$id_member'
			AND MONTH(periode_start) = '$month'
			AND YEAR(periode_start) = '$year'
			AND MONTH(periode_end) = '$month'
			AND YEAR(periode_end) = '$year'
		");

$orderProcessRA = $this->db->query("SELECT a.id as id_ra, d.id_shipping_instruction, a.id_member, a.no_cos, a.id_keyaccount, e.nama, a.status as status_ra, a.jenis_produk, a.ra_from, a.status_document as status_document_ra, b.total_po, c.total_pi, d.total_invoice
			FROM request_allocation a
			LEFT JOIN (SELECT id_request_allocation, COUNT(id) as total_po FROM purchase_order 
			WHERE status = 'PO'
			GROUP BY id_request_allocation) b ON b.id_request_allocation = a.id
			LEFT JOIN (SELECT id_request_allocation, COUNT(id) as total_pi FROM purchase_order 
			WHERE status = 'PI'
			GROUP BY id_request_allocation) c ON c.id_request_allocation = a.id
			LEFT JOIN (SELECT a.id_shipping_instruction, c.id_request_allocation, COUNT(a.id) as total_invoice
			FROM invoice_shipping_instruction a
			LEFT JOIN shipping_instruction b ON b.id = a.id_shipping_instruction
			LEFT JOIN purchase_order c ON c.id = b.id_purchase_order
			GROUP BY c.id_request_allocation) d ON d.id_request_allocation = a.id
			LEFT JOIN member_new e ON e.id_member = a.id_member
			WHERE $id = '$id_member'
			AND a.status = 'RA'
			AND MONTH(created_at) = '$month'
			AND YEAR(created_at) = '$year'
		");

// array_push($output, $orderProcessCOS->result());
$output = $orderProcessCOS->result_array();
foreach ($orderProcessRA->result_array() as $key => $result) {
  if (count($orderProcessRA->result_array()) > 0) {
    array_push($output, $result);
  }
}
$total_RA = count($output);


  $ch = curl_init();
  $url = "https://stg.dilan-reporting.perhutani.id/api/master-country";
  $header = array(
      "Authorization: Bearer 21|9ZMixlIbMUnzovzTQ9GttlIlaO2DJj4TzpavOLiu",
      "Content-Type: application/json",
      "Accept: application/json"
  );

  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

  $resp = curl_exec($ch);
  if ($e = curl_error($ch)) {
      echo ($e);
  } else {
      $country = json_decode($resp);
  }


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Basic page needs -->
  <meta charset="utf-8">

  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

  <?php
  $last       = $this->uri->total_segments();
  $record_num = $this->uri->segment($last);

  $UriSegment = json_decode($this->website_content->meta($record_num));
  ?>

  <meta property="og:title" content="<?php echo $UriSegment->title; ?>" />
  <meta property="og:type" content="website" />
  <meta property="og:description" content="<?php echo $UriSegment->description; ?>" />
  <meta name="author" content="Kemudahan Berbelanja Kayu Terbaik &raquo; Toko Perhutani">
  <meta name="robots" content="all">

  <!--[if IE]>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <![endif]-->
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Toko Perhutani DEV</title>
  <meta name="Before buying it, get the feel and look of the Refresh Food & Restaurant Website Template by viewing the demo preview. View the pages, examine the images, click the buttons, explore the features.">
  <meta name="keywords" content="food shop, fresh, modern, Refresh farm, Restaurant farm shop, Refresh food, Refresh shop, agriculture, e-commerce, eco, eco products, farm, farming, food, health, Restaurant, Refresh food, retail, shop, store" />

  <!-- Mobile specific metas  -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Favicon  -->
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/images/logo-perhutani.png">

  <!-- Google Fonts -->
  <link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic,500,500italic,700' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'>

  <!-- CSS Style -->

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">

  <!-- Datepicker CSS -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap-datepicker3.css">

  <!-- font-awesome & simple line icons CSS -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/font-awesome.css" media="all">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/simple-line-icons.css" media="all">

  <!-- owl.carousel CSS -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/owl.carousel.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/owl.theme.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/owl.transitions.css">

  <!-- animate CSS  -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/animate.css" media="all">

  <!-- flexslider CSS -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/flexslider.css">

  <!-- jquery-ui.min CSS  -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/jquery-ui.css">

  <!-- Revolution Slider CSS -->
  <link href="<?php echo base_url(); ?>assets/css/revolution-slider.css" rel="stylesheet">

  <!-- style CSS -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css" media="all">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/apps.css" media="all">

  <!-- Sweetalert -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/dist/sweetalert.css">
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/dist/sweetalert.min.js"></script>
  <style type="text/css">
    .main-div:after {
      content: "";
      clear: both;
      display: table;
    }

    #div01,
    #div02,
    #div03 {
      display: inline;
      padding-left: 15px;
    }

    .cdiv {

      display: inline;

    }

    .inline {
      vertical-align: top;
      display: inline-block;
      margin: 0 10px 0 0;
    }

    .content-dropdown li a:hover {
      color: #27ae60;
    }
  </style>

</head>
<!-- End Plugin -->

<body class="cms-index-index cms-home-page">

  <!--[if lt IE 8]>
      <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
  <![endif]-->

  <!-- mobile menu -->
  <div id="mobile-menu">
    <ul>
      <li><a href="<?php echo base_url(); ?>">Beranda</a></li>
      <li><a href="<?php echo base_url(); ?>panduan">Panduan</a></li>
      <!--<li><a href="<?php echo base_url(); ?>faqs">Pusat Bantuan</a></li>
      <li><a href="<?php echo base_url(); ?>article/static_art/contact-center">Contact Center</a></li>-->
      <li><a href="<?php echo base_url(); ?>article/static_art/cara-pembayaran">Cara Pembayaran</a></li>
      <li><a href="<?php echo base_url(); ?>article/static_art/syarat-dan-ketentuan">Syarat & Ketentuan</a></li>
      <li><a href="<?php echo base_url(); ?>SertifikatPerhutani">Sertifikat Perhutani</a></li>
    </ul>
  </div>
  <!-- end mobile menu -->
  <div id="page">
    <!-- Header -->
    <header>
      <div class="header-container">
        <div class="container">
          <div class="row">
            <div class="col-sm-6 col-md-6 col-xs-12">
              <!-- Header Logo -->
              <a class="" style="color: white; font-weight:800; font-size:30px" href="<?php echo base_url(); ?>">
                <h6 class="title-app">TokoPerhutani</h6>
              </a>
              <!-- End Header Logo -->
            </div>
            <div class="col-md-6 col-sm-6 col-lg-4 col-xs-12 ml-maxright">
              <div class="row float-right" style="display:flex; position: relative;">
                <?php if ($this->session->userdata('id_member') == "") { ?>
                  <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                    <div class="btn-group" role="group" aria-label="First group">
                      <button id="login_button" type="button" class="btn btn-dark" data-toggle="modal" data-target="#LoginModal"> Login </button>
                    </div>
                    <div class="btn-group mr-2" role="group" aria-label="First group">
                      <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Daftar</button>
                        <ul class="dropdown-menu dropdown-menu-right" style="margin-top: 50%;">
                          <li>
                              <!--<button id="login_button" type="button" class="btn btn-dark" data-toggle="modal" data-target="#register"> Login </button>-->
                              <a href="#" id="login_button" data-toggle="modal" data-target="#register">Daftar POTP</a>
                              </li>
                          <li><a href="http://sipuhh.dephut.net:7777/itts/a_daftar_online" target="_blank">Daftar SiPUHH</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                <?php } else {
                  $id_member = $this->session->userdata('id_member');
                  $member = $this->db->query('SELECT * FROM member_new WHERE id_member=' . $id_member)->result_array();
                  $nama = explode(" ", $member[0]['nama']);
                ?>
                  <div class="d-flex">
                    <!-- Keranjang -->
                    <div class="mr-1">
                      <div class="dropdown block-company-wrapper">
			<a role="button" data-toggle="dropdown" data-target="#" class="block-company dropdown-toggle icon-menu" href="#"><i style="color:white;" class="fa cart_icon font-20 text-main"></i></a>
			<?php if (count($keranjang->result_array()) > 0) : ?>
                          <div class="badges"></div>
                        <?php endif; ?>
                        <ul class="dropdown-menu content-dropdown">
                          <li class="header-dropdown" style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="display: flex; align-items: center;">
                              <span class="fs-18 fw-7 mr-1" style="color: #4F4F4F; ">Keranjang Anda</span>
                              <span class="fs-12 fw-7" style="color: white ; background-color: #EB5757; border-radius: 999px; padding: 4px 9px;"><?= count($keranjang->result_array()) ?></span>
                            </div>
                            <a href="#" class="fw-6 float-right pr-0" style="color: #219653; font-size: 14px;">
                              Lihat Keranjang
                              <img src="<?= base_url(); ?>/assets/images/entypo_chevron-right.png" height="16px" alt="">
                            </a>
                          </li>
                          <li class="divider divider-dropdown" role="separator"></li>
                          <li class="items-dropdown font-13 mb-1">
                            <?php if ($keranjang->num_rows() > 0) { ?>
                              <?php foreach ($keranjang->result_array() as $result) { ?>
                                <div class="d-flex mb-1">
                                  <!-- GANTI DENGAN GAMBAR -->
                                  <img class="item-center mr-2" style="width: 85px; height: 85px;" src="<?= base_url(); ?>assets/images/products/<?= $result['url_foto']?>"></img>
                                  <div style="display: flex; flex-direction: column; justify-content: center;">
                                    <span class="fs-18 fw-6" style="color: #4F4F4F;"><?= $result['nama_kategori']; ?></span>
                                    <span class="fs-12" style="color: #828282;  font-weight: normal;"><?= $result['total_quantity'] . ' Barang' ?>
                                    </span>
                                    <span class="fs-18 fw-6" style="color: #F2994A;">Rp <?= number_format(($result['total_price']), 0, ',', '.') ?></span>
                                  </div>
                                </div>
                              <?php } ?>
                            <?php } ?>
                          </li>
                        </ul>
                      </div>
                    </div>

                    <!-- Notifikasi -->
                    <div class="mr-1">
                      <div class="dropdown block-company-wrapper hidden-xs">
                        <a role="button" data-toggle="dropdown" data-target="#" class="block-company dropdown-toggle icon-menu" href="#"><i class="fa notif_icon" style="color:white;"></i>
                          <?php if (count($output) > 0) : ?>
                            <div class="badges"></div>
                          <?php endif; ?>
                        </a>
                        <ul class="dropdown-menu content-dropdown notifikasi">
                          <li class="header-dropdown">
                            <div style="display: flex; justify-content:space-between">
                              <div style="display: flex; align-items: center;">
                                <span class="fs-18 fw-7 mr-1" style="color: #4F4F4F; ">Notifikasi</span>
                                <span class="fs-12 fw-7" style="color: white ; background-color: #EB5757; border-radius: 999px; padding: 4px 9px;"><?= count($output); ?></span>
                              </div>
                            </div>
                          </li>
                          <li class="divider divider-dropdown" role="separator"></li>
                          <li class="items-dropdown ">
                            <div class="notif-retail" style="width: 568px;">
                              <!-- <div class="popup-content mt-1 mb-1" style="display: flex; justify-content: space-between; align-items: center;">
                                <div style="display: flex; flex-direction: column;">
                                  <div class="mb-1 d-flex" style="align-items: center;">
                                    <h4 class="fs-18 fw-6 mr-1">Madu</h4>
                                    <h5 class="fs-12 fw-4" style="color: #828282;">200 Kg</h5>
                                  </div>
                                  <div style="display: flex; align-items: center;">
                                    <img src="<?= base_url(); ?>/assets/images/bx_bxs-notification.png" alt="menunggu" style="width: 20px;" class="mr-1">
                                    <span class="fs-12 fw-4" style="color: #219653;">Menunggu Proses
                                      Pembayaran</span>
                                  </div>
                                </div>
                                <ul id="progressbar_1" class="float-right mg-0">
                                  <li class="active">Menunggu Konfirmasi</li>
                                  <li class="">Pesanan Diproses</li>
                                  <li>Pesanan Dikirim</li>
                                  <li>Sampai Tujuan</li>
                                </ul>
                              </div>
                              <div class="popup-content mt-1 mb-1" style="display: flex; justify-content: space-between; align-items: center;">
                                <div style="display: flex; flex-direction: column;">
                                  <div class="mb-1 d-flex" style="align-items: center;">
                                    <h4 class="fs-18 fw-6 mr-1">Minyak Kayu Putih</h4>
                                    <h5 class="fs-12 fw-4" style="color: #828282;">200 Kg</h5>
                                  </div>
                                  <div style="display: flex; align-items: center;">
                                    <span class="fs-12 fw-4" style="color: #828282;">Pesanan sedang dikirim</span>
                                  </div>
                                </div>
                                <ul id="progressbar_1" class="float-right mg-0">
                                  <li class="active">Menunggu Konfirmasi</li>
                                  <li class="">Pesanan Diproses</li>
                                  <li>Pesanan Dikirim</li>
                                  <li>Sampai Tujuan</li>
                                </ul>
                              </div> -->
                            </div>
                          </li>
                          <!-- <li class="divider divider-dropdown" role="separator"></li> -->
                          <li class="items-dropdown non-retail">
                            <?php foreach ($output as $key => $result) {
                              if ($key < 2) { ?>
                                <div class="mt-1  mb-1">
                                  <div class="d-flex" style="justify-content: space-between; align-items: center;">
                                    <div class="col-sm-7 pl-0">
                                      <?php if ($result['ra_from'] == 'ln') { ?>
                                        <div class="label-green">Internasional</div>
                                      <?php } else { ?>
                                        <div class="label-green">Local</div>
                                      <?php } ?>
                                      <h5 class="fs-14 fw-6 mr-1">Pembelian <?php echo $result['jenis_produk'] ?></h5>
                                    </div>
                                    <a href="<?= base_url(); ?>notifikasi" class="fw-6 fs-14 float-right" style="color: #219653;">
                                      Lihat Detail
                                      <img src="<?= base_url(); ?>/assets/images/entypo_chevron-right.png" style="height: 16px;" alt="">
                                    </a>
                                  </div>

                                  <div class="box mt-1">
                                    <div class="box-body">
                                      <?php if ($result['status_ra'] === 'RA') { ?>
                                        <ul id="progressbar_2" class="mg-0">
                                          <li class="active">Request Allocation</li>
                                          <li class="">Confirmation of Sales</li>
                                          <li>Purchase Order</li>
                                          <li>Performa Invoice</li>
                                          <li>Invoice</li>
                                        </ul>
                                        <div class="mt-2 box-notif">
                                          <p class="font-11 v-middle obj-middle text-notif">Pengajuan Request Allocation menunggu approval perhutani, mohon menunggu beberapa saat.</h6>
                                        </div>
                                      <?php } else if ($result['status_ra'] === 'COS') { ?>
                                        <ul id="progressbar_2" class="mg-0">
                                          <li class="active">Request Allocation</li>
                                          <li class="active">Confirmation of Sales</li>
                                          <?php if ($result['total_pi'] > 0) { ?>
                                            <li class="active">Purchase Order</li>
                                            <li class="active">Proforma Invoice</li>
                                          <?php } elseif ($result['total_po'] > 0) { ?>
                                            <li class="active">Purchase Order</li>
                                            <li>Proforma Invoice</li>
                                          <?php } else { ?>
                                            <li>Purchase Order</li>
                                            <li>Proforma Invoice</li>
                                          <?php } ?>
                                          <?php if ($result['total_invoice'] > 0) { ?>
                                            <li class="active">Invoice</li>
                                          <?php } else { ?>
                                            <li>Invoice</li>
                                          <?php } ?>
                                        </ul>
                                        <?php if ($result['total_pi'] == 0) { ?>
                                          <div class="mt-2 box-notif">
                                            <p class="font-11 v-middle obj-middle text-notif">Request allocation anda sudah di approve, silahkan ajukan Purchase Order</h6>
                                          </div>
                                        <?php } else if ($result['total_invoice'] > 0) { ?>
                                          <div class="mt-2 box-notif">
                                            <p class="font-11 v-middle obj-middle text-notif">Invoice anda sudah terbit, silahkan lakukan pembayaran sesuai waktu yang telah di tentukan</h6>
                                          </div>
                                        <?php } ?>
                                      <?php } ?>
                                    </div>
                                  </div>
                                </div>
                              <?php } ?>
                            <?php } ?>
                          </li>
                          <li class="divider divider-dropdown" role="separator"></li>
                          <?php if ($total_RA > 2) { ?>
                            <li class=" dropdwon-items item-center">
                              <a class="fs-12 fw-6 mb-1" href="<?= base_url(); ?>notifikasi" style="color: #4F4F4F;"><?= ($total_RA - 2); ?> more</a>
                            </li>
                          <?php } ?>
                        </ul>
                      </div>
                    </div>

                    <!-- Pesan -->
                    <div class="mr-3">
                      <div class="dropdown block-company-wrapper hidden-xs">
                        <a role="button" data-toggle="dropdown" data-target="#" class="block-company dropdown-toggle icon-menu" href="#"><i class="email_icon" style="color:white;"></i></a>
                        <?php if ($notif_pesan->num_rows() > 0) { ?>
                            <ul class="dropdown-menu content-dropdown">
                              <li class="header-dropdown">
                                <div style="display: flex; justify-content:space-between">
                                  <div style="display: flex; align-items: center;">
                                    <span class="fs-18 fw-7 mr-1" style="color: #4F4F4F;">Pesan</span>
                                    <span class="fs-12 fw-7" style="color: white ; background-color: #EB5757; border-radius: 999px; padding: 4px 9px;"><?php echo count($notif_pesan->result_array()); ?></span>
                                  </div>
                                </div>
                              </li>
                              <li class="divider divider-dropdown" role="separator"></li>
                                <?php foreach ($notif_pesan->result_array() as $result) { ?>
                                  <li class="items-dropdown ">                        
                                    <div class="popup-content mb-1 pl-2" style="align-items: center;">
                                      <img src="<?= base_url(); ?>assets/images/ic_message_enabled.png" style="width: 40px;" class="mr-2" alt="">
                                      <div style="display: flex; flex-direction: column;">
                                        <h6 style="font-size: 10px; color:#BDBDBD; margin-top: 6px;"><?= $result['created_at']; ?></h6>
                                        <h5 class="fs-14 fw-7" style="margin-top: 6px; color: #444444;"><?= $result['title']; ?></h5>
                                        <p class="fs-12 fw-4" style="margin-top: 6px; color: #989898;">
                                          <?= $result['message']; ?>
                                        </p>
                                      </div>
                                    </div>
                                  </li>
                                <?php } ?>
                            </ul>
                         <?php } ?>
                      </div>
                    </div>

                    <!-- User -->
                    <div style="padding: 4px;">
                      <div class="dropdown block-company-wrapper">
                        <span class="mt-1 icon-menu font-weight-bold text-white" style="padding: 0;"><?= ucwords(strtolower($nama[0])) ?></span>
                      </div>
                    </div>
                    <div class="mr-1">
                      <div class="dropdown block-company-wrapper">
                        <a role="button" data-toggle="dropdown" data-target="#" class="block-company dropdown-toggle icon-menu" href="#">
                          <i style="color:white;" class="user_icon"></i>
                        </a>
                        <ul class="dropdown-menu content-dropdown" style="min-width: 300px; margin:10px -268px;">
                          <li class="font-15">
                            <a class="mt-1" href="#" style="display: flex; align-items: center;">
                              <img src="<?= base_url(); ?>/assets/images/ic_user_enabled.png" style="width: 21px; height: 20px;" class="mr-2" alt="">
                              <div style="display: flex; flex-direction: column;">
                                <h5 class="fw-7 fs-14" style="color: #4F4F4F;"><?= ucwords(strtolower($member[0]['nama'])) ?></h5>
                                <h6 class="fw-4 fs-12" style="color: #828282;">
                                  <?php if ($this->session->userdata('level_user') === 'Key Account') {
                                    echo $this->session->userdata('level_user');
                                  } else {
                                    echo $this->session->userdata('level_user') . ' (' . $this->session->userdata('asal_negara') . ')';
                                  } ?>
                                </h6>
                              </div>
                            </a>
                          </li>
                          <li class="divider divider-dropdown" role="separator"></li>
                          <li class="font-13 mb-1">
                            <a href="<?= base_url(); ?>personal_data">
                              <img src="<?= base_url(); ?>/assets/images/ic_edit_profile.png" style="width: 20px;" class="mr-2" alt="">
                              Edit Profile
                            </a>
                          </li>
                          <li class="font-13 mb-1">
                            <a href="<?= base_url(); ?>history">
                              <img src="<?= base_url(); ?>/assets/images/ic_history.png" style="width: 20px;" class="mr-2" alt="">
                              History Pesanan
                            </a>
                          </li>
                          <li class="font-13 mb-1">
                            <a href="<?= base_url(); ?>ubah_password">
                              <img src="<?= base_url(); ?>/assets/images/ic_lock.png" style="width: 20px;" class="mr-2" alt="">
                              Ganti Password
                            </a>
                          </li>
                          <li class="font-13 mb-1">
                            <a href="<?= base_url(); ?>auth/logout">
                              <img src="<?= base_url(); ?>/assets/images/ic_sign_out.png" style="width: 20px;" class="mr-2" alt="">
                              Keluar
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
              </div>
            </div>
          </div>
        </div>

      </div>
    </header>
    <!-- end header -->

    <!-- Navbar  Menu-->
    <nav class="nav-bg-menu">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="mtmegamenu">
              <ul>
                <li class="mt-root">
                  <div class="mt-root-item"><a href="<?php echo base_url(); ?>">
                      <div class="title title_font"><span class="title-text">Beranda<?php echo $this->lang->line('menu_beranda'); ?></span></div>
                    </a></div>
                </li>
                <li class="mt-root">
                  <div class="mt-root-item"><a href="<?php echo base_url(); ?>panduan">
                      <div class="title title_font"><span class="title-text">Panduan<?php echo $this->lang->line('menu_panduan'); ?></span></div>
                    </a></div>
                </li>
                <li class="mt-root">
                  <div class="mt-root-item"><a href="<?php echo base_url(); ?>article/static_art/cara-pembayaran">
                      <div class="title title_font"><span class="title-text">Cara Pembayaran<?php echo $this->lang->line('menu_pembayaran'); ?></span></div>
                    </a></div>
                </li>
                <li class="mt-root">
                  <div class="mt-root-item"><a href="<?php echo base_url(); ?>article/static_art/syarat-dan-ketentuan">
                      <div class="title title_font"><span class="title-text">Syarat Ketentuan<?php echo $this->lang->line('menu_syarat_ketentuan'); ?></span></div>
                    </a></div>
                </li>
                <li class="mt-root">
                  <div class="mt-root-item"><a href="<?php echo base_url(); ?>SertifikatPerhutani">
                      <div class="title title_font"><span class="title-text">Sertifikat<?php echo $this->lang->line('menu_sertifikat_pethutani'); ?></span></div>
                    </a></div>
                </li>
                <li class="mt-root">
                  <div class="dropdown jtv-language-box mt-2">
                    <!-- <select onchange="javascript:window.location.href='<?php echo base_url(); ?>LanguageSwitcher/switchLang/'+this.value;">
                      <option value="english" <?php if ($this->session->userdata('site_lang') == 'english') echo 'selected="selected"'; ?>><i class="ina-flag"></i> English</option>
                      <option value="indo" <?php if ($this->session->userdata('site_lang') == 'indo') echo 'selected="selected"'; ?>><i class="ina-flag"></i> Indonesia</option>
                    </select> -->

                    <a role="button" data-toggle="dropdown" data-target="#" class="block-language dropdown-toggle d-flex" href="#">
                      <i class="ina-flag"></i><span class=" fa fa-chevron-down lay-flag"></span> </a>
                    <ul class="dropdown-menu" role="menu">
                      <li> <a class="<?php if ($this->session->userdata('site_lang') == 'indo' && $this->session->userdata('asal_negara') == 'Indonesia') echo 'selected="selected"'; ?>" href="<?php echo base_url(); ?>LanguageSwitcher/switchLang/indo"> <i class="ina-flag"></i> Indonesia</a> </li>
                      <li> <a class="<?php if ($this->session->userdata('site_lang') == 'english' && $this->session->userdata('asal_negara') != 'Indonesia') echo 'selected="selected"'; ?>" href="<?php echo base_url(); ?>LanguageSwitcher/switchLang/english"> <i class="eng-flag"></i> English</a> </li>
                    </ul>
                  </div>
                </li>
                <li class="mt-root">
                  <div class="mt-root-item">
                    <label class="wrap-retail_1 input">
                      <select class="dropdown-menu2" style="width:48px;">
                        <option>IDR</option>
                      </select>
                    </label>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- end nav -->

    <!-- Login Modal -->
    <div class="modal fade" id="LoginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header" style="border-bottom: 0px;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <img alt="e-commerce" src="<?php echo base_url(); ?>assets/images/tokoperhutani.png" style="width: 55%; margin-top: 10%; margin-left: 20%;">
          </div>
          <input type="hidden" name="p" value="" id="p">
          <form id="form-login" name="formAddress" method="POST" action="">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="csrf_header" style="width: 400px">
            <div class="modal-body" style="padding:25px 35px 0px 35px;">
              <div class="input-group" style="margin-bottom:17px;">
                <span class="input-group-addon bg-white border-left-radius"><i class="fa fa-user text-main"></i></span>
                <input id="email" type="text" class="form-control border-right-radius" name="email" placeholder="E-mail" autocomplete="off" required="true">
              </div>
              <div class="input-group" style="margin-bottom:17px;">
                <span class="input-group-addon bg-white border-left-radius"><i class="fa fa-lock text-main"></i></span>
                <input id="password" type="password" class="form-control border-right-radius" placeholder="Password" autocomplete="off" required="true" onfocus="showPassword()" onblur="hidePassword()"> <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                <input id="xpassword" type="hidden" name="password" placeholder="Password" autocomplete="off" required="true">
              </div>

              <div class="input-group" style="margin-bottom:17px;">
                <div class="g-recaptcha" data-sitekey="6LdXfuYUAAAAAC2J8Hfrxue7hQ-0SIc7w8aaXa0s" style="margin-left:1px;"></div>
              </div>
            </div>
            <div class="modal-footer" style="border-top:0px;">
              <div class="row text-left" style="margin: auto 5%; align-items: center;">
                <div class="col-md-6">
                  <a href="<?php echo base_url(); ?>forgot_password" class="font-12">Lupa Password?</a>
                </div>
                <div class="col-md-6 text-right">
                  <button id="btn_login" name="btn_login" type="button" class="btn btn-sm btn-main">LOGIN</button>
                </div>
              </div>
              <div class="text-center" style="margin: 33px 0px;">
                <h6 class="text-muted font-weight-normal">Belum punya akun? <a class="text-main font-weight-bold" href="<?php echo base_url(); ?>auth">Daftar</a></h6>
              </div>
            </div>
          </form>
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

    <div class="modal fade" id="processing" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog " role="document">
        <div class="modal-content card-login">
          <div class="modal-body text-center" style="padding:0px 45px 30px 45px">
            <img src="<?php echo base_url('assets/images/AjaxLoader.gif'); ?>" alt="" />
            <br />
            <br />
            Processing...
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal-message">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header no-padding">
            <div class="table-header" style="padding: 10px;">
              <button class="close" data-dismiss="modal" type="button" style="margin-top: -8px; width: 34px; margin-left: 0px; margin-right: -8px;"><i class="soap-icon-close"></i></button>
              Message
            </div>
          </div>

          <div class="modal-body">
            &nbsp;
          </div>

          <div class="modal-footer no-margin-top">
            <button class="btn btn-sm btn-danger pull-left" data-dismiss="modal">Ok</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>

    <!-- Message Modal -->
    <div class="modal fade" id="modal-message" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content card-login">
          <div class="modal-header" style="border-bottom: 0px;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <div class="mt-3 text-center">
              <i class="fa fa-clipboard mr-1 font-20 text-main"></i><span class="font-weight-bold text-main">Message</span>
            </div>
          </div>
          <div class="modal-body text-center" style="padding:0px 45px 30px 45px">
            &nbsp;
          </div>
          <div class="modal-footer no-margin-top">
            <button class="btn btn-block btn-outline-main" data-dismiss="modal">OK</button>
          </div>
        </div>
      </div>
    </div>
    <!-- End Modal Message -->



    <!-- modal register --
    <div id="register" class="modal-container">-->
     <div class="fade modal-container" id="register" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <form class="modal-content1">
        <div class="modal-title">
          <span>Register</span>
          <a class="modal-close" href="#"><img src="assets/images/eva_close-fill.png" alt="..."></a>
        </div>
  
        <div class="row mb-1">
          <div class="col-md-12 col-lg-12 col-xs-12 mb-1">
            <span style="font-weight: 600;font-size: 16px;">Alamat email</span>
          </div>
          <div class="col-md-12 col-lg-12 col-xs-12">
            <input type="text" class="input-custom form-control" name="email_register" id="email_register">
          </div>
        </div>
  
        <div class="row mb-1">
          <div class="col-md-12 col-lg-12 col-xs-12 mb-1">
            <span style="font-weight: 600;font-size: 16px;">Lokasi Negara</span>
          </div>
          <div class="col-md-12 col-lg-12 col-xs-12">
            <select class="input-custom form-control" name="asal_negara" id="asal_negara" required oninvalid="this.setCustomValidity('Asal negara harus dipilih')" oninput="setCustomValidity('')">
                            <option selected disabled>Pilih Asal Negara</option>
                            <?php foreach ($country as $result => $object) { ?>
                                <option value="<?php echo $object->c_country_id; ?>"><?php echo $object->name; ?></option>
                            <?php } ?>
            </select>
          </div>
        </div>
  
        <div class="row mb-1">
          <div class="col-md-12 col-lg-12 col-xs-12 mb-1">
            <span style="font-weight: 600;font-size: 16px;">Level User</span>
          </div>
          <div class="col-md-12 col-lg-12 col-xs-12">
            <select class="input-custom form-control">
              <option value="Member">Member</option>
              <option value="Agent">Agent</option>
              <option value="Key Account">Key Account</option>
            </select>
          </div>
        </div>

        <!--
        <div class="modal-input">
          <span class="mb-1">Level User</span>
          <!-- <div class="modal-level">
            <button id="member-level" type="button">Member</button>
            <button id="agent-level" type="button">Agent</button>
            <button id="store-manager-level" type="button">Store Manager</button>
          </div> --

          <div class="radio-toolbar">
            <input type="radio" id="radioApple" name="radioFruit" value="apple" checked>
            <label for="radioApple">Member</label>
  
            <input type="radio" id="radioBanana" name="radioFruit" value="banana">
            <label for="radioBanana">Agent</label>
  
            <input type="radio" id="radioOrange" name="radioFruit" value="orange">
            <label for="radioOrange">Store Manager</label>
          </div>
        </div>-->
  
        <button class="modal-btn" id="btn_register" type="button" >
          <span>Register</span>
        </button>
  
        <span class="modal-footer">Have an account? <a href="#">Log In</a></span>
      </form>
    </div>
    <!-- end modal register -->





    <!-- JS Plugin-->
    <!-- jquery js -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>

    <!-- bootstrap js -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>

    <!-- datepicker js -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.min.js"></script>

    <!-- owl.carousel.min js -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/owl.carousel.min.js"></script>

    <!-- bxslider js -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.bxslider.js"></script>

    <!-- Slider Js -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/revolution-slider.js"></script>
    <script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl=en"></script>

    <!-- megamenu js -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/megamenu.js"></script>
    <script type="text/javascript">
      /* <![CDATA[ */
      var mega_menu = '0';

      /* ]]> */
    </script>

    <!-- jquery.mobile-menu js -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/mobile-menu.js"></script>

    <!--jquery-ui.min js -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>

    <!-- main js -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/main.js"></script>

    <!-- countdown js -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/countdown.js"></script>


    <!-- Revolution Slider -->
    <script type="text/javascript">
      jQuery(document).ready(function() {
        jQuery('.tp-banner').revolution({
          delay: 9000,
          startwidth: 1920,
          startheight: 790,
          hideThumbs: 10,

          navigationType: "bullet",
          navigationStyle: "preview1",

          hideArrowsOnMobile: "on",

          touchenabled: "on",
          onHoverStop: "on",
          spinner: "spinner4"
        });


        // var popUpShown = getCookie('popUpShown');
        // var numberOfDaysCookieExpiresIn = 99999999999;

        // // check the cookie to see if the popup has been shown already
        // if (popUpShown != '1') {


        //   // set the cookie so we dont show the pop up again
        //   setCookie('popUpShown', '1', numberOfDaysCookieExpiresIn);
        // };

        // var executed = false;
        // Cookies.set('executed', 'false');
        // var asalnegara = "<?php echo $this->session->userdata('asal_negara'); ?>";
        // var sitelang = "<?php echo $this->session->userdata('site_lang') ?>";

        // if (asalnegara != "Indonesia") {
        //   if (sitelang == 'english') {
        //     return
        //   } else {
        //     // Cookies.set('executed', 'true');
        //     // executed = true;
        //     location.href = "<?php echo base_url(); ?>LanguageSwitcher/switchLang/english";
        //   }
        // } else {
        //   if (sitelang == 'indo') {
        //     return
        //   } else {
        //     // Cookies.set('executed', 'true');
        //     // executed = true;
        //     location.href = "<?php echo base_url(); ?>LanguageSwitcher/switchLang/indo";
        //   }
        // }


        // alert(asalnegara);
      });
    </script>

    <script type="text/javascript">
      password = '';
      p = '';

      function setPasswordBack() {
        showPassword();
      }

      function hidePassword() {
        p = document.getElementById('password');
        password = p.value;
        param = "q=" + password + "&<?php echo $this->security->get_csrf_token_name(); ?>=" + $("#csrf_header").val();
        var xmlhttp = new XMLHttpRequest();
        p = document.getElementById('p');
        p.type = "hidden";
        p.value = password;

        xmlhttp.open("POST", "<?php echo base_url(); ?>auth/GetHit", true);
        xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var obj = JSON.parse(this.responseText);
            var new_hash = obj.csrfHash;
            var password = obj.param;
            $("#xpassword").val(password);
            $("#csrf_header").val(new_hash);
          }
        };
        xmlhttp.send(param);
        $("#password").addClass("form-control border-right-radius");
      }

      function showPassword() {
        p = document.getElementById('password');
        p.type = "password";
        p.value = "";
      }
    </script>



    <script type="text/javascript">
      function hideemail() {
        $('#password').attr("autocomplete", "off");
        setTimeout('$("#password").val("");', 1000);
      }

      $('#password').attr("autocomplete", "off");
      setTimeout('$("#password").val("");', 1000);

      $(document).on('click', '.toggle-password', function() {
        $(this).toggleClass("fa-eye fa-eye-slash");

        var input = $("#password");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
      });

      $(document).ready(function() {

        var hidePassword = function() {
          password = '';
          p = '';
          p = document.getElementById('password');
          password = p.value;
          param = "q=" + password + "&<?php echo $this->security->get_csrf_token_name(); ?>=" + $("#csrf_header").val();
          var xmlhttp = new XMLHttpRequest();

          xmlhttp.open("POST", "<?php echo base_url(); ?>auth/GetHit", true);
          xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
          xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              var obj = JSON.parse(this.responseText);
              var new_hash = obj.csrfHash;
              var password = obj.param;
              $("#xpassword").val(password);
              $("#csrf_header").val(new_hash);
            }
          };
          xmlhttp.send(param);
        }
      });

      $('#btn_login').on('click', function() {
        var password = $("#password").val();
        var email = $("#email").val();
        var tokenCode = '<?php echo $this->security->get_csrf_hash(); ?>';
        $.ajax({
          url: "<?php echo base_url(); ?>auth/login2",
          method: "post",
          cache: false,
          data: {
            'email': email,
            'password_login': password,
            'POTPtokenCode': tokenCode,
            'g-recaptcha-response': grecaptcha.getResponse()
          },
          dataType: "json",
          beforeSend: function() {
            $("#indicator").modal("show");
          },
          success: function(data) {
            $("#indicator").modal("hide");
            $("#LoginModal").modal("hide");
            $("#csrf_header").val(data.POTPtokenCode);
            if (data.status == "ok") {
              location.reload(true);
              // location.href = data.message;
              // var kodeManager = jQuery.trim(data.kode_manager);
              // if (kodeManager != "") {
              //   location.reload();
              // } else {
              //   location.reload();
              // }
            }

            // if (data.status == "update_profile") {
            //   location.href = data.message;
            // }

            // if (data.status == "pembeli_baru") {
            //   location.href = data.message;
            // }

            // if (data.status == "change_password") {
            //   location.href = data.message;
            // }

            if (data.status == "error") {
              showMessage(data.message);
              tokenCode = data.POTPtokenCode;
            }

            if (data.status == "userLogin") {
              showMessage(data.message);
            }

          },
          compltete: function(data) {
            $("#indicator").modal("hide");
          },
          error: function(e) {
            $("#indicator").modal("hide");
          }
        });
      });



     $('#btn_register').on('click', function() {
        var email_register = $("#email_register").val();
        var tokenCode = '<?php echo $this->security->get_csrf_hash(); ?>';
        $.ajax({
          url: "<?php echo base_url(); ?>auth/register",
          method: "post",
          cache: false,
          data: {
            'email_register': email_register,
            //'password_login': password,
            'POTPtokenCode': tokenCode
            //'g-recaptcha-response': grecaptcha.getResponse()
          },
          dataType: "json",
          beforeSend: function() {
            //$("#indicator").modal("show");
          },
          success: function(data) {
            $("#indicator").modal("hide");
            $("#LoginModal").modal("hide");
            $("#csrf_header").val(data.POTPtokenCode);
            if (data.status == "ok") {
              location.reload(true);
            }

            if (data.status == "error") {
              showMessage(data.message);
              tokenCode = data.POTPtokenCode;
            }

            if (data.status == "userLogin") {
              showMessage(data.message);
            }

          },
          compltete: function(data) {
            $("#indicator").modal("hide");
          },
          error: function(e) {
            $("#indicator").modal("hide");
          }
        });
      });



      $('form[name="formAddress"]').submit(function(e) {
        e.preventDefault();
        //hidePassword();
        $.ajax({
          url: "<?php echo base_url(); ?>auth/login2",
          method: "post",
          cache: false,
          data: $(this).serialize(),
          dataType: "json",
          beforeSend: function() {
            $("#indicator").modal("show");
          },
          success: function(data) {
            $("#indicator").modal("hide");
            $("#LoginModal").modal("hide");
            $("#csrf_header").val(data.POTPtokenCode);
            if (data.status == "ok") {
              var kodeManager = jQuery.trim(data.kode_manager);
              if (kodeManager != "") {
                location.reload();
              } else {
                location.reload();
              }
            }

            if (data.status == "update_profile") {
              location.href = data.message;
            }

            if (data.status == "pembeli_baru") {
              location.href = data.message;
            }

            if (data.status == "change_password") {
              location.href = data.message;
            }

            if (data.status == "error") {
              showMessage(data.message);
            }

            if (data.status == "userLogin") {
              showMessage(data.message);
            }

          },
          compltete: function(data) {
            $("#indicator").modal("hide");
          },
          error: function(e) {
            $("#indicator").modal("hide");
          }
        });
      });


      function showMessage(pStrMessage) {
        $('body').css('overflow', 'hidden');
        $("#modal-message .modal-body").html(pStrMessage);
        $("#modal-message").modal("show");
      }

      function redirect_daftar() {
        window.location.href = '<?php echo base_url(); ?>auth';
      }
    </script>



    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-72889993-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];

      function gtag() {
        dataLayer.push(arguments);
      }
      gtag('js', new Date());

      gtag('config', 'UA-72889993-1');
    </script>
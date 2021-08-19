<!DOCTYPE html> 
<html lang="en"> 
<head> 
<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 

<title>Perum Perhutani</title> 
<?php
	if(date('H') =='23'){
	    $datetime = new DateTime('tomorrow');
	    $tomorrow = $datetime->format('F d, Y 08:00:00');
	   //echo $tomorrow;
    }else{
        $datetime = new DateTime('now');
        $tomorrow = $datetime->format('F d, Y 08:00:00');
    }
?>

<script>
	
	var dateTomorrow = '<?php echo $tomorrow;?>';
</script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/countdown/style.css" type="text/css" media="screen">
<script type="text/javascript" src="<?php echo base_url();?>assets/countdown/js/jquery-1.7.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/countdown/js/jquery.countdown.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/countdown/js/jquery.tipsy.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/countdown/js/jquery.subscribe.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/countdown/js/jquery.contact.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/countdown/js/custom.js"></script>

</head> 
 
<body> 
	<div id="wrapper" style="padding-top:15px">
		<!--
		<header>
			<a class="logo" href="#"><img src="<?php echo base_url(); ?>assets/images/logo-perhutani.png" alt="logo" title="logo" /></a>
		</header>
		-->
		<div class="card" style="background-color:white;padding:20px;padding-left:50px;padding-right:50px">
			<div class="card-body">
			<h2 style="padding-top: 35px;">Survey Kepuasan Pelanggan</h2>					
					<div class="row"></div>
					<div class="row"></div>
					<p style="padding-top: 15px;font-size:15px" align="justify">
					Pelanggan POTP Yang Terhormat,<br><br>
					Kami dari Puslitbang Perhutani saat ini kami sedang melakukan survei tentang kepuasan pelanggan terhadap layanan dari Perhutani khususnya pelanggan kayu baik jati maupun rimba. Penelitian ini bertujuan untuk mengetahui kepuasan pelanggan terhadap layanan dari Perhutani, oleh karena itu kami mohon kesediaan Bapak/Ibu/ Saudara untuk memberikan jawaban dan masukan seobyektif mungkin. Kami mengucapkan terima kasih kepada Anda karena telah bersedia meluangkan waktu untuk membantu penelitian kami.<br><br>
					Untuk melanjutkan transaksi Anda, mohon untuk dapat melakukan pengisian survey pada link dibawah ini: <a target="_blank" href="http://puslitbangperhutani.com/survey-1">http://puslitbangperhutani.com/survey-1</a>
					<br><br>
					<sup>(*)</sup><small>Pastikan mengisi email yang valid <font color="red">sesuai dengan akun POTP</font> Anda.</small><br>
					<sup>(*)</sup><small>Jika Anda belum melakukan pengisian survey, maka Anda tidak dapat melanjutkan transaksi Anda.</small><br>
					<sup>(*)</sup><small>Jika Anda sudah mengisi survey diatas, silahkan refresh halaman ini untuk melanjutkan transaksi Anda.<small>
					</p>
			</div>
		</div>
		
			
			
		</div><!--end book-->
		
		<!--<p class="copyright">Copyright &copy; Perum Perhutani - All Rights Reserved</p>-->
		
	</div><!--end wrapper-->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/countdown/js/jquery.placeholder.js"></script>	<!-- placeholder html5 tag support for IE and Old Browsers -->
</body> 
</html>


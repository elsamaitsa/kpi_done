<?php
/*
error_reporting(-1); // reports all errors
ini_set("display_errors", "1"); // shows all errors
ini_set("log_errors", 1);*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class forgot_password extends MX_Controller
{
	public function __construct()
	{
	    parent::__construct();
	    $this->load->library('../controllers/aesencrypt');
	}



	public function index(){

			$data['title']				= 'Perhutani Ecommerce';
			$data['main_content'] 		= 'forgot_password';
			$data['menu']		        = $this->website_content->getMenu2(0,"");
			$data['search_list']		= $this->website_content->search_list(0);
			$this->load->view('includes/template', $data);
			$this->load->library('session');
			$user_id  = $this->session->userdata('user_id');
	}

	public function gen_code() {
			$create = strtoupper(md5(uniqid(rand(),true)));
			$style = substr($create,0,6);
			return $style;
	}


	public function checkForCharacterCondition($string) {
	    return (bool) preg_match('/(?=.*([A-Z]))(?=.*([a-z]))(?=.*([0-9]))(?=.*([~`\!@#\$%\^&\*\(\)_\{\}\[\]]))/', $string);
	}


	public function generate_pass() {
	    global $j;

		$j = 1;
	    $allowedCharacters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $pass = '';
	    $length = 8;
	    $max = mb_strlen($allowedCharacters, '8bit') - 1;
	    for ($i = 0; $i < $length; ++$i) {
	        $pass .= $allowedCharacters[random_int(0, $max)];
	    }

	    return $pass;
	    //exit();
	    /*if ($this->checkForCharacterCondition($pass)){
	        return $pass;
	    }else{
	        $j++;
	        return $this->generate_pass();
	    }*/
	}



	public function send_email($email_to,$isi_pesan,$file_attachment){
		$Mail = new PHPMailer();
		$Mail->IsSMTP(); // Use SMTP
		$Mail->Host        = "smtp.gmail.com"; // Sets SMTP server
		$Mail->SMTPAuth    = TRUE; // enable SMTP authentication
		$Mail->SMTPSecure  = "ssl"; //Secure conection
		$Mail->Port        = 465; // set the SMTP port
		$Mail->Username    = 'noreply@perhutani.co.id'; // SMTP account username
		$Mail->Password    = 'B3thebest'; // SMTP account password
		$Mail->CharSet     = 'UTF-8';

		$ToEmail = $email_to;

		$MessageHTML=$isi_pesan;
		$Mail->Encoding    = '8bit';
		$Mail->Subject     = 'LUPA PASSWORD E Commerce Perhutani ';
		$Mail->ContentType = 'text/html; charset=utf-8\r\n';
		$Mail->From        = 'noreply@localhost';
		$Mail->FromName    = 'E Commerce Perhutani ';
		// $Mail->AddAttachment($file_attachment, 'file.pdf');
		//$Mail->WordWrap    = 900; // RFC 2822 Compliant for Max 998 characters per line
		$Mail->AddAddress( $ToEmail ); // To:
		$Mail->isHTML( TRUE );
		$Mail->SMTPDebug  = 1;
		$Mail->Body    = $MessageHTML;
		//$Mail->AltBody = $MessageTEXT;
		if($Mail->Send()){
			return "Sukses";
		}else{
			return "gagal";
		}
		$Mail->SmtpClose();
	}

	public function update_forgot($email,$no_ktp,$password){

			$md5pass=md5($password);
			$pass = $this->aesencrypt->encrypt($password);
			$sql = "update member set count_login = 0, new_password = '$pass', password = '$md5pass', exp_password=DATE_ADD(sysdate(), INTERVAL 6 MONTH) where email = '$email' and no_ktp = '$no_ktp' and status = '1'";
			$query 	= $this->db->query($sql);


			if($query){
				return "true";
			}else{
				return "false";
			}
	}


	public function google_validate_captcha() {
	    $google_captcha = $this->input->post('g-recaptcha-response');
	    $google_response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LdXfuYUAAAAAByn5_3C8yUMVc43HxIQoORllkqD&response=" . $google_captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
	    $vgoogle=json_decode($google_response,true);
	    if ($vgoogle['success'] == false) {
	        return FALSE;
	    } else {
	    	return TRUE;
	    }
	}

	public function save(){
		$email=$this->input->post('email');
		$no_ktp=$this->input->post('no_ktp');
		$google_captcha = $this->input->post('g-recaptcha-response');
		if($this->google_validate_captcha()==FALSE){
			$this->session->set_flashdata('result', 'Maaf, Captcha tidak sesuai');
			redirect('auth');
		}elseif($google_captcha==""){
			$this->session->set_flashdata('result', 'Maaf, Captcha harus dipilih');
			redirect('auth');
		}
		$password_rand 						= $this->generate_pass();
		$result 							= $this->db->query("SELECT * from member where email = ? and no_ktp = ? and status = 1",
																									  array(
																											$email,
																											$no_ktp
																										));
		$result_belum_tervalidasi 	= $this->db->query("SELECT * from member where email = ? and no_ktp = ? and status = 0",
																									  array(
																											$email,
																											$no_ktp
																										));
		$result_terblokir		 			= $this->db->query("SELECT * from member where (email = ? and no_ktp = ? and status = 3)
																										or (email = ? and no_ktp = ? and status = 7)",
																									  array(
																											$email,
																											$no_ktp,
																											$email,
																											$no_ktp
																										));

		if($result->num_rows() > 0){
			foreach ( $result->result() as $row ) {

			$isi_pesan = "<h2>Selamat</h2>
				Password akun Anda berhasil direset,
				<div style='border-bottom:1px solid #ddd;border-left:1px solid #ddd;border-right:1px solid #ddd;border-top:3px solid red;padding:20px;font-size:13px;font-family:arial;'>
				<img style='width:10%;' src='https://www.tokoperhutani.com/assets/images/logo-perhutani.png'>
				<p style='line-height:18px'>
					<b style='font-size:16px'>Dear , ".$row->nama."</b><br>
						<br>
						</p>
						<br>
						<table style='width:50%;' style='1px solid #ccc; border-collapse:collapse;'>

							<tr>
								<th style=' padding-top: 5px; text-align:left; color:green; padding-bottom: 5px;' colspan='2'>
									Password akun Anda berhasil direset!
								</th>
							</tr>
							<tr>
								<td style=' padding-top: 5px; text-align:left; padding-bottom: 5px;'>
									Nama
								</td>
								<td style=' padding-top: 5px; text-align:left; padding-bottom: 5px;padding-right:5px; '>
									".$row->nama."
								</td>
							</tr>

							<tr>
								<td style=' padding-top: 5px; padding-bottom: 5px; text-align:left;'>
									Tanggal Lahir
								</td>
								<td style=' padding-top: 5px; padding-bottom: 5px; text-align:left;padding-right:5px; '>
									".$row->ttl."
								</td>
							</tr>

							<tr>
								<td style=' padding-top: 5px; text-align:center; color:green; padding-bottom: 5px;' colspan='0'>
									Berikut Data Login Akun Anda
								</td><td></td>
							</tr>
							<tr>
								<td style=' padding-top: 5px; text-align:left; color:green; padding-bottom: 5px;'>
									username
								</td>
								<td style=' padding-top: 5px; text-align:left; color:green; padding-bottom: 5px;padding-right:5px; '>
									".$row->email."
								</td>
							</tr>

							<tr>
								<td style=' padding-top: 5px; text-align:left; color:green; padding-bottom: 5px;'>
									Password
								</td>
								<td style=' padding-top: 5px; text-align:left; color:green; padding-bottom: 5px;padding-right:5px; '>
									$password_rand
								</td>
							</tr>
							<tr>
								<td style=' padding-top: 5px; text-align:left; color:green; padding-bottom: 5px;' colspan='2'>
									Silahkan <a href='https://www.tokoperhutani.com'>Klik disini untuk Login pada e-commerce Perhutani dengan akun anda</a>
								</td>
							</tr>
							</table>
							<br>

						</div>";
				if($this->update_forgot($row->email,$row->no_ktp,$password_rand) == "true"){
					$this->send_email($email,$isi_pesan,"");
					redirect('sukses_forgot_password');
				} else {
					echo $password_rand;
				}
			}
		}

		else if ($result_belum_tervalidasi->num_rows() > 0){
				$this->session->set_flashdata('result', 'Maaf, Akun anda belum tervalidasi oleh Admin. Mohon menunggu konfirmasi dari kami.');
				redirect('auth');
		}

		else if ($result_terblokir->num_rows() > 0){
			$this->session->set_flashdata('result', 'Maaf, status akun Anda saat ini sedang terblokir, Anda hanya dapat melakukan reset ulang password jika status akun Anda aktif.');
			redirect('auth');
		}

		else {
				$this->session->set_flashdata('result', 'Maaf, Kami tidak memiliki data dengan Email dan No KTP Tersebut');
				redirect('auth');
			}

	}
}

?>

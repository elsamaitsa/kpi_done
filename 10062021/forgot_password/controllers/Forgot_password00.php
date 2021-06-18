<?php 
//error_reporting(1);
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class forgot_password extends MX_Controller
{
	
	public function index(){

			$data['title']				= 'Perhutani Ecommerce';
			$data['main_content'] 		= 'forgot_password';
			$data['menu']		        = $this->website_content->getMenu2(0,"");
			$data['search_list']		= $this->website_content->search_list(0);
			$this->load->view('includes/template', $data);
			$this->load->library('session');
			$user_id  = $this->session->userdata('user_id');
	}	
	
	
function save(){
		function gen_code() { 
					$create = strtoupper(md5(uniqid(rand(),true))); 
					$style = substr($create,0,6);
					return $style;
		}
		

	function send_email($email_to,$isi_pesan,$file_attachment){
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
			$MessageTEXT="bb";
			$Mail->Encoding    = '8bit';
			$Mail->Subject     = 'KONFIRMASI REGISTRASI  E Commerce Perhutani ';
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
	
	
	function update_forgot($email,$no_ktp,$password){
		$pass = md5($password);
		$sql = "update member set password = '$pass' where email = '$email' and no_ktp = '$no_ktp' and status = '1'";
		$query 	= $this->db->query($sql);
		

		if($query){
			return "true";
		}else{
			return "false";
		}
	}
		$email=$_POST['email'];
		$no_ktp=$_POST['no_ktp'];
		$password_rand 				= gen_code();
		$result 					= $this->db->query("select * from member where email = '$email' and no_ktp = '$no_ktp' and status = 1");
		$result_belum_tervalidasi 	= $this->db->query("select * from member where email = '$email' and no_ktp = '$no_ktp' and status = 0");
		$result_terblokir		 	= $this->db->query("select * from member where email = '$email' and no_ktp = '$no_ktp' and status = 3 
														or email = '$email' and no_ktp = '$no_ktp' and status = 7");

		if($result->num_rows() > 0){
			foreach ( $result->result() as $row ) {
		
			$isi_pesan = "<h2>Selamat</h2>
				Akun Anda telah Aktif,
				<div style='border-bottom:1px solid #ddd;border-left:1px solid #ddd;border-right:1px solid #ddd;border-top:3px solid red;padding:20px;font-size:13px;font-family:arial;'>
				<img src='https://www.tokoperhutani.com/assets/images/logo-email.png'>
				<p style='line-height:18px'>
					<b style='font-size:16px'>Dear , ".$row->nama."</b><br>
						<br>
						</p>
						<br>
						<table style='width:50%;' style='1px solid #ccc; border-collapse:collapse;'>
						
							<tr>
								<th style=' padding-top: 5px; text-align:left; color:green; padding-bottom: 5px;' colspan='2'>
									Konfirmasi Validasi <br> Selamat, Akun Anda Telah Aktif
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
				if(update_forgot($row->email,$row->no_ktp,$password_rand) == "true"){
					send_email($email,$isi_pesan,"");
					redirect('sukses_forgot_password');
				}
				else{
						// echo $password_rand;
					}
			}
		}

		else if ($result_belum_tervalidasi->num_rows() > 0){
				$this->session->set_flashdata('result', 'Maaf, Akun anda belum tervalidasi oleh Admin. Mohon menunggu konfirmasi dari kami.');
				redirect('auth');
		}

		else if ($result_terblokir->num_rows() > 0){
			$this->session->set_flashdata('result', 'Maaf, Akun anda telah diblokir.');
			redirect('auth');
		}

		else {
				$this->session->set_flashdata('result', 'Maaf, Kami tidak memiliki data dengan Email dan No KTP Tersebut');
				redirect('auth');
			}
		
}
}
    
?>
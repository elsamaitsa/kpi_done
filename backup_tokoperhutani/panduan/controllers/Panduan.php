<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class panduan extends MX_Controller{

    public function index(){

		$date_from_user = strtotime(date('Y-m-d H:i:s'));
		$now 		= new DateTime('now');
		$start_date = strtotime($now->format('Y-m-d 23:00:00'));
		$tomorrow 	= new DateTime('tomorrow');
		$end_date	= strtotime($tomorrow->format('Y-m-d 02:00:00'));
		// echo $date_from_user.'<br>'.$start_date.'<br>'.$end_date;
		
		if(($date_from_user > $start_date) && ($date_from_user < $end_date)){
			$mainContent = 'closed';
		}else{
			$mainContent = 'beranda';
		}
		
		$data=array(
			'title'					=>'Perhutani Ecommerce',
			'main_content' 			=>'index',
			
		);
		$this->load->view('includes/template', $data);
		
	}
	
}
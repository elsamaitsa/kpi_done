<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class article extends MX_Controller
{

	  public function detil(){
		$jml = $this->db->get('ecomm_m_kapling');
			
		$data=array(
			'title'			=>'Perhutani Ecommerce',
			'main_content' 	=>'detil',
			'menu'		    =>$this->website_content->getMenu2(0,""),
			'search_list'	=>$this->website_content->search_list(0),
			'detil_article' => $this->headline_article(),
			'scroll_article' => $this->scroll_article()
			);
		$this->load->view('includes/template', $data);
	}
	public function static_art(){
		$jml = $this->db->get('ecomm_m_kapling');
			
		$data=array(
			'title'			=>'Perhutani Ecommerce',
			'main_content' 	=>'static_content',
			'menu'		    =>$this->website_content->getMenu2(0,""),
			'search_list'	=>$this->website_content->search_list(0),
			'detil_article' => $this->static_article(),
			'scroll_article' => $this->scroll_article()
			);
		$this->load->view('includes/template', $data);
	}
	
	
	public function static_article(){
		$id = $this->uri->segment(3);	
		$query = $this->db->query("select * from article, menu where article.id_menu = menu.id_menu and menu.link = '$id' ");
		foreach($query->result() as $board){
			$data[] = $board;
		}
		return $data;
	}
	
	public function headline_article(){
		$id = $this->uri->segment(3);	
		$query = $this->db->query("select * from article where url_article = '$id' ");
		foreach($query->result() as $board){
			$data[] = $board;
		}
		return $data;
	}
	
	public function scroll_article(){
		$query = $this->db->query("select * from article where headline = 'Y' limit 3");
		foreach($query->result() as $board){
			$data[] = $board;
		}
		return $data;
	}
}
    
?>
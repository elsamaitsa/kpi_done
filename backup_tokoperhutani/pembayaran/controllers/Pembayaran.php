<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pembayaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // $this->load->library('../controllers/aesencrypt');
    }

    public function index()
    {
        $mainContent = 'pembayaran';
        $id = $this->input->get('id', TRUE);
        $id_member = $this->session->userdata('id_member');

        $detailPembayaran = $this->db->query("SELECT a.id as id_orders, a.batas_pembayaran, a.nama_bank, b.url_image as bank_image, a.nomor_bank, b.account_name, a.total_pembayaran, a.total_harga, a.total_ongkir, b.url_image
            FROM orders_retail a 
            LEFT JOIN bank_retail b ON b.id = a.id_bank_retail
            WHERE a.id = '$id'"
        );

        $totalQuantity = $this->db->query("SELECT SUM(total_quantity) as total_quantity 
            FROM orders_retail_produk 
            WHERE id_orders_retail = '$id'
            GROUP BY id_orders_retail"
        )->result_array();

        $data['title']                = 'Pembayaran Tokoperhutani';
        $data['main_content']         = $mainContent;
        $data['detailPembayaran']    = $detailPembayaran;
        $data['totalQuantity']    = $totalQuantity;

        $this->load->view('includes/template', $data);
    }
}

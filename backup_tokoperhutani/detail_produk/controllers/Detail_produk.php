<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Detail_produk extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// $this->load->library('../controllers/aesencrypt');
	}

	public function index()
	{
		$id = $this->input->get('id', TRUE);

		$detail_produk = $this->db->query("select * from produk_kategori where id = $id");
		$produk_foto = $this->db->query("SELECT * FROM produk_kategori_foto WHERE id_produk_kategori = $id");
		$namaproduk = $detail_produk->result_array();
		$nama_produk = $namaproduk[0]['nama_kategori'];

		if ($namaproduk[0]['sales_type'] == 'Non Retail') {
			$mainContent = 'detail_produk';
		} else if ($namaproduk[0]['sales_type'] == 'Retail') {
			$mainContent = 'detail_produk_retail';
		}

		$month = date('m');
		$year = date('Y');
		$currentDate = date('Y-m-d H:i:s');
		$id_member = $this->session->userdata('id_member');

		if ($id_member != '') {
			$produkLog = $this->insert_produk_show_log($id_member, $id);
		}

		if ($this->session->userdata('level_user') == 'Agent') {
			$query2 = 'a.id_member';
		} else {
			$query2 = 'a.id_keyaccount';
		}

		$checkKeranjang = $this->db->query("SELECT * FROM keranjang
			WHERE id_member = '$id_member'
			AND id_produk_kategori = '$id'")->result_array();

		$checkCOS = $this->db->query("SELECT * FROM `request_allocation` a
			LEFT JOIN price_list d ON d.id = a.id_price_list
            LEFT JOIN (SELECT b.id, SUM(quantity_approve) as total_quantity_approve 
			FROM warehouse_request_allocation a 
			LEFT JOIN request_allocation b ON b.id = a.id_request_allocation 
			WHERE b.id_member = '$id_member' 
			AND b.status = 'COS'
			GROUP BY id_request_allocation) b ON b.id = a.id
			LEFT JOIN (SELECT c.id, SUM(quantity_sell) as total_quantity_sell 
			FROM purchase_order a 
			LEFT JOIN purchase_order_quantity b ON b.id_purchase_order = a.id
			LEFT JOIN request_allocation c ON c.id = a.id_request_allocation
			WHERE c.id_member = '$id_member'
			GROUP BY a.id_request_allocation) c ON c.id = a.id 
			WHERE status = 'COS' 
			AND a.id_member = '$id_member'
			AND a.jenis_produk = '$nama_produk'
			AND b.total_quantity_approve <> c.total_quantity_sell
			AND MONTH(a.periode_end) = '$month' AND YEAR(a.periode_end) = '$year' 
			AND MONTH(a.periode_start) = '$month' AND YEAR(a.periode_start) = '$year'
			AND a.periode_end >  '$currentDate'
		")->row();

		$checkWaitingCOS = $this->db->query("SELECT * FROM request_allocation
			WHERE status_document IN ('waiting approval','waiting approval adendum')
			AND id_member = '$id_member'
			AND jenis_produk = '$nama_produk'
			AND MONTH(created_at) = '$month' AND YEAR(created_at) = '$year'
		")->row();

		$checkCOSquantity = $this->db->query("SELECT * 
			FROM request_allocation a 
			LEFT JOIN (SELECT b.id, SUM(quantity_approve) as total_quantity_approve 
			FROM warehouse_request_allocation a 
			LEFT JOIN request_allocation b ON b.id = a.id_request_allocation 
			WHERE b.id_member = '$id_member' 
			AND b.status = 'COS'
			GROUP BY id_request_allocation) b ON b.id = a.id
			LEFT JOIN (SELECT c.id, SUM(quantity_sell) as total_quantity_sell 
			FROM purchase_order a 
			LEFT JOIN purchase_order_quantity b ON b.id_purchase_order = a.id
			LEFT JOIN request_allocation c ON c.id = a.id_request_allocation
			WHERE c.id_member = '$id_member'
			GROUP BY a.id_request_allocation) c ON c.id = a.id
			WHERE status = 'COS'
			AND id_member = '$id_member'
			AND a.jenis_produk = '$nama_produk'
			AND b.total_quantity_approve <> c.total_quantity_sell
			AND MONTH(a.periode_end) < '$month' AND YEAR(a.periode_end) <= '$year' 
			AND MONTH(a.periode_start) < '$month' AND YEAR(a.periode_start) <= '$year'
		")->row();

		$orderProcess = $this->getOrderProcess($nama_produk);

		$data['title']				= 'Detail Produk Tokoperhutani';
		$data['main_content'] 		= $mainContent;
		$data['nama_produk'] 		= $nama_produk;
		$data['detail_produk'] 		= $detail_produk;
		$data['produk_foto'] 		= $produk_foto;
		$data['orderProcess'] 		= $orderProcess;
		$data['jumlah_cos'] 		= count($checkCOS);
		$data['jumlah_adendum'] 	= count($checkCOSquantity);
		$data['jumlah_waiting'] 	= count($checkWaitingCOS);
		$data['checkKeranjang'] = $checkKeranjang;
	
		$this->load->view('includes/template', $data);
	

	}

	public function insert_produk_show_log(
		$id_member,
		$id_produk
	) {
		$data_log = array(
			'id_produk_kategori' => $id_produk,
			'id_member' => $id_member,
			'created_at' => date('Y-m-d H:i:s'),
		);

		$query2 = $this->db->insert('produk_kategori_show_log', $data_log);
	}

	public function getOrderProcess($nama_produk)
	{
		$currentDate = date('Y-m-d');
		$month = date('m');
		$year = date('Y');
		$id_member = $this->session->userdata('id_member');

		if ($this->session->userdata('level_user') == 'Agent' || $this->session->userdata('level_user') == 'Member') {
			$id = 'a.id_member';
		} else {
			$id = 'a.id_keyaccount';
		}

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
			WHERE DATE(a.tgl_terbit) = '$currentDate'
			GROUP BY c.id_request_allocation) d ON d.id_request_allocation = a.id
			LEFT JOIN member_new e ON e.id_member = a.id_member
			WHERE $id = '$id_member'
			AND a.jenis_produk = '$nama_produk'
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
			WHERE DATE(a.tgl_terbit) = '$currentDate'
			GROUP BY c.id_request_allocation) d ON d.id_request_allocation = a.id
			LEFT JOIN member_new e ON e.id_member = a.id_member
			WHERE $id = '$id_member'
			AND a.status = 'RA'
			AND a.status_document != 'not approve'
			AND a.jenis_produk = '$nama_produk'
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

		// print_r(json_encode($output));
		return ($output);
	}

	public function save_keranjang()
	{
		// $id_produk = $this->input->get('id', TRUE);
		$id_member = $this->session->userdata('id_member');
		$total_quantity = $this->input->post('total_quantity');
		$id_produk = $this->input->post('id_produk');

		$checkKeranjang = $this->db->query("SELECT * FROM keranjang
			WHERE id_member = '$id_member'
			AND id_produk_kategori = '$id_produk'")->result_array();

		if (count($checkKeranjang) > 0) {
			$id_keranjang = $checkKeranjang[0]['id'];
			$quantity_keranjang = $checkKeranjang[0]['total_quantity'];
			$total = $quantity_keranjang + $total_quantity;

			$query2 = $this->db->query(
				"UPDATE keranjang 
				SET total_quantity = '$total'
				WHERE id = '$id_keranjang'"
			);
		} else {
			$data_keranjang = array(
				'id_produk_kategori' => $id_produk,
				'id_member' => $id_member,
				'total_quantity' => $total_quantity,
				'status' => 'uncheckout',
				'created_at' => date('Y-m-d H:i:s'),
			);

			$query2 = $this->db->insert('keranjang', $data_keranjang);
		}

		if ($query2 == "true") {
			$result = array(
				"status"     => "success",
				"value"     => "Berhasil menambah keranjang",
				"message"   => $this->db->error()
			);
		} else {
			$result = array(
				"status"     => "failed",
				"value"     => "Gagal menambah keranjang",
				"message"   => $this->db->error()
			);
		}

		echo json_encode($result);
	}

	public function filterOrderProcess()
	{
		$nama_produk = $this->input->post('produk');
		$id_produk = $this->input->post('id_produk');

		$agent = $this->input->post('agent');
		$agent = implode("','", $agent);

		// $status = $this->input->post('status');

		$tgl = $this->input->post('tanggalRA');

		$status = $this->input->post('status');

		$query = "";
		if ($agent != '') {
			$query .= "AND a.ra_from IN ('" . $agent . "') ";
		}
		if ($tgl  != '') {
			$query .= "AND a.created_at LIKE '" . $tgl . "%'";
		}
		if ($status != '') {
			switch ($status) {
				case 'RA':
					$query .= "AND a.status = 'RA'";
					break;
				case 'COS':
					$query .= "AND a.status = 'COS'";
					break;
				case 'PO':
					$query .= "AND a.status = 'COS'";
					break;
				case 'PI':
					$query .= "AND total_pi > 0";
					break;
				case 'In':
					$query .= "AND total_invoice > 0";
					break;
				default:
					break;
			}
		}
		$month = date('m');
		$year = date('Y');
		$id_member = $this->session->userdata('id_member');

		if ($this->session->userdata('level_user') == 'Agent') {
			$id = 'a.id_member';
		} else {
			$id = 'a.id_keyaccount';
		}

		$orderProcessCOS = $this->db->query("SELECT a.id as id_ra, d.id_shipping_instruction, a.created_at, a.id_member, a.no_cos, a.id_keyaccount, e.nama, a.status as status_ra, a.jenis_produk, a.ra_from, a.status_document as status_document_ra, b.total_po, c.total_pi, d.total_invoice
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
			AND a.jenis_produk = '$nama_produk'
			AND MONTH(periode_start) = '$month'
			AND YEAR(periode_start) = '$year'
			AND MONTH(periode_end) = '$month'
			AND YEAR(periode_end) = '$year'" . $query);

		$orderProcessRA = $this->db->query("SELECT a.id as id_ra, d.id_shipping_instruction, a.created_at, a.id_member, a.no_cos, a.id_keyaccount, e.nama, a.status as status_ra, a.jenis_produk, a.ra_from, a.status_document as status_document_ra, b.total_po, c.total_pi, d.total_invoice
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
			AND a.status_document != 'not approve'
			AND a.jenis_produk = '$nama_produk'
			AND MONTH(created_at) = '$month'
			AND YEAR(created_at) = '$year'" . $query);

		// array_push($output, $orderProcessCOS->result());
		$output = $orderProcessCOS->result_array();
		foreach ($orderProcessRA->result_array() as $key => $result) {
			if (count($orderProcessRA->result_array()) > 0) {
				array_push($output, $result);
			}
		}

		$print = '';
		if (count($output) > 0) {
			foreach ($output as $resultOrder) {
				$print .= '<div class="box bg-gray2 mt-1 mr-1 ml-1">
								<div class="box-header d-flex" style="justify-content: space-between;">
									<h5 class="label-header-2 ml-2 text-grey">' . $resultOrder['no_cos'] . '</h5>
									<h5 class="label-header-2 text-grey text-right">Agent: ' . $resultOrder['nama'] . ' (' . strtoupper($resultOrder['ra_from']) . ')</h5>
								</div>
								<div class="box-body" style="padding: 10px 15px;">';
				if ($resultOrder['status_ra'] == 'RA') {
					$print .= '<ul id="progressbar_3" class="mg-0">
										<li class="active">Request Allocation</li>
										<li>Confirmation of Sales</li>
										<li>Purchase Order</li>
										<li>Performa Invoice</li>
										<li>Invoice</li>
									</ul>';
					if ($resultOrder['status_document_ra'] === 'waiting approval tandon') {
						$print .= '<div class="mt-2 box-notif">
													<p class="font-11 v-middle obj-middle text-center text-notif">Lakukan proses pembayaran uang tandon segera pada page request allocation sebelum menuju tahap selanjutnya</h6>
												</div>
                                                <div class="text-right mt-2">
                                                    <a class="btn btn-green btn-sm" href="' . base_url() . 'stok?id=' . $this->input->get('id', TRUE) . '&id_ra=' . $resultOrder['id_ra'] . '">Bayar Tandon</a>
												</div>';
					} else {
						$print .= '<div class="mt-2 box-notif">
													<p class="font-11 v-middle obj-middle text-notif">Pengajuan Request Allocation menunggu approval perhutani, mohon menunggu beberapa saat.</h6>
												</div>';
					}
				} else if ($resultOrder['status_ra'] == 'COS') {
					$print .= '<ul id="progressbar_3" class="mg-0">
												<li class="active">Request Allocation</li>
												<li class="active">Confirmation of Sales
												</li>
												<li class="active">';
					if ($resultOrder['total_po'] > 0) {
						$print .= '<div style="display: flex; flex-direction:column; align-items:center;">
                                                                    <p>Purchase Order </p>
                                                                    <div class="numbering v-middle">' . $resultOrder['total_po'] . '</div>
                                                                </div>';
					} else {
						$print .= 'Purchase Order';
					}
					$print .= '</li>';
					if ($resultOrder['total_pi'] > 0) {
						$print .= '<li class="active">
														<div style="display: flex; flex-direction:column; align-items:center;">
															<p>Proforma Invoice </p>
															<div class="numbering v-middle">' . $resultOrder['total_pi'] . '</div>
														</div>
													</li>';
					} else {
						$print .= '<li>Proforma Invoice</li>';
					}
					if ($resultOrder['total_invoice'] > 0) {
						$print .= '<li class="active">
														<div style="display: flex; flex-direction:column; align-items:center;">
															<p>Invoice</p>
															<div class="numbering v-middle">' . $resultOrder['total_invoice'] . '</div>
														</div>
													</li>';
					} else {
						$print .= '<li>Invoice</li>';
					}
					$print .= '</ul>';
					if ($resultOrder['total_invoice'] > 0) {
						$print .= '<div class="mt-2 box-notif">
										<p class="font-9 v-middle obj-middle text-notif">Invoice anda sudah terbit, silahkan lakukan pembayaran sesuai waktu yang telah di tentukan</h6>
									</div>
									<div class="text-right mt-2">
									<a class="btn btn-outline-green btn-sm" href="' . base_url() . 'confirmation_of_sales?id=' . $id_produk . '">Confirmation of Sales</a>';
						if ($this->session->userdata('level_user') === 'Key Account') {
							$print .= '<a class="btn btn-outline-green btn-sm" href="' . base_url() . 'purchase_order?id=' . $id_produk . '&asal=' . $resultOrder['ra_from'] . '">Purchase Order</a>';
						} else {
							$print .= '<a class="btn btn-outline-green btn-sm" href="' . base_url() . 'purchase_order?id=' . $id_produk . '">Purchase Order</a>';
						}
						$print .= '<a class="btn btn-outline-green btn-sm" href="' . base_url() . 'proforma_invoice?id=' . $id_produk . '">Proforma Invoice</a>
                                                            <a class="btn btn-green btn-sm" href="' . base_url() . 'invoice?id=' . $resultOrder['id_shipping_instruction'] . '">Invoice</a>
									</div>';
					} else if ($resultOrder['total_pi'] == 0) {
						$print .= '<div class="mt-2 box-notif">
										<p class="font-11 v-middle obj-middle text-notif">Request allocation anda sudah di approve, silahkan ajukan Purchase Order </h6>
									</div>
									<div class="text-right mt-2">
										<a class="btn btn-outline-green btn-sm mr-1" href="' . base_url() . 'confirmation_of_sales?id=' . $id_produk . '">Confirmation of Sales</a>';
						if ($this->session->userdata('level_user') === 'Key Account') {
							$print .= '<a class="btn btn-outline-green btn-sm mr-1" href="' . base_url() . 'purchase_order?id=' . $id_produk . '&asal=' . $resultOrder['ra_from'] . '">Purchase Order</a>';
						} else {
							$print .= '<a class="btn btn-outline-green btn-sm mr-1" href="' . base_url() . 'purchase_order?id=' . $id_produk . '">Purchase Order</a>';
						}
						$print .= '</div>';
					} else if ($resultOrder['total_pi'] > 0) {
						$print .= '<div class="text-right mt-2">
										<a class="btn btn-outline-green btn-sm" href="' . base_url() . 'confirmation_of_sales?id=' . $id_produk . '">Confirmation of Sales</a>';
						if ($this->session->userdata('level_user') === 'Key Account') {
							$print .= '<a class="btn btn-outline-green btn-sm" href="' . base_url() . 'purchase_order?id=' . $id_produk . '&asal=' . $resultOrder['ra_from'] . '">Purchase Order</a>';
						} else {
							$print .= '<a class="btn btn-outline-green btn-sm" href="' . base_url() . 'purchase_order?id=' . $id_produk . '">Purchase Order</a>';
						}
						$print .= '<a class="btn btn-outline-green btn-sm" href="' . base_url() . 'proforma_invoice?id=' . $id_produk . '">Proforma Invoice</a>
								</div>';
					}
				}
				$print .= '</div>
					</div>';
			}
		} else {
			$print .= "<h4 class='mr-1 ml-1'>Data Not Found</h4>";
		}

		echo $print;
		// echo json_encode($dataHistory->num_rows());
	}

	public function sortOrderProcess()
	{
		$nama_produk = $this->input->post('produk');
		$id_produk = $this->input->post('id_produk');

		$sortby = $this->input->post('sortby');
		$query = "";
		if ($sortby != '') {
			if ($sortby === 'last') {
				$query .= "ORDER BY a.created_at DESC";
			} elseif ($sortby === 'first') {
				$query .= "ORDER BY a.created_at ASC";
			}
		}
		$month = date('m');
		$year = date('Y');
		$id_member = $this->session->userdata('id_member');

		if ($this->session->userdata('level_user') == 'Agent') {
			$id = 'a.id_member';
		} else {
			$id = 'a.id_keyaccount';
		}

		$orderProcessCOS = $this->db->query("SELECT a.id as id_ra, d.id_shipping_instruction, a.created_at, a.id_member, a.no_cos, a.id_keyaccount, e.nama, a.status as status_ra, a.jenis_produk, a.ra_from, a.status_document as status_document_ra, b.total_po, c.total_pi, d.total_invoice
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
			AND a.jenis_produk = '$nama_produk'
			AND MONTH(periode_start) = '$month'
			AND YEAR(periode_start) = '$year'
			AND MONTH(periode_end) = '$month'
			AND YEAR(periode_end) = '$year'" . $query);

		$orderProcessRA = $this->db->query("SELECT a.id as id_ra, d.id_shipping_instruction, a.created_at, a.id_member, a.no_cos, a.id_keyaccount, e.nama, a.status as status_ra, a.jenis_produk, a.ra_from, a.status_document as status_document_ra, b.total_po, c.total_pi, d.total_invoice
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
			AND a.status_document != 'not approve'
			AND a.jenis_produk = '$nama_produk'
			AND MONTH(created_at) = '$month'
			AND YEAR(created_at) = '$year'" . $query);

		// array_push($output, $orderProcessCOS->result());
		$output = $orderProcessCOS->result_array();
		foreach ($orderProcessRA->result_array() as $key => $result) {
			if (count($orderProcessRA->result_array()) > 0) {
				array_push($output, $result);
			}
		}

		$print = '';
		if (count($output) > 0) {
			foreach ($output as $resultOrder) {
				$print .= '<div class="box bg-gray2 mt-1 mr-1 ml-1">
								<div class="box-header d-flex" style="justify-content: space-between;">
									<h5 class="label-header-2 ml-2 text-grey">' . $resultOrder['no_cos'] . '</h5>
									<h5 class="label-header-2 text-grey text-right">Agent: ' . $resultOrder['nama'] . ' (' . strtoupper($resultOrder['ra_from']) . ')</h5>
								</div>
								<div class="box-body" style="padding: 10px 15px;">';
				if ($resultOrder['status_ra'] == 'RA') {
					$print .= '<ul id="progressbar_3" class="mg-0">
										<li class="active">Request Allocation</li>
										<li>Confirmation of Sales</li>
										<li>Purchase Order</li>
										<li>Performa Invoice</li>
										<li>Invoice</li>
									</ul>';
					if ($resultOrder['status_document_ra'] === 'waiting approval tandon') {
						$print .= '<div class="mt-2 box-notif">
													<p class="font-11 v-middle obj-middle text-center text-notif">Lakukan proses pembayaran uang tandon segera pada page request allocation sebelum menuju tahap selanjutnya</h6>
												</div>
                                                <div class="text-right mt-2">
                                                    <a class="btn btn-green btn-sm" href="' . base_url() . 'stok?id=' . $this->input->get('id', TRUE) . '&id_ra=' . $resultOrder['id_ra'] . '">Bayar Tandon</a>
												</div>';
					} else {
						$print .= '<div class="mt-2 box-notif">
													<p class="font-11 v-middle obj-middle text-notif">Pengajuan Request Allocation menunggu approval perhutani, mohon menunggu beberapa saat.</h6>
												</div>';
					}
				} else if ($resultOrder['status_ra'] == 'COS') {
					$print .= '<ul id="progressbar_3" class="mg-0">
												<li class="active">Request Allocation</li>
												<li class="active">Confirmation of Sales
												</li>
												<li class="active">';
					if ($resultOrder['total_po'] > 0) {
						$print .= '<div style="display: flex; flex-direction:column; align-items:center;">
                                                                    <p>Purchase Order </p>
                                                                    <div class="numbering v-middle">' . $resultOrder['total_po'] . '</div>
                                                                </div>';
					} else {
						$print .= 'Purchase Order';
					}
					$print .= '</li>';
					if ($resultOrder['total_pi'] > 0) {
						$print .= '<li class="active">
														<div style="display: flex; flex-direction:column; align-items:center;">
															<p>Proforma Invoice </p>
															<div class="numbering v-middle">' . $resultOrder['total_pi'] . '</div>
														</div>
													</li>';
					} else {
						$print .= '<li>Proforma Invoice</li>';
					}
					if ($resultOrder['total_invoice'] > 0) {
						$print .= '<li class="active">
														<div style="display: flex; flex-direction:column; align-items:center;">
															<p>Invoice</p>
															<div class="numbering v-middle">' . $resultOrder['total_invoice'] . '</div>
														</div>
													</li>';
					} else {
						$print .= '<li>Invoice</li>';
					}
					$print .= '</ul>';
					if ($resultOrder['total_invoice'] > 0) {
						$print .= '<div class="mt-2 box-notif">
										<p class="font-9 v-middle obj-middle text-notif">Invoice anda sudah terbit, silahkan lakukan pembayaran sesuai waktu yang telah di tentukan</h6>
									</div>
									<div class="text-right mt-2">
									<a class="btn btn-outline-green btn-sm" href="' . base_url() . 'confirmation_of_sales?id=' . $id_produk . '">Confirmation of Sales</a>';
						if ($this->session->userdata('level_user') === 'Key Account') {
							$print .= '<a class="btn btn-outline-green btn-sm" href="' . base_url() . 'purchase_order?id=' . $id_produk . '&asal=' . $resultOrder['ra_from'] . '">Purchase Order</a>';
						} else {
							$print .= '<a class="btn btn-outline-green btn-sm" href="' . base_url() . 'purchase_order?id=' . $id_produk . '">Purchase Order</a>';
						}
						$print .= '<a class="btn btn-outline-green btn-sm" href="' . base_url() . 'proforma_invoice?id=' . $id_produk . '">Proforma Invoice</a>
                                                            <a class="btn btn-green btn-sm" href="' . base_url() . 'invoice?id=' . $resultOrder['id_shipping_instruction'] . '">Invoice</a>
									</div>';
					} else if ($resultOrder['total_pi'] == 0) {
						$print .= '<div class="mt-2 box-notif">
										<p class="font-11 v-middle obj-middle text-notif">Request allocation anda sudah di approve, silahkan ajukan Purchase Order </h6>
									</div>
									<div class="text-right mt-2">
										<a class="btn btn-outline-green btn-sm mr-1" href="' . base_url() . 'confirmation_of_sales?id=' . $id_produk . '">Confirmation of Sales</a>';
						if ($this->session->userdata('level_user') === 'Key Account') {
							$print .= '<a class="btn btn-outline-green btn-sm mr-1" href="' . base_url() . 'purchase_order?id=' . $id_produk . '&asal=' . $resultOrder['ra_from'] . '">Purchase Order</a>';
						} else {
							$print .= '<a class="btn btn-outline-green btn-sm mr-1" href="' . base_url() . 'purchase_order?id=' . $id_produk . '">Purchase Order</a>';
						}
						$print .= '</div>';
					} else if ($resultOrder['total_pi'] > 0) {
						$print .= '<div class="text-right mt-2">
										<a class="btn btn-outline-green btn-sm" href="' . base_url() . 'confirmation_of_sales?id=' . $id_produk . '">Confirmation of Sales</a>';
						if ($this->session->userdata('level_user') === 'Key Account') {
							$print .= '<a class="btn btn-outline-green btn-sm" href="' . base_url() . 'purchase_order?id=' . $id_produk . '&asal=' . $resultOrder['ra_from'] . '">Purchase Order</a>';
						} else {
							$print .= '<a class="btn btn-outline-green btn-sm" href="' . base_url() . 'purchase_order?id=' . $id_produk . '">Purchase Order</a>';
						}
						$print .= '<a class="btn btn-outline-green btn-sm" href="' . base_url() . 'proforma_invoice?id=' . $id_produk . '">Proforma Invoice</a>
								</div>';
					}
				}
				$print .= '</div>
					</div>';
			}
		} else {
			$print .= "<h4 class='mr-1 ml-1'>Data Not Found</h4>";
		}

		echo $print;
		// echo json_encode($dataHistory->num_rows());
	}

}

<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/SandyShop/core/init.php';

	$data = array('success' => false ,'message'=>array(),'data' =>array());

	$tglawal = $_POST['tglawal'];
	$tglakhir = $_POST['tglakhir'];

	$query = "SELECT 
		a.tgl_order,
		c.nama_lengkap,
		c.Email,
		d.id_produk,
		d.nama_produk,
		SUM(b.jumlah) Qty,
		d.Harga,
		SUM(b.jumlah) * d.Harga Total
	FROM orders a
	LEFT JOIN ordersdetail b on a.id_orders = b.orders_id
	LEFT JOIN pembelian c on a.id_customer = c.id_kustomer
	LEFT JOIN produk d on b.id_produk = d.id_produk
	WHERE a.tgl_order BETWEEN '$tglawal' AND '$tglakhir'
	GROUP BY a.tgl_order,c.nama_lengkap,c.Email,d.id_produk,d.nama_produk,d.Harga";
	$result = $db->query($query);
	$to_encode = array();
	while($row = mysqli_fetch_assoc($result)) {
	  $to_encode[] = $row;
	}

	$data['success'] = true;
    $data['data'] = $to_encode;

    echo json_encode($data);
?>
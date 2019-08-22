<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/SandyShop/core/init.php';
	$id = sanitize($_POST['id']);
	$noresi = sanitize($_POST['noresi']);
	$db->query("UPDATE orders SET status_order = 'Di Kirim', no_resi = '$noresi' WHERE id_orders = '$id'");
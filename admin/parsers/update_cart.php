<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/SandyShop/core/init.php';
	$mode = sanitize($_POST['mode']);
	$edit_size = sanitize($_POST['edit_size']);
	$edit_id = sanitize($_POST['edit_id']);
	$cartQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
	$result = mysqli_fetch_assoc($cartQ);
	$items = json_decode($result['items'],true);
	$updated_items = array();
	$domain = (($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST']:false);
	if ($mode == 'removeone') {
		foreach ($items as $atem) {
			if ($atem['id'] == $edit_id && $atem['size'] == $edit_size) {
				$atem['quantity'] = $atem['quantity'] - 1;
			}
			if ($atem['quantity'] > 0) {
				$updated_items[] = $atem;
			}
		}
	}

	if ($mode == 'addone') {
		foreach ($items as $atem) {
			if ($atem['id'] == $edit_id && $atem['size'] == $edit_size) {
				$atem['quantity'] = $atem['quantity'] + 1;
			}
			$updated_items[] = $atem;
		}
	}

	if (!empty($updated_items)) {
		$json_update = json_encode($updated_items);
		$db->query("UPDATE cart SET items = '{$json_update}' WHERE id = '{$cart_id}'");
		$_SESSION['success_flash'] = 'Keranjang belanja anda sudah di update!';
	}

	if (empty($updated_items)) {
		$db->query("DELETE FROM cart WHERE id = '{$cart_id}'");
		setcookie(CART_COOKIE,'',1,"/",$domain,false);
	}
?>
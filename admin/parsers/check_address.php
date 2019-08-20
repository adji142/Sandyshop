<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/SandyShop/core/init.php';
	$name = sanitize($_POST['full_name']);
	$email = sanitize($_POST['email']);
	$street = sanitize($_POST['street']);
	$street2 = sanitize($_POST['street2']);
	$city = sanitize($_POST['city']);
	$state = sanitize($_POST['state']);
	$zip_code = sanitize($_POST['zip_code']);
	$conutry = sanitize($_POST['country']);
	$errors = array();
	$required = array(
		'full_name' => 'Nama Lengkap',
		'email' 		=> 'Email',
		'street'		=> 'Alamat',
		'city'	  	=> 'Kota',
		'state'			=> 'Provinsi',
		'zip_code'  => 'Kode Pos',
		'country'		=> 'Negara',
		);

	//cek jika semua formulir tidak ada yang diisi
	foreach ($required as $f => $d) {
		if(empty($_POST[$f]) || $_POST[$f] == ''){
			$errors[] = $d.' tidak boleh kosong!.';
		}
	}

	if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
		$errors[] = 'Tolong masukkan email yang valid.';
	}

	if (!empty($errors)) {
		echo display_errors($errors);
	}else{
		echo "OK";
	}
?>
<?php
// session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/SandyShop/core/init.php';
include 'includes/head.php';

$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
$email = trim($email);
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);
$errors = array();
?>
<style type="text/css">
body{
	background-image : url("/SandyShop/images/headerlogo/background.png");
	background-size : 100vw 100vh;
	background-attachment: fixed;
}
</style>

<div id="login-form">
	<div>

		<?php
		if ($_POST) {

			# validasi Form
			if (empty($_POST['email']) || empty($_POST['password'])) {
				$errors[] = 'Kolom email dan password harus diisi';
			}

			# validasi email
			if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
				$errors[] = 'Tolong ketikkan email yang valid';
			}

			#jika password kurang dari 6
			if (strlen($password) < 6) {
				$errors[] = 'Password tidak boleh kurang dari 6 huruf';
			}

			# cek email jika sudah ada didalam database
			$query = $db->query("SELECT * FROM users WHERE email = '$email'");
			$user = mysqli_fetch_assoc($query);
			$hitung = mysqli_num_rows($query);
			if ($hitung < 1) {
				$errors[] = 'Email yang anda masukan salah!';
			}

			if (!password_verify($password,$user['password'])) {
				$errors[] = 'Password yang anda masukan salah!';
			}

			# cek kesalahan
			if (!empty($errors)) {
				echo display_errors($errors);
			}else{
				#jika semua verifikasi sudah dilewati
				$user_id = $user['id'];
				// $user_id = $user['full_name'];
				$permit = $user['permissions'];
				login($user_id);
				$_SESSION['permit'] = $permit;
				$_SESSION['user'] = $user_id;
			}

		}
		?>

	</div>
	<h2 class="text-center">Login</h2>
	<?php
		$passnew = "adji142";
		echo password_hash($passnew,PASSWORD_DEFAULT)
	 ?>
	<form action="login.php" method="post">
		<div class="form-group">
			<input type="text" name="email" class="form-control" id="email" value="<?=$email;?>">
			<label for="email">Email :</label>
		</div>
		<div class="form-group">
			<label for="password">Password : </label>
			<input type="password" name="password" class="form-control" id="password" value="<?=$password?>">
		</div>
		<div class="form-group">
			<input type="submit" class="btn btn-primary" name="name" value="Login">
		</div>
	</form>
	<p class="text-right"><a href="/SandyShop/index.php">Visit Site</a></p>
</div>

<footer class="text-center" id="footeristik">&copy; Copyright 2016 Shauntas's Boutique, Created By : Restu Haerul Z.</footer>

<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/SandyShop/core/init.php';
if(!is_logged_in()){
  login_error_redirect();
}
include 'includes/head.php';

$hashed = $user_data['password'];
$old_password = ((isset($_POST['old_password']))?sanitize($_POST['old_password']):'');
$old_password = trim($old_password);
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);
$confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
$confirm = trim($confirm);
$new_hashed = password_hash($password, PASSWORD_DEFAULT);
$user_id = $user_data['id'];
$errors = array();
?>
<div id="login-form">
	<div>

		<?php
		if ($_POST) {

			# validasi Form
			if (empty($_POST['old_password']) || empty($_POST['password']) || empty($_POST['confirm'])) {
				$errors[] = 'Semua kolom wajib diisi!';
			}

			#jika password kurang dari 6
			if (strlen($password) < 6) {
				$errors[] = 'Password tidak boleh kurang dari 6 huruf';
			}

      #jika password tidak sama dengan konfirmasi password
      if ($password != $confirm) {
        $errors[] = 'Kombinasi Password dengan Konfirmasi Password, Tidak cocok!';
      }

      if (!password_verify($old_password,$hashed)) {
        $erros[] = 'Password lama anda tidak ada di dalam database!';
      }

			# cek kesalahan
			if (!empty($errors)) {
				echo display_errors($errors);
			}else{
				#jika semua verifikasi sudah dilewati, maka password akan diganti
        $db->query("UPDATE users SET password = '$new_hashed' WHERE id = '$user_id'");
        $_SESSION['success_flash'] = 'Password berhasil diganti.';
        header('Location: index.php');
			}

		}
    ?>

	</div>

	<h2 class="text-center">Ganti Password</h2>
	<form action="change_password.php" method="post">
		<div class="form-group">
			<label for="old_password">Password Lama :</label>
			<input type="password" name="old_password" class="form-control" id="old_password" value="<?=$old_password;?>">
		</div>
		<div class="form-group">
			<label for="password">Password Baru :</label>
			<input type="password" name="password" class="form-control" id="password" value="<?=$password?>">
		</div>
    <div class="form-group">
			<label for="confirm">Konfirmasi Password:</label>
			<input type="password" name="confirm" class="form-control" id="confirm" value="<?=$confirm?>">
		</div>
		<div class="form-group">
      <a href="index.php" class="btn btn-default">Cancel</a>
			<input type="submit" class="btn btn-primary" name="name" value="Change">
		</div>
	</form>
</div>

<?php include 'includes/footer.php'; ?>

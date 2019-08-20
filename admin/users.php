<?php
  require_once '../core/init.php';
  if(!is_logged_in()){
   login_error_redirect();
  }
  if (!has_permissions()) {
   permission_error_redirect('index.php');
  }
  include 'includes/head.php';
  include 'includes/navigation.php';
  if (isset($_GET['delete'])) {
    $delID = sanitize($_GET['delete']);
    $db->query("DELETE FROM users WHERE id = '$delID'");
    $_SESSION['success_flash'] = 'User berhasil dihapus';
    header('Location: users.php');
  }
  if (isset($_GET['add'])) {
    $name = ((isset($_POST['name']))?sanitize($_POST['name']):'');
    $email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
    $password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
    $confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
    $permissions = ((isset($_POST['permissions']))?sanitize($_POST['permissions']):'');
    $errors = array();
    if ($_POST) {
      $emailQuery = $db->query("SELECT * FROM users WHERE email = '$email'");
      $hitung = mysqli_num_rows($emailQuery);

      if ($hitung != 0) {
        $errors[] = 'Email ini sudah ada didalam database, Tolong masukkan email yang lain!';
      }

      $required = array('name', 'email', 'password', 'confirm', 'permissions');
      foreach ($required as $f) {
        if (empty($_POST[$f])) {
          $errors[] = 'Kolom tidak boleh ada yang kosong 1 pun!!!';
          break;
        }
      }

      if (strlen($password) < 6) {
        $errors[] = 'Password tidak boleh kurang dari 6 huruf!';
      }

      if ($password != $confirm) {
        $errors[] = 'Kombinasi password dan konfirmasi password, Tidak cocok!';
      }

      if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Tolong masukkan email yang valid';
      }

      if (!empty($errors)) {
        echo display_errors($errors);
      }else{
        //Jika validasi sudah terlewati semua, maka user akan ditambahkan ke dalam database
        $hashed = password_hash($password,PASSWORD_DEFAULT);
        
        $db->query("INSERT INTO users (full_name,email,password,permissions) VALUES ('$name','$email','$hashed','$permissions')");
        $_SESSION['success_flash'] = 'Users berhasil ditambahkan!';
        header('Location: users.php');
      }
    }
?>
<div class="container">
  <h2 class="text-center">Tambah Users</h2><hr>
  <form action="users.php?add=1" method="post">
    <div class="form-group col-md-6">
      <label for="nama">Nama Lengkap:</label>
      <input type="text" name="name" id="name" class="form-control" value="<?=$name;?>">
    </div>
    <div class="form-group col-md-6">
      <label for="email">Email:</label>
      <input type="text" name="email" id="email" class="form-control" value="<?=$email;?>">
    </div>
    <div class="form-group col-md-6">
      <label for="password">Password:</label>
      <input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
    </div>
    <div class="form-group col-md-6">
      <label for="confirm">Konfirmasi Password:</label>
      <input type="password" name="confirm" id="confirm" class="form-control" value="<?=$confirm;?>">
    </div>
    <div class="form-group col-md-6">
      <label for="permission">Permissions:</label>
      <select class="form-control" name="permissions">
        <option value=""<?=(($permissions == '')?' selected':'');?>></option>
        <option value="editor"<?=(($permissions == 'editor')?' selected':'');?>>Editor</option>
        <option value="admin,editor"<?=(($permissions == 'admin,editor')?' selected':'');?>>Admin</option>
      </select>
    </div>
    <div class="form-group pull-right" style="margin-top: 25px;">
      <a href="users.php" class="btn btn-default">Cancel</a>
      <input type="submit" class="btn btn-primary" value="Tambah User">
    </div>
  </form>
</div>
<?php
  }else{
  $userQuery = $db->query("SELECT * FROM users ORDER BY full_name");
?>

<div class="container">
  <h2 class="text-center">Users</h2>
  <a href="users.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Tambah Users Baru</a>
  <hr>
  <table class="table table-bordered table-striped table-condensed">
    <thead><th></th><th>Nama</th><th>Email</th><th>Bergabung Tanggal</th><th>Terakhir Login</th><th>Hak Akses</th></thead>
    <tbody>
      <?php foreach($userQuery as $user) : ?>
      <tr>
        <td>
          <?php
          if ($user['id'] != $user_data['id']):
          	if (!has_permissions()) {
							   permission_error_redirect('index.php');
							  }
          ?>
            <a href="users.php?delete=<?=$user['id'];?>" class="btn btn-default btn-xs" onclick="return confirm('Yakin akan menghapus user ini!');">
              <span class="glyphicon glyphicon-remove-sign"></span>
            </a>
          <?php endif; ?>
        </td>
        <td><?=$user['full_name'];?></td>
        <td><?=$user['email'];?></td>
        <td><?=indonesian_date($user['join_date']);?></td>
        <td><?=(($user['last_login'] == '0000-00-00 00:00:00')?' Users ini belum pernah login':indonesian_date($user['last_login']));?></td>
        <td><?=$user['permissions'];?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php } include 'includes/footer.php'; ?>

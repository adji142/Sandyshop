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
    $db->query("DELETE FROM Supplier WHERE id_supplier = '$delID'");
    $_SESSION['success_flash'] = 'Supplier berhasil dihapus';
    header('Location: Supplier.php');
  }
  if (isset($_GET['add'])) {
    $kodesup = ((isset($_POST['kodesup']))?sanitize($_POST['kodesup']):'SP'.rand());
    $namasub = ((isset($_POST['namasub']))?sanitize($_POST['namasub']):'');
    $alamatsub = ((isset($_POST['alamatsub']))?sanitize($_POST['alamatsub']):'');
    $tlpsub = ((isset($_POST['tlpsub']))?sanitize($_POST['tlpsub']):'');
    $ketsub = ((isset($_POST['ketsub']))?sanitize($_POST['ketsub']):'');
    $tgl_masuk = ((isset($_POST['tgl_masuk']))?sanitize($_POST['tgl_masuk']):'');
    $errors = array();
    if ($_POST) {
      $emailQuery = $db->query("SELECT * FROM Supplier WHERE id_supplier = '$kodesup'");
      $hitung = mysqli_num_rows($emailQuery);

      if ($hitung != 0) {
        $errors[] = 'Kode Supplier ini sudah ada didalam database, Tolong masukkan Kode Supplier yang lain!';
      }

      $required = array('kodesup', 'namasub', 'alamatsub', 'tlpsub', 'ketsub','tgl_masuk');
      foreach ($required as $f) {
        if (empty($_POST[$f])) {
          $errors[] = 'Kolom tidak boleh ada yang kosong 1 pun!!!';
          break;
        }
      }

      if (!empty($errors)) {
        echo display_errors($errors);
      }else{
        //Jika validasi sudah terlewati semua, maka user akan ditambahkan ke dalam database
        
        $db->query("INSERT INTO Supplier VALUES ('$kodesup','$namasub','$alamatsub','$tlpsub','$ketsub','$tgl_masuk')");
        $_SESSION['success_flash'] = 'Users berhasil ditambahkan!';
        header('Location: Supplier.php');
      }
    }
?>
<div class="container">
  <h2 class="text-center">Tambah Supplier</h2><hr>
  <form action="Supplier.php?add=1" method="post">
    <div class="form-group col-md-6">
      <label for="nama">Kode Supplier:</label>
      <input type="text" name="kodesup" id="kodesup" class="form-control" value="<?=$kodesup;?>" readonly>
    </div>
    <div class="form-group col-md-6">
      <label for="email">Nama Supplier:</label>
      <input type="text" name="namasub" id="namasub" class="form-control" value="<?=$namasub;?>">
    </div>
    <div class="form-group col-md-6">
      <label for="password">Alamat Supplier</label>
      <input type="text" name="alamatsub" id="alamatsub" class="form-control" value="<?=$alamatsub;?>">
    </div>
    <div class="form-group col-md-6">
      <label for="confirm">Telepon Supplier:</label>
      <input type="text" name="tlpsub" id="tlpsub" class="form-control" value="<?=$tlpsub;?>">
    </div>
    <div class="form-group col-md-6">
      <label for="confirm">Keterangan:</label>
      <input type="text" name="ketsub" id="ketsub" class="form-control" value="<?=$ketsub;?>">
    </div>
    <div class="form-group col-md-6">
      <label for="confirm">Tanggal Masuk:</label>
      <input type="date" name="tgl_masuk" id="tgl_masuk" class="form-control" value="<?=$tgl_masuk;?>">
    </div>
    <div class="form-group pull-right" style="margin-top: 25px;">
      <a href="users.php" class="btn btn-default">Cancel</a>
      <input type="submit" class="btn btn-primary" value="Tambah User">
    </div>
  </form>
</div>
<?php
  }else{
  $userQuery = $db->query("SELECT * FROM Supplier ORDER BY id_supplier");
?>

<div class="container">
  <h2 class="text-center">Supplier</h2>
  <a href="Supplier.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Tambah Supplier Baru</a>
  <hr>
  <table class="table table-bordered table-striped table-condensed">
    <thead><th></th><th>Kode Supplier</th><th>Nama Supplier</th><th>Alamat Supplier</th><th>Telepon Supplier</th><th>Keterangan</th></thead>
    <tbody>
      <?php foreach($userQuery as $user) : ?>
      <tr>
        <td>
          <?php
          	if (!has_permissions()) {
							   permission_error_redirect('index.php');
							  }
          ?>
            <a href="Supplier.php?delete=<?=$user['id_supplier'];?>" class="btn btn-default btn-xs" onclick="return confirm('Yakin akan menghapus Supplier ini!');">
              <span class="glyphicon glyphicon-remove-sign"></span>
            </a>
        </td>
        <td><?=$user['id_supplier'];?></td>
        <td><?=$user['supplier'];?></td>
        <td><?=$user['alamat'];?></td>
        <td><?=$user['telepon'];?></td>
        <td><?=$user['keterangan'];?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php } include 'includes/footer.php'; ?>
<script type="text/javascript">
  $(document).ready(function () {
      document.title = "Supplier";
    });
</script>
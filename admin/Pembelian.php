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

  $brandQ = $db->query("SELECT * FROM products ORDER BY id");
  if (isset($_GET['delete'])) {
    $delID = sanitize($_GET['delete']);
    $db->query("DELETE FROM pembelian WHERE id = '$delID'");
    $_SESSION['success_flash'] = 'Pembelian berhasil dihapus';
    header('Location: Pembelian.php');
  }
  if (isset($_GET['add'])) {
    $nonota = ((isset($_POST['nonota']))?sanitize($_POST['nonota']):'NT'.rand());
    $tglnota = ((isset($_POST['tglnota']))?sanitize($_POST['tglnota']):'');
    $idproduct = ((isset($_POST['idproduct']))?sanitize($_POST['idproduct']):'');
    $qty = ((isset($_POST['qty']))?sanitize($_POST['qty']):'');
    $errors = array();
    if ($_POST) {
      $emailQuery = $db->query("SELECT * FROM Pembelian WHERE nonota = '$nonota'");
      $hitung = mysqli_num_rows($emailQuery);

      if ($hitung != 0) {
        $errors[] = 'No NOta ini sudah ada didalam database, Tolong masukkan No NOta yang lain!';
      }

      $required = array('nonota', 'tglnota', 'idproduct', 'qty');
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
        
        $db->query("INSERT INTO Pembelian VALUES ('$nonota','$tglnota',$idproduct,$qty)");
        $_SESSION['success_flash'] = 'Users berhasil ditambahkan!';
        header('Location: Pembelian.php');
      }
    }
?>
<div class="container">
  <h2 class="text-center">Tambah Supplier</h2><hr>
  <form action="Supplier.php?add=1" method="post">
    <div class="form-group col-md-6">
      <label for="nama">Nomer Nota:</label>
      <input type="text" name="nonota" id="nonota" class="form-control" value="<?=$nonota;?>" readonly>
    </div>
    <div class="form-group col-md-6">
      <label for="email">Tanggal Nota:</label>
      <input type="date" name="tglnota" id="tglnota" class="form-control" value="<?=$tglnota;?>">
    </div>
    <div class="form-group col-md-3">
      <label for="brand">Product :*</label>
      <select class="form-control" name="idproduct" id="idproduct">
        <option value=""<?=(($idproduct == '')?' selected':'');?>></option>
        <?php foreach ($brandQ as $b) : ?>
          <option value="<?=$b['id'];?>"<?=(($idproduct == $b['id'])?' selected':'');?>>
            <?=$b['title'];?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group col-md-6">
      <label for="email">Jumlah:</label>
      <input type="number" name="qty" id="qty" class="form-control" value="<?=$qty;?>">
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
  <h2 class="text-center">Users</h2>
  <a href="Pembelian.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Tambah Pembelian Baru</a>
  <hr>
  <table class="table table-bordered table-striped table-condensed">
    <thead><th></th><th>No Nota</th><th>Tanggal Nota</th><th>Supplier</th><th>Kode Product</th><th>Nama Product</th><th>Qty</th></thead>
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

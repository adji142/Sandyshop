<?php
  require_once '../core/init.php';
  if(!is_logged_in()){
    login_error_redirect();
  }
  include 'includes/head.php';
  include 'includes/navigation.php';
  //Ambil brands dari database
  $sql = "SELECT * FROM kota ORDER BY nama_kota";
  $result = $db->query($sql);
  $errors = array();

  //Edit brand
  if (isset($_GET['edit']) && !empty($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $edit_id = sanitize($edit_id);
    $sql2 = "SELECT * FROM kota WHERE id_kota = '$edit_id'";
    $er = $db->query($sql2);
    $ekota = mysqli_fetch_assoc($er);
  }

  //Hapus brand
  if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_id = sanitize($delete_id);
    $sql = "DELETE FROM kota WHERE id_kota = '$delete_id'";
    $db->query($sql);
    header('Location: kota.php');
  }

  //jika tambah form adalah submit
  if (isset($_POST['add_submit'])) {
    $kota = sanitize($_POST['kota']);
    $ongkir = sanitize($_POST['ongkir']);
    //cek jika brand kosong
    if ($_POST['kota'] == null || $_POST['ongkir'] == null) {
      $errors[] .= 'Inputan tidak boleh kosong!';
     }
     // cek jika brand sudah ada di database
     $sql = "SELECT * FROM kota WHERE nama_kota = '$kota'";
     if (isset($_GET['edit'])) {
       $sql = "SELECT * FROM kota WHERE nama_kota = '$kota' AND id_kota != '$edit_id'";
     }
     $rezult = $db->query($sql);
     $count = mysqli_num_rows($rezult);
     if ($count > 0) {
       $errors[] .= 'kota dengan nama <b>'.$kota.'</b> sudah ada di dalam database';
     }

    //display errors
    if(!empty($errors)){
      echo display_errors($errors);
    }else{
      //tambah brand ke database
      $sql = "INSERT INTO kota (nama_kota,ongkos_kirim) VALUES ('$kota',$ongkir)";
      if (isset($_GET['edit'])) {
        $sql = "UPDATE kota SET nama_kota = '$kota',ongkos_kirim = '$ongkir' WHERE id_kota = '$edit_id'";
      }
      $db->query($sql);
      header('Location: Kota.php');
    }
  }
?>

<style type="text/css">
  .table-auto{
    width: auto;
    margin: 0 auto;
  }
</style>

<div class="container">
  <h2 class="text-center">Kota</h2><hr>
  <!-- Form Brand -->
  <div class="text-center">
    <form class="form-inline" action="Kota.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:'');?>" method="post">
      <div class="fom-group">
        <?php
        $kota_value = '';
        $ongkir_value = '';
        if (isset($_GET['edit'])) {
          $kota_value = $ekota['nama_kota'];
          $ongkir_value = $ekota['ongkos_kirim'];
        }else{
          if (isset($_POST['kota'])) {
            $kota_value = sanitize($_POST['kota']);
            $ongkir_value = sanitize($_POST['ongkir']);
          }
        }
        ?>
        <label for="brand"><?=((isset($_GET['edit']))?'Edit':'Tambah');?> Kota</label>
        <input type="text" name="kota" id="kota" class="form-control" value="<?=$kota_value;?>">
        <label for="brand"><?=((isset($_GET['edit']))?'Edit':'Tambah');?> ongkir</label>
        <input type="number" name="ongkir" id="ongkir" class="form-control" value="<?=$ongkir_value;?>">
        <?php if(isset($_GET['edit'])) : ?>
          <a href="brands.php" class="btn btn-default">Cancel</a>
        <?php endif; ?>
        <input type="submit" name="add_submit" value="<?=((isset($_GET['edit']))?'Edit':'Tambah');?> Kota" class="btn btn-success">
      </div>
    </form>
  </div>
  <hr>
  <table class="table table-bordered table-striped table-auto table-condensed">
      <thead>
        <th></th>
        <th>Kota</th>
        <th>Ongkos Kirim</th>
        <th></th>
      </thead>
      <tbody>
      <?php foreach ($result as $ambil) : ?>
        <tr>
          <td><a href="Kota.php?edit=<?=$ambil['id_kota'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a></td>
          <td><?=$ambil['nama_kota'];?></td>
          <td><?=$ambil['ongkos_kirim'];?></td>
          <td><a href="Kota.php?delete=<?=$ambil['id_kota'];?>" class="btn btn-xs btn-default" onclick="return confirm('Yakin akan menghapus data ini');">
              <span class="glyphicon glyphicon-remove-sign"></span></a>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
  </table>
</div>
<?php include 'includes/footer.php'; ?>

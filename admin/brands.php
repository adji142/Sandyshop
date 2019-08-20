<?php
  require_once '../core/init.php';
  if(!is_logged_in()){
    login_error_redirect();
  }
  include 'includes/head.php';
  include 'includes/navigation.php';
  //Ambil brands dari database
  $sql = "SELECT * FROM brand ORDER BY brand";
  $result = $db->query($sql);
  $errors = array();

  //Edit brand
  if (isset($_GET['edit']) && !empty($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $edit_id = sanitize($edit_id);
    $sql2 = "SELECT * FROM brand WHERE id = '$edit_id'";
    $er = $db->query($sql2);
    $eBrand = mysqli_fetch_assoc($er);
  }

  //Hapus brand
  if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_id = sanitize($delete_id);
    $sql = "DELETE FROM brand WHERE id = '$delete_id'";
    $db->query($sql);
    header('Location: brands.php');
  }

  //jika tambah form adalah submit
  if (isset($_POST['add_submit'])) {
    $brand = sanitize($_POST['brand']);
    //cek jika brand kosong
    if ($_POST['brand'] == null) {
      $errors[] .= 'Inputan tidak boleh kosong!';
     }
     // cek jika brand sudah ada di database
     $sql = "SELECT * FROM brand WHERE brand = '$brand'";
     if (isset($_GET['edit'])) {
       $sql = "SELECT * FROM brand WHERE brand = '$brand' AND id != '$edit_id'";
     }
     $rezult = $db->query($sql);
     $count = mysqli_num_rows($rezult);
     if ($count > 0) {
       $errors[] .= 'Brand dengan nama <b>'.$brand.'</b> sudah ada di dalam database';
     }

    //display errors
    if(!empty($errors)){
      echo display_errors($errors);
    }else{
      //tambah brand ke database
      $sql = "INSERT INTO brand (brand) VALUES ('$brand')";
      if (isset($_GET['edit'])) {
        $sql = "UPDATE brand SET brand = '$brand' WHERE id = '$edit_id'";
      }
      $db->query($sql);
      header('Location: brands.php');
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
  <h2 class="text-center">Brands</h2><hr>
  <!-- Form Brand -->
  <div class="text-center">
    <form class="form-inline" action="brands.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:'');?>" method="post">
      <div class="fom-group">
        <?php
        $brand_value = '';
        if (isset($_GET['edit'])) {
          $brand_value = $eBrand['brand'];
        }else{
          if (isset($_POST['brand'])) {
            $brand_value = sanitize($_POST['brand']);
          }
        }
        ?>
        <label for="brand"><?=((isset($_GET['edit']))?'Edit':'Tambah');?> Brand</label>
        <input type="text" name="brand" id="brand" class="form-control" value="<?=$brand_value;?>">
        <?php if(isset($_GET['edit'])) : ?>
          <a href="brands.php" class="btn btn-default">Cancel</a>
        <?php endif; ?>
        <input type="submit" name="add_submit" value="<?=((isset($_GET['edit']))?'Edit':'Tambah');?> Brand" class="btn btn-success">
      </div>
    </form>
  </div>
  <hr>
  <table class="table table-bordered table-striped table-auto table-condensed">
      <thead>
        <th></th>
        <th>Brands</th>
        <th></th>
      </thead>
      <tbody>
      <?php foreach ($result as $ambil) : ?>
        <tr>
          <td><a href="brands.php?edit=<?=$ambil['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a></td>
          <td><?=$ambil['brand'];?></td>
          <td><a href="brands.php?delete=<?=$ambil['id'];?>" class="btn btn-xs btn-default" onclick="return confirm('Yakin akan menghapus data ini');">
              <span class="glyphicon glyphicon-remove-sign"></span></a>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
  </table>
</div>
<?php include 'includes/footer.php'; ?>

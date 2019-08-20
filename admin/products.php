<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/SandyShop/core/init.php';
if(!is_logged_in()){
  login_error_redirect();
}
include 'includes/head.php';
include 'includes/navigation.php';

if (isset($_GET['delete'])) {
  $delID = $_GET['delete'];
  $delID = sanitize($delID);
  $delSql = "UPDATE produk SET deleted = 1 WHERE id_produk = '$delID'";
  $db->query($delSql);
  header('Location: products.php');
}

$dbpath = '';
if (isset($_GET['add']) || isset($_GET['edit'])) {
  $parentQ = $db->query("SELECT * FROM Kategori WHERE parent = 0 ORDER BY Nama_kategori");
  $SupplierQ = $db->query("SELECT * FROM supplier ");
  $kdprod = ((isset($_POST['kdprod']) && $_POST['kdprod'] != '')?sanitize($_POST['kdprod']):'');
  $title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):'');
  $parent = ((isset($_POST['parent']) && !empty($_POST['parent']))?sanitize($_POST['parent']):'');
  $category = ((isset($_POST['child']) && !empty($_POST['child']))?sanitize($_POST['child']):'');
  $price = ((isset($_POST['price']) && $_POST['price'] != '')?sanitize($_POST['price']):'');
  $price = preg_replace("/[^0-9]/", "", $price);
  $Qty = ((isset($_POST['Qty']) && $_POST['Qty'] != '')?sanitize($_POST['Qty']):'');
  $Berat = ((isset($_POST['Berat']) && $_POST['Berat'] != '')?sanitize($_POST['Berat']):'');
  $sup = ((isset($_POST['sup']) && $_POST['sup'] != '')?sanitize($_POST['sup']):'');
  $description = ((isset($_POST['description']))?sanitize($_POST['description']):'');
  $disc = ((isset($_POST['disc']))?sanitize($_POST['disc']):'');
  $saved_image = '';

  if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $edit_id = sanitize($edit_id);
    $productresults = $db->query("SELECT * FROM produk WHERE id_produk = '$edit_id'");
    $products = mysqli_fetch_assoc($productresults);
    if (isset($_GET['delete_image'])) {
      $imgi = (int)$_GET['imgi'] - 1;
      $images = explode(',',$products['gambar']);
      $image_url = $_SERVER['DOCUMENT_ROOT'].$images[$imgi];
      unlink($image_url);
      unset($images[$imgi]);
      $imageString = implode(',',$images);
      $db->query("UPDATE products SET gambar = '{$imageString}' WHERE id_produk = '{$edit_id}'");
      header('Location: products.php?edit='.$edit_id);
    }
    $category = ((isset($_POST['child']) && !empty($_POST['child']))?sanitize($_POST['child']):$products['id_kategori']);
    $kdprod = ((isset($_POST['kdprod']) && $_POST['kdprod'] != '')?sanitize($_POST['kdprod']):$products['id_produk']);
    $title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):$products['nama_produk']);
    $parentResult = $db->query("SELECT * FROM Kategori WHERE id_kategori = '$category'");
    $pQ = mysqli_fetch_assoc($parentResult);
    $parent = ((isset($_POST['parent']) && !empty($_POST['parent']))?sanitize($_POST['parent']):$pQ['parent']);
    $price = ((isset($_POST['price']) && $_POST['price'] != '')?sanitize($_POST['price']):$products['Harga']);
    $Qty = ((isset($_POST['Qty']) && $_POST['Qty'] != '')?sanitize($_POST['Qty']):(int)$products['Stok']);
    $Berat = ((isset($_POST['Berat']) && $_POST['Berat'] != '')?sanitize($_POST['Berat']):(int)$products['Berat']);
    $sup = ((isset($_POST['sup']) && $_POST['sup'] != '')?sanitize($_POST['sup']):$products['supplier']);
    $description = ((isset($_POST['description']))?sanitize($_POST['description']):$products['deskripsi']);
    $disc = ((isset($_POST['disc']))?sanitize($_POST['disc']):$products['Diskon']);
    $saved_image = (($products['gambar'] != '')?$products['gambar']:'');
    $dbpath = $saved_image;
  }

  if (!empty($sizes)) {
    $sizeString = sanitize($sizes);
    $sizeString = rtrim($sizeString,',');
    $sizesArray = explode(',',$sizeString);
    $sArray = array();
    $qArray = array();
    $tArray = array();
    foreach ($sizesArray as $ss) {
      $s = explode(':',$ss);
      $sArray[] = $s[0];
      $qArray[] = $s[1];
      $tArray[] = $s[2];
    }
  }else{
    $sizesArray = array();
  }

  if ($_POST) {
    $errors = array();
    $required = array('title', 'parent', 'child', 'price','Qty');
    $allowed = array('png','jpg','jpeg','gif');
    $photoName = array();
    $uploadPath = array();
    $tmpLoc = array();
    foreach ($required as $field) {
      if ($_POST[$field] == '') {
        $errors[] = 'Form tidak boleh ada yang kosong!';
        break;
      }
    }
    // var_dump($_FILES['photo']);
    $photoCount = count($_FILES['photo']['name']);
      if ($photoCount > 0) {
        for ($i=0; $i < $photoCount; $i++) { echo $i;
          $name = $_FILES['photo']['name'][$i];
          $nameArray = explode('.',$name);
          $fileName = $nameArray[0];
          $fileExt = $nameArray[1];
          $mime = explode('/',$_FILES['photo']['type'][$i]);
          $mimeType = $mime[0];
          $mimeExt = $mime[1];
          $tmpLoc[] = $_FILES['photo']['tmp_name'][$i];
          $fileSize = $_FILES['photo']['size'][$i];
          $uploadName = md5(microtime().$i).'.'.$fileExt;
          $uploadPath[] = BASEURL.'images/products'.$uploadName;
          if ($i != 0) {
            $dbpath .= ',';
          }
          $dbpath .= '/SandyShop/images/products'.$uploadName;
          if ($mimeType != 'image') {
            $errors[] = 'File harus berupa gambar';
          }
          if (!in_array($fileExt, $allowed)) {
            $errors[] = 'Gambar harus berekstensi png, jpg, jpeg atau gif';
          }
          if ($fileSize > 15000000) {
            $errors[] = 'Ukuran file tidak boleh lebih dari 15MB.';
          }
          if ($fileExt != $mimeExt && ($mimeExt == 'jpeg' && $fileExt != 'jpg')) {
            $errors[] = 'Errors 404 ! Ulangi upload dengan benar';
      }
    }
  }

    if (!empty($errors)) {
      echo display_errors($errors);
    }else{
      if($photoCount > 0){
        //Upload file dan tambah ke dalam database
        for ($i=0; $i < $photoCount; $i++) {
          move_uploaded_file($tmpLoc[$i], $uploadPath[$i]);
        }
      }

      // echo "masuk insert";
      $insertSql = "INSERT INTO produk (id_produk, id_kategori, nama_produk, deskripsi, Harga, Stok, Berat, gambar,supplier,Diskon,deleted)
      VALUES ('$kdprod', '$category','$title','$description','$price','$Qty','$Berat','$dbpath','$sup','$disc',0)";
      if (isset($_GET['edit'])) {
        $insertSql = "UPDATE produk SET nama_produk = '$title', Harga = '$price', Diskon = '$disc',
         id_kategori = '$category', gambar = '$dbpath', deskripsi = '$description'
        WHERE id_produk = '$edit_id'";
        var_dump($insertSql);
      }
      try {
        $db->query($insertSql); 
      } catch (Exception $e) {
        // print_r('err'.$e->getMessage());
      }
      header('Location: products.php');
    }
  }
  ?>

  <div class="container">
    <h2 class="text-center"><?=((isset($_GET['edit']))?'Edit ':'');?>Products</h2><hr>
    <form action="products.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1');?>" method="post" enctype="multipart/form-data">
      <div class="form-group col-md-3">
        <label for="title">Kode Product*:</label>
        <input type="text" name="kdprod" class="form-control" id="kdprod" value="<?=$kdprod;?>" required>
      </div>
      <div class="form-group col-md-3">
        <label for="title">Nama Produk*:</label>
        <input type="text" name="title" class="form-control" id="title" value="<?=$title;?>">
      </div>
      <div class="form-group col-md-3">
        <label for="parent">Parent Category*:</label>
        <select class="form-control" id="parent" name="parent">
          <option value=""<?=(($parent == '')?' selected':'');?>></option>
          <?php foreach ($parentQ as $p) : ?>
            <option value="<?=$p['id_kategori'];?>"<?=(($parent == $p['id_kategori'])?' selected':'');?>><?=$p['Nama_kategori'];?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group col-md-3">
        <label for="child">Child Category*:</label>
        <select class="form-control" id="child" name="child">
        </select>
      </div>
      <div class="form-group col-md-3">
        <label for="price">Price*:</label>
        <input type="text" id="price" name="price" class="form-control" value="<?=((isset($_GET['edit']))?$price:'');?>">
      </div>
      <div class="form-group col-md-3">
        <label for="disc">Diskon (Rp)*:</label>
        <input type="text" id="disc" name="disc" class="form-control" value="<?=((isset($_GET['edit']))?$disc:'');?>">
      </div>
      <div class="form-group col-md-3">
        <label>Quantity*:</label>
        <input type="number" id="Qty" name="Qty" class="form-control" value="<?=((isset($_GET['edit']))?$Qty:'');?>">
      </div>
      <div class="form-group col-md-3">
        <label>Berat*:</label>
        <input type="number" id="Berat" name="Berat" class="form-control" value="<?=((isset($_GET['edit']))?$Berat:'');?>">
      </div>
      <div class="form-group col-md-3">
        <label for="child">Supplier *:</label>
        <select class="form-control" id="sup" name="sup">
          <option value=""<?=(($sup == '')?' selected':'');?>></option>
          <?php foreach ($SupplierQ as $p) : ?>
            <option value="<?=$p['id_supplier'];?>"<?=(($sup == $p['id_supplier'])?' selected':'');?>><?=$p['supplier'];?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group col-md-6">
        <?php if($saved_image != '') : ?>
          <?php
            $imgi = 1;
            $images = explode(',',$saved_image);
          ?>
          <?php foreach($images as $image): ?>
          <div class="saved-image col-md-4">
            <img src="<?=$image;?>" alt="saved image"><br>
            <a href="products.php?delete_image=1&edit=<?=$edit_id;?>&imgi=<?=$imgi;?>" class="btn btn-xs btn-danger">Delete Image</a>
          </div>
          <?php
          $imgi++;
          endforeach; ?>
        <?php else: ?>
          <label for="photo">Products Photo*:</label>
          <input type="file" name="photo[]" id="photo" class="form-control" multiple>
        <?php endif; ?>
      </div>
      <div class="form-group col-md-6">
        <label for="description">Description*:</label>
        <textarea name="description" class="form-control" id="description" rows="6"><?=$description;?></textarea>
      </div>
      <div class="form-group pull-right" style="margin-right: 14px;">
        <a href="products.php" class="btn btn-default">Cancel</a>
        <input type="submit" class="btn btn-success" value="<?=((isset($_GET['edit']))?'Edit':'');?> Product">
      </div><div class="clearfix"></div>
    </form>
  </div>
  <?php
}else{
  $sql = "SELECT * FROM produk WHERE deleted = 0";
  $presult = $db->query($sql);
  if (isset($_GET['featured'])) {
    $id = $_GET['id'];
    $featured = (int)$_GET['featured'];
    $fsql = "UPDATE produk SET featured = '$featured' WHERE id_produk = '$id'";
    $db->query($fsql);
    header('Location: products.php');
  }
  ?>
  <div class="container">
    <h2 class="text-center">Products</h2>
    <a href="products.php?add=1" class="btn btn-success pull-right" style="margin-top: -35px;">Tambah Produk</a><div class="clearfix"></div>
    <hr>
    <table class="table table-bordered table-condensed table-striped">
      <thead>
        <th></th><th>Produk</th><th>Harga</th><th>Kategori</th><th>Fitur</th><th>Terjual</th>
      </thead>
      <tbody>
        <?php foreach ($presult as $produk) :
          $childID = $produk['id_kategori'];
          $catSql = "SELECT * FROM Kategori WHERE id_kategori = '$childID'";
          $result = $db->query($catSql);
          $child = mysqli_fetch_assoc($result);
          $parentID = $child['parent'];
          $pSql = "SELECT * FROM Kategori WHERE id_kategori = '$parentID'";
          $presult = $db->query($pSql);
          $parent = mysqli_fetch_assoc($presult);
          $category = $parent['Nama_kategori'].'->'.$child['Nama_kategori'];
          ?>
          <tr>
            <td>
              <a href="products.php?edit=<?=$produk['id_produk'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
              <a href="products.php?delete=<?=$produk['id_produk'];?>" class="btn btn-xs btn-default" onclick="return confirm('Yakin akan menghapus data ini ?');">
                <span class="glyphicon glyphicon-remove"></span>
              </a>
            </td>
            <td><?=$produk['nama_produk'];?></td>
            <td><?=money($produk['Harga']);?></td>
            <td><?=$category;?></td>
            <td>
              <a href="products.php?featured=<?=(($produk['featured'] == 0)?'1':'0');?>&id=<?=$produk['id_produk'];?>" class="btn btn-xs btn-default"
              title="<?=(($produk['featured'] == 0)?'Klik Untuk Menampilkan Produk':'Klik Untuk Tidak Menampilkan Produk Ini');?>">
                <span class="glyphicon glyphicon-<?=(($produk['featured'] == 1)?'minus':'plus');?>"></span>
              </a>
              &nbsp; <?=(($produk['featured'] == 1)?'Ditampilkan':'Tidak Ditampilkan');?>
            </td>
            <td>0</td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php } include 'includes/footer.php'; ?>
  <script type="text/javascript">
    $('document').ready(function(){
      get_child_options('<?=$category;?>');
    });
  </script>
<!--Sendok ini akan bengkok, bengkok, bengkok atuh euy tulungan sakali ewang,bengkok bengkoookkk maneh teh atuh-->

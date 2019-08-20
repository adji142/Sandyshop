<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/SandyShop/core/init.php';
$parentID = (int)$_POST['parentID'];
$selected = sanitize($_POST['selected']);
$childQ = $db->query("SELECT * FROM kategori WHERE parent = '$parentID' ORDER BY Nama_kategori");
ob_start();
?>
  <option value=""></option>
  <?php foreach ($childQ as $child) : ?>
    <option value="<?=$child['id_kategori'];?>"<?=(($selected == $child['id_kategori'])?' selected':'');?>><?=$child['Nama_kategori'];?></option>
  <?php endforeach; ?>
<?php echo ob_get_clean(); ?>

<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/SandyShop/core/init.php';
if(!is_logged_in()){
  login_error_redirect();
}
include 'includes/head.php'; // include file
include 'includes/navigation.php';

// update produk
if (isset($_GET['repair'])) {
	$repairID = (int)$_GET['repair'];
	$repairID = sanitize($repairID);
	$repairSql = "UPDATE products SET deleted = 0 WHERE id = '$repairID'";
	$db->query($repairSql);
	header('Location: archived.php');
}

// delete produk
if (isset($_GET['delete'])) {
	$delID = (int)$_GET['delete'];
	$delID = sanitize($delID);
	$deleteSql = "DELETE FROM products WHERE id = '$delID'";
	$db->query($deleteSql);
	header('Location: archived.php');
}

// listing produk
$Tsql 	= "SELECT * FROM products WHERE deleted = 1";
$Tquery = $db->query($Tsql);
?>
<div class="container">
	<h2 class="text-center">Archived Products</h2><hr>
	<table class="table table-bordered table-condensed table-striped">
		<thead>
			<th>Opsi</th>
			<th>Produk</th>
			<th>Harga</th>
			<th>Kategori</th>
		</thead>
		<tbody>
		<?php foreach ($Tquery as $del) :
		  $childID = $del['categories'];
      $catSql = "SELECT * FROM categories WHERE id = '$childID'";
      $result = $db->query($catSql);
      $child = mysqli_fetch_assoc($result);

      $parentID = $child['parent'];
      $pSql = "SELECT * FROM categories WHERE id = '$parentID'";
      $presult = $db->query($pSql);
      $parent = mysqli_fetch_assoc($presult);
      $category = $parent['category'].'->'.$child['category'];
    ?>
			<tr>
				<td>
				   <a href="archived.php?repair=<?=$del['id'];?>" class="btn btn-xs btn-default"
            onclick="return confirm('Yakin akan mengembalikan data ini ?');" title="Repair!">
            <span class="glyphicon glyphicon-refresh"></span></a>
		       <a href="archived.php?delete=<?=$del['id'];?>" class="btn btn-xs btn-default"
            onclick="return confirm('Yakin akan menghapus data ini ?');" title="Delete!">
            <span class="glyphicon glyphicon-remove-sign"></span></a>
				</td>
				<td><?=$del['title'];?></td>
				<td><?=money($del['price']);?></td>
				<td><?=$category;?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>

<?php include 'includes/footer.php'; ?>
<script type="text/javascript">
	$(document).ready(function () {
	  	document.title = "Produk Archived";
    });
</script>
<?php
 require_once 'core/init.php';
 include 'includes/head.php';
 include 'includes/navigation.php';
 include 'includes/headerpartial.php';
 include 'includes/leftbar.php';

 $sql = "SELECT * FROM products";
 $cat_id = (($_POST['cat'] != '')?sanitize($_POST['cat']):'');
 if ($cat_id == '') {
   $sql .= ' WHERE deleted = 0';
 }else{
   $sql .= ' WHERE categories = '.$cat_id.' AND deleted = 0';
 }
 $price_sort = (($_POST['price_sort'] != '')?sanitize($_POST['price_sort']):'');
 $min_price = (($_POST['min_price'] != '')?sanitize($_POST['min_price']):'');
 $max_price = (($_POST['max_price'] != '')?sanitize($_POST['max_price']):'');
 $price_sort = preg_replace("/[^0-9]/", "", $price_sort);
 $min_price = preg_replace("/[^0-9]/", "", $min_price);
 $max_price = preg_replace("/[^0-9]/", "", $max_price);
 $brand = (($_POST['brand'] != '')?sanitize($_POST['brand']):'');
 if ($min_price != '') {
   $sql .= " AND price >= '{$min_price}'";
 }
 if ($max_price != '') {
   $sql .= " AND price <= '{$max_price}'";
 }
 if ($brand != '') {
   $sql .= " AND brand = '{$brand}'";
 }
 if ($price_sort == 'murah') {
   $sql .= " ORDER BY price";
 }
 if ($price_sort == 'mahal') {
   $sql .= " ORDER BY price DESC";
 }
 $productQ = $db->query($sql);
 $category = get_category($cat_id);
?>

  <!-- konten utama -->
  <div class="col-md-8">
    <div class="row">
      <?php if($cat_id != ''): ?>
        <h2 class="text-center"><?=$category['parent']. ' ' .$category['child'];?></h2>
      <?php else: ?>
        <h2 class="text-center">Shaunta's Boutique</h2>
      <?php endif; ?>
      <?php foreach ($productQ as $fitur) : ?>
      <div class="col-md-3 text-center">
        <h4><?=$fitur['title'];?></h4>
        <?php $photos = explode(',',$fitur['image']); ?>
        <img src="<?=$photos[0];?>" alt="<?=$fitur['title'];?>" class="img-thumb"/>
        <p class="list-price text-danger">List Price: <s><?=money($fitur['last_price']);?></s></p>
        <p class="price">Our Price: <?=money($fitur['price']);?></p>
        <button type="button" class="btn btn-sm btn-success" onclick="detailsmodal(<?=$fitur['id'];?>)">
          Details
        </button>
      </div>
      <?php endforeach; ?>

    </div>
  </div>

<?php
  include 'includes/rightbar.php';
  include 'includes/footer.php';
?>

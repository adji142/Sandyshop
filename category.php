<?php
 require_once 'core/init.php';
 include 'includes/head.php';
 include 'includes/navigation.php';
 include 'includes/headerpartial.php';
 include 'includes/leftbar.php';

 if (isset($_GET['cat'])) {
   $cat_id = sanitize($_GET['cat']);
 }else{
   $cat_id = '';
 }

 $sql = "SELECT * FROM products WHERE categories = '$cat_id'";
 $productQ = $db->query($sql);
 $category = get_category($cat_id);
?>

  <!-- konten utama -->
  <div class="col-md-8">
    <div class="row">
      <h2 class="text-center"><?=$category['parent']. ' ' .$category['child'];?></h2>

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

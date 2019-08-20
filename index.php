<?php
 require_once 'core/init.php';
 include 'includes/head.php';
 include 'includes/navigation.php';
 include 'includes/headerfull.php';
 include 'includes/leftbar.php';

 $sql = "SELECT * FROM produk WHERE featured = 1 AND deleted = 0";
 $featured = $db->query($sql);
?>

  <!-- konten utama -->
  <div class="col-md-8">
    <div class="row">
      <h2 class="text-center">Produk Fitur</h2>

      <?php foreach ($featured as $fitur) : ?>
      <div class="col-md-3 text-center">
        <h4><?=$fitur['nama_produk'];?></h4>
        <?php $photos = explode(',',$fitur['gambar']); ?>
        <img src="<?=$photos[0];?>" alt="<?=$fitur['nama_produk'];?>" class="img-thumb"/>
        <p class="list-price text-danger">List Price: <s><?=money($fitur['Harga']);?></s></p>
        <p class="price">Our Price: <?=money($fitur['Harga']- $fitur['Diskon']);?></p>
        <button type="button" class="btn btn-sm btn-success" onclick="detailsmodal('<?=$fitur['id_produk'];?>')">
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

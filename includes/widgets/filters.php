<?php
  $cat_id = ((isset($_REQUEST['cat']))?sanitize($_REQUEST['cat']):'');
  $price_sort = ((isset($_REQUEST['price_sort']))?sanitize($_REQUEST['price_sort']):'');
  $min_price = ((isset($_REQUEST['min_price']))?sanitize($_REQUEST['min_price']):'');
  $max_price = ((isset($_REQUEST['max_price']))?sanitize($_REQUEST['max_price']):'');
  $b = ((isset($_REQUEST['brand']))?sanitize($_REQUEST['brand']):'');
  $brandSql = $db->query("SELECT * FROM brand ORDER BY brand");
?>
<h3 class="text-center">Cari Berdasarkan:</h3>
<h4 class="text-center">Harga</h4>
<form action="search.php" method="post">
    <input type="hidden" name="cat" value="<?=$cat_id;?>">
    <input type="hidden" name="price_sort" value="0">
    <input type="radio" name="price_sort" value="murah"<?=(($price_sort == 'murah')?' checked':'');?>>Murah ke Mahal<br>
    <input type="radio" name="price_sort" value="mahal"<?=(($price_sort == 'mahal')?' checked':'');?>>Mahal ke Murah<br><br>
    <input type="text" name="min_price" class="price-range" placeholder="Min Rp." value="<?=$min_price;?>">Ke
    <input type="text" name="max_price" class="price-range" placeholder="Max Rp." value="<?=$max_price;?>"><br><br>
    <input type="submit" name="cari" class="btn btn-xs btn-primary" value="Cari">
</form>

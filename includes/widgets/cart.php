<h3 class="text-center">Keranjang Belanja</h3>
<div>
<?php if (empty($cart_id)): ?>
  <p style="font-size: 10px;" class="text-danger text-center">Keranjang anda masih kosong!</p>
<?php else:
  $cartQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
  $results = mysqli_fetch_assoc($cartQ);
  $items = json_decode($results['items'],true);
  $i = 1;
  $sub_total = 0;
?>
<table class="table table-condensed" id="cart_widget">
  <tbody>
    <?php foreach($items as $item):
      $productQ = $db->query("SELECT * FROM produk WHERE id_produk = '{$item['id']}'");
      $product = mysqli_fetch_assoc($productQ);
    ?>
    <tr style="font-size: 11px;">
      <td><?=$item['quantity'];?></td>
      <td><?=substr($product['nama_produk'],0,15);?></td>
      <td><?=money($item['quantity'] * $product['Harga']);?></td>
    </tr>
    <?php
      $sub_total += ($item['quantity'] * $product['Harga'])-$product['Diskon'];
    endforeach; ?>
    <tr style="font-size: 11px;">
      <td></td>
      <td>Sub Total</td>
      <td><?=money($sub_total);?></td>
    </tr>
  </tbody>
</table>
<a href="cart.php" class="btn btn-xs btn-primary pull-right">Lihat Keranjang</a>
<div class="clearfix"></div>
<?php endif; ?>
</div>

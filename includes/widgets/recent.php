<h3 class="text-center">Item Populer</h3>
<?php
  $transQ = $db->query("SELECT * FROM cart WHERE paid = 1 ORDER BY id DESC LIMIT 5");
  $results = array();
  foreach ($transQ as $row) {
    $results[] = $row;
  }
  $row_count = $transQ->num_rows;
  $used_ids = array();
  for ($i=0; $i < $row_count ; $i++) {
    $json_items = $results[$i]['items'];
    $items = json_decode($json_items,true);
    foreach ($items as $item){
      if (!in_array($item['id'], $used_ids)) {
        $used_ids[] = $item['id'];
      }
    }
  }
?>
<div id="recent_widget">
  <table class="table table-condensed">
    <?php foreach($used_ids as $id) :
        $productQ = $db->query("SELECT id_produk,nama_produk FROM produk WHERE id_produk = '{$id}'");
        $product = mysqli_fetch_assoc($productQ);
      ?>
      <tr>
        <td>
          <?=substr($product['nama_produk'],0,15);?>
        </td>
        <td>
          <a class="text-primary" onclick="detailsmodal('<?=$id?>')">Lihat</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>

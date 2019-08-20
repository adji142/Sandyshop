<?php
  require_once '../core/init.php';
  if (!is_logged_in()) {
    header('Location: login.php');
  }
  include 'includes/head.php';
  include 'includes/navigation.php';

  //Konfirmasi order
  if (isset($_GET['complete']) && $_GET['complete'] == 1) {
    $cart_id = sanitize($_GET['cart_id']);
    $db->query("UPDATE cart SET shipped = 1 WHERE id = '{$cart_id}'");
    $_SESSION['success_flash'] = 'Orderan berhasil dikonfirmasi!';
    header('Location: index.php');
  }

  $txn_id = sanitize($_GET['txn_id']);
  $productQ = $db->query(
    "SELECT i.id_produk as 'id', i.nama_profuk as 'title', c.id_kategori as 'cid', c.Nama_kategori as 'child', p.Nama_kategori as 'parent'
    FROM produk i
    LEFT JOIN kategori c ON i.id_kategori = c.id_kategori
    LEFT JOIN categories p ON c.parent = p.id_kategori
    WHERE i.id_produk IN ({$ids})
");
?>
<div class="container">
  <h2 class="text-center">Orderan Barang</h2><hr>
  <table class="table table-condensed table-bordered table-striped">
    <thead>
      <th>Quantity</th>
      <th>Title</th>
      <th>Kategori</th>
      <th>Ukuran</th>
    </thead>
    <tbody>
      <?php foreach($productQ as $produk) : ?>
      <tr>
        <td><?=$produk['quantity'];?></td>
        <td><?=$produk['title'];?></td>
        <td><?=$produk['parent'].'->'.$produk['child'];?></td>
        <td><?=$produk['size'];?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <div class="row">
    <div class="col-md-6">
      <h3 class="text-center">Detail Order</h3>
      <table class="table table-condensed table-striped table-bordered">
        <tbody>
          <tr>
            <td>Sub Total</td>
            <td><?=money($txn['sub_total']);?></td>
          </tr>
          <tr>
            <td>Ongkir</td>
            <td><?=money($txn['tax']);?></td>
          </tr>
          <tr>
            <td>Grand Total</td>
            <td><?=money($txn['grand_total']);?></td>
          </tr>
          <tr>
            <td>Tanggal Order</td>
            <td><?=indonesian_date($txn['txn_date']);?></td>
          </tr>
        </tbody>
      </table>
      </div>
      <div class="col-md-6">
        <h3 class="text-center">Alamat Pembeli</h3>
        <address>
          <b>Nama Lengkap : </b><?=$txn['full_name'];?><br>
          <b>Alamat : </b><?=$txn['street'];?><br>
          <b>No HP : </b><?=($txn['street2'] != '')?$txn['street2'].'<br>':'';?>
          <b>Kota / Provinsi / Kodepos : </b><?=$txn['city'].', '.$txn['state'].' '.$txn['zip_code'];?><br>
          <b>Negara : </b><?=$txn['country'];?><br>
        </address>
      </div>
      <div class="pull-right">
        <a href="index.php" class="btn btn-large btn-default">Cancel</a>
        <a href="orders.php?complete=1&cart_id=<?=$cart_id;?>" class="btn btn-large btn-primary">Konfirmasi</a>
      </div>
    </div>
  </div>
<?php include 'includes/footer.php'; ?>

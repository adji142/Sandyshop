<?php
require_once '../core/init.php';
if(!is_logged_in()){
  header('Location: login.php');
}
include 'includes/head.php';
include 'includes/navigation.php';

$txnQuery = "SELECT
  c.nama_lengkap,c.Alamat,a.tgl_order,SUM((b.jumlah * e.Harga) - COALESCE(e.Diskon,0)) Total,a.status_order,a.no_resi
FROM orders a
LEFT JOIN ordersdetail b on a.id_orders = b.orders_id
LEFT JOIN pembelian c on a.id_customer = c.id_kustomer
LEFT JOIN users d on c.Email = d.email
LEFT JOIN produk e on e.id_produk = b.id_produk
WHERE d.id = '".$_SESSION['user']."' GROUP BY c.nama_lengkap,c.Alamat,a.status_order,a.no_resi,a.tgl_order ";
$query = $db->query($txnQuery);
// var_dump($txnQuery);
?>
<div class="container">
  <div class="col-md-12">
    <h3 class="text-center">Orderan Anda</h3><hr>
    <table class="table table-condensed table bordered table-striped">
      <thead>
        <th>Nama</th><th>Alamat Kirim</th><th>Tanggal</th><th>Total</th><th>Status Order</th><th>No Resi</th>
      </thead>
      <tbody>
        <?php foreach($query as $q): ?>
        <tr>
          <!-- <td><a href="orders.php?txn_id=<?=$q['id'];?>" class="btn btn-xs btn-info">Detail</a></td> -->
          <td><?=$q['nama_lengkap'];?></td>
          <td><?=$q['Alamat'];?></td>
          <td><?=indonesian_date($q['tgl_order']);?></td>
          <td><?=money($q['Total']);?></td>
          <td><?=$q['status_order'];?></td>
          <td><?=$q['no_resi'];?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<script type="text/javascript">
  $(document).ready(function () {
      document.title = "Dashboard";
    });
</script>
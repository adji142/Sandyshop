<?php
require_once '../core/init.php';
if(!is_logged_in()){
  header('Location: login.php');
}
include 'includes/head.php';
include 'includes/navigation.php';

$txnQuery = "SELECT t.id, t.cart_id, t.full_name, t.description, t.txn_date, t.grand_total, c.items, c.paid, c.shipped
             FROM transactions t
             LEFT JOIN cart c ON t.cart_id = c.id
             WHERE c.paid = 1 AND c.shipped = 0 AND userid = ".$_SESSION['user']."
             ORDER BY t.txn_date";
$query = $db->query($txnQuery);

?>
<div class="container">
  <div class="col-md-12">
    <h3 class="text-center">Orderan Anda</h3><hr>
    <table class="table table-condensed table bordered table-striped">
      <thead>
        <th></th><th>Nama</th><th>Deskripsi</th><th>Total</th><th>Tanggal</th>
      </thead>
      <tbody>
        <?php foreach($query as $q): ?>
        <tr>
          <td><a href="orders.php?txn_id=<?=$q['id'];?>" class="btn btn-xs btn-info">Detail</a></td>
          <td><?=$q['full_name'];?></td>
          <td><?=$q['description'];?></td>
          <td><?=money($q['grand_total']);?></td>
          <td><?=indonesian_date($q['txn_date']);?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
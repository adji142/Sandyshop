<?php
require_once '../core/init.php';
if(!is_logged_in()){
  header('Location: login.php');
}
$cek = $_SESSION['permit'];
// echo $cek;
if($cek=='user'){
  header('location: dashboard.php');
}

include 'includes/head.php';
include 'includes/navigation.php';

$txnQuery = "SELECT a.id_orders,c.nama_lengkap,a.no_resi,SUM(b.jumlah * d.Harga) Jumlah,a.tgl_order FROM orders a
LEFT JOIN ordersdetail b on a.id_orders = b.orders_id
LEFT JOIN pembelian c on a.id_customer = c.id_kustomer
LEFT JOIN produk d on b.id_produk = d.id_produk
GROUP BY a.id_orders,c.nama_lengkap,a.tgl_order,a.no_resi";
$query = $db->query($txnQuery);
?>
<div class="container">
  <div class="col-md-12">
    <h3 class="text-center">Orderan Masuk</h3><hr>
    <table class="table table-condensed table bordered table-striped">
      <thead>
        <th></th><th>Nama</th><th>Total</th><th>Tanggal</th>
      </thead>
      <tbody>
        <?php foreach($query as $q): ?>
        <tr>
          <td><a href="#" id="kirimmodal" <?=$q['no_resi'] != '' ? 'disabled' : '';?> class="btn btn-xs btn-info" onclick="OpenModal(<?=$q['id_orders'];?>)">Detail</a></td>
          <td><?=$q['nama_lengkap'];?></td>
          <td><?=money($q['Jumlah']);?></td>
          <td><?=indonesian_date($q['tgl_order']);?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="row">
    <!--Penjualan Perbulan-->
    <?php
      $thisYr = date("Y");
      $lastYr = $thisYr - 1;
      $thisYrQ = $db->query("SELECT SUM(b.jumlah * d.Harga) Jumlah,a.tgl_order FROM orders a
                            LEFT JOIN ordersdetail b on a.id_orders = b.orders_id
                            LEFT JOIN pembelian c on a.id_customer = c.id_kustomer
                            LEFT JOIN produk d on b.id_produk = d.id_produk
                            where YEAR(tgl_order) = '{$thisYr}'
                            GROUP BY a.id_orders,c.nama_lengkap,a.tgl_order");
      $lastYrQ = $db->query("SELECT SUM(b.jumlah * d.Harga) Jumlah,a.tgl_order FROM orders a
                            LEFT JOIN ordersdetail b on a.id_orders = b.orders_id
                            LEFT JOIN pembelian c on a.id_customer = c.id_kustomer
                            LEFT JOIN produk d on b.id_produk = d.id_produk
                            where YEAR(tgl_order) = '{$lastYr}'
                            GROUP BY a.id_orders,c.nama_lengkap,a.tgl_order");
      $current = array();
      $last = array();
      $currentTotal = 0;
      $lastTotal = 0;
      if ($thisYrQ) {
        foreach($thisYrQ as $year){
          $month = date("m",strtotime($year['tgl_order']));
          // print_r($month);
          if (!array_key_exists($month,$current)) {
            $current[(int)$month] += $year['Jumlah'];
          }else{
            $current[(int)$month] += $year['Jumlah'];
          }
          $currentTotal += $year['Jumlah'];
        }
      }
      
      if ($lastYrQ) {
        foreach($lastYrQ as $last){
          $month = date("m",strtotime($last['tgl_order']));
          if (!array_key_exists($month,$current)) {
            $last[(int)$month] = $last['Jumlah'];
          }else{
            $last[(int)$month] += $last['Jumlah'];
          }
          $lastTotal += $last['Jumlah'];
      }
      }
      
    ?>
    <div class="col-md-4">
      <h3 class="text-center">Penjualan Perbulan</h3><hr>
      <table class="table table-condensed table-striped table-bordered">
        <thead>
          <th></th>
          <th><?=$lastYr;?></th>
          <th><?=$thisYr;?></th>
        </thead>
        <tbody>
          <?php for($i = 1; $i <= 12; $i++):
            $dt = DateTime::createFromFormat('!m',$i)
          ?>
          <tr<?=(date("m") == $i)?' class="info"':'';?>>
            <td><?=$dt->format("F");?></td>
            <td><?=(array_key_exists($i,$last))?money($last[$i]):money(0);?></td>
            <td><?=(array_key_exists($i,$current))?money($current[$i]):money(0);?></td>
          </tr>
          <?php endfor; ?>
          <tr>
            <td>Total</td>
            <td><?=money($lastTotal);?></td>
            <td><?=money($currentTotal);?></td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Persediaan -->
    <?php
    $iQuery = $db->query("SELECT a.id_produk,a.nama_produk,b.Nama_Kategori,a.Stok FROM produk a LEFT JOIN kategori b on a.id_kategori = b.id_kategori order by a.Stok limit 10");
    $lowItems = array();
    foreach($iQuery as $produk){
      $item = array();
        $item = array(
          'id_produk' => $produk['id_produk'],
          'nama_produk' => $produk['nama_produk'],
          'Nama_Kategori' => $produk['Nama_Kategori'],
          'Stok' => $produk['Stok']
        );
        $lowItems[] = $item;
    }
    ?>
    <div class="col-md-8">
      <h3 class="text-center">Persediaan Rendah</h3><hr>
      <table class="table table-condensed table-striped table-bordered">
        <thead>
          <th>Stock</th>
          <th>Kode Produk</th>
          <th>Nama Produk</th>
          <!-- <th>Nama Kategori</th> -->
        </thead>
        <tbody>
          <?php foreach($lowItems as $item): ?>
          <tr<?=($item['Stok'] == 0)?' class="danger"':'';?>>
            <td><?=$item['id_produk'];?></td>
            <td><?=$item['nama_produk'];?></td>
            <td><?=$item['Nama_Kategori'];?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php include 'includes/footer.php';?>

<div class="modal fade" id="kirim" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div class="modal-header">
      <button class="close" type="button" onclick="CloseModal()" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <h4 class="modal-title text-center">Kirim Produk</h4>
    </div>
    <div class="modal-body">
      <div class="container-fluid">
        <div class="row">
          <form action="#" method="post">
            <div class="form-group">
                <label for="quantity">Nomer Resi:</label>
                <input type="text" name="resi" id="resi" class="form-control">
                <input type="hidden" name="id_orders" id="id_orders" class="form-control">
              <div class="col-xs-9"></div>
            </div><br>
          </form>
        </div>
      </div>
    </div>

    <div class="modal-footer">
      <button class="btn btn-default" onclick="CloseModal()">Close</button>
      <button class="btn btn-warning" onclick="Kirim(); return false;"><span class="glyphicon glyphicon-shopping-cart"></span>Kirim</button>
    </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function () {
      document.title = "Main Menu";
    });
</script>
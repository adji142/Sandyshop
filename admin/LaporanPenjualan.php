<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/SandyShop/core/init.php';
if(!is_logged_in()){
  login_error_redirect();
}
include 'includes/head.php';
include 'includes/navigation.php';
$title = 'Laporan Penjualan';
?>
<div class="container">
	<h2 class="text-center">Laporan Penjualan</h2><hr><br>
	<form action="LaporanPenjualan.php" method="GET">
		Tanggal Awal: <input type="date" name="tglawal" id="tglawal"> s/d Tanggal Awal: <input type="date" name="tglakhir" id="tglakhir"> <button type="submit">Proses</button><br>
	</form>
	<table class="table table-bordered table-condensed table-striped" id="datalaporan">
		<thead>
			<tr>
				<th>No</th>
				<th>Tanggal Order</th>
				<th>Nama Customer</th>
				<th>Email Customer</th>
				<th>Kode Barang</th>
				<th>Nama Barang</th>
				<th>Qty</th>
				<th>Harga</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			<?php
				// $q['no_resi'] != '' ? 'disabled' : '';
				// if isset($_GET['tglawal']) ? $tglawal = $_GET['tglawal']:'';
				// if isset($_GET['tglakhir']) ?  $tglawal = $_GET['tglakhir']:'';
				if (isset($_GET['tglawal']) && isset($_GET['tglakhir'])) {
					$tglawal = $_GET['tglawal'];
					$tglakhir = $_GET['tglakhir'];

					$query = "SELECT 
						a.tgl_order,
						c.nama_lengkap,
						c.Email,
						d.id_produk,
						d.nama_produk,
						SUM(b.jumlah) Qty,
						d.Harga,
						SUM(b.jumlah) * d.Harga Total
					FROM orders a
					LEFT JOIN ordersdetail b on a.id_orders = b.orders_id
					LEFT JOIN pembelian c on a.id_customer = c.id_kustomer
					LEFT JOIN produk d on b.id_produk = d.id_produk
					WHERE a.tgl_order BETWEEN '$tglawal' AND '$tglakhir'
					GROUP BY a.tgl_order,c.nama_lengkap,c.Email,d.id_produk,d.nama_produk,d.Harga";

					$Tquery = $db->query($query);
					$i = 1;
					foreach ($Tquery as $rs) {
						echo "<tr>";
						echo "<td>".$i."</td>";
						echo "<td>".$rs['tgl_order']."</td>";
						echo "<td>".$rs['nama_lengkap']."</td>";
						echo "<td>".$rs['Email']."</td>";
						echo "<td>".$rs['id_produk']."</td>";
						echo "<td>".$rs['nama_produk']."</td>";
						echo "<td>".$rs['Qty']."</td>";
						echo "<td>".money($rs['Harga'])."</td>";
						echo "<td>".money($rs['Total'])."</td>";
						echo "</tr>";

						$i++;
					}
				}
			?>
		</tbody>
	</table>
</div>

<?php include 'includes/footer.php'; ?>
<script type="text/javascript">
	  $(document).ready(function () {
	  	document.title = "Laporan Penjualan";
        $('#datalaporan').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy',{
              extend: 'excel',
              messageTop: 'Laporan Penjualan.'
            },
            {
              extend: 'csv',
              messageTop: 'Laporan Penjualan.'
            },
            {
              extend: 'pdf',
              messageTop: 'Laporan Penjualan.'
            },
            {
              extend: 'print',
              messageTop: 'Laporan Penjualan.'
            }
            ] // 'copy', 'csv', 'excel', 'pdf', 'print'
        });
    });
</script>
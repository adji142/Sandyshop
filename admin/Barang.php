<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/SandyShop/core/init.php';
if(!is_logged_in()){
  login_error_redirect();
}
include 'includes/head.php'; // include file
include 'includes/navigation.php';
?>
<div class="container">
	<h2 class="text-center">Laporan Barang</h2><hr>
	<table class="table table-bordered table-condensed table-striped" id="datalaporan">
		<thead>
			<th>No</th>
			<th>Kode Produk</th>
			<th>Nama Produk</th>
			<th>Kategori</th>
			<th>Supplier</th>
			<th>Stock Awal</th>
			<th>Di Beli</th>
			<th>Stock Akhir / Tersedia</th>
		</thead>
		<tbody>
			<?php
				$query = "SELECT 
					a.id_produk,
					a.nama_produk,
					b.Nama_kategori,
					a.Stok Stokawal,
					a.Stok - a.Dibeli Available,
					a.Dibeli Laku,
					c.supplier
				FROM produk a
				LEFT JOIN kategori b on a.id_kategori = b.id_kategori
				LEFT JOIN supplier c on a.supplier = c.id_supplier";

					$Tquery = $db->query($query);
					$i = 1;
					foreach ($Tquery as $rs) {
						echo "<tr>";
						echo "<td>".$i."</td>";
						echo "<td>".$rs['id_produk']."</td>";
						echo "<td>".$rs['nama_produk']."</td>";
						echo "<td>".$rs['Nama_kategori']."</td>";
						echo "<td>".$rs['supplier']."</td>";
						echo "<td>".$rs['Stokawal']."</td>";
						echo "<td>".$rs['Laku']."</td>";
						echo "<td>".$rs['Available']."</td>";
						echo "</tr>";

						$i++;
					}
			?>
		</tbody>
	</table>
</div>

<?php include 'includes/footer.php'; ?>
<script type="text/javascript">
	  $(document).ready(function () {
	  	document.title = "Laporan Barang";
        $('#datalaporan').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy',{
              extend: 'excel',
              messageTop: 'Laporan Barang.'
            },
            {
              extend: 'csv',
              messageTop: 'Laporan Barang.'
            },
            {
              extend: 'pdf',
              messageTop: 'Laporan Barang.'
            },
            {
              extend: 'print',
              messageTop: 'Laporan Barang.'
            }
            ] // 'copy', 'csv', 'excel', 'pdf', 'print'
        });
    });
</script>
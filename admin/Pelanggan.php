<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/SandyShop/core/init.php';
if(!is_logged_in()){
  login_error_redirect();
}
include 'includes/head.php';
include 'includes/navigation.php';
?>
<div class="container">
	<h2 class="text-center">Laporan Pelanggan</h2><hr>
	<table class="table table-bordered table-condensed table-striped" id="datalaporan">
		<thead>
			<th>No</th>
			<th>Nama Pelanggan</th>
			<th>Email</th>
			<th>Alamat</th>
			<th>Telepon</th>
			<th>Akumulasi Belanja</th>
		</thead>
		<tbody>
			<?php
				$query = "SELECT 
					a.nama_lengkap,a.Email,a.Alamat,a.Telepon,SUM((c.jumlah*d.Harga) - d.Diskon) total
				FROM pembelian a
				LEFT JOIN orders b on a.id_kustomer = b.id_customer
				LEFT JOIN ordersdetail c on b.id_orders = c.orders_id
				LEFT JOIN produk d on c.id_produk = d.id_produk
				GROUP BY a.nama_lengkap,a.Email,a.Alamat,a.Telepon";

					$Tquery = $db->query($query);
					$i = 1;
					foreach ($Tquery as $rs) {
						echo "<tr>";
						echo "<td>".$i."</td>";
						echo "<td>".$rs['nama_lengkap']."</td>";
						echo "<td>".$rs['Email']."</td>";
						echo "<td>".$rs['Alamat']."</td>";
						echo "<td>".$rs['Telepon']."</td>";
						echo "<td>".money($rs['total'])."</td>";
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
	  	document.title = "Laporan Pelanggan";
        $('#datalaporan').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy',{
              extend: 'excel',
              messageTop: 'Laporan Pelanggan.'
            },
            {
              extend: 'csv',
              messageTop: 'Laporan Pelanggan.'
            },
            {
              extend: 'pdf',
              messageTop: 'Laporan Pelanggan.'
            },
            {
              extend: 'print',
              messageTop: 'Laporan Pelanggan.'
            }
            ] // 'copy', 'csv', 'excel', 'pdf', 'print'
        });
    });
</script>
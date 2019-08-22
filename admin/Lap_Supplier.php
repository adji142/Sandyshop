<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/SandyShop/core/init.php';
if(!is_logged_in()){
  login_error_redirect();
}
include 'includes/head.php';
include 'includes/navigation.php';
?>
<div class="container">
	<h2 class="text-center">Laporan Supplier</h2><hr>
	<table class="table table-bordered table-condensed table-striped" id="datalaporan">
		<thead>
			<th>No</th>
			<th>Kode Supplier</th>
			<th>Nama Supplier</th>
			<th>Alamat</th>
			<th>No Telepon</th>
			<th>Tanggal Masuk</th>
			<th>Keterangan</th>
		</thead>
		<tbody>
			<?php
				$query = "SELECT * FROM supplier";

					$Tquery = $db->query($query);
					$i = 1;
					foreach ($Tquery as $rs) {
						echo "<tr>";
						echo "<td>".$i."</td>";
						echo "<td>".$rs['id_supplier']."</td>";
						echo "<td>".$rs['supplier']."</td>";
						echo "<td>".$rs['alamat']."</td>";
						echo "<td>".$rs['telepon']."</td>";
						echo "<td>".$rs['tglmasuk']."</td>";
						echo "<td>".$rs['keterangan']."</td>";
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
	  	document.title = "Laporan Supplier";
        $('#datalaporan').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy',{
              extend: 'excel',
              messageTop: 'Laporan Supplier.'
            },
            {
              extend: 'csv',
              messageTop: 'Laporan Supplier.'
            },
            {
              extend: 'pdf',
              messageTop: 'Laporan Supplier.'
            },
            {
              extend: 'print',
              messageTop: 'Laporan Supplier.'
            }
            ] // 'copy', 'csv', 'excel', 'pdf', 'print'
        });
    });
</script>
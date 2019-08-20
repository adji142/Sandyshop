<?php
	require_once 'core/init.php';
	include 'includes/head.php';
	include 'includes/navigation.php';
	include 'includes/headerpartial.php';
	if ($cart_id != '') {
		$cartQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
		$result = mysqli_fetch_assoc($cartQ);
		$items = json_decode($result['items'],true);
		$i = 1;
		$sub_total = 0;
		$item_count = 0;
	}
	$kotaQ = $db->query("SELECT * FROM kota");
?>

<div class="col-md-12">
	<div class="row">
		<h2 class="text-center">Keranjang Belanja Saya</h2><hr>
		<?php if($cart_id == ''): ?>
			<div class="bg-danger">
				<p class="text-center text-danger">
					Keranjang belanja anda masih kosong
				</p>
			</div>
		<?php else: ?>
			<table class="table table-bordered table-condensed table-striped">
				<thead><th>#</th><th>Item</th><th>Harga</th><th>Quantity</th><th>Sub Total</th></thead>
				<tbody>
					<?php
						foreach ($items as $item) {
							$product_id = $item['id'];
							$productQ = $db->query("SELECT * FROM produk WHERE id_produk = '{$product_id}'");
							$product = mysqli_fetch_assoc($productQ);
							// $sArray = explode(',',$product['sizes']);
							// foreach($sArray as $sizeString){
							// 	$s = explode(':',$sizeString);
							// 	if ($s[0] == $item['size']) {
							// 		$available = $s[1];
							// 	}
							// }
							?>
							<tr>
								<td><?=$i;?></td>
								<td><?=$product['nama_produk'];?></td>
								<td><?=money($product['Harga'] - $product['Diskon']);?></td>
								<td>
									<button class="btn btn-xs btn-default" onclick="update_cart('removeone','<?=$product['id_produk'];?>','<?=$item['size'];?>');">
									-</button>
									<?=$item['quantity'];?>
									<?php if($item['quantity'] < ($product['Stok'] - $product['Dibeli'])): ?>
									<button class="btn btn-xs btn-default" onclick="update_cart('addone','<?=$product['id_produk'];?>','<?=$item['size'];?>');">
									+</button>
									<?php else: ?>
										<span class="text-danger">Max</span>
									<?php endif; ?>
								</td>
								<td><?=money($item['quantity'] * ($product['Harga'] - $product['Diskon']));?></td>
							</tr>
					<?php
						$i++;
						$item_count += $item['quantity'];
						$sub_total += (($product['Harga'] - $product['Diskon'] ) * $item['quantity']);
					}
					$tax = TAXRATE * $sub_total;
					$grand_total = $sub_total;
					?>
				</tbody>
			</table>
			<table class="table table-bordered table-condensed text-right">
			<legend>Total</legend>
				<thead class="totals-table-header">
					<th>Total Item</th>
					<th>Sub Total</th>
					<th>Grand Total</th>
				</thead>
				<tbody>
					<td><?=$item_count;?></td>
					<td><?=money($sub_total);?></td>
					<td class="bg-success"><?=money($grand_total);?></td>
				</tbody>
			</table>
			<!-- Button trigger modal -->
			<button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#checkoutModal">
			  <span class="glyphicon glyphicon-shopping-cart"></span> Check Out >>
			</button>

			<!-- Modal -->
			<div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkModalLabel">
			  <div class="modal-dialog modal-lg" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="checkoutModalLabel">Formulir</h4>
			      </div>
			      <div class="modal-body">
			      	<div class="row">
			        <form method="post" action="terimakasih.php" id="payment-form">
			        <span class="bg-danger" id="payment-errors"></span>
							<input type="hidden" name="tax" value="<?=$tax;?>">
							<input type="hidden" name="sub_total" value="<?=$sub_total;?>">
							<input type="hidden" name="grand_total" value="<?=$grand_total;?>">
							<input type="hidden" name="cart_id" value="<?=$cart_id;?>">
							<input type="hidden" name="description" value="<?=$item_count.' item'.(($item_count > 1)?'s':'').' dari Shauntas Boutique.';?>">
			        	<div id="step1" style="display:block">
			        		<div class="form-group col-md-6">
			        			<label for="fullname">Nama Lengkap:</label>
			        			<input type="text" class="form-control" id="full_name" name="full_name">
			        		</div>
			        		<div class="form-group col-md-6">
			        			<label for="fullname">Email:</label>
			        			<input type="text" class="form-control" id="email" name="email">
			        		</div>
			        		<div class="form-group col-md-6">
			        			<label for="fullname">Password:</label>
			        			<input type="Password" class="form-control" id="pwd" name="pwd">
			        		</div>
			        		<div class="form-group col-md-6">
			        			<label for="fullname">Alamat:</label>
			        			<input type="text" class="form-control" id="street" name="street" data-stripe="address_line1">
			        		</div>
			        		<div class="form-group col-md-6">
			        			<label for="fullname">No Hp:</label>
			        			<input type="text" class="form-control" id="street2" name="street2" data-stripe="address_line2">
			        		</div>
			        		<div class="form-group col-md-6">
			        			<label for="fullname">Kota</label>
			        			<!-- <input type="text" class="form-control" id="city" name="city" data-stripe="adress_city"> -->
			        			<select class="form-control" id="city" name="city">
						          <option value=""></option>
						          <?php foreach ($kotaQ as $p) : ?>
						            <option value="<?=$p['id_kota'].'|'.$p['ongkos_kirim'];?>"><?=$p['nama_kota'];?></option>
						          <?php endforeach; ?>
						        </select>
			        		</div>
			        		<div class="form-group col-md-6">
			        			<label for="fullname">Provinsi</label>
			        			<input type="text" class="form-control" id="state" name="state" data-stripe="address_state">
			        		</div>
			        		<div class="form-group col-md-6">
			        			<label for="fullname">Kode Pos:</label>
			        			<input type="text" class="form-control" id="zip_code" name="zip_code" data-stripe="address_zip">
			        		</div>
			        		<div class="form-group col-md-6">
			        			<label for="fullname">Negara:</label>
			        			<input type="text" class="form-control" id="country" name="country" data-stripe="address_country">
			        		</div>
			        	</div>
			        	<!-- <div id="step2" style="display: none;">
			        		<div class="form-group col-md-3">
			        			<label for="name">Nama di Kartu Kredit:</label>
			        			<input type="text" id="name" class="form-control" data-stripe="name">
			        		</div>
			        		<div class="form-group col-md-3">
			        			<label for="number">Nomor Kartu Kredit:</label>
			        			<input type="text" id="number" class="form-control" data-stripe="number">
			        		</div>
			        		<div class="form-group col-md-3">
			        			<label for="CVC">CVC:</label>
			        			<input type="text" id="cvc" class="form-control" data-stripe="cvc">
			        		</div>
			        		<div class="form-group col-md-2">
			        			<label for="exp-month">Bulan:</label>
			        			<select id="exp-month" class="form-control" data-stripe="exp_month">
											<option value=""></option>
											<?php for($i = 1; $i < 13; $i++): ?>
												<option value="<?=$i;?>"><?=$i;?></option>
											<?php endfor; ?>
			        			</select>
			        		</div>
			        		<div class="form-group col-md-2">
			        			<label for="exp-year">Tahun:</label>
			        			<select id="exp-year" class="form-control" data-stripe="exp_year">
			        				<?php $yr = date("Y"); ?>
			        				<?php for($i = 0; $i < 11; $i++): ?>
												<option value="<?=$yr + $i;?>"><?=$yr + $i;?></option>
											<?php endfor; ?>
										</select>
			        		</div>
			        	</div> -->

			      </div>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        <!-- <button type="button" class="btn btn-primary" onclick="check_address();" id="next_button">Next >></button>
			        <button type="button" class="btn btn-primary" onclick="back_address();" id="back_button" style="display: none;"><< Back</button> -->
			        <button type="submit" class="btn btn-primary" id="check_out_button">
			        <span class="glyphicon glyphicon-shopping-cart"></span>Check Out >></button>
			      </div>
			      </form>
			    </div>
			  </div>
			</div>
		<?php endif; ?>
	</div>
</div>

<script>
	function back_address(){
		$('#payment-errors').html("");
		$('#step1').css("display","block");
		$('#step2').css("display","none");
		$('#next_button').css("display","inline-block");
		$('#back_button').css("display","none");
		$('#check_out_button').css("display","none");
		$('#checkoutModalLabel').html('Formulir');
	}


	function check_address(){
		var data = {
			'full_name' : $('#full_name').val(),
			'email' : $('#email').val(),
			'street' : $('#street').val(),
			'street2' : $('#street2').val(),
			'city' : $('#city').val(),
			'state' : $('#state').val(),
			'zip_code' : $('#zip_code').val(),
			'country' : $('#country').val(),
		};
		$.ajax({
			url : '/SandyShop/admin/parsers/check_address.php',
			method : 'POST',
			data : data,
			success : function(data){
				if (data != 'OK') {
					$('#payment-errors').html(data);
				}
				if (data == 'OK') {
					$('#payment-errors').html("");
					$('#step1').css("display","none");
					$('#step2').css("display","block");
					$('#next_button').css("display","none");
					$('#back_button').css("display","inline-block");
					$('#check_out_button').css("display","inline-block");
					$('#checkoutModalLabel').html('Masukkan Kartu Kredit');
				}
			},
			error : function(){alert('Sepertinya ada kesalahan');},
		});
	}
</script>
<?php include 'includes/footer.php'; ?>

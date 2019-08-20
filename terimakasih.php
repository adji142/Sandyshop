<?php
require_once 'core/init.php';

$temp = explode('|', $_POST['city']);

$full_name = sanitize($_POST['full_name']);
$email = sanitize($_POST['email']);
$street = sanitize($_POST['street']);
$street2 = sanitize($_POST['street2']);
$city = $temp[0];
$ongkir = $temp[1];
$state = sanitize($_POST['state']);
$zip_code = sanitize($_POST['zip_code']);
$country = sanitize($_POST['country']);
$tax = sanitize($_POST['tax']);
$sub_total = sanitize($_POST['sub_total']);
$grand_total = sanitize($_POST['grand_total']);
$cart_id = sanitize($_POST['cart_id']);
$description = sanitize($_POST['description']);
$pwd = sanitize($_POST['pwd']);
$txn_date = date("Y-m-d H:i:s");
$join_date = date("Y-m-d");
// if (!isset($_SESSION['user']))
// {
//   $user = $_SESSION['user'];
// }
// else{

// }
$hashed = password_hash($pwd,PASSWORD_DEFAULT);
//menyesuaikan persediaan
$itemQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
$iresults = mysqli_fetch_assoc($itemQ);
$items = json_decode($iresults['items'],true);

$id_pembelian = '';
// foreach($items as $item){
//   $newSizes = array();
//   $item_id = $item['id'];
//   $productQ = $db->query("SELECT * FROM products WHERE id = '{$item_id}'");
//   $product = mysqli_fetch_assoc($productQ);
//   $sizes = sizesToArray($product['sizes']);
//   foreach ($sizes as $size) {
//     if ($size['size'] == $item['size']) {
//       $q = $size['quantity'] - $item['quantity'];
//       $newSizes[] = array('size' => $size['size'],'quantity' => $q);
//     }else{
//       $newSizes[] = array('size' => $size['size'],'quantity' => $size['quantity']);
//     }
//   }
//   $sizeString = sizesToString($newSizes);
//   $db->query("UPDATE products SET sizes = '{$sizeString}' WHERE id = '{$item_id}'");
// }

// insert pembelian

$cekPembelian = $db->query("SELECT * FROM pembelian WHERE email = '$email'");
if (mysqli_num_rows($cekPembelian) == 0) {
  $db->query("INSERT INTO pembelian(Password,nama_lengkap,Alamat,Email,Telepon,id_kota,kodepos,provinsi,negara)
            VALUES
            ('$hashed','$full_name','$street','$email','street2','$city','$zip_code','$state','$country')
            "
          );
  $id_pembelian = $db->insert_id;
  $query = "INSERT INTO users(password,full_name,email,join_date,permissions, last_login)
            VALUES
            ('$hashed','$full_name','$email','$txn_date','user','$txn_date')
            ";
  $db->query($query);
}

// insert orders
$doid = '';
$db->query("INSERT INTO orders VALUES(0,'Di Bayar','$join_date',$id_pembelian,'','',$ongkir)");
$doid = $db->insert_id;

// insert ordersDetails
$item_count = 0;
foreach($items as $item){
  $prod = $item['id'];
  $quantity = $item['quantity'];
  $db->query("INSERT INTO ordersdetail VALUES(0,$doid,'$prod',$quantity)");
  $item_count += $quantity;

  // update produk
  $productQ = $db->query("SELECT COALESCE(Dibeli,0) Dibeli FROM produk WHERE id_produk = '$prod'");
  $product = mysqli_fetch_assoc($productQ);
  $beli = (int)$product['Dibeli'] + (int)$quantity;
  $qry = "UPDATE produk set Dibeli = $beli where id_produk = '$prod'";
  $db->query($qry);
  var_dump($qry);
}
$db->query("UPDATE cart SET paid = 1 WHERE id = '{$cart_id}'");

$domain = ($_SERVER['HTTP_HOST'] != "localhost")? '.'.$_SERVER['HTTP_HOST']:false;
setcookie(CART_COOKIE,'',1,"/",$domain,false);
include 'includes/head.php';
include 'includes/navigation.php';
include 'includes/headerpartial.php';
?>
  <h1 class="text-center text-success">Terima Kasih :)</h1>
  <p> Pesanan Anda Sudah Kami Terima, Selanjutnya Silahkan Melakukan Pembayaran Senilai Total Belanjaan anda dengan detail :</p>
  <table class="table table-bordered table-condensed text-right">
    <legend>Total</legend>
      <thead class="totals-table-header">
        <th>Total Item</th>
        <th>Sub Total</th>
        <th>Ongkos Kirim</th>
        <th>Grand Total</th>
      </thead>
      <tbody>
        <td><?=$item_count;?></td>
        <td><?=money($sub_total);?></td>
        <td><?=money($ongkir);?></td>
        <td class="bg-success"><?=money($sub_total + $ongkir);?></td>
      </tbody>
    </table>
  <p> Pembayaran dilayani dengan cara transfer ke No Rekening :</p>

  <p> Setelah Melakukan pembayaran pesanan anda akan di kirim ke alamat :</p>
  <address>
    <?=$full_name;?><br>
    <?=$street;?><br>
    <?=(($street2 != '')?$street2.'<br>':'');?>
    <?=$city. ', '.$state.' '.$zip_code;?>
    <?=$country;?><br>
  </address>
  <p>Silahkan Login untuk melihat progress pesanan anda</p>
<?php
include 'includes/footer.php';
?>

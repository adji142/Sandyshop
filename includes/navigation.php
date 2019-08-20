<?php
$sql = "SELECT * FROM kategori WHERE parent = 0";
$query = $db->query($sql);
?>

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <a href="index.php" class="navbar-brand">More Boutique</a>
    <ul class="nav navbar-nav">
      <?php
      foreach ($query as $key) :
        $parent_id = $key['id_kategori'];
        $sql2 = "SELECT * FROM kategori WHERE parent = '$parent_id'";
        $cquery = $db->query($sql2);
      ?>
      <!--Men cloth -->
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=$key['Nama_kategori'];?> <span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
          <?php foreach ($cquery as $child) : ?>
          <li><a href="category.php?cat=<?=$child['id_kategori'];?>"><?=$child['Nama_kategori'];?></a></li>
          <?php endforeach; ?>
        </ul>
      </li>
      <?php endforeach; ?>
      <li><a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> My Cart</a></li>
      <?php
      $var = '';
      if(!isset($user_data['first'])){
        $var = '';
      }
      else{
      $var = $user_data['first'];
      }
      if($var == ''){
        echo '<li><a href="admin/login.php">Member? Login</a></li>';
      }
      else {
        echo '<li><a href="admin">Welcome '.$var.'</a></li>';
      }
      
      ?>
    </ul>
  </div>
</nav>

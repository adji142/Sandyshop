<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <a href="/SandyShop/admin/index.php" class="navbar-brand">Home Boutique</a>
    <ul class="nav navbar-nav">
      <!-- Menu Items-->
      <?php if (has_permissions('admin')): ?>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Master
          <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" role="menu">
          <li><a href="Supplier.php">Supplier</a></li>
          <li><a href="Kota.php">Kota</a></li>
        </ul>
      </li>
      <!-- <li><a href="Pembelian.php">Pembelian</a></li> -->
      <!-- <li><a href="brands.php">Brands</a></li> -->
      <li><a href="categories.php">Categories</a></li>
      <li><a href="products.php">Products</a></li>
      <!-- <li><a href="archived.php">Archived</a></li> -->
              <li><a href="users.php">Users</a></li>
      <?php endif; ?>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hi, <?=$user_data['first'];?>!
          <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" role="menu">
          <li><a href="change_password.php">Ganti Password</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </li>
      <!-- <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=$key['category'];?> <span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
          <li><a href="#"></a></li>
        </ul>
      </li>
    </ul> -->
  </div>
</nav>

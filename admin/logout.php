<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/SandyShop/core/init.php';
unset($_SESSION['SBUser']);
unset($_SESSION['user']);
header('Location: login.php');

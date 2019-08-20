<?php
define('BASEURL', $_SERVER['DOCUMENT_ROOT'].'/SandyShop/');
define('CART_COOKIE','SBwi72UCklwiqzz2');
define('CART_COOKIE_EXPIRE',time() + (86400 * 30));
define('TAXRATE',0.087);

define('CURRENCY', 'usd');
define('CHECKOUTMODE','TEST');

if (CHECKOUTMODE == 'TEST') {
	define('STRIPE_PRIVATE','sk_test_AlDkpwyLXnfcfcAaWLN9OwO5');
	define('STRIPE_PUBLIC', 'pk_test_IcvvdOzGYuTerl2oEZM4mmDY');
}

if (CHECKOUTMODE == 'LIVE') {
	define('STRIPE_PRIVATE','sk_live_35qzuiZuTERqh2I01bOzodtj');
	define('STRIPE_PUBLIC', 'pk_live_pL0Ecvf2uYD4XKiE2Bo50RTN');
}
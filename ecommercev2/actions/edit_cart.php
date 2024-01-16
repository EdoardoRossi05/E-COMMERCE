<?php

require_once "../models/Cart.php";
require_once "../models/Product.php";
require_once "../models/CartProduct.php";

session_start();

$carrello = CartProduct::Find($_POST['cart_id'],$_POST['product_id']);
$carrello->Save($carrello->getCartId(), $carrello->getProductId(), $_POST['quantita']);


header('Location: http://localhost:63342/ecommercev2/views/carts/index.php');
exit;
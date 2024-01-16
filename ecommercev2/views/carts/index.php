<?php

require_once "../../models/Cart.php";
require_once "../../models/User.php";
require_once "../../models/Product.php";

session_start();

$current_user = $_SESSION['current_user'];
$carrello = Cart::FindByUserId($current_user->GetId());
$prodotti = Product::FetchAll();


?>

<html>
<head>
    <title>Carrello</title>
</head>hh

<body>

<?php include '../navbar.php'; ?>

<?php
foreach ($prodotti as $prodotto) {
    echo "<ul>";
    echo "<li>";
    echo "marca:" . $prodotto->getMarca() . "<br>";
    echo "nome:" . $prodotto->getNome() . "<br>";
    echo "prezzo:" . $prodotto->getPrezzo() . "<br>";
    echo "</li>";
    echo "</ul>";
?>

<form action="../../actions/add_to_cart.php" method="POST">
    <input type="number" name="quantita" min = "0">
    <input type="hidden" name="product_id" value="<?php echo $prodotto->getId(); ?>">
    <input type="hidden" name="cart_id" value="<?php echo $carrello->getId(); ?>">
    <input type="submit" value="aggiungi">
</form>

<?php }
?>
<a class = "button" href = "../cart.php">Vai al carrello</a>

</body>
</html>